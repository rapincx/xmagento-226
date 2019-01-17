<?php

namespace ChaOS\EditProductForm\Ui\DataProvider\Product\Form\Modifier;

use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;

class CustomFieldset extends AbstractModifier
{
    /**
     * @param array $meta
     * @return array
     */
    public function modifyMeta(array $meta): array
    {
        $meta['test_fieldset_name'] = [
            'arguments' => [
                'data' => [
                    'config' => [
                        'label' => __('Modifier Fieldset'),
                        'componentType' => 'fieldset',
                        'sortOrder' => 50,
                        'collapsible' => true
                    ]
                ]
            ],
            'children' => [
                'first_field' => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'componentType' => 'field',
                                'formElement'   => 'input',
                                'label'         => __('Custom Field First'),
                                'dataType'      => 'text',
                                'sortOrder'     => 45,
                                'dataScope'     => 'custom_field_first',
                            ]
                        ]
                    ]
                ],
                'second_field' => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'componentType' => 'field',
                                'formElement'   => 'select',
                                'label'         => __('Custom Field Second'),
                                'dataType'      => 'text',
                                'sortOrder'     => 45,
                                'dataScope'     => 'custom_field_second',
                                'options' => [
                                    ['value' => '0', 'label' => __('No')],
                                    ['value' => '1', 'label' => __('Yes')]
                                ],
                            ]
                        ]
                    ]
                ],
                'third_field' => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'componentType' => 'field',
                                'formElement'   => 'date',
                                'label'         => __('Custom Field Third'),
                                'dataType'      => 'date',
                                'sortOrder'     => 45,
                                'dataScope'     => 'custom_field_third',
                                'options' => [
                                    ['value' => '0', 'label' => __('No')],
                                    ['value' => '1', 'label' => __('Yes')]
                                ],
                            ]
                        ]
                    ]
                ]
            ]
        ];
        return $meta;
    }

    /**
     * {@inheritdoc}
     */
    public function modifyData(array $data): array
    {
        return $data;
    }
}