<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * Product in category grid
 */
namespace Theshreyas\AdminProductLinks\Block\Adminhtml\Category\Tab;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Grid;
use Magento\Backend\Block\Widget\Grid\Column;
use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Helper\Data;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Registry;

class Product extends \Magento\Catalog\Block\Adminhtml\Category\Tab\Product
{
   
    /**
     * Prepare columns.
     *
     * @return Extended
     */
    protected function _prepareColumns()
    {
        parent::_prepareColumns();
        $this->addColumnAfter(
            'name',
            [
                'header' => __('Name'),
                'renderer'  => \Theshreyas\AdminProductLinks\Block\Adminhtml\ProductNameUrlRenderer::class,
                'index' => 'name'
            ],
            'entity_id'
        );
        $this->addColumnsOrder('name', 'entity_id')->sortColumnsByOrder();
        return $this;
    }
}
