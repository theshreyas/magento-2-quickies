<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare (strict_types = 1);

namespace Theshreyas\CmsImage\Model\Resolver;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

/**
 * @inheritdoc
 */
class FeaturedImage implements ResolverInterface
{

    const CMS_TABLE = 'cms_page';

    /**
     * @var ResourceConnection
     */
    private $resourceConnection;

    /**
     * @var StoreManagerInterface
     */
    private $_storeManager;

    /**
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        ResourceConnection $resourceConnection
    ) {
        $this->resourceConnection = $resourceConnection;
        $this->_storeManager      = $storeManager;

    }
    /**
     * @inheritdoc
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        $connection = $this->resourceConnection->getConnection();

        $tableName = $connection->getTableName(self::CMS_TABLE);

        $query = $connection->select()
            ->from($tableName, ['featured_image'])
            ->where('identifier = ?', $value['identifier']);
        // ->where('page_id = ?', (int) $value['page_id']);//page_id deprecated

        $fetchData = $connection->fetchRow($query);
        if (isset($fetchData['featured_image']) && $fetchData['featured_image'] != "") {

            $FeaturedImage = $fetchData['featured_image'];
            return $FeaturedImage;
            // $media_url     = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
            // return $media_url.'cms/featuredimage/'.$FeaturedImage;
        } else {
            return "";
        }
    }
}
