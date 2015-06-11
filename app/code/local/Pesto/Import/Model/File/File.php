<?php
/**
 * File: File.php
 * Date: 11.06.15 - 13:15
 *
 * @author pest (pest11s@gmail.com)
 */

class Pesto_Import_Model_File_File extends Mage_Core_Model_Abstract {

    //Имя файла для парсинга
    protected $_filePath = '';

    //Передача имени файла для импорта
    public function setFilePath($fileName) {
        $this->_filePath = $fileName;
        return $this;
    }

    //Получение имени файла для импорта
    public function getFilePath() {
        return $this->_filePath;
    }

    /**
     * Парсинг файла
     */
    public function parseFile() {}

}