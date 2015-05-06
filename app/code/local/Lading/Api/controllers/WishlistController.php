<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 5/6/15
 * Time: 12:38 PM
 */

class Lading_Api_WishlistController extends Mage_Core_Controller_Front_Action {

    public function getAction() {
        echo "hello world";
    }


    public function addAction() {
        try {
            $product_id = $this->getRequest ()->getParam ( 'product' );
            $params = $this->getRequest ()->getParams ();
            if (isset ( $params ['qty'] )) {
                $filter = new Zend_Filter_LocalizedToNormalized ( array (
                    'locale' => Mage::app ()->getLocale ()->getLocaleCode ()
                ) );
                $params ['qty'] = $filter->filter ( $params ['qty'] );
            } else
                // $params ['qty'] = 1; // 调试直接设为1
                // $param=$this->getRequest ()->getParam ( 'param' );
                // $qty = $this->getRequest ()->getParam ( 'qty' );
                if ($product_id == '') {
                    $session->addError ( "Product Not Added
					The SKU you entered ($sku) was not found." );
                }
            $request = Mage::app ()->getRequest ();
            $product = Mage::getModel ( 'catalog/product' )->load ( $product_id );
            $session = Mage::getSingleton ( 'core/session', array (
                'name' => 'frontend'
            ) );
            $cart = Mage::helper ( 'checkout/cart' )->getCart ();
            // $cart->addProduct ( $product, $qty );
            $cart->addProduct ( $product, $params );
            $session->setLastAddedProductId ( $product->getId () );
            $session->setCartWasUpdated ( true );
            $cart->save ();
            $items_qty = floor ( Mage::getModel ( 'checkout/cart' )->getQuote ()->getItemsQty () );
            $result = '{"result":"success"';
            $result .= ', "items_qty": "' . $items_qty . '"}';
            echo $result;
        } catch ( Exception $e ) {
            $result = '{"result":"error"';
            $result .= ', "message": "' . $e->getMessage () . '"}';
            echo $result;
        }
    }


    public function delAction() {
        $cart = Mage::getSingleton ( 'checkout/cart' );
        if (!Mage::getSingleton('checkout/type_onepage')->getQuote()->hasItems()) {
            $this->errors[] = 'Cart is empty!';
            return $this->errors;
        }
        if (!$cart->getQuote()->validateMinimumAmount()) {
            $warning = Mage::getStoreConfig('sales/minimum_order/description');
            $this->errors[] = $warning;
        }

        if (($messages = $cart->getQuote()->getErrors())) {
            foreach ($messages as $message) {
                if ($message) {
                    $this->errors[] = $message->getText();
                }
            }
        }

        return $this->errors;
    }




}
