<?php
namespace ChaOS\AskQuestion\Controller\Submit;

use Magento\Framework\App\Request\Http;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;

class Index extends \Magento\Framework\App\Action\Action
{
    const STATUS_ERROR = 'Error';
    const STATUS_SUCCESS = 'Success';
    /**
     * @var \Magento\Framework\Data\Form\FormKey\Validator
     */
    private $formKeyValidator;
    
    /**
     * Index constructor.
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \Magento\Framework\App\Action\Context $context
    ) {
        parent::__construct($context);
        $this->formKeyValidator = $formKeyValidator;
    }
    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var Http $request */
        $request = $this->getRequest();
        try {
            if (!$this->formKeyValidator->validate($request) || $request->getParam('hide-it')) {
                throw new LocalizedException(
                    __('Something went wrong. Probably you were away for quite a long time already. Please, reload the page and try again.')
                );
            }
            if (!$request->isAjax()) {
                throw new LocalizedException(__('This request is not valid and can not be processed.'));
            }
            // Here we must also process backend validation or all form fields.
            // Otherwise attackers can just copy our page, remove fields validation and send anything they want
            $data = [
                'status' => self::STATUS_SUCCESS,
                'message' => 'Your request was submitted. We\'ll get in touch with you as soon as possible.'
            ];
        } catch (LocalizedException $e) {
            $data = [
                'status'  => self::STATUS_ERROR,
                'message' => $e->getMessage()
            ];
        }
        /**
         * @var \Magento\Framework\Controller\Result\Json $controllerResult
         */
        $controllerResult = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        return $controllerResult->setData($data);
    }
}