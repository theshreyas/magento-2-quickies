<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare (strict_types = 1);

namespace Theshreyas\WPPasswordConverter\Plugin\Graphql\Magento\Integration\Model;

use Magento\Customer\Model\CustomerRegistry;
use Magento\Customer\Model\ResourceModel\CustomerRepository;
use Magento\Framework\Encryption\EncryptorInterface;

class CustomerTokenService
{
    /**
     * Encryption model
     *
     * @var EncryptorInterface
     */
    protected $encryptor;
    /**
     * @var CustomerRegistry
     */
    protected $customerRegistry;

    /**
     *
     * @var CustomerRepository
     */
    protected $customerRepository;

    /**
     *
     * @var helper
     */
    protected $helper;

    /**
     * WPPassword constructor.
     *
     * @param \Magento\Framework\Encryption\EncryptorInterface $encryptor
     * @param CustomerRegistry $customerRegistry
     * @param CustomerRepository $customerRepository
     * @param \Theshreyas\WPPasswordConverter\Helper\Data $helper
     */
    public function __construct(
        EncryptorInterface $encryptor,
        CustomerRegistry $customerRegistry,
        CustomerRepository $customerRepository,
        \Theshreyas\WPPasswordConverter\Helper\Data $helper
    ) {
        $this->encryptor          = $encryptor;
        $this->customerRegistry   = $customerRegistry;
        $this->customerRepository = $customerRepository;
        $this->helper             = $helper;
    }
    /**
     * Validate to check whether this is old wordpress Password and save it in magento format
     *
     * @param \Magento\Integration\Model\CustomerTokenService $subject
     * @param string $username
     * @param string $password
     */
    public function beforeCreateCustomerAccessToken(
        \Magento\Integration\Model\CustomerTokenService $subject,
        $username,
        $password
    ) {
        try {
            $customer = $this->customerRepository->get($username);
            if ($customer->getId()) {
                $customerSecure = $this->customerRegistry->retrieveSecureData($customer->getId());
                $hash           = trim($customerSecure->getPasswordHash());

                if (substr($hash, 0, 4) === '$P$B' && $this->helper->checkPassword($password, $hash)) {
                    $customerSecure->setPasswordHash($this->encryptor->getHash($password, true));
                    $this->customerRepository->save($customer);
                }
            }
        } catch (\Exception $e) {
            \Magento\Framework\App\ObjectManager::getInstance()
                ->get(\Psr\Log\LoggerInterface::class)
                ->debug($e->getMessage());
            return [$username, $password];
        }
        return [$username, $password];
    }
}
