<?php
/**
 * @author pest (pest11s@gmail.com) 
 */

class Pesto_Core_TestController extends Mage_Core_Controller_Front_Action {

    public function indexAction() {
        echo 'test';
    }

    public function testAction() {
        /* @var $model Pesto_Import_Model_Senator */
        $model = Mage::getModel('pesto_import/senator');

        try {
            $model->ftpConnect();
            $model->getFile('positions.xls');
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }

}