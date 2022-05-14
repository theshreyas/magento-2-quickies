<?php

declare (strict_types = 1);

namespace Theshreyas\GuestStockAlert\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class UnsubscribeStockAlert implements ResolverInterface
{
    protected $resourceConnection;

    public function __construct(
        \Magento\Customer\Model\Customer $customer,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\ProductAlert\Model\Stock $stock,
        \Magento\Framework\App\ResourceConnection $resourceConnection

    ) {
        $this->_customer          = $customer;
        $this->_storeManager      = $storeManager;
        $this->_stock             = $stock;
        $this->resourceConnection = $resourceConnection;

    }

    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        if (!isset($args['email']) || empty($args['email'])) {
            throw new GraphQlInputException(__('Email is required.'));
        }
        $email = trim($args['email']);
        try {
            $customer = $this->_customer;
            $customer->setWebsiteId($this->_storeManager->getWebsite()->getId());
            $customer->loadByEmail($email);
            if ($customer->getId()) {
                $this->_stock->deleteCustomer($customer->getId(), $this->_storeManager->getStore()->getWebsiteId());
            }
            $connection = $this->resourceConnection->getConnection();
            $connection->delete(
                'product_alert_stock',
                ['email = ?' => $email]
            );

            return [
                'message' => __('You will no longer receive stock alerts.'),
                'status'  => true,
            ];
        } catch (\Exception $e) {

            return [
                'message' => __('Unable to update the alert subscription.'),
                'status'  => true,
            ];
        }
    }
}
