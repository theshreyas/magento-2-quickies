<?php

declare(strict_types=1);

namespace Theshreyas\CustomerDataSync\Plugin;

class CreateAccountPlugin
{

    /**
     * @param \Theshreyas\CustomerDataSync\Helper\AddressDataSync $addressDataSync
     */
    public function __construct(
        protected \Theshreyas\CustomerDataSync\Helper\AddressDataSync $addressDataSync
    ) {
    }

    /**
     * Update data_sync field on customer create
     *
     * @param \Magento\Customer\Api\AccountManagementInterface $subject
     * @param \Magento\Customer\Api\Data\CustomerInterface $customer
     * @return \Magento\Customer\Api\Data\CustomerInterface
     */
    public function beforeCreateAccount(
        \Magento\Customer\Api\AccountManagementInterface $subject,
        \Magento\Customer\Api\Data\CustomerInterface $customer
    ) {
        $customer = $this->addressDataSync->setDataSync($customer);
        return [$customer];
    }
}
