<?php

namespace ChaOS\SomeWidget\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;
/**
 * Class SpecialLink
 * @package ChaOS\SomeWidget\Block\Widget
 */
class SpecialLink extends Template implements BlockInterface
{
    /**
     * @var string
     */
    protected $_template = 'widget/somewidget.phtml';
    /**
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function outputBlock(): string
    {
        return $this->getLayout()
            ->createBlock('Magento\Cms\Block\Block')
            ->setBlockId($this->getBlockId())
            ->toHtml();
    }
}