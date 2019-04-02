<?php

namespace ChaOS\AskQuestion\Setup;

use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Model\Entity\Attribute\Source\Boolean;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Store\Model\Store;
use ChaOS\AskQuestion\Model\AskQuestion;
use Magento\Framework\DB\Transaction;
use Magento\Customer\Model\Customer;
use Magento\Customer\Model\ResourceModel\Attribute;
use Magento\Eav\Model\Config;
use Magento\Customer\Api\Data\GroupInterfaceFactory;
use Magento\Customer\Api\GroupRepositoryInterface;
use Magento\Customer\Api\AddressMetadataInterface;

/**
 * Class UpgradeData
 * @package ChaOS\AskQuestion\Setup
 */
class UpgradeData implements UpgradeDataInterface
{
    public const DISALLOWED_QUESTION_CUSTOMER_GROUP = 'Disallow questions group';
    public const CUSTOMER_CITY_DISTRICT = 'city_district';

    /**
     * @var \ChaOS\AskQuestion\Model\AskQuestionFactory
     */
    private $_askQuestionFactory;
    /**
     * @var \Magento\Eav\Setup\EavSetupFactory
     */
    private $eavSetupFactory;
    /**
     * @var \Magento\Framework\DB\TransactionFactory
     */
    private $_transactionFactory;
    /** @var Config */
    private $eavConfig;
    /** @var Attribute */
    private $attributeResource;
    private $groupFactory;
    private $groupRepository;

    /**
     * UpgradeData constructor.
     * @param \ChaOS\AskQuestion\Model\AskQuestionFactory $askQuestionFactory
     * @param \Magento\Framework\DB\TransactionFactory $transactionFactory
     * @param \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory
     * @param Attribute $attributeResource
     * @param GroupInterfaceFactory $groupFactory
     * @param GroupRepositoryInterface $groupRepository
     * @param Config $eavConfig
     */
    public function __construct(
        \ChaOS\AskQuestion\Model\AskQuestionFactory $askQuestionFactory,
        \Magento\Framework\DB\TransactionFactory $transactionFactory,
        \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory,
        \Magento\Customer\Model\ResourceModel\Attribute $attributeResource,
        GroupInterfaceFactory $groupFactory,
        GroupRepositoryInterface $groupRepository,
        Config $eavConfig
    )
    {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->_askQuestionFactory = $askQuestionFactory;
        $this->_transactionFactory = $transactionFactory;
        $this->eavConfig = $eavConfig;
        $this->attributeResource = $attributeResource;
        $this->groupFactory = $groupFactory;
        $this->groupRepository = $groupRepository;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\State\InvalidTransitionException
     */
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
                    ->setQuestion('Just a Demo Question')
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
        // Add customer attribute
        /** @var EavSetup $eavSetupFactory */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $eavSetup->addAttribute(
            Customer::ENTITY,
            'disallow_ask_question',
            [
                'type' => 'int',
                'label' => 'Disallow Ask Question',
                'input' => 'boolean',
                'required' => true,
                'visible' => true,
                'user_defined' => true,
                'sort_order' => 11,
                'position' => 11,
                'system' => 0,
                'source' => Boolean::class,
                'default' => Boolean::VALUE_NO
            ]
        );
        $attribute = $this->eavConfig->getAttribute(
            Customer::ENTITY,
            'disallow_ask_question'
        )->setData(
            [
                'used_in_forms' => ['adminhtml_customer', 'customer_account_edit'],
            ]
        );
        $this->attributeResource->save($attribute);
        // Add customer Address attribute
        /** @var EavSetup $eavSetupFactory */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $eavSetup->addAttribute(
            AddressMetadataInterface::ENTITY_TYPE_ADDRESS,
            self::CUSTOMER_CITY_DISTRICT,
            [
                'label' => __('City District'),
                'input' => 'text',
                'visible' => true,
                'required' => false,
                'position' => 150,
                'sort_order' => 150,
                'system' => false
            ]
        );
        $customAddressAttribute = $this->eavConfig->getAttribute(
            AddressMetadataInterface::ENTITY_TYPE_ADDRESS,
            self::CUSTOMER_CITY_DISTRICT
        );
        $customAddressAttribute->setData(
            'used_in_forms',
            [
                'adminhtml_customer_address',
                'customer_address_edit',
                'customer_register_address'
            ]
        );
        $this->attributeResource->save($customAddressAttribute);
        // Create the new group
        /** @var \Magento\Customer\Model\Group $group */
        $group = $this->groupFactory->create();
        $group->setCode(self::DISALLOWED_QUESTION_CUSTOMER_GROUP);
        $this->groupRepository->save($group);
        /** End setup */
        $setup->endSetup();
    }
}