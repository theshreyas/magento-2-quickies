<?php

declare(strict_types=1);

namespace Theshreyas\Amazonpay\Model\Resolver;

use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Authorization\Model\UserContextInterface;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlAuthorizationException;
use Magento\Framework\GraphQl\Exception\GraphQlAuthenticationException;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\QuoteGraphQl\Model\Cart\GetCartForUser;
use Amazon\Core\Client\ClientFactoryInterface;
use Amazon\Core\Domain\AmazonAddressFactory;
use Amazon\Core\Exception\AmazonServiceUnavailableException;
use Amazon\Payment\Api\AddressManagementInterface;
use Amazon\Payment\Api\Data\QuoteLinkInterfaceFactory;
use Amazon\Payment\Helper\Address;
use Amazon\Payment\Domain\AmazonOrderStatus;
use Amazon\Payment\Domain\AmazonAuthorizationStatus;
use Exception;
use Magento\Checkout\Model\Session;
use Magento\Customer\Model\AddressFactory;
use Magento\Directory\Model\ResourceModel\Country\CollectionFactory;
use Magento\Framework\Exception\SessionException;
use Magento\Framework\Validator\Exception as ValidatorException;
use Magento\Framework\Validator\Factory;
use Magento\Framework\Webapi\Exception as WebapiException;
use Magento\Quote\Model\Quote;
use AmazonPay\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class AmazonShippingAddress implements ResolverInterface
{
  /**
   * @var ClientFactoryInterface
   */
  private $clientFactory;

  /**
   * @var Address
   */
  private $addressHelper;

  /**
   * @var QuoteLinkInterfaceFactory
   */
  private $quoteLinkFactory;

  /**
   * @var Session
   */
  private $session;

  /**
   * @var CollectionFactory
   */
  private $countryCollectionFactory;

  /**
   * @var AmazonAddressFactory
   */
  private $amazonAddressFactory;

  /**
   * @var Factory
   */
  private $validatorFactory;

  /**
   * @var LoggerInterface
   */
  private $logger;

  /**
   * @var AddressFactory
   */
  private $addressFactory;
  /**
   * @var GetCartForUser
   */
  private $getCartForUser;
  /**
   * @param ClientFactoryInterface    $clientFactory
   * @param Address                   $addressHelper
   * @param QuoteLinkInterfaceFactory $quoteLinkFactory
   * @param Session                   $session
   * @param CollectionFactory         $countryCollectionFactory
   * @param AmazonAddressFactory      $amazonAddressFactory
   * @param Factory                   $validatorFactory
   * @param LoggerInterface           $logger
   * @param AddressFactory            $addressFactory
   * @param GetCartForUser            $getCartForUser
   */
  public function __construct(
    ClientFactoryInterface $clientFactory,
    Address $addressHelper,
    QuoteLinkInterfaceFactory $quoteLinkFactory,
    Session $session,
    CollectionFactory $countryCollectionFactory,
    AmazonAddressFactory $amazonAddressFactory,
    Factory $validatorFactory,
    LoggerInterface $logger,
    AddressFactory $addressFactory,
    GetCartForUser $getCartForUser
  ) {
    $this->clientFactory            = $clientFactory;
    $this->addressHelper            = $addressHelper;
    $this->quoteLinkFactory         = $quoteLinkFactory;
    $this->session                  = $session;
    $this->countryCollectionFactory = $countryCollectionFactory;
    $this->amazonAddressFactory     = $amazonAddressFactory;
    $this->validatorFactory         = $validatorFactory;
    $this->logger                   = $logger;
    $this->addressFactory           = $addressFactory;
    $this->getCartForUser           = $getCartForUser;
  }
  /**
   * @inheritdoc
   */
  public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
  {
    if (empty($args['input']['cart_id'])) {
      throw new GraphQlInputException(__('Required parameter "cart_id" is missing'));
    }

    if (empty($args['input']['addressConsentToken'])) {
      throw new GraphQlInputException(__('Required parameter "addressConsentToken" is missing'));
    }

    if (empty($args['input']['amazonOrderReferenceId'])) {
      throw new GraphQlInputException(__('Required parameter "amazonOrderReferenceId" is missing'));
    }

    $maskedCartId = $args['input']['cart_id'];
    $storeId = (int)$context->getExtensionAttributes()->getStore()->getId();
    $cart = $this->getCartForUser->execute($maskedCartId, $context->getUserId(), $storeId);
    $amazonOrderReferenceId = $args['input']['amazonOrderReferenceId'];
    $addressConsentToken = $args['input']['addressConsentToken'];
    $address = $this->getShippingAddress($amazonOrderReferenceId, $addressConsentToken, $cart);
    return $address;
  }
  /**
   * {@inheritdoc}
   */
  public function getShippingAddress($amazonOrderReferenceId, $addressConsentToken, $cart)
  {
    try {
      $data = $this->getOrderReferenceDetails($amazonOrderReferenceId, $addressConsentToken);

      if ($this->isSuspendedStatus($data)) {
        throw new GraphQlAuthenticationException(__('There has been a problem with the selected payment method on your ' .
          'Amazon account. Please choose another one.'));
      }

      $this->updateQuoteLink($amazonOrderReferenceId, $cart);

      if (isset($data['OrderReferenceDetails']['Destination']['PhysicalDestination'])) {
        $shippingAddress = $data['OrderReferenceDetails']['Destination']['PhysicalDestination'];
        return $this->convertToMagentoAddress($shippingAddress, true);
      }
      throw new Exception();
    } catch (ValidatorException $e) {
      throw $e;
    } catch (Exception $e) {
      $this->logger->error($e);
      $this->throwUnknownErrorException();
    }
  }

  protected function throwUnknownErrorException()
  {
    throw new GraphQlAuthenticationException(__('Amazon could not process your request.'));
  }

  protected function convertToMagentoAddress(array $address, $isShippingAddress = false)
  {
    $amazonAddress  = $this->amazonAddressFactory->create(['address' => $address]);
    $magentoAddress = $this->addressHelper->convertToMagentoEntity($amazonAddress);

    if ($isShippingAddress) {
      $validator = $this->validatorFactory->createValidator('amazon_address', 'on_select');

      if (!$validator->isValid($magentoAddress)) {
        throw new ValidatorException(null, null, [$validator->getMessages()]);
      }

      $countryCollection = $this->countryCollectionFactory->create();

      $collectionSize = $countryCollection->loadByStore()
        ->addFieldToFilter('country_id', ['eq' => $magentoAddress->getCountryId()])
        ->setPageSize(1)
        ->setCurPage(1)
        ->getSize();

      if (1 != $collectionSize) {
        throw new GraphQlAuthenticationException(__('the country for your address is not allowed for this store'));
      }

      // Validate address
      $validate = $this->addressFactory->create()->updateData($magentoAddress)->validate();
      if (is_array($validate)) {
        $validate[] = __('Your address may be updated in your Amazon account.');
        throw new ValidatorException(null, null, [$validate]);
      }
    }

    return $this->addressHelper->convertToArray($magentoAddress);
  }

  protected function getOrderReferenceDetails($amazonOrderReferenceId, $addressConsentToken)
  {
    $client = $this->clientFactory->create();

    /**
     * @var ResponseInterface $response
     */
    $response = $client->getOrderReferenceDetails(
      [
        'amazon_order_reference_id' => $amazonOrderReferenceId,
        'address_consent_token'     => $addressConsentToken
      ]
    );

    $data = $response->toArray();

    if (200 != $data['ResponseStatus'] || !isset($data['GetOrderReferenceDetailsResult'])) {
      throw new GraphQlInputException(__('Amazon could not process your request.'));
    }

    return $data['GetOrderReferenceDetailsResult'];
  }

  protected function updateQuoteLink($amazonOrderReferenceId, $quote)
  {
    if (!$quote->getId()) {
      throw new SessionException(__('Your session has expired, please reload the page and try again.'));
    }

    $quoteLink = $this->quoteLinkFactory->create()->load($quote->getId(), 'quote_id');

    if ($quoteLink->getAmazonOrderReferenceId() != $amazonOrderReferenceId) {
      $quoteLink
        ->setAmazonOrderReferenceId($amazonOrderReferenceId)
        ->setQuoteId($quote->getId())
        ->setConfirmed(false)
        ->save();
    }
  }

  protected function isSuspendedStatus($data)
  {
    $orderStatus = $data['OrderReferenceDetails']['OrderReferenceStatus'] ?? false;

    return ($orderStatus && $orderStatus['State'] == AmazonOrderStatus::STATE_SUSPENDED
      && $orderStatus['ReasonCode'] == AmazonAuthorizationStatus::REASON_INVALID_PAYMENT_METHOD);
  }
}
