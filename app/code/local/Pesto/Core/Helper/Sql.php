<?php
/**
 * File: Sql.php
 * Date: 14.05.13 - 10:10
 *
 * @company BestArtDesign
 * @site http://bestartdesign.com
 * @author pest (pest11s@gmail.com)
 */

class BestArt_Core_Helper_Sql extends Mage_Core_Helper_Abstract {

    protected $_connection;

    protected function getConnection() {

        if(!$this->_connection) {
            /* @var $resource Mage_Core_Model_Resource */
            $resource = Mage::getSingleton('core/resource');
            $this->_connection = $resource->getConnection('core_read');
        }
        return $this->_connection;

    }

    /**
     * Выполнение запроса
     *
     * @param $sql
     *
     * @return string
     */
    public function execSql($sql) {
        try {
            return $this->getConnection()->fetchOne($sql);
        }catch(Exception $e) {
            return NULL;
        }
    }

    /**
     * Получение данных из базы
     *
     * @param $sql
     *
     * @return array|null
     */
    public function getSqlData($sql) {
        try {
            return $this->getConnection()->fetchAll($sql);
        }catch(Exception $e) {
            return NULL;
        }
    }

}