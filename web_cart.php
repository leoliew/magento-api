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

}elseif(Mage::app()->getRequest()->getParam('route') == "rest/web_api/addCartItem"){

	# -- $_GET params ------------------------------
    $productId = Mage::app()->getRequest()->getParam('id', 555);
	$quantity = Mage::app()->getRequest()->getParam('quantity', 4);
    # -- End $_GET params --------------------------
    print_r(json_encode(addCartItem($productId, $quantity)));
}elseif(Mage::app()->getRequest()->getParam('route') == "rest/web_api/getCartItems"){

	# -- $_GET params ------------------------------

    # -- End $_GET params --------------------------
    print_r(json_encode(getCartItems()));
}


/**
 * @method frontEndSession
 * @return void
 */
function frontEndSession(){
    Mage::getSingleton('core/session', array('name' => 'frontend'));
}



/**
 * @method addCartItem
 * @param int $productId
 * @param int $quantity
 * @return array
 */
function addCartItem($productId, $quantity){
    $json = array('success' => true, 'error' => null, 'models' => array());
    try {
        frontEndSession();
        $product = Mage::getModel('catalog/product')->load((int) $productId);
        $basket = Mage::getSingleton('checkout/cart');
        $basket->addProduct($product, $quantity ?: 1);
        $basket->save();
        // Fetch the items from the user's basket.
        $json['models'] = getCartItems();
    } catch (Exception $e) {
        $json['success'] = false;
        switch ($e->getMessage()) {
            case 'This product is currently out of stock.':
                $json['error'] = 'stock';
                break;
            default:
                $json['error'] = $e->getMessage();
                break;
        }
    }
    return $json;
}


/**
 * @method getCartItems
 * @return array
 */
function getCartItems(){
    frontEndSession();
    $session    = Mage::getSingleton('checkout/session');
    $quote      = $session->getQuote();
    $items      = $quote->getAllItems();
    $data       = array();
    // Calculate all of the totals.
    $totals     = $quote->getTotals();
    $subTotal   = $totals['subtotal']->getValue();
    $grandTotal = $totals['grand_total']->getValue();
    foreach ($items as $item) {
        if ($item->getProduct()->getTypeId() === 'simple') {
            $parentIds = Mage::getResourceSingleton('catalog/product_type_configurable')
                             ->getParentIdsByChild($item->getProduct()->getEntityId());
            $parentId = (int) $parentIds[0];
        }
        $data[] = array(
            'id'        => (int) $item->getProduct()->getEntityId(),
            'parentId'  => $parentId ?: null,
            'itemId'    => (int) $item->getItemId(),
            'quantity'  => (int) $item->getQty(),
            'name'      => $item->getProduct()->getName(),
            'price'     => $item->getPrice()
        );
    }
    return array('subTotal' => $subTotal, 'grandTotal' => $grandTotal, 'items' => $data);
}