<?php

namespace ChaOS\AskQuestion\Model;

use ChaOS\AskQuestion\Model\ResourceModel\AskQuestion\Collection;
use Magento\Framework\Stdlib\DateTime\DateTime;

/**
 * Class ChangeStatus
 * @package ChaOS\AskQuestion\Model
 */
class ChangeStatus
{
    /**
     * @var \ChaOS\AskQuestion\Model\ResourceModel\AskQuestion\CollectionFactory
     */
    private $collectionFactory;
    /**
     * @var DateTime
     */
    private $date;

    public function __construct(
        \ChaOS\AskQuestion\Model\ResourceModel\AskQuestion\CollectionFactory $collectionFactory,
        DateTime $date
    )
    {
        $this->collectionFactory = $collectionFactory;
        $this->date = $date;
    }

    /**
     * @param $status
     * @param $days
     */
    public function changeQuestionStatus($status, $days): void
    {
        /** @var Collection $questionCollectionfactory */
        $questionCollection = $this->collectionFactory->create();
        // set filters to collection
        $questionCollection->addFieldToFilter('created_at', ['lt' => $this->getSearchDate($days)])
            ->addFieldToFilter('status', ['neq' => $status]);
        $questionCollection->load();
        foreach ($questionCollection as $item) {
            $item->setStatus('answered');
        }
        $questionCollection->save();
    }

    /**
     * @param int $days
     * @return false|int|string
     */
    private function getSearchDate($days)
    {
        // get date in $days before current
        $currentDate = $this->date->gmtDate("Y-m-d h:i:s");
        $beforeDate = strtotime('-' . $days . 'day', strtotime($currentDate));
        $beforeDate = $this->date->gmtDate('Y-m-d h:i:s', $beforeDate);
        return $beforeDate;
    }
}