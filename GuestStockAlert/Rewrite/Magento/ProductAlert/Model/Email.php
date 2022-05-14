<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare (strict_types = 1);

namespace Theshreyas\GuestStockAlert\Rewrite\Magento\ProductAlert\Model;

use Magento\Framework\App\Area;
use Magento\ProductAlert\Block\Email\AbstractEmail;
use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Model\ScopeInterface;

class Email extends \Magento\ProductAlert\Model\Email
{
    const XML_PATH_EMAIL_IDENTITY = 'catalog/productalert/email_identity';

    /**
     * Send customer email
     *
     * @return bool
     * @throws MailException
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function send()
    {
        $storeId = 1;
        if ($this->_website === null || !$this->isExistDefaultStore()) {
            return false;
        }
        if (!empty(get_class_methods($this->_customer))) {
            $email        = $this->_customer->getEmail();
            $customerName = $this->_customerHelper->getCustomerName($this->_customer);
            $storeId      = (int) $this->_customer->getStoreId();
        } else {
            if (!$this->_customer) {
                return false;
            }

            $email        = $this->_customer->email;
            $customerName = 'Customer';
        }

        $products           = $this->getProducts();
        $templateConfigPath = $this->getTemplateConfigPath();
        if (!in_array($this->_type, ['price', 'stock']) || count($products) === 0 || !$templateConfigPath) {
            return false;
        }

        $storeId = (int) $this->getStoreId() ?: $storeId;
        $store   = $this->getStore($storeId);

        $this->_appEmulation->startEnvironmentEmulation($storeId);

        $block = $this->getBlock();
        $block->setStore($store)->reset();

        // Add products to the block
        foreach ($products as $product) {
            if (!empty(get_class_methods($this->_customer))) {
                $product->setCustomerGroupId($this->_customer->getGroupId());
            }

            $block->addProduct($product);
        }

        $templateId = $this->_scopeConfig->getValue(
            $templateConfigPath,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );

        $alertGrid = $this->_appState->emulateAreaCode(
            Area::AREA_FRONTEND,
            [$block, 'toHtml']
        );
        $this->_appEmulation->stopEnvironmentEmulation();

        $this->_transportBuilder->setTemplateIdentifier(
            $templateId
        )->setTemplateOptions(
            ['area' => Area::AREA_FRONTEND, 'store' => $storeId]
        )->setTemplateVars(
            [
                'customerName' => $customerName,
                'alertGrid'    => $alertGrid,
            ]
        )->setFromByScope(
            $this->_scopeConfig->getValue(
                self::XML_PATH_EMAIL_IDENTITY,
                ScopeInterface::SCOPE_STORE,
                $storeId
            ),
            $storeId
        )->addTo(
            $email,
            $customerName
        )->getTransport()->sendMessage();

        return true;
    }

    /**
     * Retrieve the store for the email
     *
     * @param int $storeId
     * @return StoreInterface
     * @throws NoSuchEntityException
     */
    private function getStore(int $storeId): StoreInterface
    {
        return $this->_storeManager->getStore($storeId);
    }

    /**
     * Retrieve the block for the email based on type
     *
     * @return Price|Stock
     * @throws LocalizedException
     */
    private function getBlock(): AbstractEmail
    {
        return $this->_type === 'price'
        ? $this->_getPriceBlock()
        : $this->_getStockBlock();
    }

    /**
     * Retrieve the products for the email based on type
     *
     * @return array
     */
    private function getProducts(): array
    {
        return $this->_type === 'price'
        ? $this->_priceProducts
        : $this->_stockProducts;
    }

    /**
     * Retrieve template config path based on type
     *
     * @return string
     */
    private function getTemplateConfigPath(): string
    {
        return $this->_type === 'price'
        ? self::XML_PATH_EMAIL_PRICE_TEMPLATE
        : self::XML_PATH_EMAIL_STOCK_TEMPLATE;
    }

    /**
     * Check if exists default store.
     *
     * @return bool
     */
    private function isExistDefaultStore(): bool
    {
        if (!$this->_website->getDefaultGroup() || !$this->_website->getDefaultGroup()->getDefaultStore()) {
            return false;
        }
        return true;
    }
}
