<?php
/**
 * Created by PhpStorm.
 * User: chaos
 * Date: 08.11.18
 * Time: 15:21
 */

namespace ChaOS\LearnRoute\Controller\JsonResponse;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\Result\Json;

/**
 * Class Index
 * @package ChaOS\LearnRoute\Controller\JsonResponse
 */
class Index extends Action
{
    
    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     */
    public function execute()
    {
        /**
         * @var Json $controllerResult
         */
        $controllerResult = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $data = ['content' => "https://inchoo.net/magento-2/routing-in-magento-2/"];
        
        return $controllerResult->setData($data);
    }
}