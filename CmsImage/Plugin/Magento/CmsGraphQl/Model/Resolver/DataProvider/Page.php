<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare (strict_types = 1);

namespace Theshreyas\CmsImage\Plugin\Magento\CmsGraphQl\Model\Resolver\DataProvider;

use Magento\Cms\Api\Data\PageInterface;
use Magento\Cms\Api\PageRepositoryInterface;

class Page
{
    /**
     * @var PageRepositoryInterface
     */
    private $pageRepository;

    public function __construct(
        PageRepositoryInterface $pageRepository
    ) {
        $this->pageRepository = $pageRepository;
    }

    public function afterGetDataByPageIdentifier(
        \Magento\CmsGraphQl\Model\Resolver\DataProvider\Page $subject,
        $result
    ) {
        if ($result && isset($result[PageInterface::PAGE_ID])) {
            $page                     = $this->pageRepository->getById($result[PageInterface::PAGE_ID]);
            $result['featured_image'] = $page->getFeaturedImage();
        }
        return $result;
    }

    public function afterGetDataByPageId(
        \Magento\CmsGraphQl\Model\Resolver\DataProvider\Page $subject,
        $result
    ) {
        if ($result && isset($result[PageInterface::PAGE_ID])) {
            $page                     = $this->pageRepository->getById($result[PageInterface::PAGE_ID]);
            $result['featured_image'] = $page->getFeaturedImage();
        }
        return $result;
    }
}
