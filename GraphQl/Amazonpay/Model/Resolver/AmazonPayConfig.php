<?php

declare(strict_types=1);

namespace Theshreyas\Amazonpay\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

/**
 * @inheritdoc
 */
class AmazonPayConfig implements ResolverInterface
{
    protected $scopeConfig;

    public function __construct(\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @inheritdoc
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;

        $merchant_id = $this->scopeConfig->getValue('payment/amazon_payment/merchant_id', $storeScope);
        $client_id = $this->scopeConfig->getValue('payment/amazon_payment/client_id', $storeScope);
        $sandbox = $this->scopeConfig->getValue('payment/amazon_payment/sandbox', $storeScope);
        $payment_region = $this->scopeConfig->getValue('payment/amazon_payment/payment_region', $storeScope);
        $button_color = $this->scopeConfig->getValue('payment/amazon_payment/button_color', $storeScope);
        $button_size = $this->scopeConfig->getValue('payment/amazon_payment/button_size', $storeScope);

        return array(
            'merchant_id' => $merchant_id,
            'client_id' => $client_id,
            'sandbox' => $sandbox,
            'payment_region' => $payment_region,
            'button_color' => $button_color,
            'button_size' => $button_size
        );
    }
}
