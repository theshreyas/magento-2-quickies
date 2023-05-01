<?php
namespace Theshreyas\MassProductUpdate\Controller\Adminhtml\Massaction;

use Magento\Backend\App\Action;
use Magento\Catalog\Controller\Adminhtml\Product;
use Magento\Framework\Controller\ResultFactory;

class Index extends \Theshreyas\MassProductUpdate\Controller\Adminhtml\Massaction
{
    /**
     * Validate data before using it
     *
     * @param string $field
     * @param string $action
     * @throws \Theshreyas\MassProductUpdate\Model\CustomException
     */
    protected function _validateData($field, $action)
    {
        $field = trim($field);
        if (strpos($action, 'Theshreyas_') === 0) {
            $action = str_replace("Theshreyas_", "", $action);
        } else {
            throw new \Theshreyas\MassProductUpdate\Model\CustomException(
                __('Something was wrong. Please try again.')
            );
        }

        if ($action === "related") {
            $action = "relate";
        }

        return [$field, $action];
    }

    /**
     * Update product(s) data action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $idsFromRequest = $this->getRequest()->getParam('selected', 0);
        if (!$idsFromRequest) {
            $collection = $this->filter->getCollection($this->collectionFactory->create());
            $productIds = $collection->getAllIds();
        } else {
            foreach ($idsFromRequest as $id) {
                $productIds[] = (int)$id;
            }
        }

        $storeId = (int) $this->getRequest()->getParam('store', 0);
        $field = $this->getRequest()->getParam('theshreyas_massproductupdate_field');
        $action = $this->getRequest()->getParam('action');

        try {
            list($field, $action) = $this->_validateData($field, $action);
            $className = 'Theshreyas\MassProductUpdate\Model\Command\\'  . ucfirst($action);
            if (class_exists($className)) {
                $command = $this->_objectManager->create($className);
                $success = $command->execute($productIds, $storeId, $field);

                if ($success instanceof \Magento\Framework\Phrase) {
                    $this->messageManager->addSuccessMessage($success);
                } elseif ($success !== '') {
                    return $success;
                }

                // show non critical erroes to the user
                foreach ($command->getErrors() as $err) {
                    $this->messageManager->addErrorMessage($err);
                }

                $this->_productPriceIndexerProcessor->reindexList($productIds);
            }
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Theshreyas\MassProductUpdate\Model\CustomException $e) {
            $this->messageManager->addExceptionMessage($e, $e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage(
                $e,
                __('Something went wrong while updating the product(s) data.')
            );
        }

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('catalog/product/', ['store' => $storeId]);
    }
}
