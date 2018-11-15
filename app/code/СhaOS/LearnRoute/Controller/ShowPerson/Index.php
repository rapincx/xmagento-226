<?php
/**
 * Created by PhpStorm.
 * User: chaos
 * Date: 08.11.18
 * Time: 15:28
 */

namespace ChaOS\LearnRoute\Controller\ShowPerson;

use Magento\Framework\App\Action\Action;

class Index extends Action
{
    
    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return void
     */
    public function execute()
    {
        $name = 'Yaroslav';
        $lastName = 'Volovyk';
        $this->_view->loadLayout()
            ->getLayout()
            ->getBlock('learnroute.block')
            ->setName($name)
            ->setLastName($lastName);
        $this->_view->renderLayout();
    }
}