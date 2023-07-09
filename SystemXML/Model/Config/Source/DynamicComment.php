<?php

namespace Theshreyas\SystemXML\Model\Config\Source;

use Magento\Framework\UrlInterface;

class DynamicComment implements \Magento\Config\Model\Config\CommentInterface
{
    protected $urlInterface;
    
    protected $authSession;
    
    public function __construct(
        \Magento\Backend\Model\Auth\Session $authSession,
        UrlInterface $urlInterface
    ) {
        $this->urlInterface = $urlInterface;
        $this->authSession = $authSession;
    }

    public function getCommentText($elementValue)
    {
        $currentUser = $this->authSession->getUser();
        $username = $currentUser->getUsername();
        $email = $currentUser->getEmail();
        file_put_contents(BP . '/var/log/Shreyas3.log', print_r(gettype($elementValue), true).PHP_EOL, FILE_APPEND);

        // $this->authSession->getUser()->getEmail();
        // $url = $this->urlInterface->getUrl('adminhtml/system_config/edit/section/payment');
        return 'Current Admin User : '.$username. ' with Email : '.$email.'<br>Field Value : '.$elementValue;
    }
}