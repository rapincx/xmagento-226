<?php

namespace ChaOS\AskQuestion\Controller\Adminhtml\Questions;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Json;
use ChaOS\AskQuestion\Model\AskQuestion;
use Magento\Framework\DB\Transaction;

/**
 * Class InlineEdit
 * @package ChaOS\AskQuestion\Controller\Adminhtml\Questions
 */
class InlineEdit extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $jsonFactory;
    /**
     * @var \Magento\Framework\DB\TransactionFactory
     */
    private $transactionFactory;
    /**
     * @var \ChaOS\AskQuestion\Model\AskQuestionFactory
     */
    private $questionsFactory;

    /**
     * InlineEdit constructor.
     * @param \Magento\Framework\DB\TransactionFactory $transactionFactory
     * @param Context $context
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
     * @param \ChaOS\AskQuestion\Model\AskQuestionFactory $questionsFactory
     */
    public function __construct(
        \Magento\Framework\DB\TransactionFactory $transactionFactory,
        Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        \ChaOS\AskQuestion\Model\AskQuestionFactory $questionsFactory
    )
    {
        parent::__construct($context);
        $this->transactionFactory = $transactionFactory;
        $this->jsonFactory = $jsonFactory;
        $this->questionsFactory = $questionsFactory;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|Json|\Magento\Framework\Controller\ResultInterface
     * @throws \Exception
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];
        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            if (!count($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            }
            /** @var Transaction $transaction */
            $transaction = $this->transactionFactory->create();
            foreach ($postItems as $postItem) {
                /** @var AskQuestion $question */
                $question = $this->questionsFactory->create();
                $question->setData($postItem);
                $transaction->addObject($question);
            }
            $transaction->save();
        }
        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }
}