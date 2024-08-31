<?php

namespace Theshreyas\AdminProductLinks\Block\Adminhtml;

use Magento\Framework\DataObject;

class ProductNameUrlRenderer extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
    /**
     * Construct function
     *
     * @param \Theshreyas\AdminProductLinks\Helper\Data $helper
     */
    public function __construct(
        protected \Theshreyas\AdminProductLinks\Helper\Data $helper
    ) {
    }

    /**
     * Render link html
     *
     * @param DataObject $row
     */
    public function render(DataObject $row)
    {
        $productUrl = $this->helper->getProductUrl($row->getEntityId());
        return '<a href="'.$productUrl.'" target="_blank">'.$row->getName().'</a>';
    }
}
