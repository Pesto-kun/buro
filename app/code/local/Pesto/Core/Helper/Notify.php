<?php
/**
 * File: Notify.php
 * Date: 01.06.15 - 12:54
 *
 * @author pest (pest11s@gmail.com)
 */

class Pesto_Core_Helper_Notify extends Mage_Core_Helper_Abstract {

    /* @var $_notificationModel Mage_AdminNotification_Model_Inbox*/
    protected $_notificationModel;

//    protected $_notifyMail;
    protected $_notifyLevel = array(
        'notice' => 1,
        'minor' => 2,
        'major' => 3,
        'critical' => 4,
    );

    protected function _getNotificationModel() {
        return $this->_notificationModel;
    }

//    protected function getNotifyMail($key = '') {
//        if($key) {
//            return isset($this->_notifyMail[$key]) ? $this->_notifyMail[$key] : NULL;
//        } else {
//            return $this->_notifyMail;
//        }
//    }

    protected function getNotifyLevel($type) {
        return isset($this->_notifyLevel[$type]) ? $this->_notifyLevel[$type] : NULL;
    }

    function __construct() {
        $this->_notificationModel = Mage::getModel('adminnotification/inbox');
//        $this->_notifyMail = Mage::getStoreConfig('updater_global/notify');
    }

    /**
     * Добавление уведомления и отправка почты
     *
     * @param $title
     * @param $description
     * @param string $url
     * @param string $type
     */
    public function addNotify($title, $description, $url = '', $type = 'default') {
        switch($type) {
            case 'notice':
                $this->_getNotificationModel()->addNotice($title, $description, $url);
                break;
            case 'minor':
                $this->_getNotificationModel()->addMinor($title, $description, $url);
                break;
            case 'major':
                $this->_getNotificationModel()->addMajor($title, $description, $url);
                break;
            case 'critical':
                $this->_getNotificationModel()->addCritical($title, $description, $url);
                break;
            default:
                $this->_getNotificationModel()->addNotice($title, $description, $url);
        }

//        //Проверка необходимости отправки email
//        if($this->getNotifyMail('notify_by_email') && $this->getNotifyLevel($type)) {
//
//            //Проверяем уровень уведомления об ошибках
//            if($this->getNotifyMail('level') <= $this->getNotifyLevel($type)) {
//
//                //Отправка Email
//                $this->_sendEmail($title, $description, $type);
//            }
//        }

    }

//    /**
//     * Отправка письма администратору
//     *
//     * @param $subject
//     * @param $message
//     * @param $type
//     */
//    protected function _sendEmail($subject, $message, $type) {
//
//        $mailTo = $this->getNotifyMail('recipient_email');
//        $mailFrom = $this->getNotifyMail('sender_email_identity');
//
//        if($mailTo && $mailFrom) {
//
//            switch($type) {
//                case 'notice':
//                    $template = 'bestart_updater_notice_template';
//                    break;
//                case 'minor':
//                    $template = 'bestart_updater_minor_template';
//                    break;
//                case 'major':
//                    $template = 'bestart_updater_major_template';
//                    break;
//                case 'critical':
//                    $template = 'bestart_updater_critical_template';
//                    break;
//                default:
//                    $template = 'bestart_updater_default_template';
//            }
//
//            try {
//                Mage::getModel('bestart_updater/email')->sendEmail(
//                    $template,
//                    array('name' => 'Info', 'email' => $mailFrom),
//                    $mailTo,
//                    'Admin',
//                    $subject,
//                    array('message' => $message)
//                );
//            } catch(Exception $e) {
//                $this->_getNotificationModel()
//                    ->addCritical(
//                        "Can't send notify email",
//                        "Exception while try send email for notify admin.\n" . $e->getMessage()
//                    );
//            }
//
//        }
//    }
//
}