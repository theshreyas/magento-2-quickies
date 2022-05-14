<?php

declare (strict_types = 1);

namespace Theshreyas\GuestStockAlert\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class SaveStockAlert implements ResolverInterface
{
    public function __construct(
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Customer\Model\Customer $customer,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\ProductAlert\Model\Stock $stock
    ) {
        $this->_productRepository = $productRepository;
        $this->_customer          = $customer;
        $this->_storeManager      = $storeManager;
        $this->_stock             = $stock;
    }

    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        if (!isset($args['input']['product_id']) || empty($args['input']['product_id'])) {
            throw new GraphQlInputException(__('Product id is required.'));
        }

        if (!isset($args['input']['email']) || empty(trim($args['input']['email']))) {
            throw new GraphQlInputException(__('Email address is required.'));
        }

        try {
            $_product   = $this->_productRepository->getById($args['input']['product_id']);
            $stockModel = $this->_stock
                ->setProductId($_product->getId())
                ->setWebsiteId($this->_storeManager->getStore()->getWebsiteId())
                ->setStoreId($this->_storeManager->getStore()->getId())
                ->setParentId($args['input']['product_id']);

            $customer = $this->_customer;
            $customer->setWebsiteId($this->_storeManager->getWebsite()->getId());
            $customer->loadByEmail($args['input']['email']);

            $stockCollection = $this->_stock->getCollection()
                ->addWebsiteFilter($this->_storeManager->getWebsite()->getId())
                ->addFieldToFilter('product_id', $args['input']['product_id'])
                ->addStatusFilter(0)
                ->setCustomerOrder();

            if (!$customer->getId()) {
                $stockModel->setEmail($args['input']['email']);
                $stockCollection->addFieldToFilter('email', $args['input']['email']);
            } else {
                $stockModel->setCustomerId($customer->getId());
                $stockCollection->addFieldToFilter('customer_id', $customer->getId());
            }

            if ($stockCollection->getSize() > 0) {
                return [
                    'message' => "Thank you! You are already subscribed to this product.",
                ];
            } else {
                $stockModel->save();
                return [
                    'message' => 'Alert subscription has been saved',
                    'id'      => $stockModel->getId(),
                ];
            }
        } catch (\Exception $e) {
            throw new GraphQlInputException(__($e->getMessage()));
            // throw new GraphQlInputException(__("The alert subscription couldn't update at this time. Please try again later."));
        }
    }
}
