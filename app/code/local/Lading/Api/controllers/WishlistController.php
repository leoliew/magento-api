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
                $wishlist_id = $item-> getId();
                $product = $item->getProduct();
                $productid = $product->getId();
                $product = Mage::getModel ("catalog/product")->load ($productid);
                $arrProductIds [] = array (
                    'wishlist_id' => $wishlist_id,
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
        $customer = Mage::getModel('customer/customer');
        $wishlist = Mage::getModel('wishlist/wishlist');
        $product  = Mage::getModel('catalog/product');
        $product_id  = $_GET['product_id'];
        $customer->load($customer_id);
        $wishlist->loadByCustomer($customer_id);
        if($customer_id && $product_id){
            $res = $wishlist->addNewItem($product->load($product_id));
            if($res){
                $code = 0;
                $msg = "your product has been added in wishlist";
            }
            $result = array(
                'code' => $code,
                'msg' => $msg,
                'model' => $res
            );
            echo json_encode($result);
        }else{
            $result = array(
                'code' => 1,
                'msg' => 'can not get customer info or product id',
                'model' => null
            );
            echo json_encode($result);
        }
    }


//    public function delAction(){
//        $product_id = (int)$this->getRequest()->getParam('$product_id');
//        $item = Mage::getModel('wishlist/item')->load($product_id);
//        $result = array(
//            'code' => 1,
//            'msg' => 'delete success!',
//            'model' => null
//        );
//        if (!$item->getId()) {
//            $result['code'] = 1;
//            $result['msg'] = 'delete fail!';
//        }
//        $wishlist = $this->_getWishlist($item->getWishlistId());
//        if (!$wishlist) {
//            $result['code'] = 1;
//            $result['msg'] = 'delete fail!';
//        }
//        try {
//            $item->delete();
//            $wishlist->save();
//        } catch (Mage_Core_Exception $e) {
//            Mage::getSingleton('customer/session')->addError(
//                $this->__('An error occurred while deleting the item from wishlist: %s', $e->getMessage())
//            );
//        } catch (Exception $e) {
//            Mage::getSingleton('customer/session')->addError(
//                $this->__('An error occurred while deleting the item from wishlist.')
//            );
//        }
//        Mage::helper('wishlist')->calculate();
//        echo json_encode($result);
//    }


}
