<?php
/**
 * @author pest (pest11s@gmail.com) 
 */

class Pesto_Core_TestController extends Mage_Core_Controller_Front_Action {

    public function indexAction() {
        echo 'test';
    }

    public function testAction() {
        try {
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }

}