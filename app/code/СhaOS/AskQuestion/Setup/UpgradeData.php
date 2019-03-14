<?php

namespace ChaOS\AskQuestion\Setup;

use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Catalog\Setup\CategorySetup;
use Magento\Eav\Model\Entity\Attribute\Source\Boolean;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Store\Model\Store;
use ChaOS\AskQuestion\Model\AskQuestion;
use Magento\Framework\DB\Transaction;

/**
 * Class UpgradeData
 * @package ChaOS\AskQuestion\Setup
 */
class UpgradeData implements UpgradeDataInterface
{
    /**
     * @var \ChaOS\AskQuestion\Model\AskQuestionFactory
     */
    private $_askQuestionFactory;
    /**
     * @var \Magento\Eav\Setup\EavSetupFactory
     */
    private $eavSetupFactory;
    private $categorySetupFactory;
    /**
     * @var \Magento\Framework\DB\TransactionFactory
     */
    private $_transactionFactory;

    /**
     * UpgradeData constructor.
     * @param \ChaOS\AskQuestion\Model\AskQuestionFactory $askQuestionFactory
     * @param \Magento\Framework\DB\TransactionFactory $transactionFactory
     */
    public function __construct(
        \ChaOS\AskQuestion\Model\AskQuestionFactory $askQuestionFactory,
        \Magento\Framework\DB\TransactionFactory $transactionFactory,
        \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory,
        \Magento\Catalog\Setup\CategorySetupFactory $categorySetupFactory
    )
    {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->_askQuestionFactory = $askQuestionFactory;
        $this->_transactionFactory = $transactionFactory;
        $this->categorySetupFactory = $categorySetupFactory;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /** Start setup */
        $setup->startSetup();
        if (version_compare($context->getVersion(), '1.0.2', '<')) {
            $statuses = [AskQuestion::STATUS_PENDING, AskQuestion::STATUS_ANSWERED];
            /** @var Transaction $transaction */
            $transaction = $this->_transactionFactory->create();
            for ($i = 1; $i <= 5; $i++) {
                /** @var AskQuestion $askQuestion */
                $askQuestion = $this->_askQuestionFactory->create();
                $askQuestion->setName("Customer #$i")
                    ->setEmail("chaos-mails-$i@gmail.com")
                    ->setPhone("+38098-$i$i$i-$i$i-$i$i")
                    ->setProductName('Stellar Solar Jacket')
                    ->setSku('WJ01')
                    ->setQuestion('Just a test question')
                    ->setStatus($statuses[array_rand($statuses)])
                    ->setStoreId(Store::DISTRO_STORE_ID);
                $transaction->addObject($askQuestion);
            }
            $transaction->save();
        }
        /** Add new product attribute */
        /** @var EavSetup $eavSetupFactory */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'allow_question',
            [
                'group' => 'General',
                'type' => 'int',
                'backend' => '',
                'frontend' => '',
                'sort_order' => 50,
                'label' => 'Allow to ask questions',
                'input' => 'boolean',
                'class' => '',
                'source' => Boolean::class,
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => true,
                'required' => true,
                'user_defined' => true,
                'default' => Boolean::VALUE_YES,
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'visible_on_front' => false,
                'used_in_product_listing' => true,
                'unique' => false,
                'apply_to' => ''
            ]
        );
        /** End setup */
        $setup->endSetup();
    }
}