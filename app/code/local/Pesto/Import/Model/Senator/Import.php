<?php
/**
 * @author pest (pest11s@gmail.com) 
 */

//use SimpleExcel\SimpleExcel;

class Pesto_Import_Model_Senator_Import extends Pesto_Import_Model_Senator_Data {

    protected $_goods = 'positions.csv';
    protected $_attributes = 'types_names.csv';
    protected $_attributesValue = 'types_values.csv';
    protected $_attributesData = 'types_values_assign.csv';

//    public function getRequiredFileNames() {
//        return array(
//            $this->_goods,
//            $this->_attributes,
//            $this->_attributesValue,
//            $this->_attributesData,
//        );
//    }

    public function importProducts() {

        try {
            //Получаем файлы с данными
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

        //Типы полей
        //TODO тут забить хардкодом
        $this->_parseAttributes();

        //Значение полей
        $this->_parseAttributesValues();

        //Свойства товара

        //Товары

    }

    protected function _parseAttributes() {
        return array(
            '01' => 'Тип товара',
            '02' => 'Цвет',
            '03' => 'Тип ручки',
            '04' => 'Материал',
            '05' => 'Цвет чернил',
            '06' => 'Тип крепления папки',
            '07' => 'Формат папки',
            '08' => 'Ценовая категория',
            '09' => 'Категория кружек',
            '10' => 'Категория папок',
            '11' => 'Рекламный материал',
            '12' => 'Категория ручек',
            '13' => 'Подкатегория ручек',
            '14' => 'Категория других товаров',
            '15' => 'Подкатегория других товаров',
            '16' => '1',
            '17' => '2',
            '18' => 'Подкатегория кружек',
            '19' => 'Новинка',
            '20' => 'Pantone',
            '21' => 'Возможности нанесения',
            '22' => 'Категория Koziol',
            '23' => 'Подкатегория Koziol',
            '24' => 'Категория офиса',
            '25' => 'Подкатегория офиса',
        );
    }

    protected function _parseAttributesValues() {

        //Локальный файл
        $filePath = $this->getLocalFilePath($this->_attributesValue);

        //Получаем данные
        /* @var $csv Pesto_Import_Model_Senator_Csv_Values */
        $csv = Mage::getModel('pesto_import/senator_csv_values');
        $csv->setFilePath($filePath)->parseFile()->formatData();
        $a = $csv->getRows();
    }
}