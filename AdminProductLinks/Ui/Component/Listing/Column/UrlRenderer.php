<?php

namespace Theshreyas\AdminProductLinks\Ui\Component\Listing\Column;

class UrlRenderer extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * Construct function
     *
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory
     * @param \Theshreyas\AdminProductLinks\Helper\Data $helper
     * @param array $components
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        protected \Theshreyas\AdminProductLinks\Helper\Data $helper,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare DataSource function
     *
     * @param array $dataSource
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {

            foreach ($dataSource['data']['items'] as &$item) {
                $productUrl = $this->helper->getProductUrl($item['entity_id']);
                $item['name'] = '<a href="'.$productUrl.'">'.$item['name'].'</a>';
            }
        }

        return $dataSource;
    }
}
