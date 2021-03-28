<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Theshreyas\Amazonpay\Rewrite\Amazon\Payment\Gateway\Data\Order;

use Magento\Payment\Gateway\Data\Order\AddressAdapterFactory;
use Magento\Payment\Gateway\Data\AddressAdapterInterface;
use Magento\Payment\Gateway\Data\OrderAdapterInterface;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Sales\Model\Order;
use Amazon\Core\Model\AmazonConfig;
use Amazon\Core\Helper\Data;

class OrderAdapter extends \Amazon\Payment\Gateway\Data\Order\OrderAdapter
{
  /**
   * @var Order
   */
  private $order;

  /**
   * @var AddressAdapter
   */
  private $addressAdapterFactory;

  /**
   * @var Data
   */
  private $coreHelper;

  /**
   * @var AmazonConfig
   */
  private $config;

  /**
   * @var  CartRepositoryInterface 
   */
  private $cartRepository;

  /**
   * OrderAdapter constructor.
   *
   * @param Order $order
   * @param AddressAdapterFactory $addressAdapterFactory
   * @param Data $coreHelper
   * @param \Amazon\Core\Model\AmazonConfig $config
   * @param CartRepositoryInterface $cartRepository
   */
  public function __construct(
    Order $order,
    \Magento\Payment\Gateway\Data\Order\AddressAdapterFactory $addressAdapterFactory,
    Data $coreHelper,
    AmazonConfig $config,
    CartRepositoryInterface $cartRepository
  ) {
    $this->order = $order;
    $this->addressAdapterFactory = $addressAdapterFactory;
    $this->coreHelper = $coreHelper;
    $this->config = $config;
    $this->cartRepository = $cartRepository;
  }

  /**
   * Returns currency code
   *
   * @return string
   */
  public function getCurrencyCode()
  {
    return $this->order->getBaseCurrencyCode();
  }

  /**
   * Returns order increment id
   *
   * @return string
   */
  public function getOrderIncrementId()
  {
    return $this->order->getIncrementId();
  }

  /**
   * Returns customer ID
   *
   * @return int|null
   */
  public function getCustomerId()
  {
    return $this->order->getCustomerId();
  }

  /**
   * Returns billing address
   *
   * @return AddressAdapterInterface|null
   */
  public function getBillingAddress()
  {
    if ($this->order->getBillingAddress()) {
      return $this->addressAdapterFactory->create(
        ['address' => $this->order->getBillingAddress()]
      );
    }

    return null;
  }

  /**
   * Returns shipping address
   *
   * @return AddressAdapterInterface|null
   */
  public function getShippingAddress()
  {
    if ($this->order->getShippingAddress()) {
      return $this->addressAdapterFactory->create(
        ['address' => $this->order->getShippingAddress()]
      );
    }

    return null;
  }

  /**
   * Returns order store id
   *
   * @return int
   */
  public function getStoreId()
  {
    return $this->order->getStoreId();
  }

  /**
   * Returns order id
   *
   * @return int
   */
  public function getId()
  {
    return $this->order->getEntityId();
  }

  /**
   * Returns order grand total amount
   *
   * @return float|null
   */
  public function getGrandTotalAmount()
  {
    return $this->order->getBaseGrandTotal();
  }

  /**
   * Returns list of line items in the cart
   *
   * @return \Magento\Sales\Api\Data\OrderItemInterface[]
   */
  public function getItems()
  {
    return $this->order->getItems();
  }

  /**
   * Gets the remote IP address for the order.
   *
   * @return string|null Remote IP address.
   */
  public function getRemoteIp()
  {
    return $this->order->getRemoteIp();
  }

  /**
   * Gets order currency code and amount if Amazon multi-currency was used.
   * @param $amount
   * @return array
   */
  public function getMulticurrencyDetails($amount)
  {
    $values = ['multicurrency' => false];

    if ($this->config->useMultiCurrency()) {
      $invoices = $this->order->getInvoiceCollection();

      foreach ($invoices->getItems() as $key => $invoice) {
        $baseTotal = $invoice->getBaseGrandTotal();

        // compare numeric values to make sure we have the right invoice
        // (could have an invoice for each item during partial capture).
        if (bccomp($baseTotal, (float)$amount) == 0) {
          $values = [
            'multicurrency' => true,
            'order_currency' => $invoice->getOrderCurrencyCode(),
            'total' => $invoice->getGrandTotal()
          ];
          break;
        }
      }
    }

    $values['store_name'] = $this->order->getStoreName();
    $values['store_id'] = $this->order->getStoreId();

    return $values;
  }


  /**
   * Returns current Amazon Order Reference ID
   * @return string
   */
  public function getAmazonOrderID()
  {
    $orderID = '';

    $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/amazon_pay.log');
    $logger = new \Zend\Log\Logger();
    $logger->addWriter($writer);
    $logger->info('orderID ' . $orderID);

    if (!empty($this->order->getExtensionAttributes()->getAmazonOrderReferenceId())) {
      $orderID = $this->order->getExtensionAttributes()->getAmazonOrderReferenceId()->getAmazonOrderReferenceId();
      $logger->info('orderID in order' . $orderID);
    } else {
      $quote = $this->cartRepository->get($this->order->getQuoteId());
      if (!empty($quote->getExtensionAttributes()->getAmazonOrderReferenceId())) {
        $orderID = $quote->getExtensionAttributes()->getAmazonOrderReferenceId()->getAmazonOrderReferenceId();
        $logger->info('orderID in quote ' . json_encode($orderID));
      }
    }

    return $orderID;
  }

}

