<?php
namespace Theshreyas\SetupDataWithCSV\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchVersionInterface;

class AddData implements DataPatchInterface, PatchVersionInterface
{
    protected $moduleReader;
    protected $connection;

    protected $resource;
    private $moduleDataSetup;
    /**
     * @var Csv
     */
    protected $csv;
    /**
     * @var File
     */
    protected $file;

    public function __construct(
        \Magento\Framework\Module\Dir\Reader $moduleReader,
        ModuleDataSetupInterface $moduleDataSetup,
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\Framework\File\Csv $csv,
        \Magento\Framework\Filesystem\Driver\File $fileDriver

    ) {
        $this->moduleReader    = $moduleReader;
        $this->moduleDataSetup = $moduleDataSetup;
        $this->connection      = $resource->getConnection();
        $this->resource        = $resource;
        $this->csv             = $csv;
        $this->fileDriver      = $fileDriver;
    }

    public function apply()
    {
        $setupDir = $this->moduleReader->getModuleDir(
            \Magento\Framework\Module\Dir::MODULE_SETUP_DIR,
            'Theshreyas_SetupDataWithCSV'
        );
        $bulkInsertData = [];
        $csvFile        = $setupDir . '/Patch/Data/US_zipcodes.csv';

        if ($this->fileDriver->isExists($csvFile)) {

            $this->csv->setDelimiter(",");
            $csvData = $this->csv->getData($csvFile);

            if (!empty($csvData)) {

                $c = 0;
                foreach ($csvData as $key => $row) {

                    if ($c != 0) {
                        $bulkInsertData[] = [
                            'zipcode'     => trim($row[0]),
                            'state'       => trim($row[1]),
                            'country'     => trim($row[2]),
                            'description' => trim($row[3]),
                        ];
                    }
                    $c++;
                }
            }

        }
        $this->moduleDataSetup->startSetup();

        $zipcode_table = $this->resource->getTableName('test_uszipcodes');

        $this->connection->insertMultiple($zipcode_table, $bulkInsertData);
        // $model = $this->_objectManager->create(\Theshreyas\SetupDataWithCSV\Model\Uszipcodes::class); //if model is created
        // $model->setZipcode('12345')
        //     ->setState('IL')
        //     ->setCountry('US')
        //     ->setDescription('IL Description');
        // $model->save();
        $this->moduleDataSetup->endSetup();
    }

    public static function getDependencies()
    {
        return [];
    }

    public static function getVersion()
    {
        return '1.0.1';
    }

    public function getAliases()
    {
        return [];
    }
}
