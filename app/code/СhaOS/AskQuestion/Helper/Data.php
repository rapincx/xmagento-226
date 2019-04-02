<?php

namespace ChaOS\AskQuestion\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Data
 * @package ChaOS\AskQuestion\Helper
 */
class Data extends AbstractHelper
{
    public const XML_PATH_CHAOS_CRON_ENABLE = 'ChaOS_cron_options/cron/enable';
    public const XML_PATH_CHAOS_CRON_DAYS = 'ChaOS_cron_options/cron/days';

    /**
     * @param null $storeId
     * @return int|bool
     */
    public function getConfigValueEnableCron($storeId = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_CHAOS_CRON_ENABLE,
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
            self::XML_PATH_CHAOS_CRON_DAYS,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
}