<?php

namespace Theshreyas\WidgetFeaturedCategories\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class FeaturedCategories extends Template implements BlockInterface
{
    protected $_template = "widget/categories.phtml";

    private $categoryCollectionFactory;

    /**
     * @param Template\Context $context
     * @param categoryCollectionFactory $categoryCollectionFactory
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->categoryCollectionFactory = $categoryCollectionFactory;
    }

    /**
     * @param $limit
     * @return \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory[]
     */
    public function getCategories($category_ids,$limit=50)
    {
        $category_ids = array_map('intval', explode(',', $category_ids));

        $categoryCollection = $this->categoryCollectionFactory->create();
        
        $categoryCollection->addAttributeToSelect('*');

        $categoryCollection->addFieldToFilter('entity_id', $category_ids);

        $categoryCollection->setPageSize($limit);

        return $categoryCollection;
    }
}