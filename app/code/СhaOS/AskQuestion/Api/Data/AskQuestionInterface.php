<?php

namespace ChaOS\AskQuestion\Api\Data;

/**
 * Interface AskQuestionInterface
 * @package ChaOS\AskQuestion\Api\Data
 * @api
 */
interface AskQuestionInterface
{
    /**
     * Get question Id
     *
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * Set question Id
     *
     * @param int $id
     * @return AskQuestionInterface
     */
    public function setId($id);

    /**
     * Gets the created-at timestamp for the question.
     *
     * @return string|null Created-at timestamp.
     */
    public function getCreatedAt(): ?string;

    /**
     * Get customer Name
     *
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * Set customer Name
     *
     * @param string $name
     * @return AskQuestionInterface
     */
    public function setName($name);

    /**
     * Get customer Email
     *
     * @return string|null
     */
    public function getEmail(): ?string;

    /**
     * Set customer Email
     *
     * @param string $email
     * @return AskQuestionInterface
     */
    public function setEmail($email);

    /**
     * Get customer Phone
     *
     * @return string|null
     */
    public function getPhone(): ?string;

    /**
     * Set customer Phone
     *
     * @param string $phone
     * @return AskQuestionInterface
     */
    public function setPhone($phone);

    /**
     * Get product ProductName
     *
     * @return string|null
     */
    public function getProductName(): ?string;

    /**
     * Set product ProductName
     *
     * @param string $productName
     * @return AskQuestionInterface
     */
    public function setProductName($productName);

    /**
     * Get product Sku
     *
     * @return string|null
     */
    public function getSku(): ?string;

    /**
     * Set product Sku
     *
     * @param string $sku
     * @return AskQuestionInterface
     */
    public function setSku($sku);

    /**
     * Get Question
     *
     * @return string|null
     */
    public function getQuestion(): ?string;

    /**
     * Set Question
     *
     * @param string $question
     * @return AskQuestionInterface
     */
    public function setQuestion($question);

    /**
     * Get QuestionStatus
     *
     * @return string|null
     */
    public function getStatus(): ?string;

    /**
     * Set QuestionStatus
     *
     * @param string $status
     * @return AskQuestionInterface
     */
    public function setStatus($status);

    /**
     * Get StoreId
     *
     * @return int|null
     */
    public function getStoreId(): ?int;

    /**
     * Set StoreId
     *
     * @param string $storeId
     * @return AskQuestionInterface
     */
    public function setStoreId($storeId);
}