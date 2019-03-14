<?php

namespace ChaOS\AskQuestion\Controller\Adminhtml\Questions;

use Magento\Framework\Controller\ResultFactory;

/**
 * Class Index
 * @package ChaOS\AskQuestion\Controller\Adminhtml\AskQuestion
 */
class Index extends \Magento\Backend\App\Action
{
    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend(__('Ask Question'));
        return $resultPage;
    }
}