<?php

namespace ChaOS\EditProductForm\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{
    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            [
                'label' => __('Success'),
                'value' => 'success',
            ],
            [
                'label' => __('Error'),
                'value' => 'error',
            ],
        ];
    }
}