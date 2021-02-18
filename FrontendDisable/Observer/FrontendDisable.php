<?php
namespace Theshreyas\FrontendDisable\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\ActionFlag;
use Magento\Framework\App\Response\RedirectInterface;
use Magento\Backend\Helper\Data;
use Theshreyas\FrontendDisable\Helper\Data as FrontendDisableHelper;

class FrontendDisable implements ObserverInterface{

    protected   $_actionFlag;
    protected   $redirect;
    private     $helperBackend;
    private     $frontendDisableHelper;

    public function __construct(
        ActionFlag $actionFlag,
        RedirectInterface $redirect,
        Data $helperBackend,
        FrontendDisableHelper $frontendDisableHelper,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->_storeManager = $storeManager;
        $this->_actionFlag = $actionFlag;
        $this->redirect = $redirect;
        $this->helperBackend = $helperBackend;
        $this->frontendDisableHelper = $frontendDisableHelper;
    }
    
    /**
     * Show an empty page(default)/Custom Page/Redirect to HomePage/Admin site.
     * Depends on the config in
     * Stores > Configuration > Advanced > Admin > Disable Frontend
     *
     */
    public function execute(\Magento\Framework\Event\Observer $observer){

        $configType = $this->frontendDisableHelper->getConfigType();

        if($configType != 0){

            $this->_actionFlag->set('', \Magento\Framework\App\Action\Action::FLAG_NO_DISPATCH, true);

            $controller = $observer->getControllerAction();

            if($configType == 2){
                $this->redirect->redirect($controller->getResponse(),$this->_storeManager->getStore()->getBaseUrl());
            }
            if($configType == 3){
                $this->redirect->redirect($controller->getResponse(),$this->helperBackend->getHomePageUrl());
            }
            if($configType == 4){
                $this->redirect->redirect($controller->getResponse(),$this->frontendDisableHelper->getCustomUrl());
            }
        }
        
    }
}