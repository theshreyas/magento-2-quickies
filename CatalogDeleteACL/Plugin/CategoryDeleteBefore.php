<?php
declare (strict_types = 1);

namespace Theshreyas\CatalogDeleteACL\Plugin;

use Magento\Framework\AuthorizationInterface;
use Magento\Framework\Exception\LocalizedException;

class CategoryDeleteBefore
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
     * @param \Magento\Catalog\Model\ProductRepository $subject
     * @param int|string $categoryId
     * @return array
     */
    public function beforeDeleteByIdentifier(
        \Magento\Catalog\Model\CategoryRepository $subject,
        $categoryId
    ) {
        $CategoryDeleteAccess = $this->helper->getCategoryDeleteConfig();
        if ($CategoryDeleteAccess && !$this->authorization->isAllowed(self::ACL_RESOURCE)) {
            throw new LocalizedException(__('You don\'t have permission for this operation.'));
        }
        return [$categoryId];
    }
}
