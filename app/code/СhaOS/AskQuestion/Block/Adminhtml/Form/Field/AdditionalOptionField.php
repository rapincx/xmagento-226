<?php

namespace ChaOS\AskQuestion\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

/**
 * Class AdditionalOptionField
 * @package ChaOS\AskQuestion\Block\Adminhtml\Form\Field
 */
class AdditionalOptionField extends AbstractFieldArray
{
    /**
     * {@inheritdoc}
     */
    protected function _prepareToRender()
    {
        $this->addColumn('first_value', ['label' => __('First Value'), 'class' => 'required-entry']);
        $this->addColumn('second_value', ['label' => __('Second Value')]);
        $this->addColumn('third_value', ['label' => __('Third Value'), 'class' => 'required-entry text']);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add New Fields');
    }
}