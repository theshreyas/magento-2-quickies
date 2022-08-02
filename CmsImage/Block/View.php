<?php

namespace Theshreyas\CmsImage\Block;

use Magento\CmsGraphQl\Model\Resolver\DataProvider\Page as PageDataProvider;

class View extends \Magento\Framework\View\Element\Template
{
    /**
     * @var PageDataProvider
     */
    private $pageDataProvider;

    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    public function __construct(\Magento\Catalog\Block\Product\Context $context,
        PageDataProvider $pageDataProvider,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $data = []) {
        $this->pageDataProvider = $pageDataProvider;
        $this->_storeManager    = $storeManager;
        parent::__construct($context, $data);
    }

    protected function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    public function getOgImageUrl()
    {

        $page_id  = $this->getRequest()->getParam('page_id');
        $pageData = $this->pageDataProvider->getDataByPageId((int) $page_id);

        // return $this->getRequest()->getUriString();
        $_ogimage = $pageData['featured_image'];
        if ($_ogimage != "") {
            $media_url = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
            $_ogimage  = $media_url . "cms/featuredimage/" . $_ogimage;
        }

        return $_ogimage;
    }
}
