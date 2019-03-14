<?php

namespace ChaOS\AskQuestion\Controller\Adminhtml\Questions;

use Magento\Framework\Controller\ResultFactory;

/**
 * Class Edit
 * @package ChaOS\AskQuestion\Controller\Adminhtml\Questions
 */
class Edit extends \Magento\Backend\App\Action
{
    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend(__('Edit Customer Question'));
        return $resultPage;
    }
}