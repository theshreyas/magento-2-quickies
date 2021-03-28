<?php

declare(strict_types=1);

namespace Theshreyas\DynamicAttributesGraphql\Model\Resolver\Product;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

/**
 * @inheritdoc
 */
class DynamicAttributes implements ResolverInterface
{

  private $_productRepository;

  public function __construct(
    \Magento\Catalog\Model\ProductRepository $productRepository
  ) {
    $this->_productRepository = $productRepository;
  }
  /**
   * @inheritdoc
   */
  public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
  {
    if (!isset($args['fields'])) {
      throw new GraphQlInputException(__('Input parameter "fields" is missing'));
    }
    $product = $this->_productRepository->getById($value['entity_id']);
    $data = array();
    foreach ($args['fields'] as $fi) {
      $att = $product->getResource()->getAttribute($fi);
      if (isset($att) && $att) {
        if (in_array(
          $att->getFrontendInput(),
          ['multiselect', 'select']
        )) {
          $data[$fi . '_label'] = $product->getAttributeText($fi);
        }
        $data[$fi] = $product->getData($fi);
      }
    }
    return json_encode((object) $data);
  }
}
