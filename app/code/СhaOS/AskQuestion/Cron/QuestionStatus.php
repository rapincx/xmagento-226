<?php

namespace ChaOS\AskQuestion\Cron;

use ChaOS\AskQuestion\Model\ChangeStatus;

/**
 * Class QuestionStatus
 * @package ChaOS\AskQuestion\Cron
 */
class QuestionStatus
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;
    private $statusModel;

    /**
     * Example constructor.
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        ChangeStatus $statusModel
    )
    {
        $this->logger = $logger;
        $this->statusModel = $statusModel;
    }

    /**
     * This will change status of questions
     */
    public function execute()
    {
        $this->statusModel->changeQuestionStatus(
            \ChaOS\AskQuestion\Model\AskQuestion::STATUS_ANSWERED,
            $this->getDays()
        );
        $this->logger->info('Cron Works');
    }

    /**
     * @return int
     */
    private function getDays(): int
    {
        return 3;
    }
}