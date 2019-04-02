<?php

namespace ChaOS\AskQuestion\Api;

use ChaOS\AskQuestion\Api\Data\{AskQuestionSearchResultsInterface, AskQuestionInterface};
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\{LocalizedException, NoSuchEntityException};

/**
 * Interface AskQuestionRepositoryInterface
 * @package ChaOS\AskQuestion\Api
 * @api
 */
interface AskQuestionRepositoryInterface
{
    /**
     * Save question.
     *
     * @param AskQuestionInterface $askQuestion
     * @return AskQuestionInterface
     * @throws LocalizedException
     */
    public function save(AskQuestionInterface $askQuestion);

    /**
     * Retrieve question.
     *
     * @param int $questionId
     * @return AskQuestionInterface
     * @throws LocalizedException
     */
    public function getById($questionId);

    /**
     * Retrieve question matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return AskQuestionSearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete question.
     *
     * @param AskQuestionInterface $askQuestion
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(AskQuestionInterface $askQuestion): bool;

    /**
     * Delete request sample by ID.
     *
     * @param int $questionId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById($questionId): bool;
}