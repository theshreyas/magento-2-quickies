<?php
namespace Theshreyas\CustomerDataSync\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Catalog\Model\Product;
use Magento\Customer\Api\AddressMetadataInterface;
use Magento\Eav\Model\Config as EavConfig;
use Magento\Catalog\Model\Product\Attribute\Backend\Price;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Customer\Model\Customer;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;

class AddDataSyncCustomerAddressAttribute implements DataPatchInterface
{
    /**
     * Data sync attribute
     */
    public const DATA_SYNC = 'data_sync';

    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * EAV Config data.
     *
     * @var EavConfig
     */
    private $eavConfig;

    /**
     * @var CustomerSetupFactory
     */
    protected $customerSetupFactory;

    /**
     * @var AttributeSetFactory
     */
    private $attributeSetFactory;

    /**
     * Constructor Initialize
     *
     * @param EavSetupFactory $eavSetupFactory
     * @param EavConfig $eavConfig
     * @param CustomerSetupFactory $customerSetupFactory
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param AttributeSetFactory $attributeSetFactory
     * @return void
     */
    public function __construct(
        EavSetupFactory $eavSetupFactory,
        EavConfig $eavConfig,
        CustomerSetupFactory $customerSetupFactory,
        ModuleDataSetupInterface $moduleDataSetup,
        AttributeSetFactory $attributeSetFactory
    ) {
        $this->eavConfig = $eavConfig;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->customerSetupFactory = $customerSetupFactory;
        $this->moduleDataSetup = $moduleDataSetup;
        $this->attributeSetFactory = $attributeSetFactory;
    }

    /**
     * Do Upgrade
     *
     * @return void
     */
    public function apply()
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        /* Create Data Sync Attribute */
        $eavSetup->addAttribute(
            AddressMetadataInterface::ENTITY_TYPE_ADDRESS,
            self::DATA_SYNC,
            [
                'label' => 'Data Sync',
                'input' => 'text',
                'type' => 'varchar',
                'visible' => true,
                'required' => false,
                'position' => 200,
                'sort_order' => 200,
                'system' => false
            ]
        );

        $dataSyncAttribute = $this->eavConfig->getAttribute(
            AddressMetadataInterface::ENTITY_TYPE_ADDRESS,
            self::DATA_SYNC
        );

        $dataSyncAttribute->setData(
            'used_in_forms',
            ['adminhtml_customer_address', 'customer_address_edit', 'customer_register_address']
        );
        $dataSyncAttribute->save();
    }
    /**
     * Get aliases
     *
     * @return void
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * Get dependencies
     *
     * @return void
     */
    public static function getDependencies()
    {
        return [];
    }
}
