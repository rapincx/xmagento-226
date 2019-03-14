<?php

namespace ChaOS\AskQuestion\Controller\Adminhtml\Questions;

use Magento\Backend\App\Action;
use ChaOS\AskQuestion\Model\AskQuestion;

/**
 * Class Delete
 * @package ChaOS\AskQuestion\Controller\Adminhtml\Questions
 */
class Delete extends \Magento\Backend\App\Action
{
    /**
     * @var \ChaOS\AskQuestion\Model\AskQuestionFactory
     */
    private $questionFactory;

    /**
     * Delete constructor.
     * @param Action\Context $context
     * @param \ChaOS\AskQuestion\Model\AskQuestionFactory $questionFactory
     */
    public function __construct(
        Action\Context $context,
        \ChaOS\AskQuestion\Model\AskQuestionFactory $questionFactory
    )
    {
        parent::__construct($context);
        $this->questionFactory = $questionFactory;
    }

    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            try {
                $question = $this->questionFactory->create();
                $question->load($id);
                $question->delete();
                $this->messageManager->addSuccessMessage(__('You deleted the question.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/');
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find a question to delete.'));

        return $resultRedirect->setPath('*/*/');
    }
}