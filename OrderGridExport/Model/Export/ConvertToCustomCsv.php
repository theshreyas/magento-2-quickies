<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Theshreyas\OrderGridExport\Model\Export;

use Magento\Ui\Model\Export\MetadataProvider;
use Magento\Ui\Model\Export\SearchResultIteratorFactory;
use Magento\Framework\Api\Search\DocumentInterface;
use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Convert\Excel;
use Magento\Framework\Convert\ExcelFactory;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\WriteInterface;
use Magento\Ui\Component\MassAction\Filter;

/**
 * Class ConvertToCustomCsv
 */
class ConvertToCustomCsv
{
    /**
     * @var WriteInterface
     */
    protected $directory;

    /**
     * @var MetadataProvider
     */
    protected $metadataProvider;

    /**
     * @var ExcelFactory
     */
    protected $excelFactory;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var SearchResultIteratorFactory
     */
    protected $iteratorFactory;

    /**
     * @var array
     */
    protected $fields;

    protected $resourceConnection;

    /**
     * @param Filesystem $filesystem
     * @param Filter $filter
     * @param MetadataProvider $metadataProvider
     * @param ExcelFactory $excelFactory
     * @param SearchResultIteratorFactory $iteratorFactory
     */
    public function __construct(
        ResourceConnection $resourceConnection,
        Filesystem $filesystem,
        Filter $filter,
        MetadataProvider $metadataProvider,
        ExcelFactory $excelFactory,
        SearchResultIteratorFactory $iteratorFactory
    ) {
        $this->resourceConnection = $resourceConnection;
        $this->filter = $filter;
        $this->directory = $filesystem->getDirectoryWrite(DirectoryList::VAR_DIR);
        $this->metadataProvider = $metadataProvider;
        $this->excelFactory = $excelFactory;
        $this->iteratorFactory = $iteratorFactory;
    }

    /**
     * Returns Filters with options
     *
     * @return array
     */
    protected function getOptions()
    {
        if (!$this->options) {
            $this->options = $this->metadataProvider->getOptions();
        }
        return $this->options;
    }

    /**
     * Returns DB fields list
     *
     * @return array
     */
    protected function getFields()
    {
        if (!$this->fields) {
            $component = $this->filter->getComponent();
            $this->fields = $this->metadataProvider->getFields($component);
        }
        return $this->fields;
    }

    /**
     * Returns row data
     *
     * @param DocumentInterface $document
     * @return array
     */
    public function getRowData(DocumentInterface $document)
    {
        return $this->metadataProvider->getRowData($document, $this->getFields(), $this->getOptions());
    }

    /**
     * Returns Custom CSV file
     *
     * @return array
     * @throws LocalizedException
     */
    public function getCustomCsvFile()
    {
        $component = $this->filter->getComponent();
        $name = md5(microtime());
        $file = 'export/' . $component->getName() . $name . '.csv';

        $this->filter->prepareComponent($component);
        $this->filter->applySelectionOnTargetProvider();

        $dataProvider       = $component->getContext()->getDataProvider();
        $dataProvider->getSearchCriteria()->setCurrentPage(0)->setPageSize(3000);

        $items              = $dataProvider->getSearchResult()->getItems();
        $orderIds           = [];
        $orderStatusLabels  = ['order_received' => 'Order Received','processing' => 'Processing','pending_payment' => 'Pending Payment','fraud' => 'Suspected Fraud','payment_review' => 'Payment Review','v12finance_awaitingFulfilment' => 'V12finance AwaitingFulfilment','v12finance_referred' => 'V12finance Referred Pending Payment','payment_pending' => 'Payment Pending','pending' => 'Pending','partial_deposit_paid' => 'Partial Deposit Paid','holded' => 'On Hold','complete' => 'Complete','closed' => 'Refunded','payment_failed' => 'Payment Failed','canceled' => 'Canceled','paypal_canceled_reversal' => 'PayPal Canceled Reversal','failed_finance' => 'Failed Finance','pending_paypal' => 'Pending PayPal','paypal_reversed' => 'PayPal Reversed'];


        foreach ($items as $item) {
            $orderIds[] = $item->getCustomAttribute('increment_id')->getValue();
        }

        $orderIds = implode("','",$orderIds);

        $this->directory->create('export');

        $stream = $this->directory->openFile($file, 'w+');
        $stream->lock();
        
        $headers = ['Date Placed','Web Reference','Item Reference','Name','Email','Payment Method','Amount Paid','Address','Contact Number','Order Status'];

        $stream->writeCsv($headers);

        $query = "select o.created_at as 'order_date',
                    o.increment_id as 'order_number',
                    o.status as 'order_status',
                    i.sku as 'sku',
                    i.product_options,
                    CONCAT(o.customer_firstname, ' ',o.customer_lastname) as 'name',
                    o.customer_email as 'email',
                    p.method as 'payment_method',
                    o.total_paid as 'total_paid',
                    CONCAT(sh.street,' ',sh.city,' ',sh.postcode) as 'shipping_address',
                    sh.telephone as 'telephone'
                    from sales_order_item i 
                    inner join sales_order o on o.entity_id = i.order_id
                    right join sales_order_address as sh on o.entity_id = sh.parent_id and o.shipping_address_id = sh.entity_id
                    inner join sales_order_payment p on o.entity_id = p.parent_id
                    where i.parent_item_id IS NULL and o.increment_id IN ('".$orderIds."') 
                    order by o.created_at desc limit 3000;";

        $connection = $this->resourceConnection->getConnection();
        $result = $connection->fetchAll($query);
        
        foreach ($result as $item)
        {
            $ring_size = $width = $length = $chain = $cut = $carat = $clarity = $color = $metal = $certificate_number = '';

            // $options = json_decode($item['product_options'],TRUE);
            
            // if(isset($options)){
            //     if(isset($options['attributes_info'])){
            //         foreach ($options['attributes_info'] as $k => $v) {
            //             if(isset($v['label'])){
            //                 if($v['label'] == 'Metal')
            //                     $metal   = $v['value'];
            //                 else if($v['label'] == 'Carat')
            //                     $carat   = $v['value'];
            //                 else if($v['label'] == 'Colour')
            //                     $color   = $v['value'];
            //             }
            //         }
            //     }
            //     if(isset($options['options'])){
            //         foreach ($options['options'] as $k => $v) {
            //             if(isset($v['label'])){
            //                 if($v['label'] == 'Metal')
            //                     $metal = $v['value'];
            //                 else if($v['label'] == 'Certificate')
            //                     $certificate = $v['value'];
            //             }
            //         }
            //     }
            //     if(isset($options['info_buyRequest'])){
            //         if(isset($options['info_buyRequest']['bracelet_length'])){
            //             $length = $options['info_buyRequest']['bracelet_length'];
            //         }
            //         if(isset($options['info_buyRequest']['chain'])){
            //             $chain = $options['info_buyRequest']['chain'];
            //         }
            //     }
            //     if(isset($options['additional_options'])){
            //         foreach ($options['additional_options'] as $k => $v) {
            //             if(isset($v['label'])){
            //                 if($v['label'] == 'Ring Size')
            //                     $ring_size = $v['value'];
            //                 else if($v['label'] == 'Width')
            //                     $width = $v['value'];
            //             }
            //         }
            //     }
            // }
            $order_date         = $item['order_date'];
            $order_number       = $item['order_number'];
            $order_status       = isset($orderStatusLabels[$item['order_status']]) ? $orderStatusLabels[$item['order_status']] : $item['order_status'];
            $sku                = $item['sku'];
            $name               = $item['name'];
            $email              = $item['email'];
            $payment_method     = $item['payment_method'];
            $total_paid         = $item['total_paid'];
            $shipping_address   = $item['shipping_address'];
            $telephone          = $item['telephone'];

            $csvRow = [$order_date,$order_number,$sku,$name,$email,$payment_method,$total_paid,$shipping_address,$telephone,$order_status];
            
            $stream->writeCsv($csvRow);
        }

        $stream->unlock();
        $stream->close();

        return [
            'type' => 'filename',
            'value' => $file,
            'rm' => true  // can delete file after use
        ];
    }

    /**
     * @param string $componentName
     * @param array $items
     * @return void
     */
    protected function prepareItems($componentName, array $items = [])
    {
        foreach ($items as $document) {
            $this->metadataProvider->convertDate($document, $componentName);
        }
    }
}