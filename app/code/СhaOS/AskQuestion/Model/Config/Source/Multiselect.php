<?php

namespace ChaOS\AskQuestion\Model\Config\Source;

/**
 * Class Multiselect
 * @package ChaOS\AskQuestion\Model\Config\Source
 */
class Multiselect implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        $data = [
            ['value' => '1', 'label' => __('Top Right')],
            ['value' => '2', 'label' => __('Top Left')],
            ['value' => '3', 'label' => __('Middle Right')],
            ['value' => '4', 'label' => __('Middle')],
            ['value' => '5', 'label' => __('Middle Left')],
            ['value' => '6', 'label' => __('Bottom Right')],
            ['value' => '7', 'label' => __('Bottom Left')]
        ];
        return $data;
    }
}