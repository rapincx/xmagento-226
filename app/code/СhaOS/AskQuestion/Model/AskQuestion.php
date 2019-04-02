<?php

namespace ChaOS\AskQuestion\Model;

use ChaOS\AskQuestion\Model\ResourceModel\AskQuestion as AskQuestionResource;
use ChaOS\AskQuestion\Api\Data\AskQuestionInterface;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Registry;
use Magento\Framework\Model\Context;

/**
 * Class AskQuestion
 * @package ChaOS\AskQuestion\Model
 */
class AskQuestion
    extends \Magento\Framework\Model\AbstractModel
    implements AskQuestionInterface
{
    /**
     * This is available question statuses
     */
    public const STATUS_PENDING = 'pending';
    public const STATUS_READ = 'read';
    public const STATUS_ANSWERED = 'answered';
    protected $_eventPrefix = 'askquestion_question';
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $_storeManager;

    /**
     * AskQuestion constructor.
     * @param Context $context
     * @param Registry $registry
     * @param StoreManagerInterface $storeManager
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        StoreManagerInterface $storeManager,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    )
    {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
        $this->_storeManager = $storeManager;
    }

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init(AskQuestionResource::class);
    }

    /**
     * @return \Magento\Framework\Model\AbstractModel
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function beforeSave(): \Magento\Framework\Model\AbstractModel
    {
        if (!$this->getStatus()) {
            $this->setStatus(self::STATUS_PENDING);
        }
        if (!$this->getStoreId()) {
            $this->setStoreId($this->_storeManager->getStore()->getId());
        }
        return parent::beforeSave();
    }

    /**
     * {@inheritdoc}
     */
    public function setId($id)
    {
        return $this->setData('question_id', $id);
    }

    /**
     * {@inheritDoc}
     */
    public function getId(): ?int
    {
        return $this->getData('question_id');
    }

    /**
     * Gets the created-at timestamp for the question.
     *
     * @return string|null Created-at timestamp.
     */
    public function getCreatedAt(): ?string
    {
        return $this->getData('created_at');
    }

    /**
     * Get customer Name
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->getData('name');
    }

    /**
     * @param string $name
     * @return AskQuestionInterface|AskQuestion
     */
    public function setName($name)
    {
        return $this->setData('name', $name);
    }

    /**
     * Get customer Email
     *
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->getData('email');
    }

    /**
     * @param string $email
     * @return AskQuestionInterface|AskQuestion
     */
    public function setEmail($email)
    {
        return $this->setData('email', $email);
    }

    /**
     * Get customer Phone
     *
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->getData('phone');
    }

    /**
     * @param string $phone
     * @return AskQuestionInterface|AskQuestion
     */
    public function setPhone($phone)
    {
        return $this->setData('phone', $phone);
    }

    /**
     * Get product ProductName
     *
     * @return string|null
     */
    public function getProductName(): ?string
    {
        return $this->getData('product_name');
    }

    /**
     * @param string $productName
     * @return AskQuestionInterface|void
     */
    public function setProductName($productName)
    {
        return $this->setData('product_name', $productName);
    }

    /**
     * Get product Sku
     *
     * @return string|null
     */
    public function getSku(): ?string
    {
        return $this->getData('sku');
    }

    /**
     * @param string $sku
     * @return AskQuestionInterface|void
     */
    public function setSku($sku)
    {
        return $this->setData('sku', $sku);
    }

    /**
     * Get Question
     *
     * @return string|null
     */
    public function getQuestion(): ?string
    {
        return $this->getData('question');
    }

    /**
     * @param string $question
     * @return AskQuestionInterface|void
     */
    public function setQuestion($question)
    {
        return $this->setData('question', $question);
    }

    /**
     * Get QuestionStatus
     *
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->getData('status');
    }

    /**
     * @param string $status
     * @return AskQuestionInterface|void
     */
    public function setStatus($status)
    {
        return $this->setData('status', $status);
    }

    /**
     * Get StoreId
     *
     * @return int|null
     */
    public function getStoreId(): ?int
    {
        return $this->getData('store_id');
    }

    /**
     * @param string $storeId
     * @return AskQuestionInterface|void
     */
    public function setStoreId($storeId)
    {
        return $this->setData('store_id', $storeId);
    }
}