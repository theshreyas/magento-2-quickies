<?php
declare (strict_types = 1);

namespace Theshreyas\CatalogDeleteACL\Plugin;

class AclTreeDisplay
{

    protected const CATEGORY_DELETE = 'Magento_Catalog::delete_category';
    protected const PRODUCT_DELETE  = 'Magento_Catalog::delete_product';

    /**
     * @param \Theshreyas\CatalogDeleteACL\Helper\Data $helper
     */
    public function __construct(
        protected \Theshreyas\CatalogDeleteACL\Helper\Data $helper
    ) {
    }

    /**
     * @param \Magento\Framework\Acl\AclResource\Provider $subject
     * @param array $result
     * @return array $result
     */
    public function afterGetAclResources(
        \Magento\Framework\Acl\AclResource\Provider $subject,
        $result
    ) {
        $ProductDeleteAccess  = $this->helper->getProductDeleteConfig();
        $CategoryDeleteAccess = $this->helper->getCategoryDeleteConfig();
        if (!$ProductDeleteAccess) {
            $this->findAndRemoveAcl($result, self::PRODUCT_DELETE);
        }
        if (!$CategoryDeleteAccess) {
            $this->findAndRemoveAcl($result, self::CATEGORY_DELETE);
        }
        return $result;
    }

    /**
     * @param array $result
     * @param string $unwantedKey
     * @return bool
     */
    public function findAndRemoveAcl(&$result, $unwantedKey)
    {
        try {
            foreach ($result as $key => &$child) {
                if ($child['id'] === $unwantedKey) {
                    unset($result[$key]);
                    return true;
                }
                $this->findAndRemoveAcl($child['children'], $unwantedKey);
            }
        } catch (\Exception $e) {
            return false;
        }
        return false;
    }
}
