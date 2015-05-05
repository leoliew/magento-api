<?php
// define('MAGENTO_PLUGIN_VERSION', 'v1.2.3');
// define('KANCART_APP_KEY', Mage::getStoreConfig('Kancart/Kancart_group/Kancart_appkey', Mage::app()->getStore()));
// define('KANCART_APP_SECRECT', Mage::getStoreConfig('Kancart/Kancart_group/Kancart_appsecrect', Mage::app()->getStore()));
// if (Mage::getStoreConfig('Kancart/Kancart_group/Kancart_PaymentEnv', Mage::app()->getStore()) == 1)
//     define('PAYPAL_ENVIRONMENT', 'live');
// else
//     define('PAYPAL_ENVIRONMENT', 'sandbox');



class Lading_Api_IndexController extends Lading_Api_Controller_Action {
	public function indexAction() {
		echo 'hello world!';
	}
}