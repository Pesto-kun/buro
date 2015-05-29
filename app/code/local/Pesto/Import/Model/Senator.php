<?php
/**
 * @author pest (pest11s@gmail.com) 
 */

class Pesto_Import_Model_Senator extends Pesto_Import_Model_Ftp {

    protected $_goods = 'positions.xls';
    protected $_attributes = 'types_names.xls';
    protected $_attributesValue = 'types_values.xls';
    protected $_attributesData = 'types_values_assign.xls';

    public function __construct() {
        parent::__construct();
        $this->_type = 'senator';
        $data = Mage::getStoreConfig('pesto_import/senator');
        $this->initFtpData($data['ftp_url'], $data['ftp_login'], $data['ftp_password']);
    }
}