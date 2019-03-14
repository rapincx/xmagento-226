<?php

namespace ChaOS\AskQuestion\Block;

use Magento\Framework\View\Element\Template;
use ChaOS\AskQuestion\Model\ResourceModel\AskQuestion\Collection;

/**
 * Class AskQuestion
 * @package ChaOS\AskQuestion\Block
 */
class Questions extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \ChaOS\AskQuestion\Model\ResourceModel\AskQuestion\CollectionFactory
     */
    private $collectionFactory;
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * Questions constructor.
     * @param Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \ChaOS\AskQuestion\Model\ResourceModel\AskQuestion\CollectionFactory $collectionFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \ChaOS\AskQuestion\Model\ResourceModel\AskQuestion\CollectionFactory $collectionFactory,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->collectionFactory = $collectionFactory;
        $this->_coreRegistry = $registry;
    }

    /**
     * Get current product id
     *
     * @return null|int
     */
    public function getProductName()
    {
        $product = $this->_coreRegistry->registry('product');
        return $product ? $product->getName() : null;
    }

    /**
     * @return Collection
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getQuestions(): Collection
    {
        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();
        if ($limit = $this->getData('limit')) {
            $collection->setPageSize($limit);
        }
        $collection->addFieldToFilter('product_name', $this->getProductName())
            ->load();
        return $collection;
    }
}