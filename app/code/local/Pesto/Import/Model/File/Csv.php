<?php

/**
 * File: Csv.php
 * Date: 11.06.15 - 13:16
 *
 * @author pest (pest11s@gmail.com)
 */
class Pesto_Import_Model_File_Csv extends Pesto_Import_Model_File_File {

    protected $_header = array();
    protected $_rows = array();

    /**
     * @return array
     */
    public function getHeader() {
        return $this->_header;
    }

    /**
     * @param array $header
     */
    public function setHeader($header) {
        $this->_header = $header;
    }

    /**
     * @return array
     */
    public function getRows() {
        return $this->_rows;
    }

    /**
     * @param $row
     *
     * @return array
     */
    public function addRow($row) {
        return $this->_rows[] = $row;
    }

    /**
     * Парсинг csv файла
     */
    public function parseFile() {

        try {

            //Открываем файл на чтение
            if(($handle = fopen($this->getFilePath(), "r")) !== FALSE) {
                //Читаем заголовок таблицы
                if(($data = fgetcsv($handle, 0, ";")) !== FALSE) {
                    $this->setHeader($data);
                }
                //Читаем построчно файл
                while(($data = fgetcsv($handle, 0, ";")) !== FALSE) {
                    $row = array();
                    //Перестраиваем в ассоциативный массив
                    foreach($this->getHeader() as $key => $col) {
                        $row[$col] = $data[$key];
                    }
                    $this->addRow($row);
                }
                //Закрываем файл
                fclose($handle);
            }

        } catch(Exception $e) {
            throw $e;
        }

        return $this;
    }
}