<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare (strict_types = 1);

namespace Theshreyas\GuestStockAlert\Rewrite\Magento\ProductAlert\Model;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Store\Model\ScopeInterface;

class Observer extends \Magento\ProductAlert\Model\Observer
{
	/**
	 * Allow stock alert
	 *
	 */
	const XML_PATH_STOCK_ALLOW = 'catalog/productalert/allow_stock';

	const DEFAULT_BUNCH_SIZE = 10000;

	/**
	 * Process stock emails
	 *
	 * @param Email $email
	 * @return $this
	 * @throws \Exception
	 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
	 * @SuppressWarnings(PHPMD.NPathComplexity)
	 */
	protected function _processStock(\Magento\ProductAlert\Model\Email $email) {
		$email->setType('stock');

		foreach ($this->_getWebsites() as $website) {
			/* @var $website Website */
			try {
				if (!$website->getDefaultGroup() || !$website->getDefaultGroup()->getDefaultStore()) {
					continue;
				}

				if (!$this->_scopeConfig->getValue(
					self::XML_PATH_STOCK_ALLOW,
					ScopeInterface::SCOPE_STORE,
					$website->getDefaultGroup()->getDefaultStore()->getId()
				)
				) {
					continue;
				}
			} catch (\Exception $e) {
				$this->_errors[] = $e->getMessage();
				throw $e;
			}
			try {
				$collection = $this->_stockColFactory->create()
					->addWebsiteFilter($website->getId())
					->addStatusFilter(0)
					->setCustomerOrder()
					->addOrder('product_id');
			} catch (\Exception $e) {
				$this->_errors[] = $e->getMessage();
				throw $e;
			}

			$previousCustomer = null;
			$email->setWebsite($website);
			foreach ($this->loadItems($collection, self::DEFAULT_BUNCH_SIZE) as $alert) {
				$this->setAlertStoreId($alert, $email);
				try {

					if (!$previousCustomer || empty(get_class_methods($previousCustomer)) || !empty(get_class_methods($previousCustomer)) && $previousCustomer->getId() != $alert->getCustomerId()) {

						$customer = $alert->getCustomerId() ? $this->customerRepository->getById($alert->getCustomerId()) : null;

						if ($previousCustomer) {
							$email->send();
						}
						// if (!$customer) {
						//     continue;
						// }
						$email->clean();
						if (!$customer) {
							$Cust        = new \stdClass();
							$Cust->email = $alert->getEmail();
							// $Cust->setEmail($alert->getEmail());
							$customer = $Cust;
						}
						$previousCustomer = $customer;
						$email->setCustomerData($customer);
					} else {
						$customer = $previousCustomer;
					}

					$product = $this->productRepository->getById(
						$alert->getProductId(),
						false,
						$website->getDefaultStore()->getId()
					);

					if (!property_exists($customer, 'email')) {
						$product->setCustomerGroupId($customer->getGroupId());
					} else

					if ($this->productSalability->isSalable($product, $website)) {
						$email->addStockProduct($product);

						$alert->setSendDate($this->_dateFactory->create()->gmtDate());
						$alert->setSendCount($alert->getSendCount() + 1);
						$alert->setStatus(1);
						$alert->save();
					}
				} catch (\Exception $e) {
					$this->_errors[] = $e->getMessage();
					throw $e;
				}
			}

			if ($previousCustomer) {
				try {
					$email->send();
				} catch (\Exception $e) {
					$this->_errors[] = $e->getMessage();
					throw $e;
				}
			}
			// else{

			// }

		}

		return $this;
	}

	/**
	 * Load items by bunch size
	 *
	 * @param AbstractCollection $collection
	 * @param int $bunchSize
	 * @return \Generator
	 */
	private function loadItems(AbstractCollection $collection, int $bunchSize): \Generator
	{
		$collection->setPageSize($bunchSize);
		$pageCount = $collection->getLastPageNumber();
		$curPage   = 1;
		while ($curPage <= $pageCount) {
			$collection->clear();
			$collection->setCurPage($curPage);
			foreach ($collection as $item) {
				yield $item;
			}
			$curPage++;
		}
	}

	/**
	 * Set alert store id.
	 *
	 * @param Price|Stock $alert
	 * @param Email $email
	 * @return Observer
	 */
	private function setAlertStoreId($alert, Email $email): Observer {
		$alertStoreId = $alert->getStoreId();
		if ($alertStoreId) {
			$email->setStoreId((int) $alertStoreId);
		}

		return $this;
	}
}
