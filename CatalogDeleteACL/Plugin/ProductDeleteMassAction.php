<?php
declare (strict_types = 1);

namespace Theshreyas\CatalogDeleteACL\Plugin;

use Magento\Framework\AuthorizationInterface;

class ProductDeleteMassAction
{

    protected const ACL_RESOURCE  = 'Magento_Catalog::delete_product';
    protected const DELETE_ACTION = 'delete';

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
     * @param \Magento\Catalog\Ui\Component\Product\MassAction $subject
     * @param bool $result
     * @param string $actionType
     * @return bool $result
     */
    public function afterIsActionAllowed(
        \Magento\Catalog\Ui\Component\Product\MassAction $subject,
        $result,
        $actionType
    ) {
        if ($actionType == self::DELETE_ACTION) {
            $productDeleteAccess = $this->helper->getProductDeleteConfig();
            if ($productDeleteAccess && !$this->authorization->isAllowed(self::ACL_RESOURCE)) {
                return false;
            }
        }
        return $result;
    }
}
