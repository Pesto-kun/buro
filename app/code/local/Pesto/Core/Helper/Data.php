<?php
/**
 * User: serega
 * Date: 01.03.13
 * Time: 10:07
 */
class BestArt_Core_Helper_Data extends Mage_Core_Helper_Abstract {

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

    protected function _getPluralEn($number)
    {
        if ($number > 1)
            return 'Products';

        return 'Product';
    }

    protected function _getPluralRu($number)
    {
        if ($number % 100 > 10 AND $number % 100 < 14)
        {
            return 'Товаров';
        }

        switch ($number % 10)
        {
            case 1:
                return 'Товар';
            case 2:
            case 3:
            case 4:
                return 'Товара';
            default:
                return 'Товаров';
        }
    }

    /** Склонение слова "товар" в зависимости от кол-ва
     * @param $number
     * @param Mage_Core_Model_Locale $locale
     * @return string
     */
    public function getPluralProducts($number, Mage_Core_Model_Locale $locale)
    {
        $result = '';
        switch($locale->getLocaleCode()) {
            case 'en_EN':
            case 'en_US':
            case 'us_US':
                $result = $this->_getPluralEn($number);
                break;

            default: $result = $this->_getPluralRu($number);
        }

        return $result;
    }

    public function getMiniCartProductsHtml()
    {
        $qty = Mage::helper('checkout/cart')->getItemsQty();
        $plural = $this->getPluralProducts($qty, Mage::app()->getLocale());
        return $this->_getPluralHtml($qty, $plural);
    }

    protected function _getPluralHtml($qty, $plural)
    {
        return '<span>'.$qty.'</span> '.$plural;
    }
}