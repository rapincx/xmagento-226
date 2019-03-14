<?php

namespace ChaOS\AskQuestion\Plugin\AskQuestion\Model\ResourceModel\AskQuestion;

use Magento\Store\Model\StoreManagerInterface;
use ChaOS\AskQuestion\Model\ResourceModel\AskQuestion\Collection as QuestionCollection;
use Magento\Framework\Exception\NoSuchEntityException;

class Collection
{
    /**
     * @var bool
     */
    private $filterIsSetted = false;
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    public function __construct(StoreManagerInterface $storeManager)
    {
        $this->storeManager = $storeManager;
    }

    /**
     * @param QuestionCollection $subject
     * @param bool $printQuery
     * @param bool $logQuery
     * @throws NoSuchEntityException
     */
    public function beforeLoad(QuestionCollection $subject, $printQuery = false, $logQuery = false)
    {
        if (!$this->filterIsSetted) {
            $subject->addStoreFilter();
            $this->filterIsSetted = true;
        }
    }
}