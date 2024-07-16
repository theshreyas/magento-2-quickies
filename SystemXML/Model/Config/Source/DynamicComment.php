<?php

namespace Theshreyas\SystemXML\Model\Config\Source;

use Magento\Framework\UrlInterface;

class DynamicComment implements \Magento\Config\Model\Config\CommentInterface
{
    /**
     * Construct function
     *
     * @param \Magento\Backend\Model\Auth\Session $authSession
     * @param UrlInterface $urlInterface
     */
    public function __construct(
        protected \Magento\Backend\Model\Auth\Session $authSession,
        protected UrlInterface $urlInterface
    ) {
    }

    /**
     * Get Comment Text
     *
     * @param mixed $elementValue
     * @return string
     */
    public function getCommentText($elementValue)
    {
        $currentUser = $this->authSession->getUser();
        $username    = $currentUser->getUsername();
        $email       = $currentUser->getEmail();
        // $this->authSession->getUser()->getEmail();
        // $url = $this->urlInterface->getUrl('adminhtml/system_config/edit/section/payment');
        return 'Current Admin User : ' . $username . ' with Email : ' . $email . '<br>Field Value : ' . $elementValue;
    }
}
