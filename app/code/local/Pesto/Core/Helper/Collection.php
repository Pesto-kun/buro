<?php
/**
 * File: Collection.php
 * Date: 28.05.15 - 13:14
 *
 * @author pest (pest11s@gmail.com)
 */
class Pesto_Core_Helper_Collection extends Mage_Core_Helper_Abstract {

    /**
     *  Вернуть кол-во из коллекции
     * @param Varien_Data_Collection_Db $collection
     * @return int
     */
    public function getCountCollection(Varien_Data_Collection_Db $collection)
    {
        $collection->clear();
        $dbSelectObj = $collection->getSelectCountSql();

        $sql = (string) $dbSelectObj;

        $rowArray = $dbSelectObj->getAdapter()->getConnection()->query($sql)->fetch();

        return (int) isset($rowArray[0]) ? $rowArray[0] : 0;
    }
    
}