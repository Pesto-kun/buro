<?php
/**
 * File: Data.php
 * Date: 28.05.15 - 13:15
 *
 * @author pest (pest11s@gmail.com)
 */
class Pesto_Core_Helper_Data extends Mage_Core_Helper_Abstract {

    protected $_randStr = 'abcdefghijklmnopqrstuvwxyz0123456789';

    public function setConfig($path, $value) {
        try {
            Mage::getModel('core/config_data')->load($path, 'path')->setValue($value)->setPath($path)->save();
        } catch (Exception $e) {
            Mage::throwException($this->__('Unable to set config value'));
        }
    }

    public function getConfig($path) {

        $config_data = Mage::getModel('core/config_data')->load($path, 'path');

        if($config_data->hasData('value')) {
            return $config_data->getValue();
        }

        return NULL;
    }

    /**
     * Получение рандомной строки
     *
     * @param $size
     * @param bool $caseSensitive - пока не используется
     *
     * @return string
     *
     * @TODO добавить генерацию с учётом регистра
     */
    public function getRandomString($size, $caseSensitive = FALSE) {

        $result = '';
        $size = (int)$size;
        if($size > 0) {
            $sizeRandStr = strlen($this->_randStr)-1;
            for($i = 0; $i < $size; $i++) {
                $result .= $this->_randStr[rand(0,$sizeRandStr)];
            }
        }

        return $result;
    }

    public function isNew(Mage_Catalog_Model_Product $product){

        if(!$product->getData('news_from_date')) {
            return false;
        }

        $date = Mage::getModel('core/date')->date(NULL, time());

        $current_date = new DateTime($date); // compare date
        $from_date = new DateTime($product->getData('news_from_date')); // begin date
        $to_date = new DateTime($product->getData('news_to_date')); // end date

        $return = ($current_date >= $from_date && $current_date <= $to_date);

        return $return;
    }

    /*
    * Get the lowest price of products in store
    */
    public function getMinProductPrice() {
        // Get the current store id
        $storeId = Mage::app()
            ->getStore()
            ->getId();
        // Get a reference to the Product model
        $product = Mage::getModel('catalog/product')
            ->setStoreId($storeId)
            ->getCollection()
            ->addAttributeToSelect('price')
            ->setPageSize(1)
            ->addAttributeToSort("price", "ASC")
            ->load();

        return number_format($product->getFirstItem()
            ->getPrice(), 2, '.', '');
    }

    /*
    * Get the lowest price of products in store
    */
    public function getMaxProductPrice() {
        // Get the current store id
        $storeId = Mage::app()
            ->getStore()
            ->getId();
        // Get a reference to the Product model
        $product = Mage::getModel('catalog/product')
            ->setStoreId($storeId)
            ->getCollection()
            ->addAttributeToSelect('price')
            ->setPageSize(1)
            ->addAttributeToSort("price", "DESC")
            ->load();

        return number_format($product->getFirstItem()
            ->getPrice(), 2, '.', '');
    }
}