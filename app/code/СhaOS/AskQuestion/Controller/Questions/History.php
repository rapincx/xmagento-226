<?php

namespace ChaOS\AskQuestion\Controller\Questions;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Customer\Model\SessionFactory;
use Magento\Framework\UrlInterface;

class History extends Action
{
    /** @var PageFactory */
    protected $resultPageFactory;
    /** @var SessionFactory */
    protected $customerSessionFactory;
    /** @var UrlInterface */
    protected $urlInterface;

    public function __construct(
        UrlInterface $urlInterface,
        Context $context,
        \Magento\Customer\Model\SessionFactory $customerSessionFactory,
        PageFactory $resultPageFactory
    )
    {
        $this->customerSessionFactory = $customerSessionFactory;
        $this->resultPageFactory = $resultPageFactory;
        $this->urlInterface = $urlInterface;
        parent::__construct($context);
    }

    public function execute()
    {
        if ($this->isCustomerLoggedIn() === false) {
            // Get referer url
            $url = $this->_redirect->getRefererUrl();
            // Create login URL
            $login_url = $this->urlInterface
                ->getUrl(
                    'customer/account/login',
                    ['referer' => base64_encode($url)]
                );
            // Redirect to login URL
            /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setUrl($login_url);
            return $resultRedirect;
        }
        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('My Questions'));
        return $resultPage;
    }

    /**
     * @return bool
     */
    private function isCustomerLoggedIn(): bool
    {
        /** @var \Magento\Customer\Model\Session $customerSession */
        $customerSession = $this->customerSessionFactory->create();
        return $customerSession->isLoggedIn();
    }
}