<?php

namespace ChaOS\SomeWidget\Plugin;

use Magento\Framework\Data\Tree\NodeFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Cms\Model\PageFactory;
use Magento\Framework\UrlInterface;
/**
 * Class TopMenu
 * @package ChaOS\SomeWidget\Plugin
 */
class Topmenu
{
    /**
     * @var NodeFactory
     */
    protected $_nodeFactory;
    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;
    /**
     * @var PageFactory
     */
    protected $_pageFactory;
    /**
     * @var UrlInterface
     */
    protected $_urlBuilder;
    /**
     * TopMenu constructor.
     * @param NodeFactory $nodeFactory
     * @param PageFactory $pageFactory
     * @param StoreManagerInterface $storeManager
     * @param UrlInterface $urlBuilder
     */
    public function __construct(
        \Magento\Framework\Data\Tree\NodeFactory $nodeFactory,
        \Magento\Cms\Model\PageFactory $pageFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\UrlInterface $urlBuilder
    ) {
        $this->_nodeFactory = $nodeFactory;
        $this->_pageFactory = $pageFactory;
        $this->_storeManager = $storeManager;
        $this->_urlBuilder = $urlBuilder;
    }
    /**
     * @param \Magento\Theme\Block\Html\Topmenu $subject
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function beforeGetHtml(
        \Magento\Theme\Block\Html\Topmenu $subject
    ) {
        $page = $this->getCmsPage('geekhub-cms');
        if ($page === null) {
            return;
        }
        $node = $this->_nodeFactory->create(
            [
                'data' => [
                    'name' => __('Special offers'),
                    'id' => 'geekhub-cms',
                    'url' => $this->_urlBuilder->getUrl(null, ['_direct' =>'geekhub-cms']),
                    'has_active' => false,
                    'is_active' => false
                ],
                'idField' => 'id',
                'tree' => $subject->getMenu()->getTree()
            ]
        );
        $subject->getMenu()->addChild($node);
    }
    /**
     * @param $identifier
     * @return \Magento\Cms\Model\Page|null
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    protected function getCmsPage($identifier)
    {
        $page = $this->_pageFactory->create();
        $pageId = $page->checkIdentifier($identifier, $this->_storeManager->getStore()->getId());
        if (!$pageId) {
            return null;
        }
        $page->setStoreId($this->_storeManager->getStore()->getId());
        if (!$page->load($pageId)) {
            return null;
        }
        if (!$page->getId()) {
            return null;
        }
        return $page;
    }
}