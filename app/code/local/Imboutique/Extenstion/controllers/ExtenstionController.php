<?php
/**
 * Created by PhpStorm.
 * User: Leo
 * Date: 15/5/4
 * Time: 下午11:33
 */
class Imboutique_Extenstion_ExtenstionController extends Mage_Core_Controller_Front_Action
{
    public function indexAction() {
        echo "Hello World;";
    }
    public function showworldAction() {
        $this->loadLayout();
        $this->renderLayout();
    }
}