<?php

namespace ChaOS\AskQuestion\Helper;

use Magento\Framework\App\Area;
use Magento\Store\Model\Store;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Class NotificationMailSender
 * @package ChaOS\AskQuestion\Helper
 */
class NotificationMailSender extends AbstractHelper
{
    public const XML_PATH_STANISLAVZ_CRON_ENABLE = 'chaos_crone_options/cron/enable';
    public const XML_PATH_STANISLAVZ_CRON_DAYS = 'chaos_crone_options/cron/days';
    public const XML_PATH_STANISLAVZ_EMAIL_ENABLE = 'chaos_crone_options/email/enable';
    public const XML_PATH_STANISLAVZ_EMAIL_ADMIN_EMAIL = 'chaos_crone_options/email/admin_email';
    public const GENERAL_STORE_CONTACT_EMAIL = 'trans_email/ident_general/email';
    public const GENERAL_STORE_CONTACT_NAME = 'trans_email/ident_general/name';
    /** @var ScopeConfigInterface */
    protected $scopeConfig;
    /** @var TransportBuilder */
    protected $transportBuilder;
    /** @var StateInterface */
    protected $inlineTranslation;
    /** @var StoreManagerInterface */
    protected $storeManager;

    /**
     * NotificationMailSender constructor.
     * @param TransportBuilder $transportBuilder
     * @param StateInterface $inlineTranslation
     * @param StoreManagerInterface $storeManager
     * @param ScopeConfigInterface $scopeConfig
     * @param Context $context
     */
    public function __construct(
        TransportBuilder $transportBuilder,
        StateInterface $inlineTranslation,
        StoreManagerInterface $storeManager,
        ScopeConfigInterface $scopeConfig,
        Context $context
    )
    {
        parent::__construct($context);
        $this->transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param $receiverData
     * @param $emailTemplateID
     * @param null $adminEmailAddress
     */
    public function sendNotification($receiverData, $emailTemplateID, $adminEmailAddress = null): void
    {
        $sender = [
            'name' => $this->getStoreName(),
            'email' => $this->getStoreEmail(),
        ];
        $templateOptions = [
            'area' => Area::AREA_FRONTEND,
            'store' => Store::DEFAULT_STORE_ID,
        ];
        $templateVars = $receiverData;
        $addTo = $this->getAddTo($receiverData, $adminEmailAddress);
        if ($adminEmailAddress !== null) {
            $templateVars['vars']['isForAdmin'] = true;
        }
        try {
            $this->inlineTranslation->suspend();
            $transport = $this->transportBuilder->setTemplateIdentifier(
                $emailTemplateID
            )->setTemplateOptions(
                $templateOptions
            )->setTemplateVars(
                $templateVars
            )->setFrom(
                $sender
            )->addTo(
                $addTo
            )->getTransport();
            $transport->sendMessage();
        } catch (\Exception $e) {
            $this->inlineTranslation->resume();
            $this->_logger->error($e);
            return;
        }
    }

    /**
     * @param null $storeId
     * @return int|bool
     */
    public function getConfigValueEnableCron($storeId = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_STANISLAVZ_CRON_ENABLE,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param null $storeId
     * @return int
     */
    public function getConfigValueDays($storeId = null): int
    {
        return (int)$this->scopeConfig->getValue(
            self::XML_PATH_STANISLAVZ_CRON_DAYS,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param null $storeId
     * @return int
     */
    public function getAdminEmailEnableNotification($storeId = null): int
    {
        return (int)$this->scopeConfig->getValue(
            self::XML_PATH_STANISLAVZ_EMAIL_ENABLE,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param null $storeId
     * @return string
     */
    public function getAdminEmailAddress($storeId = null): string
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_STANISLAVZ_EMAIL_ADMIN_EMAIL,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param null $storeId
     * @return string
     */
    public function getStoreEmail($storeId = null): string
    {
        return $this->scopeConfig->getValue(
            self::GENERAL_STORE_CONTACT_EMAIL,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param null $storeId
     * @return string
     */
    public function getStoreName($storeId = null): string
    {
        return $this->scopeConfig->getValue(
            self::GENERAL_STORE_CONTACT_NAME,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param $receiverData
     * @param null $adminEmailAddress
     * @return array
     */
    private function getAddTo($receiverData, $adminEmailAddress = null): array
    {
        $addTo = [];
        if ($adminEmailAddress !== null) {
            $addTo['name'] = 'Admin';
            $addTo['email'] = $adminEmailAddress;
        } else {
            $addTo['name'] = $receiverData['name'];
            $addTo['email'] = $receiverData['email'];
        }
        return $addTo;
    }
}