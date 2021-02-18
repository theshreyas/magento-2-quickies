<?php

namespace Theshreyas\FrontendDisable\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper{

    /**
     * Get value from config
     */
    public function getConfigType() {
        return $this->scopeConfig->getValue(
            'admin/frontend_disable/show_as_frontend', ScopeInterface::SCOPE_WEBSITE
        );
    }
    /**
     * Get Custom URL from config
     */
    public function getCustomUrl() {
        return $this->scopeConfig->getValue(
            'admin/frontend_disable/custom_url', ScopeInterface::SCOPE_WEBSITE
        );
    }
}