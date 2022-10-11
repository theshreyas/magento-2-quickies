<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Theshreyas\CmsImage\Model\Cms\Page;

use Magento\Cms\Api\Data\PageInterface;
use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Cms\Model\PageFactory;
use Magento\Cms\Model\ResourceModel\Page\CollectionFactory;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\AuthorizationInterface;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;

/**
 * Class DataProvider
 */
class DataProvider extends \Magento\Cms\Model\Page\DataProvider
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @var PageRepositoryInterface
     */
    private $pageRepository;

    /**
     * @var AuthorizationInterface
     */
    private $auth;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var CustomLayoutManagerInterface
     */
    private $customLayoutManager;

    /**
     * @var PageFactory
     */
    private $pageFactory;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var StoreManagerInterface
     */
    private $_storeManager;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param Magento\Cms\Model\ResourceModel\Page\CollectionFactory $pageCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     * @param Magento\Cms\Api\Data\PageInterface|null $pool
     * @param AuthorizationInterface|null $auth
     * @param RequestInterface|null $request
     * @param CustomLayoutManagerInterface|null $customLayoutManager
     * @param PageRepositoryInterface|null $pageRepository
     * @param PageFactory|null $pageFactory
     * @param LoggerInterface|null $logger
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Magento\Cms\Model\ResourceModel\Page\CollectionFactory $pageCollectionFactory,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = [],
        \Magento\Ui\DataProvider\Modifier\PoolInterface $pool = null,
        \Magento\Framework\AuthorizationInterface $auth = null,
        \Magento\Framework\App\RequestInterface $request = null,
        \Magento\Cms\Model\Page\CustomLayoutManagerInterface $customLayoutManager = null,
        \Magento\Cms\Api\PageRepositoryInterface $pageRepository = null,
        \Magento\Cms\Model\PageFactory $pageFactory = null,
        \Psr\Log\LoggerInterface $logger = null
    ) {
        $this->request        = $request ?? ObjectManager::getInstance()->get(RequestInterface::class);
        $this->pageRepository = $pageRepository ?? ObjectManager::getInstance()->get(PageRepositoryInterface::class);
        $this->pageFactory    = $pageFactory ?: ObjectManager::getInstance()->get(PageFactory::class);
        $this->_storeManager  = $storeManager;

        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $pageCollectionFactory,
            $dataPersistor,
            $meta,
            $data,
            $pool,
            $auth,
            $request,
            $customLayoutManager,
            $pageRepository,
            $pageFactory,
            $logger
        );
    }
    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $page = $this->getCurrentPage();

        $this->loadedData[$page->getId()] = $page->getData();

        if ($page->getCustomLayoutUpdateXml() || $page->getLayoutUpdateXml()) {
            //Deprecated layout update exists.
            $this->loadedData[$page->getId()]['layout_update_selected'] = '_existing_';
        }
        if (!empty($this->loadedData[$page->getId()]['featured_image'])) {
            $media_url  = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
            $image_name = $this->loadedData[$page->getId()]['featured_image'];
            unset($this->loadedData[$page->getId()]['featured_image']);
            $this->loadedData[$page->getId()]['featured_image'][0]['name'] = $image_name;
            $this->loadedData[$page->getId()]['featured_image'][0]['url']  = $media_url . "cms/featuredimage/" . $image_name;
        }
        return $this->loadedData;
    }
    /**
     * Return current page
     *
     * @return PageInterface
     */
    private function getCurrentPage(): PageInterface
    {
        $pageId = $this->getPageId();
        if ($pageId) {
            try {
                $page = $this->pageRepository->getById($pageId);
            } catch (LocalizedException $exception) {
                $page = $this->pageFactory->create();
            }

            return $page;
        }

        $data = $this->dataPersistor->get('cms_page');
        if (empty($data)) {
            return $this->pageFactory->create();
        }
        $this->dataPersistor->clear('cms_page');

        return $this->pageFactory->create()
            ->setData($data);
    }

    /**
     * Returns current page id from request
     *
     * @return int
     */
    private function getPageId(): int
    {
        return (int) $this->request->getParam($this->getRequestFieldName());
    }
}
