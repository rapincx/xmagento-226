<?php

namespace ChaOS\AskQuestion\Observer\AskQuestion\Controller\Submit;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use ChaOS\AskQuestion\Helper\NotificationMailSender as EmailSender;

/**
 * Class Index
 * @package ChaOS\AskQuestion\Observer\AskQuestion\Controller\Submit
 */
class Index implements ObserverInterface
{
    public const ADMIN_ASKQUESTION_EMAIL_TEMPLATE = 'admin_question_notification';
    public const CUSTOMER_ASKQUESTION_EMAIL_TEMPLATE = 'customer_question_notification';
    /** @var EmailSender */
    private $emailSender;

    /**
     * Index constructor.
     * @param EmailSender $emailSender
     */
    public function __construct(
        EmailSender $emailSender
    )
    {
        $this->emailSender = $emailSender;
    }

    /**
     * @param Observer $observer
     * @return $this|void
     */
    public function execute(Observer $observer)
    {
        if (!$this->isEmailNotificationEnabled()) {
            return;
        }
        /** @var \Magento\Framework\Event $event */
        $event = $observer->getEvent();
        /** @var \Magento\Framework\App\Request\Http $request */
        $request = $event->getData('request');
        $postData = $request->getPostValue();
        // send admin notification
        $this->sendEmail(
            $postData,
            self::ADMIN_ASKQUESTION_EMAIL_TEMPLATE,
            $this->emailSender->getAdminEmailAddress()
        );
        // send customer notification
        $this->sendEmail($postData, self::CUSTOMER_ASKQUESTION_EMAIL_TEMPLATE);
        return $this;
    }

    /**
     * @return int
     */
    private function isEmailNotificationEnabled(): int
    {
        return $this->emailSender->getAdminEmailEnableNotification();
    }

    /**
     * @param $postData
     * @param $emailTemplateId
     * @param null $adminEmailAddress
     */
    private function sendEmail($postData, $emailTemplateId, $adminEmailAddress = null): void
    {
        $this->emailSender->sendNotification($postData, $emailTemplateId, $adminEmailAddress);
    }
}