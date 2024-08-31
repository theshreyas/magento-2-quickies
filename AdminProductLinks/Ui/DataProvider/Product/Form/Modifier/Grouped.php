<?php

namespace Theshreyas\AdminProductLinks\Ui\DataProvider\Product\Form\Modifier;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\Data\ProductLinkInterface;
use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Framework\Phrase;
use Magento\Ui\Component\Modal;
use Magento\Ui\Component\Form;
use Magento\GroupedProduct\Model\Product\Type\Grouped as GroupedProductType;
use Magento\Framework\UrlInterface;
use Magento\Ui\Component\DynamicRows;
use Magento\Catalog\Api\ProductLinkRepositoryInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Helper\Image as ImageHelper;
use Magento\Eav\Api\AttributeSetRepositoryInterface;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Framework\Locale\CurrencyInterface;
use Magento\GroupedProduct\Model\Product\Link\CollectionProvider\Grouped as GroupedProducts;
use Magento\Framework\App\ObjectManager;
use Magento\Catalog\Api\Data\ProductLinkInterfaceFactory;

/**
 * Data provider for Grouped products
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Grouped extends \Magento\GroupedProduct\Ui\DataProvider\Product\Form\Modifier\Grouped
{
    /**
     * @var LocatorInterface
     */
    protected $locator;

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var ProductLinkRepositoryInterface
     */
    protected $productLinkRepository;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var Status
     */
    protected $status;

    /**
     * @var AttributeSetRepositoryInterface
     */
    protected $attributeSetRepository;

    /**
     * @var ImageHelper
     */
    protected $imageHelper;

    /**
     * @var CurrencyInterface
     */
    protected $localeCurrency;

    /**
     * @var array
     */
    protected $uiComponentsConfig = [
        'button_set' => 'grouped_products_button_set',
        'modal' => 'grouped_products_modal',
        'listing' => 'grouped_product_listing',
        'form' => 'product_form',
    ];

    /**
     * @var string
     */
    private static $codeQuantityAndStockStatus = 'quantity_and_stock_status';

    /**
     * @var string
     */
    private static $codeQtyContainer = 'quantity_and_stock_status_qty';

    /**
     * @var string
     */
    private static $codeQty = 'qty';

    /**
     * @var GroupedProducts
     */
    private $groupedProducts;

    /**
     * @var ProductLinkInterfaceFactory
     */
    private $productLinkFactory;

    /**
     * @param LocatorInterface $locator
     * @param UrlInterface $urlBuilder
     * @param ProductLinkRepositoryInterface $productLinkRepository
     * @param ProductRepositoryInterface $productRepository
     * @param ImageHelper $imageHelper
     * @param Status $status
     * @param AttributeSetRepositoryInterface $attributeSetRepository
     * @param CurrencyInterface $localeCurrency
     * @param \Theshreyas\AdminProductLinks\Helper\Data $helper
     * @param array $uiComponentsConfig
     * @param GroupedProducts $groupedProducts
     * @param \Magento\Catalog\Api\Data\ProductLinkInterfaceFactory|null $productLinkFactory
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        LocatorInterface $locator,
        UrlInterface $urlBuilder,
        ProductLinkRepositoryInterface $productLinkRepository,
        ProductRepositoryInterface $productRepository,
        ImageHelper $imageHelper,
        Status $status,
        AttributeSetRepositoryInterface $attributeSetRepository,
        CurrencyInterface $localeCurrency,
        protected \Theshreyas\AdminProductLinks\Helper\Data $helper,
        array $uiComponentsConfig = [],
        GroupedProducts $groupedProducts = null,
        \Magento\Catalog\Api\Data\ProductLinkInterfaceFactory $productLinkFactory = null
    ) {
        parent::__construct($locator, $urlBuilder, $productLinkRepository, $productRepository, $imageHelper, $status, $attributeSetRepository, $localeCurrency, $uiComponentsConfig, $groupedProducts, $productLinkFactory, $helper);
    }

    /**
     * Fill meta columns
     *
     * @return array
     */
    protected function fillMeta()
    {
        $meta = parent::fillMeta();
        $meta['name'] = [
            'arguments' => [
                'data' => [
                    'config' => [
                        'componentType' => Form\Field::NAME,
                        'formElement' => Form\Element\Input::NAME,
                        'elementTmpl' => 'ui/form/element/html',
                        'dataType' => Form\Element\DataType\Text::NAME,
                        'dataScope' => 'name',
                        'fit' => false,
                        'label' => __('Name'),
                        'sortOrder' => 30,
                        'labelVisible' => false,
                    ],
                ],
            ],
        ];
        return $meta;
    }

    /**
     * Fill data column
     *
     * @param ProductInterface $linkedProduct
     * @param ProductLinkInterface $linkItem
     * @return array
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function fillData(ProductInterface $linkedProduct, ProductLinkInterface $linkItem)
    {
        $data = parent::fillData($linkedProduct, $linkItem);

        $productUrl = $this->helper->getProductUrl($linkedProduct->getId());
        $data['name'] = '<a href="'.$productUrl.'">'.$linkedProduct->getName().'</a>';
        return $data;
    }
}
