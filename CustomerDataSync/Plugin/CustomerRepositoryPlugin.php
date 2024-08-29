<?php

declare(strict_types=1);

namespace Theshreyas\CustomerDataSync\Plugin;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;

class CustomerRepositoryPlugin
{
    /**
     * @param \Theshreyas\CustomerDataSync\Helper\AddressDataSync $addressDataSync
     */
    public function __construct(
        protected \Theshreyas\CustomerDataSync\Helper\AddressDataSync $addressDataSync
    ) {
    }

    /**
     * Save Data Sync Timestamp
     *
     * @param CustomerRepositoryInterface $subject
     * @param CustomerInterface $customer
     * @return CustomerInterface
     */
    public function beforeSave(
        CustomerRepositoryInterface $subject,
        CustomerInterface $customer
    ) {
        $customer = $this->addressDataSync->setDataSync($customer);
        return [$customer];
    }
}
