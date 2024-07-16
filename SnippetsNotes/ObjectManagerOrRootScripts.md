```sh
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
```

**Load product by ID**
```sh
try{
    $product = $objectManager->get('\Magento\Catalog\Model\ProductRepository')->getById($id);
    if($product->getId())
} catch(\Magento\Framework\Exception\NoSuchEntityException $e) {
```

**Load Product by Sku**
```sh
$productRepository = $objectManager->get('\Magento\Catalog\Model\ProductRepository');
try{
    $product           = $productRepository->get($product_sku);
} catch(\Magento\Framework\Exception\NoSuchEntityException $e) {
    $e->getMessage();
}
if(isset($product) && $product->getId()) //product found
```

**Load Product ID by Sku**
```sh
$productId = $objectManager->get('Magento\Catalog\Model\Product')->getIdBySku($product_sku);
//if($productId) //product found  else //not found
```

**Assign single Product To multiple Category**
```sh
$new_category_id        = array('100', '101');
$sku                    = 'skuofproduct';
$CategoryLinkRepository = $objectManager->get('\Magento\Catalog\Api\CategoryLinkManagementInterface');
$CategoryLinkRepository->assignProductToCategories($sku, $new_category_id);
```

**Remove Products From Category**
```sh
$category_id            = 101;
$sku                    = 'skuofproduct';
$CategoryLinkRepository = $objectManager->get('\Magento\Catalog\Model\CategoryLinkRepository');
$CategoryLinkRepository->deleteByIds($category_id, $sku);
```

**Assign multiple Products To single Category**
```sh
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
```

**load category collection by multiplecategory ids**
```sh
$category_ids = [3, 5];
$category     = $objectManager->create('Magento\Catalog\Model\ResourceModel\Category\Collection');
$category->addAttributeToSelect('*');
$category->addFieldToFilter('entity_id', $category_ids);
foreach ($category as $key => $value) {
    print_r($value->getData());
}
```

**Get All products of category**
```sh
$cateinstance       = $objectManager->create('Magento\Catalog\Model\CategoryFactory');
$cateid             = '3';
$allcategoryproduct = $cateinstance->create()->load($cateid)->getProductCollection()->addAttributeToSelect('*');
foreach ($allcategoryproduct as $key => $product) {
    echo $product->getSku();
}
```

**Copy products from one category to another**
```sh
$cateinstance           = $objectManager->create('Magento\Catalog\Model\CategoryFactory');
$category_from          = 654;
$category_to            = 2617;
$allcategoryproduct     = $cateinstance->create()->load($category_from)->getProductCollection()->addAttributeToSelect('*');
$skus                   = [];
$CategoryLinkRepository = $objectManager->get('\Magento\Catalog\Api\CategoryLinkManagementInterface');
foreach ($allcategoryproduct as $key => $product) {
    $CategoryLinkRepository->assignProductToCategories($product->getSku(), [$category_to]);
    <!-- $skus[] = $product->getSku(); -->
}
```

**Set crosssell/upsell programmatically**
```sh
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
```

**Remove all images of product(base,gallery,thumbnail,swatch)**
```sh
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
```

**Delete order programmatically**
```sh
$incrementId = 10000342;
$order       = $objectManager->create('Magento\Sales\Model\Order')->loadByIncrementId($incrementId);
$invo8ices    = $order->getInvoiceCollection();
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
```
# get store configuration value
```sh
$conf          = $objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface')->getValue('cataloginventory/item_options/max_sale_qty');
//by Store Id
$this->scopeConfig->getValue(
        'sections/group/field',
        \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
        $storeId,
    );
```

**Catalog Constants**
```sh
\Magento\Catalog\Model\Product\Type::TYPE_SIMPLE = 'simple'
\Magento\Catalog\Model\Product\Type::TYPE_VIRTUAL = 'virtual'
\Magento\ConfigurableProduct\Model\Product\Type\Configurable::TYPE_CODE = 'configurable'
\Magento\GroupedProduct\Model\Product\Type\Grouped::TYPE_CODE = 'grouped'
\Magento\Bundle\Model\Product\Type::TYPE_CODE = 'bundle'
\Magento\Downloadable\Model\Product\Type::TYPE_DOWNLOADABLE = 'downloadable'

\Magento\Customer\Model\GroupManagement::CUST_GROUP_ALL = 32000
\Magento\Customer\Model\GroupManagement::NOT_LOGGED_IN_ID = 0

\Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED = 1
\Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_DISABLED = 2

\Magento\Catalog\Model\Product\Visibility::VISIBILITY_BOTH = 4
\Magento\Catalog\Model\Product\Visibility::VISIBILITY_IN_SEARCH = 3
\Magento\Catalog\Model\Product\Visibility::VISIBILITY_IN_CATALOG = 2
\Magento\Catalog\Model\Product\Visibility::VISIBILITY_NOT_VISIBLE = 1

\Magento\Framework\App\Area::AREA_GLOBAL = 'global';
\Magento\Framework\App\Area::AREA_FRONTEND = 'frontend';
\Magento\Framework\App\Area::AREA_ADMINHTML = 'adminhtml';
\Magento\Framework\App\Area::AREA_DOC = 'doc';
\Magento\Framework\App\Area::AREA_CRONTAB = 'crontab';
\Magento\Framework\App\Area::AREA_WEBAPI_REST = 'webapi_rest';
\Magento\Framework\App\Area::AREA_WEBAPI_SOAP = 'webapi_soap';
\Magento\Framework\App\Area::AREA_GRAPHQL = 'graphql';

Constants not found-
Catalog, Search | Not Visible Individually ,etc
```

**Fetch Options/Child values**
```sh
simple product options
configurable child options
bundle child options
grouped child options
```
get customer collection
$customers     = $objectManager->create('\Magento\Customer\Model\ResourceModel\Customer\CollectionFactory');
$customers = $customers->create();
$customers->setOrder('entity_id','DESC');
$customers->setPageSize(5);
// $customers->addFieldToFilter('email', 'EMAIL@gmail.com');
foreach ($customers as $key => $value) {
  print_r($value->getData());
}

todo load customer by id
load customer by resourcemodel / model (factory deprecated)