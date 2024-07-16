<?php
declare (strict_types = 1);

namespace Theshreyas\CatalogDeleteACL\Plugin;

use Magento\Framework\AuthorizationInterface;

class CategoryDeleteAction
{

    protected const ACL_RESOURCE = 'Magento_Catalog::delete_category';

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
     * @param \Magento\Catalog\Block\Adminhtml\Category\Edit\DeleteButton $subject
     * @param array $result
     * @return array $result
     */
    public function afterGetButtonData(
        \Magento\Catalog\Block\Adminhtml\Category\Edit\DeleteButton $subject,
        $result
    ) {
        $CategoryDeleteAccess = $this->helper->getCategoryDeleteConfig();
        if ($CategoryDeleteAccess && !$this->authorization->isAllowed(self::ACL_RESOURCE)) {
            return [];
        }
        return $result;
    }
}
