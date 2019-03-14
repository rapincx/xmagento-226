<?php

namespace ChaOS\AskQuestion\Observer\Catalog\Block\Product;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Registry;

/**
 * Class View
 * @package ChaOS\AskQuestion\Observer\Catalog\Block\Product
 */
class View implements ObserverInterface
{
    /**
     * Layout handle name we need to add
     */
    public const LAYOUT_HANDLE = 'ask_question_tab';
    /**
     * @var Registry
     */
    private $registry;

    /**
     * Predispatch constructor.
     * @param Registry $registry
     */
    public function __construct(
        Registry $registry
    )
    {
        $this->registry = $registry;
    }

    /**
     * @param Observer $observer
     * @return $this|void
     */
    public function execute(Observer $observer)
    {
        $actionName = $observer->getEvent()->getData('full_action_name');
        /** @var \Magento\Catalog\Model\Product $product */
        $product = $this->registry->registry('current_product');
        /** @var \Magento\Framework\View\Layout $layout */
        $layout = $observer->getEvent()->getData('layout');
        if ($product && $actionName === 'catalog_product_view' && $product->getAllowQuestion()) {
            $layout->getUpdate()->addHandle(static::LAYOUT_HANDLE);
        }
        return $this;
    }
}