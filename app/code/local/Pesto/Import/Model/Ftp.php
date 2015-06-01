<?php
/**
 * @author pest (pest11s@gmail.com) 
 */

class Pesto_Import_Model_Ftp extends Mage_Core_Model_Abstract {

    protected $_coreDir = '/buro/';
    protected $_type = 'default';
    protected $_importDir = 'source';
    protected $_importPath;

    protected $_ftpUrl;
    protected $_ftpLogin;
    protected $_ftpPassword;

    protected $_ftpConnection;

    /**
     * @return string
     */
    public function getFtpUrl() {
        return $this->_ftpUrl;
    }

    /**
     * @return string
     */
    public function getFtpLogin() {
        return $this->_ftpLogin;
    }

    /**
     * @return string
     */
    public function getFtpPassword() {
        return $this->_ftpPassword;
    }

    public function initFtpData($url, $login, $password) {
        $this->_ftpUrl = $url;
        $this->_ftpLogin = $login;
        $this->_ftpPassword = $password;
    }

    /**
     * @return mixed
     */
    public function getImportPath() {
        if(is_null($this->_importPath)) {

            $path = Mage::getBaseDir('var') . DS . $this->_coreDir . $this->_type . DS . $this->_importDir . DS;

            //Создаем директорию
            Mage::helper('pesto_core/file')->createDir($path);

            $this->setImportPath($path);
        }

        return $this->_importPath;
    }

    /**
     * @param mixed $importPath
     */
    public function setImportPath($importPath) {
        $this->_importPath = $importPath;
    }

    /**
     * @return mixed
     */
    public function getFtpConnection() {
        return $this->_ftpConnection;
    }

    /**
     * @param mixed $ftpConnection
     */
    public function setFtpConnection($ftpConnection) {
        $this->_ftpConnection = $ftpConnection;
    }

    protected function _ftpConnect() {

        //Если не указан url
        if(!$this->getFtpUrl()) {
            throw new Exception('Не указан FTP');
        }

        if($connectionId = ftp_connect($this->getFtpUrl())) {
            $this->setFtpConnection($connectionId);
            return $this;
        } else {
            throw new Exception('FTP соединение не установлено');
        }
    }

    protected function _ftpLogin() {

        //Если не указаны парамтеры для входа
        if(!$this->getFtpLogin() || !$this->getFtpPassword()) {
            throw new Exception('Не указаны параметры для подключения к url');
        }

        if(ftp_login($this->getFtpConnection(), $this->getFtpLogin(), $this->getFtpPassword())) {
            return $this;
        } else {
            throw new Exception('Невозможно подключиться к FTP с указанными параметрами');
        }
    }

    public function ftpConnect(){
        return $this->_ftpConnect()->_ftpLogin();
    }

    public function ftpCloseConnection() {
        ftp_close($this->getFtpConnection());
    }

    public function getLocalFilePath($fileName) {
        return $this->getImportPath() . $fileName;
    }

    public function getFile($fileName) {
        if(ftp_get($this->getFtpConnection(), $this->getLocalFilePath($fileName), $fileName, FTP_BINARY)) {
            return $this;
        } else {
            throw new Exception('Невозможно получить файл с FTP');
        }
    }

    public function getRequiredFileNames() {
        return array();
    }

    /**
     * Получение необходимых файлов с сервера
     *
     * @return $this
     * @throws Exception
     */
    protected function _getFiles() {
        foreach($this->getRequiredFileNames() as $_file) {
            $this->ftpConnect();
            $this->getFile($_file);
        }
        return $this;
    }
}