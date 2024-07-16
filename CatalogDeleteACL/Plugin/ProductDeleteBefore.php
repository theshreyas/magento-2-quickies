<?php
declare (strict_types = 1);

namespace Theshreyas\CatalogDeleteACL\Plugin;

use Magento\Framework\AuthorizationInterface;

class ProductDeleteBefore
{

    protected const ACL_RESOURCE = 'Magento_Catalog::delete_product';

    /**
     * @param \Magento\Framework\AuthorizationInterface $authorization
     * @param \Theshreyas\CatalogDeleteACL\Helper\Data $helper
     */
    public function __construct(
        protected AuthorizationInterface $authorization,
        protected \Theshreyas\CatalogDeleteACL\Helper\Data $helper
    ) {
    }

    /**
     * @param \Magento\Catalog\Model\ProductRepository $subject
     * @param string $sku
     * @return array
     */
    public function beforeDeleteById(
        \Magento\Catalog\Model\ProductRepository $subject,
        $sku
    ) {
        $productDeleteAccess = $this->helper->getProductDeleteConfig();
        if ($productDeleteAccess && !$this->authorization->isAllowed(self::ACL_RESOURCE)) {
            throw new \Magento\Framework\Exception\AuthorizationException(__('You don\'t have permission for this operation.'));
        }
        return [$sku];
    }
}
