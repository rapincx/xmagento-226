<?php

namespace ChaOS\AskQuestion\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface AskQuestionSearchResultsInterface
 * @package ChaOS\AskQuestion\Api\Data
 * @api
 */
interface AskQuestionSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get request samples list.
     *
     * @return AskQuestionInterface[]
     */
    public function getItems(): array;

    /**
     * Set request samples list.
     *
     * @param AskQuestionInterface[] $items
     * @return $this
     */
    public function setItems(array $items): self;
}