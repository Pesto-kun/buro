<?php
/**
 * @author pest (pest11s@gmail.com) 
 */

//use SimpleExcel\SimpleExcel;

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
            //TODO вернуть
//            $this->_getFiles();

            //Парсим файлы
            $this->_parseFiles();

            //Подготавливаем файл для магми


            //Стартуем процесс обновления

        } catch(Exception $e) {

            //Обработка ошибки
            echo '<pre style="text-align:left;background-color:white;">'.print_r($e->getMessage(),1).'</pre>';
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            Mage::helper('pesto_core/notify')->addNotify('Ошибка импорта продуктов Senator', $e->getMessage(), '', 'major');

        }

    }

    /**
     * Парсинг файлов
     */
    protected function _parseFiles() {

//        //Подключаем файл для работы с Excel

        //Типы полей
        //TODO тут забить хардкодом
        $this->_parseAttributes();

        //Значение полей
        $this->_parseAttributesValues();

        //Свойства товара

        //Товары

    }

    protected function _parseAttributes() {

    }

    protected function _parseAttributesValues() {

//        require_once(Mage::getModuleDir('', 'Pesto_Import') . '/include/SimpleExcel/SimpleExcel.php');
//        require_once('/home/pest/web/buro-reklamy.my/app/code/local/Pesto/Import/include/SimpleExcel/SimpleExcel.php');
//        require_once '../../include/SimpleExcel/SimpleExcel.php';

        //Локальный файл
        $filePath = $this->getLocalFilePath($this->_attributes);

        $includePath = Mage::getBaseDir(). "/lib/SimpleExcel";
        set_include_path(get_include_path() . PS . $includePath);

//        $excel = new \SimpleExcel\SimpleExcel('CSV');
        $excel = new SimpleExcel();
        /** @var $parser \SimpleExcel\Parser\CSVParser */
        $parser = $excel->parser;
        $parser->loadFile($filePath);
//        $a = 'test';
    }
}