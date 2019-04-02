<?php

namespace ChaOS\CustomerOrder\Controller\Customer;

/**
 * Class Order
 * @package ChaOS\CustomerOrder\Controller\Customer
 */
class Order extends \Magento\Framework\App\Action\Action
{
    /**
     * {@inheritDoc}
     */
    public function execute()
    {
        return $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_PAGE);
    }
}