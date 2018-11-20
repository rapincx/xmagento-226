<?php
/**
 * Created by PhpStorm.
 * User: chaos
 * Date: 08.11.18
 * Time: 15:17
 */

namespace ChaOS\LearnRoute\Block;

use Magento\Framework\View\Element\Template;

class CustomLayout extends Template
{
    const JSON_RESPONSE = 'homework/jsonresponse/index';
    
    /**
     * @return string
     */
    public function getLinkToJson()
    {
        return $this->getUrl(self::JSON_RESPONSE);
    }
}