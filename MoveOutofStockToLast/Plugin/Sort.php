<?php

namespace Theshreyas\MoveOutofStockToLast\Plugin;

class Sort
{

    public function afterGetSort(
        \Magento\Elasticsearch\SearchAdapter\Query\Builder\Sort $subject,
        $sorts
    ) {
        array_unshift($sorts, [
            'quantity_and_stock_status' => [
                'order' => 'desc',
            ],
        ]);
        return $sorts;
    }
}
