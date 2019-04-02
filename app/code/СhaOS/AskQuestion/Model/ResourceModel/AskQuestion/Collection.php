<?php

namespace ChaOS\AskQuestion\Model\ResourceModel\AskQuestion;

use ChaOS\AskQuestion\Model\ResourceModel\AskQuestion;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Psr\Log\LoggerInterface;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Collection
 * @package ChaOS\AskQuestion\Model\ResourceModel\AskQuestion
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var StoreManagerInterface
     */
    private $_storeManager;
    /**
     * @var string
     */
    protected $_idFieldName = 'question_id';
    /**
     * Event prefix
     *
     * @var string
     */
    protected $_eventPrefix = 'askquestion_question_collection';
    /**
     * Event object
     *
     * @var string
     */
    protected $_eventObject = 'question_collection';

    /**
     * Collection constructor.
     * @param EntityFactoryInterface $entityFactory
     * @param LoggerInterface $logger
     * @param FetchStrategyInterface $fetchStrategy
     * @param ManagerInterface $eventManager
     * @param StoreManagerInterface $storeManager
     * @param AdapterInterface|null $connection
     * @param AbstractDb|null $resource
     */
    public function __construct(
        EntityFactoryInterface $entityFactory,
        LoggerInterface $logger,
        FetchStrategyInterface $fetchStrategy,
        ManagerInterface $eventManager,
        StoreManagerInterface $storeManager,
        AdapterInterface $connection = null,
        AbstractDb $resource = null
    )
    {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
        $this->_storeManager = $storeManager;
    }

    /**
     * {@inheritDoc}
     */
    protected function _construct()
    {
        $this->_init(
            \ChaOS\AskQuestion\Model\AskQuestion::class,
            AskQuestion::class
        );
    }

    /**
     * @param int $storeId
     * @return $this
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function addStoreFilter($storeId = null): self
    {
        if (!$storeId) {
            $storeId = (int)$this->_storeManager->getStore()->getId();
        }
        $this->addFieldToFilter('store_id', $storeId);
        return $this;
    }
}