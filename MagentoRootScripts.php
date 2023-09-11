<?php
//put this file in magento root 
define('DS', DIRECTORY_SEPARATOR);
use \Magento\Framework\App\Bootstrap;

include './app/bootstrap.php';
$bootstrap     = Bootstrap::create(BP, $_SERVER);
$objectManager = $bootstrap->getObjectManager();
// $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
$app_state = $objectManager->get('\Magento\Framework\App\State');
$app_state->setAreaCode('frontend');

$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
// Lad product by ID
try{
    $product = $objectManager->get('\Magento\Catalog\Model\ProductRepository')->getById($id);
    if($product->getId())
} catch(\Magento\Framework\Exception\NoSuchEntityException $e) {

// Load Product by Sku
$productRepository = $objectManager->get('\Magento\Catalog\Model\ProductRepository');
try{
    $product           = $productRepository->get($product_sku);
} catch(\Magento\Framework\Exception\NoSuchEntityException $e) {
    $e->getMessage();
}
if(isset($product) && $product->getId()) //product found

// Load Product ID by Sku
$productId = $objectManager->get('Magento\Catalog\Model\Product')->getIdBySku($product_sku);
//if($productId) //product found  else //not found

// Assign single Product To multiple Category
$new_category_id        = array('100', '101');
$sku                    = 'skuofproduct';
$CategoryLinkRepository = $objectManager->get('\Magento\Catalog\Api\CategoryLinkManagementInterface');
$CategoryLinkRepository->assignProductToCategories($sku, $new_category_id);

// Remove Products From Category
$category_id            = 101;
$sku                    = 'skuofproduct';
$CategoryLinkRepository = $objectManager->get('\Magento\Catalog\Model\CategoryLinkRepository');
$CategoryLinkRepository->deleteByIds($category_id, $sku);

// Assign multiple Products To single Category
$categoryLinkRepository = $objectManager->get(\Magento\Catalog\Api\CategoryLinkRepositoryInterface::class);
$productLinkFactory     = $objectManager->create('Magento\Catalog\Api\Data\CategoryProductLinkInterfaceFactory');
$skus                   = ['test', 'test-1'];
foreach ($skus as $productSku) {
    $categoryProductLink = $productLinkFactory->create();
    $categoryProductLink->setSku($productSku);
    $categoryProductLink->setCategoryId($categoryId);
    $categoryProductLink->setPosition(0);
    $categoryLinkRepository->save($categoryProductLink);
}

// load category collection by multiplecategory ids
$category_ids = [3, 5];
$category     = $objectManager->create('Magento\Catalog\Model\ResourceModel\Category\Collection');
$category->addAttributeToSelect('*');
$category->addFieldToFilter('entity_id', $category_ids);
foreach ($category as $key => $value) {
    print_r($value->getData());
}

// Get All products of category
$cateinstance       = $objectManager->create('Magento\Catalog\Model\CategoryFactory');
$cateid             = '3';
$allcategoryproduct = $cateinstance->create()->load($cateid)->getProductCollection()->addAttributeToSelect('*');
foreach ($allcategoryproduct as $key => $product) {
    echo $product->getSku();
}

// Copy products from one category to another
$cateinstance           = $objectManager->create('Magento\Catalog\Model\CategoryFactory');
$category_from          = 654;
$category_to            = 2617;
$allcategoryproduct     = $cateinstance->create()->load($category_from)->getProductCollection()->addAttributeToSelect('*');
$skus                   = [];
$CategoryLinkRepository = $objectManager->get('\Magento\Catalog\Api\CategoryLinkManagementInterface');
foreach ($allcategoryproduct as $key => $product) {

    $CategoryLinkRepository->assignProductToCategories($product->getSku(), [$category_to]);
    // $skus[] = $product->getSku();
}

//set crosssell/upsell programmatically
$productSku = 'test2';
$relatedSku = array('test4', 'test5', 'test8');
$upSku      = array('test4', 'test5', 'test9');
$crossSku   = array('test12', 'test13', 'test14');
$linkData   = [];
foreach ($relatedSkus as $relatedSku) {
    $productLink = $objectManager->create('Magento\Catalog\Api\Data\ProductLinkInterface')
        ->setSku($productSku)
        ->setLinkedProductSku($relatedSku)
        ->setPosition(1)
        ->setLinkType('related');
    $linkData[] = $productLink;
}
foreach ($upSkus as $upSku) {
    $productLink = $objectManager->create('Magento\Catalog\Api\Data\ProductLinkInterface')
        ->setSku($productSku)
        ->setLinkedProductSku($upSku)
        ->setPosition(1)
        ->setLinkType('upsell');
    $linkData[] = $productLink;
}
foreach ($crossSkus as $crossSku) {
    $productLink = $objectManager->create('Magento\Catalog\Api\Data\ProductLinkInterface')
        ->setSku($productSku)
        ->setLinkedProductSku($crossSku)
        ->setPosition(1)
        ->setLinkType('crosssell');
    $linkData[] = $productLink;
}
$product = $objectManager->create('Magento\Catalog\Api\ProductRepositoryInterface')->get($productSku);
$product->setProductLinks($linkData)->save();

// remove all images of product(base,gallery,thumbnail,swatch)
$product_id     = 2;
$product        = $objectManager->create('Magento\Catalog\Model\Product')->load($product_id);
$productGallery = $objectManager->create('\Magento\Catalog\Model\ResourceModel\Product\Gallery');
$gallery        = $product->getMediaGalleryImages();
if (count($gallery) > 0) {
    foreach ($gallery as $image) {
        $productGallery->deleteGallery($image->getValueId());
    }
    $product->setMediaGalleryEntries([]);
    $product->save();
}

//delete order programmatically
$incrementId = 10000342;
$order       = $objectManager->create('Magento\Sales\Model\Order')->loadByIncrementId($incrementId);
$invoices    = $order->getInvoiceCollection();
foreach ($invoices as $invoice) {
    $invoice->delete();
}
$shipments = $order->getShipmentsCollection();
foreach ($shipments as $shipment) {
    $shipment->delete();
}
$creditmemos = $order->getCreditmemosCollection();
foreach ($creditmemos as $creditmemo) {
    $creditmemo->delete();
}
$order->delete();

//Different Logging methods
$writer = new \Zend_Log_Writer_Stream(BP . '/var/log/Theshreyas.log');
$logger = new \Zend_Log();
$logger->addWriter($writer);
$logger->info('Your text message');
$logger->info(print_r($result, true));
// OR
file_put_contents(BP . '/var/log/Theshreyas.log', print_r($key, true).PHP_EOL, FILE_APPEND);
// OR
$debugBackTrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
foreach ($debugBackTrace as $item) {
    $logger->info(@$item['class'] . @$item['type'] . @$item['function']);
}
// OR
foreach (debug_backtrace() as $_stack) {
    $string =  (isset($_stack["file"]) ? $_stack["file"] : '') . ':' .
        (isset($_stack["line"]) ? $_stack["line"] : '') . ' - ' .
        (isset($_stack["function"]) ? $_stack["function"] : '').'<br/><hr/>';
    $logger->info(print_r($string, true));
 }
//End of Different Logging methods

//get store configuration value
$conf          = $objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface')->getValue('cataloginventory/item_options/max_sale_qty');
//by Store Id
$this->scopeConfig->getValue(
        'sections/group/field',
        \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
        $storeId,
    );

//run any method/ cron programmatically
$cron = $objectManager->get('\Vendor\Module\Cron\UpdateStatus')->execute();
