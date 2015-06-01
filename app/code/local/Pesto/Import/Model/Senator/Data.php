<?php
/**
 * @author pest (pest11s@gmail.com) 
 */

class Pesto_Import_Model_Senator_Data extends Pesto_Import_Model_Ftp {

    public function __construct() {
        parent::__construct();
        $this->_type = 'senator';
        $data = Mage::getStoreConfig('pesto_import/senator');
        $this->initFtpData($data['ftp_url'], $data['ftp_login'], $data['ftp_password']);
    }
}