<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 5/6/15
 * Time: 12:38 PM
 */

class Lading_Api_WishlistController extends Mage_Core_Controller_Front_Action {
    public function getAction() {
        $customer = Mage::getSingleton('customer/session')->getCustomer();
        $wishList = Mage::getSingleton('wishlist/wishlist')->loadByCustomer($customer);
        $baseCurrency = Mage::app ()->getStore ()->getBaseCurrency ()->getCode ();
        $currentCurrency = Mage::app ()->getStore ()->getCurrentCurrencyCode ();
        $wishListItemCollection = $wishList->getItemCollection();
        if (count($wishListItemCollection)) {
            $arrProductIds = array();
            foreach ($wishListItemCollection as $item) {
                $product = $item->getProduct();
                $productid = $product->getId ();
                $product = Mage::getModel ("catalog/product")->load ($productid);
                $arrProductIds [] = array (
                    'entity_id' => $product->getId (),
                    'sku' => $product->getSku (),
                    'name' => $product->getName (),
                    'news_from_date' => $product->getNewsFromDate (),
                    'news_to_date' => $product->getNewsToDate (),
                    'special_from_date' => $product->getSpecialFromDate (),
                    'special_to_date' => $product->getSpecialToDate (),
                    'image_url' => $product->getImageUrl (),
                    'url_key' => $product->getProductUrl (),
                    'regular_price_with_tax' => number_format ( Mage::helper ( 'directory' )->currencyConvert ( $product->getPrice (), $baseCurrency, $currentCurrency ), 2, '.', '' ),
                    'final_price_with_tax' => number_format ( Mage::helper ( 'directory' )->currencyConvert ( $product->getSpecialPrice (), $baseCurrency, $currentCurrency ), 2, '.', '' ),
                    'symbol'=> Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol()
                );
            }
        };
        $customerinfo = array (
            'code' => 0,
            'msg' => "get " .count($arrProductIds). " items success!",
            'model' => array(
                'products' => $arrProductIds,
                'count' => count($arrProductIds)
            )
        );
        echo json_encode($customerinfo);
    }


    public function addAction() {
        $customer_id = Mage::getSingleton('customer/session')->getId();
        $product_id  = $_GET['product_id'];

        echo $customer_id;
        echo $product_id;

//        $wishlist = Mage::getModel('wishlist/item')->load($_product->getId(),'product_id');
//        if($wishlist->getId())
//            //product is added
//            echo "Added! - Product is in the wishlist!";
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
