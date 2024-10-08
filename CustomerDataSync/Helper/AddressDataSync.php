<?php

namespace Theshreyas\CustomerDataSync\Helper;

use Magento\Customer\Api\Data\CustomerInterface;

class AddressDataSync
{
    public const DATA_SYNC = 'data_sync';

    /**
     * @param \Magento\Framework\App\State $appState
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone
     */
    public function __construct(
        protected \Magento\Framework\App\State $appState,
        protected \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone
    ) {
    }

    /**
     * Update data_sync field with current time
     *
     * @param CustomerInterface $customer
     * @return CustomerInterface
     */
    public function setDataSync(CustomerInterface $customer)
    {
        $areaCode = $this->appState->getAreaCode();
        if ($areaCode === 'webapi_rest' || $areaCode === 'global') {
            $addresses = $customer->getAddresses();
            $currentTimestamp = $this->timezone->date()->format('Y-m-d H:i:s');
            $customer->setCustomAttribute(self::DATA_SYNC, $currentTimestamp);
            if ($addresses) {
                $addressList = [];
                foreach ($addresses as $address) {
                    $addressList[] = $address->setCustomAttribute(self::DATA_SYNC, $currentTimestamp);
                }
                $customer->setAddresses($addressList);
            }
        }
        return $customer;
    }
}
