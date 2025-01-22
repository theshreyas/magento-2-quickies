<?php

namespace Theshreyas\CustomerImportDisableEmail\Plugin;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Model\EmailNotification as CustomerEmailNotification;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class EmailNotificationPlugin
{
    public const XML_PATH_WELCOME_ENABLED = 'customer/create_account/welcome_email_enabled';
    public const BULK_API_AREA_CODE = 'global';
    public const SINGLE_API_AREA_CODE = 'webapi_rest';

    /**
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\App\State $state
     */
    public function __construct(
        protected \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        protected \Magento\Store\Model\StoreManagerInterface $storeManager,
        protected \Magento\Framework\App\State $state
    ) {
    }

    /**
     * Disable email in customer import
     *
     * @param CustomerEmailNotification $subject
     * @param \Closure $proceed
     * @param CustomerInterface $customer
     * @param string $type
     * @param string $backUrl
     * @param int|null $storeId
     * @param string $sendemailStoreId
     * @return mixed
     */
    public function aroundNewAccount(
        CustomerEmailNotification $subject,
        \Closure $proceed,
        CustomerInterface $customer,
        $type = CustomerEmailNotification::NEW_ACCOUNT_EMAIL_REGISTERED,
        $backUrl = '',
        $storeId = 0,
        $sendemailStoreId = null
    ) {
        $emailDisabled = $this->scopeConfig->getValue(
            self::XML_PATH_WELCOME_ENABLED,
            ScopeInterface::SCOPE_STORE,
            $this->storeManager->getStore()->getStoreId()
        );
        $areaCode = $this->state->getAreaCode();
        if ($areaCode == self::BULK_API_AREA_CODE || ($areaCode == self::SINGLE_API_AREA_CODE && $emailDisabled)) {
            return $subject;
        }
        return $proceed(
            $customer,
            $type,
            $backUrl,
            $storeId,
            $sendemailStoreId
        );
    }
}
