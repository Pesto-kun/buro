<?php
/**
 * File: Xml.php
 * Date: 21.03.13 - 11:12
 *
 * @company BestArtDesign
 * @site http://bestartdesign.com
 * @author pest (pest11s@gmail.com)
 */

class BestArt_Core_Helper_Xml extends Mage_Core_Helper_Abstract {

    /**
     * Получение данных в виде ассоциативного массива из XML файла
     *
     * @param $filePath
     *
     * @return mixed|null
     */
    public function getFromXmlFile($filePath) {

        //Если файл существует
        if(file_exists($filePath) && is_file($filePath)) {

            $array = array();

            try {

                $xml = simplexml_load_file($filePath);
                foreach($xml as $key => $val) {
                    $array[$key] = (int)$val;
                }

            } catch (Exception $e) {
                return FALSE;
            }

            return $array;
        }

        return NULL;
    }

    /**
     * Сохранение массива в XML файл
     *
     * @param $array
     * @param $filePath
     *
     */
    public function saveArrayToXML($array, $filePath) {

        try {

            // creating object of SimpleXMLElement
            $xml = new SimpleXMLElement("<?xml version=\"1.0\"?><config></config>");

            // function call to convert array to xml
            $this->arrayToXml($array, $xml);

            //saving generated xml file
            $xml->asXML($filePath);

        } catch(Exception $e) {
            Mage::throwException($e->getMessage());
        }

    }

    /**
     * Конвертация массива в хмл
     *
     * @param $array
     * @param SimpleXMLElement $xml
     */
    protected function arrayToXml($array, &$xml) {

        foreach($array as $key => $value) {

            if(is_array($value)) {

                if(!is_numeric($key)){

                    $subXml = $xml->addChild("$key");
                    $this->arrayToXml($value, $subXml);

                } else {
                    $this->arrayToXml($value, $xml);
                }

            } else {
                $xml->addChild("$key", "$value");
            }
        }
    }

}