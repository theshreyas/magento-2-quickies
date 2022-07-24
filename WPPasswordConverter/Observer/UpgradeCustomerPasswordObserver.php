<?php
namespace Theshreyas\WPPasswordConverter\Observer;

use Magento\Customer\Model\CustomerRegistry;
use Magento\Customer\Model\ResourceModel\CustomerRepository;
use Magento\Framework\Encryption\EncryptorInterface;
use Magento\Framework\Event\ObserverInterface;

class UpgradeCustomerPasswordObserver implements ObserverInterface
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
     * @var CustomerRepository
     */

    protected $customerRepository;

    /**
     * @var helper
     */
    protected $helper;

    /**
     * @param EncryptorInterface $encryptor
     * @param CustomerRegistry $customerRegistry
     * @param CustomerRepositoryInterface $customerRepository
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
     * Upgrade customer password hash when customer has logged in
     *
     * @param  \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $requestParams = $observer->getEvent()->getData('request')->getParams();
        $username      = $requestParams['login']['username'];
        $password      = $requestParams['login']['password'];
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
        }
    }
}
