<?php

namespace ChaOS\AskQuestion\Model\ResourceModel;
/**
 * Class AskQuestion
 * @package ChaOS\AskQuestion\Model\ResourceModel
 */
class AskQuestion extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('chaos_ask_question', 'question_id');
    }
}