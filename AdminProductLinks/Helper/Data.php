<?php

namespace Theshreyas\AdminProductLinks\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * Construct function
     *
     * @param \Magento\Backend\Helper\Data $helper
     */
    public function __construct(
        protected \Magento\Backend\Helper\Data $helper
    ) {
    }

    /**
     * Get Product Url from Id
     *
     * @param int|null $productId
     */
    public function getProductUrl($productId = null)
    {
        return $this->helper->getUrl('catalog/product/edit', ['id' => $productId]);
    }
}
