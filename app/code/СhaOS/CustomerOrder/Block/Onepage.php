<?php

namespace ChaOS\CustomerOrder\Block;

use Magento\Framework\View\Element\Template;

/**
 * Class Onepage
 * @package ChaOS\CustomerOrder\Block
 */
class Onepage extends Template
{
    /**
     * {@inheritDoc}
     */
    public function getJsLayout()
    {
        /** Set customersListUrl */
        $this->jsLayout['components']['onepageScope']['children']['steps']
        ['children']['customer-step']['config']['customersListUrl'] = $this->getUrl('customerorder/customer/getList');
        /** Set productsListUrl */
        $this->jsLayout['components']['onepageScope']['children']['steps']
        ['children']['product-step']['config']['productsListUrl'] = $this->getUrl('customerorder/product/getList');
        return json_encode($this->jsLayout, JSON_HEX_TAG);
    }
}