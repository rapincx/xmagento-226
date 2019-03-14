<?php

namespace ChaOS\PhpOop\Controller\ViewModels;

use Magento\Framework\App\Action\Context;

/**
 * Class Index
 * @package ChaOS\PhpOop\Controller\ViewModels
 */
class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @var MagentoFrameworkViewResultPageFactory
     */
    protected $pageResultFactory;

    /**
     * Index constructor.
     * @param Context $context
     * @param MagentoFrameworkViewResultPageFactory $pageFactory
     */
    public function __construct(
        Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory
    )
    {
        $this->pageResultFactory = $pageFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        return $this->pageResultFactory->create();
    }
}