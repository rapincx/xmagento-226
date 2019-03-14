<?php

namespace ChaOS\AskQuestion\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use ChaOS\AskQuestion\Model\AskQuestion;

/**
 * Class Status
 * @package ChaOS\AskQuestion\Model\Config\Source
 */
class Status implements OptionSourceInterface
{
    /**Questions Statuses
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            [
                'label' => __('Answered'),
                'value' => AskQuestion::STATUS_ANSWERED,
            ],
            [
                'label' => __('Pending'),
                'value' => AskQuestion::STATUS_PENDING,
            ],
            [
                'label' => __('Read'),
                'value' => AskQuestion::STATUS_READ,
            ],
        ];
    }
}