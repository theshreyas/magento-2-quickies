<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Theshreyas\SystemXML\Block\Adminhtml\System\Config;

/**
 * Test URL Button
 */
class CheckUrl extends \Magento\Config\Block\System\Config\Form\Field
{

    /**
     * Get the button and scripts contents
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     * @since 100.1.0
     */
    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $originalData = $element->getOriginalData();
        $this->addData(
            [
                'button_label' => __($originalData['button_label']),
                'html_id' => $element->getHtmlId(),
                'ajax_url' => $this->_urlBuilder->getUrl('catalog/search_system_config/testconnection'),
                'field_mapping' => str_replace('"', '\\"', json_encode($this->_getFieldMapping()))
            ]
        );

        return $this->_toHtml();
    }
    
    /**
     * @inheritdoc
     */
    protected function _getFieldMapping(): array
    {
        $fields = [
            'engine' => 'catalog_search_engine',
            'hostname' => 'catalog_search_elasticsearch7_server_hostname',
            'port' => 'catalog_search_elasticsearch7_server_port',
            'index' => 'catalog_search_elasticsearch7_index_prefix',
            'enableAuth' => 'catalog_search_elasticsearch7_enable_auth',
            'username' => 'catalog_search_elasticsearch7_username',
            'password' => 'catalog_search_elasticsearch7_password',
            'timeout' => 'catalog_search_elasticsearch7_server_timeout',
        ];

        return array_merge([], $fields);
    }
}
