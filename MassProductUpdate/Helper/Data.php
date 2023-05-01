<?php
namespace Theshreyas\MassProductUpdate\Helper;

use Magento\Framework\App\ResourceConnection;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var \Magento\Framework\App\ProductMetadataInterface
     */
    protected $productMetadata;

    /**
     * @var \Magento\Framework\DB\Adapter\AdapterInterface
     */
    protected $connection;

    /**
     * @var ResourceConnection
     */
    protected $resource;

    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Backend\Model\Url $urlBulder,
        \Magento\Framework\App\ProductMetadataInterface $productMetadata,
        \Magento\Framework\App\Helper\Context $context,
        ResourceConnection $resource
    ) {
        parent::__construct($context);
        $this->_objectManager = $objectManager;
        $this->_scopeConfig = $context->getScopeConfig();
        $this->urlBulder = $urlBulder;
        $this->productMetadata = $productMetadata;
        $this->connection = $resource->getConnection();
        $this->resource = $resource;
    }

    /**
     * Get command data array.
     * @return array
     */
    public function getActionDataByName($type) {
        $className = 'Theshreyas\MassProductUpdate\Model\Command\\'  . ucfirst($type);
        if (class_exists($className)) {
            $command = $this->_objectManager->create($className);
            $result = $command->getCreationData();
            $result['url'] = $this->urlBulder->getUrl('theshreyas_massproductupdate/massaction/index');
            //echo '<pre>'; print_r($result); exit;
        }
        else {
            /* initialization for delimiter lines*/
            $result = [
                'confirm_title' => '',
                'confirm_message' => '',
                'type' => $type,
                'label' => '------------',
                'url' => '',
                'fieldLabel'      => ''
            ];
        }

        return $result;
    }

    public function getMassUpdateOptions() {
        return ['modifyprice','modifyspecial','addspecial'];
    }

}
