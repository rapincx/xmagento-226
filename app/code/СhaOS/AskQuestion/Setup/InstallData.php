<?php

namespace ChaOS\AskQuestion\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * Class InstallData
 * @package ChaOS\AskQuestion\Setup
 */
class InstallData implements \Magento\Framework\Setup\InstallDataInterface
{
    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        // The code in install and upgrade scripts is the same
        // Though, right now this file  will not work because first version of this module did not have any models
    }
}