<?php
/**
 * @author pest (pest11s@gmail.com) 
 */

use SimpleExcel\SimpleExcel;

class Pesto_Import_Model_Senator_Import extends Pesto_Import_Model_Senator_Data {

    protected $_goods = 'positions.xls';
    protected $_attributes = 'types_names.xls';
    protected $_attributesValue = 'types_values.xls';
    protected $_attributesData = 'types_values_assign.xls';

    public function getRequiredFileNames() {
        return array(
            $this->_goods,
            $this->_attributes,
            $this->_attributesValue,
            $this->_attributesData,
        );
    }

    public function importProducts() {

        try {
            //Получаем файлы с данными
            $this->_getFiles();

            //Парсим файлы
            $this->_parseFiles();

            //Подготавливаем файл для магми


            //Стартуем процесс обновления

        } catch(Exception $e) {

            //Обработка ошибки
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            Mage::helper('pesto_core/notify')->addNotify('Ошибка импорта продуктов Senator', $e->getMessage(), '', 'major');

        }

    }

    /**
     * Парсинг файлов
     */
    protected function _parseFiles() {

//        //Подключаем файл для работы с Excel
//        include_once Mage::getModuleDir('', 'pesto_import') . '/include/SimpleExcel/SimpleExcel.php';

        //Типы полей
        //TODO тут забить хардкодом
        $this->_parseAttributes();

        //Значение полей
        $this->_parseAttributesValues();

        //Свойства товара

        //Товары

    }

    protected function _parseAttributesValues() {

        //Локальный файл
        $filePath = $this->getLocalFilePath($this->_attributes);

        $excel = new SimpleExcel('CSV');
        /** @var $parser \SimpleExcel\Parser\CSVParser */
        $parser = $excel->parser;
        $parser->loadFile($filePath);

    }
}