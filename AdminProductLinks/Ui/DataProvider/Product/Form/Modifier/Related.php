<?php

namespace Theshreyas\AdminProductLinks\Ui\DataProvider\Product\Form\Modifier;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\Data\ProductLinkInterface;
use Magento\Catalog\Api\ProductLinkRepositoryInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Eav\Api\AttributeSetRepositoryInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Phrase;
use Magento\Framework\UrlInterface;
use Magento\Ui\Component\DynamicRows;
use Magento\Ui\Component\Form;
use Magento\Ui\Component\Form\Element\DataType\Number;
use Magento\Ui\Component\Form\Element\DataType\Text;
use Magento\Ui\Component\Form\Element\Input;
use Magento\Ui\Component\Form\Field;
use Magento\Ui\Component\Form\Fieldset;
use Magento\Ui\Component\Modal;
use Magento\Catalog\Helper\Image as ImageHelper;
use Magento\Catalog\Model\Product\Attribute\Source\Status;

/**
 * Class for Product Modifier Related
 *
 * @api
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @since 101.0.0
 */
class Related extends \Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\Related
{
    public const DATA_SCOPE = '';
    public const DATA_SCOPE_RELATED = 'related';
    public const DATA_SCOPE_UPSELL = 'upsell';
    public const DATA_SCOPE_CROSSSELL = 'crosssell';
    public const GROUP_RELATED = 'related';

    /**
     * @var string
     */
    private static $previousGroup = 'search-engine-optimization';

    /**
     * @var int
     */
    private static $sortOrder = 90;

    /**
     * @var LocatorInterface
     * @since 101.0.0
     */
    protected $locator;

    /**
     * @var UrlInterface
     * @since 101.0.0
     */
    protected $urlBuilder;

    /**
     * @var ProductLinkRepositoryInterface
     * @since 101.0.0
     */
    protected $productLinkRepository;

    /**
     * @var ProductRepositoryInterface
     * @since 101.0.0
     */
    protected $productRepository;

    /**
     * @var ImageHelper
     * @since 101.0.0
     */
    protected $imageHelper;

    /**
     * @var Status
     * @since 101.0.0
     */
    protected $status;

    /**
     * @var AttributeSetRepositoryInterface
     * @since 101.0.0
     */
    protected $attributeSetRepository;

    /**
     * @var string
     * @since 101.0.0
     */
    protected $scopeName;

    /**
     * @var string
     * @since 101.0.0
     */
    protected $scopePrefix;

    /**
     * @var \Magento\Catalog\Ui\Component\Listing\Columns\Price
     */
    private $priceModifier;

    /**
     * @param LocatorInterface $locator
     * @param UrlInterface $urlBuilder
     * @param ProductLinkRepositoryInterface $productLinkRepository
     * @param ProductRepositoryInterface $productRepository
     * @param ImageHelper $imageHelper
     * @param Status $status
     * @param AttributeSetRepositoryInterface $attributeSetRepository
     * @param \Theshreyas\AdminProductLinks\Helper\Data $helper
     * @param string $scopeName
     * @param string $scopePrefix
     */
    public function __construct(
        LocatorInterface $locator,
        UrlInterface $urlBuilder,
        ProductLinkRepositoryInterface $productLinkRepository,
        ProductRepositoryInterface $productRepository,
        ImageHelper $imageHelper,
        Status $status,
        AttributeSetRepositoryInterface $attributeSetRepository,
        protected \Theshreyas\AdminProductLinks\Helper\Data $helper,
        $scopeName = '',
        $scopePrefix = ''
    ) {
        parent::__construct($locator, $urlBuilder, $productLinkRepository, $productRepository, $imageHelper, $status, $attributeSetRepository, $scopeName, $scopePrefix);
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
                        'sortOrder' => 20,
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
