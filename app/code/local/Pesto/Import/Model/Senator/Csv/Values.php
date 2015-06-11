<?php
/**
 * @author pest (pest11s@gmail.com) 
 */

class Pesto_Import_Model_Senator_Csv_Values extends Pesto_Import_Model_File_Csv {

    protected $_attributesValues = array();

    protected function addAttributeValue($key, $value) {
        $this->_attributesValues[$key] = $value;
    }

    public function formatData(){
        foreach($this->getRows() as $_key => $_row) {
            $this->addAttributeValue($_row['Код свойства'], array(
                'attribute' => $_row['Код типа'],
                'title' => $_row['Наименование'],
            ));
        }
    }

}