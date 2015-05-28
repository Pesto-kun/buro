<?php
/**
 * File: Cron.php
 * Date: 31.01.13 - 15:16
 *
 * @company BestArtDesign
 * @site http://bestartdesign.com
 * @author pest (pest11s@gmail.com)
 */

class BestArt_Core_Model_Cron {

    //Дозволеное время для выполнения операций
    const BA_CRON_ALLOWED_TIME = 45;

    //Кулдаун по умолчанию
    const BA_CRON_COOLDOWN_DEFAULT = 150;

    protected $_systemPathPrefix;

    protected $cronName;
    protected $_logFile;
    protected $_errorLogFile;

    protected $_allowedTime = self::BA_CRON_ALLOWED_TIME;

    public function setSystemPathPrefix($systemPathPrefix) {
        $this->_systemPathPrefix = $systemPathPrefix;
    }

    public function setLogFile($logFile) {
        $this->_logFile = $logFile;
    }

    public function setCronName($cronName) {
        $this->cronName = $cronName;
    }

    public function setErrorLogFile($errorLogFile) {
        $this->_errorLogFile = $errorLogFile;
    }

    public function getErrorLogFile() {
        return $this->_errorLogFile;
    }

    public function getLogFile() {
        return $this->_logFile;
    }

    public function getCronName() {
        return $this->cronName;
    }

    public function getCooldownPath() {
        return $this->_systemPathPrefix . DS . 'cooldown';
    }

    public function getEnabledPath() {
        return $this->_systemPathPrefix . DS. 'enabled';
    }

    public function getLockPath() {
        return $this->_systemPathPrefix . DS . 'lock';
    }

    public function updateAllowedTime($time) {
        $this->_allowedTime -= $time;
    }

    public function getAllowedTime() {
        return $this->_allowedTime;
    }

    /**
     * Выполнение парсинга по крону
     */
    public function runCron() {

        $startTime = microtime(TRUE);

        try {

            //Если процесс запущен
            if(Mage::helper('bestart_core')->getConfig($this->getEnabledPath()) == 0) {
                return;
            }

            //Текущее время
            $time = Mage::getModel('core/date')->timestamp(time());

            //Лог старта выполнения крона
            Mage::log('Run "'.$this->getCronName().'" parsing.', NULL, $this->getLogFile());

            //Загружаем флаг
            $lock = Mage::helper('bestart_core')->getConfig($this->getLockPath());

            //Проверям флаг
            if($lock != 0) {

                //Загружаем период кулдауна
                if(!($cooldown = Mage::helper('bestart_core')->getConfig($this->getCooldownPath()))) {
                    $cooldown = self::BA_CRON_COOLDOWN_DEFAULT;
                }

                //Eсли процесс выполняется и ещё не завис, то выходим
                if(($time - $lock) < $cooldown) {

                    //Информирование о уже запущеном процессе
                    Mage::log('Процесс "'.$this->getCronName().'" уже запущен.', NULL, $this->getLogFile());

                    return;
                }

                //Пишем в лог
                Mage::log("Обнаружен незавершенный процесс во время выполнения \"".$this->getCronName()."\" парсинга данных с сайта", NULL, $this->getLogFile());

            }

            //Устанавливаем флаг
            Mage::helper('bestart_core')->setConfig($this->getLockPath(), $time);

            $status = TRUE;

            //Пока позволено время
            while($this->getAllowedTime() > 0 && $status) {

                $operationTime = microtime(1);

                //Стартуем новый процесс
                $status = $this->startParsing();

                //Уменьшаем время выполнения
                $this->updateAllowedTime(microtime(1) - $operationTime);
            }

            //Снимаем флаг выполнения
            Mage::helper('bestart_core')->setConfig($this->getLockPath(), 0);

            //Проверям завершение процесса
            if(!$status) {

                //Завершаем процесс
                Mage::helper('bestart_core')->setConfig($this->getEnabledPath(), 0);

            }

        } catch(Exception $e) {

            //Снимаем флаг выполнения
            Mage::helper('bestart_core')->setConfig($this->getLockPath(), 0);
            Mage::log('Throw Exception (for "' . $this->getCronName() . '"): ' . $e->getMessage(), NULL, $this->getLogFile());
//            Mage::throwException($e->getMessage());
        }

        //Лог завершения выполнения крона
        Mage::log('Cron "'.$this->getCronName().'" is over. Time parsing: ' . (microtime(TRUE) - $startTime) . ' sec', NULL, $this->getLogFile());

    }

    /**
     * Старт парсинга по крону
     */
    protected function startParsing() {
        return FALSE;
    }

}