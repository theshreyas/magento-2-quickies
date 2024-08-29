<?php

namespace Theshreyas\CatalogDeleteACL\Helper;

use Magento\Store\Model\ScopeInterface;

class Data
{

    public const CATEGORY_DELETE_ACCESS = 'advanced_acl/acl_access/category_delete';
    public const PRODUCT_DELETE_ACCESS  = 'advanced_acl/acl_access/product_delete';

    /**
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        protected \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        protected \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
    }

    /**
     * @param string $path
     * @param mixed $storeId
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getStoreConfig($path, $storeId = null)
    {
        if (!$storeId) {
            $storeId = $this->getStoreId();
        }
        return $this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE, $storeId);
    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getProductDeleteConfig()
    {
        return $this->getStoreConfig(self::PRODUCT_DELETE_ACCESS);
    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCategoryDeleteConfig()
    {
        return $this->getStoreConfig(self::CATEGORY_DELETE_ACCESS);
    }

    /**
     * @return int
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getStoreId()
    {
        return $this->storeManager->getStore()->getId();
    }
}
