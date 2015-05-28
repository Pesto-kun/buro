<?php
/**
 * User: Serega
 * Date: 30.04.13
 * Time: 16:48
 */
class BestArt_Core_Helper_Collection extends Mage_Core_Helper_Abstract {

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