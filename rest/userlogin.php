<?php
/* 	License
*	2015-04-29
*	Create by terry
*/


//
//	Set key for access to functionality this script
//
define('WEB_API_KEY', 'key1');


require_once('../app/Mage.php');
Mage::app("default");

$key = Mage::app()->getRequest()->getParam('key');

if ( !isset($key) || $key != WEB_API_KEY ) {

	$json = array('success' => false, 'code' => 20, 'message' => 'Invalid secret key');
	print_r(json_encode($json));

}elseif(Mage::app()->getRequest()->getParam('route') == "rest/web_api/login"){

	# -- $_GET params ------------------------------
    $email = Mage::app()->getRequest()->getParam('email', 4);
	$password = Mage::app()->getRequest()->getParam('password', 4);
    # -- End $_GET params --------------------------
    print_r(json_encode(getLogin($email, $password)));
}elseif(Mage::app()->getRequest()->getParam('route') == "rest/web_api/logout"){

	# -- $_GET params ------------------------------

    # -- End $_GET params --------------------------
    print_r(json_encode(logout()));
}elseif(Mage::app()->getRequest()->getParam('route') == "rest/web_api/register"){

	# -- $_GET params ------------------------------
	$firstName = Mage::app()->getRequest()->getParam('firstName', 4);
	$lastName = Mage::app()->getRequest()->getParam('lastName', 4);
	$email = Mage::app()->getRequest()->getParam('email', 4);
	$password = Mage::app()->getRequest()->getParam('password', 4);
    # -- End $_GET params --------------------------
    print_r(json_encode(register($firstName, $lastName, $email, $password)));
}


//
function getCustomerModel(){
    // Gather the website and store preferences.
    $websiteId = Mage::app()->getWebsite()->getId();
    $store     = Mage::app()->getStore();
    // Update the customer model to reflect the current user.
    $customer = Mage::getModel('customer/customer');
    $customer->website_id = $websiteId;
    $customer->setStore($store);
    return $customer;
}

//
function getAccount(){
    $isLoggedIn = Mage::getSingleton('customer/session')->isLoggedIn();
    if (!$isLoggedIn) {
        // User isn't logged in.
        return array('loggedIn' => false, 'model' => array());
    }
    // Gather the user data, and MD5 the email address for use with Gravatar.
    $datum = Mage::helper('customer')->getCustomer()->getData();
    $datum['gravatar'] = md5($datum['email']);
    // Otherwise the user is logged in. Voila!
    return array('success' => true, 'model' => $datum);
}




/**
 * @method login
 * @param string $email
 * @param string $password
 * @return array
 */

function getLogin($email, $password){
	$json = array('success' => true, 'error' => null, 'model' => array());
	Mage::getSingleton("core/session", array("name" => "frontend"));
	$customer = getCustomerModel();
    $customer->loadByEmail($email);

	try {
		// Attempt the login procedure.
        $session = Mage::getSingleton('customer/session');
        $session->login($email, $password);
        $session->setCustomerAsLoggedIn($session->getCustomer());
        $account = getAccount();
        $json['model'] = $account['model'];
	} catch(Exception $e){

		$json['success'] = false;
		
		switch($e->getMessage()){
			case 'Invalid login or password.':
        		$json['error'] = 'credentials';
        		break;
        	default:
        		$json['error'] = 'unknown';
        		break;
		}
	}
	return $json;
}



/**
 * @method logout
 * @return array
 */
function logout(){
    Mage::getSingleton('customer/session')->logout();
    $account = getAccount();
    return array('success' => true, 'error' => null, 'model' => $account['model']);
}


/**
 * @method register
 * @param string $firstName
 * @param string $lastName
 * @param string $email
 * @param string $password
 * @return array
 */
function register($firstName, $lastName, $email, $password){
    $json = array('success' => true, 'error' => null, 'model' => array());
    $customer = getCustomerModel();
    try {
        // If new, save customer information
        $customer->firstname     = $firstName;
        $customer->lastname      = $lastName;
        $customer->email         = $email;
        $customer->password_hash = md5($password);
        $customer->save();
        // Log in the newly created user.
        getLogin($email, $password);
        $account = getAccount();
        $json['model'] = $account['model'];
    } catch (Exception $e) {
        $json['success'] = false;
        switch ($e->getMessage()) {
            case 'Customer email is required':
                $json['error'] = 'email';
                break;
            case 'This customer email already exists':
                $json['error'] = 'exists';
                break;
            default:
                $json['error'] = 'unknown';
                break;
        }
    }
    return $json;
}
