<?php

namespace ChaOS\AskQuestion\Controller\Adminhtml\Questions;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use ChaOS\AskQuestion\Model\ResourceModel\AskQuestion\Collection;

/**
 * Class MassDelete
 * @package ChaOS\AskQuestion\Controller\Adminhtml\Questions
 */
class MassDelete extends Action
{
    /**
     * @var Filter
     */
    protected $filter;
    /**
     * @var \ChaOS\AskQuestion\Model\ResourceModel\AskQuestion\CollectionFactory
     */
    private $questionsCollection;

    /**
     * MassDelete constructor.
     * @param Context $context
     * @param Filter $filter
     * @param \ChaOS\AskQuestion\Model\ResourceModel\AskQuestion\CollectionFactory $questionsCollection
     */
    public function __construct(
        Action\Context $context,
        Filter $filter,
        \ChaOS\AskQuestion\Model\ResourceModel\AskQuestion\CollectionFactory $questionsCollection
    )
    {
        parent::__construct($context);
        $this->filter = $filter;
        $this->questionsCollection = $questionsCollection;
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Redirect|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        /** @var Collection $collection */
        $collection = $this->questionsCollection->create();
        $paramsId = $this->getRequest()->getParams('selected');
        $collection->addFieldToFilter('question_id', $paramsId);
        $collectionSize = $collection->getSize();
        foreach ($collection as $question) {
            $question->delete();
        }
        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', $collectionSize));
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}