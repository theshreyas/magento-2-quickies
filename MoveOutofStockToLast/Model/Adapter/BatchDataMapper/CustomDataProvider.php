<?php

declare (strict_types = 1);

namespace Theshreyas\MoveOutofStockToLast\Model\Adapter\BatchDataMapper;

use Magento\AdvancedSearch\Model\Adapter\DataMapper\AdditionalFieldsProviderInterface;

class CustomDataProvider implements AdditionalFieldsProviderInterface
{

    /**
     * @inheritdoc
     */
    public function getFields(array $productIds, $storeId)
    {

        $object_manager = \Magento\Framework\App\ObjectManager::getInstance();
        $stockobj       = $object_manager->create(\Magento\CatalogInventory\Api\StockRegistryInterface::class);

        $fields = [];

        foreach ($productIds as $productId) {

            $stockItem          = $stockobj->getStockItem($productId);
            $isInStock          = $stockItem ? $stockItem->getIsInStock() : false;
            $fields[$productId] = ['quantity_and_stock_status' => ($isInStock ? 1 : 0)];
        }

        return $fields;
    }
}
