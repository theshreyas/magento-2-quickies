<?php
namespace Theshreyas\MassProductUpdate\Helper;

use Magento\Framework\App\ResourceConnection;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var \Magento\Framework\DB\Adapter\AdapterInterface
     */
    protected $connection;

    public function __construct(
        protected \Magento\Framework\ObjectManagerInterface $objectManager,
        protected \Magento\Backend\Model\Url $urlBulder,
        protected \Magento\Framework\App\ProductMetadataInterface $productMetadata,
        protected \Magento\Framework\App\Helper\Context $context,
        protected ResourceConnection $resource
    ) {
        parent::__construct($context);
        $this->objectManager = $objectManager;
        $this->scopeConfig = $context->getScopeConfig();
        $this->connection = $resource->getConnection();
    }

    /**
     * Get command data array.
     * @return array
     */
    public function getActionDataByName($type)
    {
        $className = 'Theshreyas\MassProductUpdate\Model\Command\\'  . ucfirst($type);
        if (class_exists($className)) {
            $command = $this->objectManager->create($className);
            $result = $command->getCreationData();
            $result['url'] = $this->urlBulder->getUrl('theshreyas_massproductupdate/massaction/index');
        } else {
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

    public function getMassUpdateOptions()
    {
        return ['modifyprice','modifyspecial','addspecial'];
    }
}
