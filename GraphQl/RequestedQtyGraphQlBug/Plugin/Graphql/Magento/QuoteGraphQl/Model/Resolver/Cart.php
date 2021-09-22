<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare (strict_types = 1);


namespace Theshreyas\RequestedQtyGraphQlBug\Plugin\Graphql\Magento\QuoteGraphQl\Model\Resolver;

use Magento\CatalogInventory\Api\StockRegistryInterface;

class Cart
{
    /**
     * @var StockRegistryInterface|null
     */
    private $stockRegistry;

    public function __construct(
        StockRegistryInterface $stockRegistry
    ) {
        $this->stockRegistry = $stockRegistry;
    }

    public function afterResolve(
        \Magento\QuoteGraphQl\Model\Resolver\Cart $subject,
        $result,
        $field,
        $context,
        $info,
        array $value = null,
        array $args = null
    ) {
        $cart = $result['model'];

        foreach ($cart->getErrors() as $k => $err) {//$cart->getHasError()
            if ($err->getText() === 'The requested qty is not available') {

                $cart->getErrors()[$k]->setText('Out of stock products removed from cart.');

                foreach ($cart->getAllVisibleItems() as $item) {

                    $stockItem = $this->stockRegistry->getStockItem($item->getProductId());

                    if ($stockItem->getManageStock() && $stockItem->getQty() - $stockItem->getMinQty() - $item->getQty() < 0) {
                        $item->delete();
                    }
                }
            }
        }
        return [
            'model' => $cart,
        ];
    }
}
