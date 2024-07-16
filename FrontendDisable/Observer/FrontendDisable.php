<?php
namespace Theshreyas\FrontendDisable\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\ActionFlag;
use Magento\Framework\App\Response\RedirectInterface;
use Magento\Backend\Helper\Data;
use Theshreyas\FrontendDisable\Helper\Data as FrontendDisableHelper;

class FrontendDisable implements ObserverInterface
{

    public function __construct(
        protected ActionFlag $actionFlag,
        protected RedirectInterface $redirect,
        protected Data $helperBackend,
        protected FrontendDisableHelper $frontendDisableHelper,
        protected \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
    }
    
    /**
     * Show an empty page(default)/Custom Page/Redirect to HomePage/Admin site.
     * Depends on the config in
     * Stores > Configuration > Advanced > Admin > Disable Frontend
     *
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {

        $configType = $this->frontendDisableHelper->getConfigType();

        if ($configType != 0) {

            $this->actionFlag->set('', \Magento\Framework\App\Action\Action::FLAG_NO_DISPATCH, true);

            $controller = $observer->getControllerAction();

            if ($configType == 2) {
                $this->redirect->redirect($controller->getResponse(), $this->storeManager->getStore()->getBaseUrl());
            }
            if ($configType == 3) {
                $this->redirect->redirect($controller->getResponse(), $this->helperBackend->getHomePageUrl());
            }
            if ($configType == 4) {
                $this->redirect->redirect($controller->getResponse(), $this->frontendDisableHelper->getCustomUrl());
            }
        }
    }
}
