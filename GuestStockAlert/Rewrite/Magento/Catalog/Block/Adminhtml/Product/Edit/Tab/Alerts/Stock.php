<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare (strict_types = 1);

namespace Theshreyas\GuestStockAlert\Rewrite\Magento\Catalog\Block\Adminhtml\Product\Edit\Tab\Alerts;

class Stock extends \Magento\Catalog\Block\Adminhtml\Product\Edit\Tab\Alerts\Stock
{
    protected function _prepareCollection()
    {
        $productId = $this->getRequest()->getParam('id');
        $websiteId = 0;
        if ($store = $this->getRequest()->getParam('store')) {
            $websiteId = $this->_storeManager->getStore($store)->getWebsiteId();
        }
        if ($this->moduleManager->isEnabled('Magento_ProductAlert')) {

            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $resource      = $objectManager->get('Magento\Framework\App\ResourceConnection');
            $connection    = $resource->getConnection();
            $sql           = "SELECT '' as firstname,'' as lastname, alert.email, `alert`.`add_date`, `alert`.`send_date`, `alert`.`send_count` from `product_alert_stock` AS `alert` WHERE (alert.product_id=" . $productId . ") and alert.customer_id = 0";
            $result        = $connection->fetchAll($sql);

            $collection = $this->_stockFactory->create()->getCustomerCollection()->join($productId, $websiteId);
            foreach ($collection as $key => $value) {
                $result[] = $value->getData();
            }
            $collection = $objectManager->create('\Magento\Framework\Data\Collection');
            foreach ($result as $key => $v) {
                $DataObject = new \Magento\Framework\DataObject($v);
                $collection->addItem(
                    $DataObject
                );
            }
            $this->setCollection($collection);
        }

        // return parent::_prepareCollection();
    }
}
