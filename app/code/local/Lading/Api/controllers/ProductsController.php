<?php

/**
 * Class Lading_Api_ProductsController
 */
class Lading_Api_ProductsController extends Mage_Core_Controller_Front_Action {


    /**
     * 获取商品自定义属性
     */
    public function getCustomOptionAction() {
        $baseCurrency = Mage::app ()->getStore ()->getBaseCurrency ()->getCode ();
        $currentCurrency = Mage::app ()->getStore ()->getCurrentCurrencyCode ();
        $product_id = $this->getRequest ()->getParam ( 'product_id' );
        $product = Mage::getModel ( "catalog/product" )->load ( $product_id );
        $selectid = 1;
        $select = array ();
        foreach ( $product->getOptions () as $o ) {
            if (($o->getType () == "field") || ($o->getType () =="file")) {
                $select [$selectid] = array (
                    'option_id' => $o->getId (),
                    'custom_option_type' => $o->getType (),
                    'custom_option_title' => $o->getTitle (),
                    'is_require' => $o->getIsRequire (),
                    'price' => number_format ( Mage::helper ( 'directory' )->currencyConvert ( $o->getPrice (), $baseCurrency, $currentCurrency ), 2, '.', '' ),
                    'price_type'=>$o->getPriceType(),
                    'sku'=>$o->getSku(),
                    'max_characters' => $o->getMaxCharacters (),
                );
            } else {
                $max_characters = $o->getMaxCharacters ();
                $optionid = 1;
                $options = array ();
                $values = $o->getValues ();
                foreach ( $values as $v ) {
                    $options [$optionid] = $v->getData ();
                    $optionid ++;
                }
                $select [$selectid] = array (
                    'option_id' => $o->getId (),
                    'custom_option_type' => $o->getType (),
                    'custom_option_title' => $o->getTitle (),
                    'is_require' => $o->getIsRequire (),
                    'price' => number_format ( Mage::helper ( 'directory' )->currencyConvert ( $o->getFormatedPrice (), $baseCurrency, $currentCurrency ), 2, '.', '' ),
                    'max_characters' => $max_characters,
                    'custom_option_value' => $options
                );
            }
            $selectid ++;
        }
        echo json_encode ( array('code'=>0, 'msg'=>null, 'model'=>$select) );
    }




    /**
     * 获取商品详情
     */
    public function getProductDetailAction() {
        $baseCurrency = Mage::app ()->getStore ()->getBaseCurrency ()->getCode ();
        $currentCurrency = Mage::app ()->getStore ()->getCurrentCurrencyCode ();
        $product_id = $this->getRequest ()->getParam ( 'product_id' );
        $products_model = Mage::getModel('mobile/products');
        $product = Mage::getModel ( "catalog/product" )->load ( $product_id );
        $store_id = Mage::app()->getStore()->getId();
        $product_detail = array();
        $options = array();
        $price = array();
        $product_type = $product->getTypeId();
        switch($product_type){
            case Mage_Catalog_Model_Product_Type::TYPE_CONFIGURABLE: {
                $product_detail['attribute_options'] = $products_model->getProductOptions($product);
                $price = Mage::getModel('mobile/currency')->getCurrencyPrice(($product->getSpecialPrice()) == null ? ($product->getPrice()) : ($product->getSpecialPrice()));
                $price = number_format($price, 2, '.', '' );
            }break;
            case Mage_Catalog_Model_Product_Type::TYPE_SIMPLE: {
                $product_detail['custom_options'] = $products_model->getProductCustomOptionsOption($product);
                $product_detail['stock_level'] = (int)Mage::getModel('cataloginventory/stock_item')->loadByProduct($product)->getQty();
                $price = $price = Mage::getModel('mobile/currency')->getCurrencyPrice(($product->getSpecialPrice()) == null ? ($product->getPrice()) : ($product->getSpecialPrice()));
                $price = number_format($price, 2, '.', '' );
            }break;
            case Mage_Catalog_Model_Product_Type::TYPE_BUNDLE: {
                $price = $products_model->collectBundleProductPrices($product);
                $product_detail['bundle_option']  =  $products_model->getProductBundleOptions($product);
            }break;
            case Mage_Catalog_Model_Product_Type::TYPE_GROUPED: {
                $product_detail['grouped_option']  =  $products_model->getProductGroupedOptions($product);
            }break;
            case Mage_Catalog_Model_Product_Type::TYPE_VIRTUAL:  {
                $price = $price = Mage::getModel('mobile/currency')->getCurrencyPrice(($product->getSpecialPrice()) == null ? ($product->getPrice()) : ($product->getSpecialPrice()));
                $price = number_format($price, 2, '.', '' );
            }break;
            default: {
                $price = $price = Mage::getModel('mobile/currency')->getCurrencyPrice(($product->getSpecialPrice()) == null ? ($product->getPrice()) : ($product->getSpecialPrice()));
                $price = number_format($price, 2, '.', '' );
            } break;
        }
        $product_detail['price'] = $price;
        $mediaGallery = array();
        foreach($product->getMediaGalleryImages()->getItems() as $image){
            $mediaGallery[] = $image['url'];
        }
        if(count($mediaGallery)<=0){
            array_push($mediaGallery,Mage::getModel('catalog/product_media_config')->getMediaUrl( $product->getImage()));
        };
        $product_detail['in_wishlist'] = false;
        if (Mage::getSingleton('customer/session')->isLoggedIn()) {
            $customer_id =  Mage::getSingleton ( 'customer/session' )->getCustomer ()->getId();
            $item_collection = Mage::getModel('wishlist/item')->getCollection()->addCustomerIdFilter($customer_id);
            foreach($item_collection as $item) {
                if($item->getProductId()==$product->getId ()){
                    $product_detail['in_wishlist'] = true;
                }
            }
        }
        $summaryData = Mage::getModel('review/review_summary')->setStoreId($store_id)  ->load($product->getId());
        $product_detail['entity_id'] = $product->getId ();
        $product_detail['rating_summary'] = $summaryData->getRatingSummary();
        $product_detail['reviews_count'] = $summaryData->getReviewsCount();
        $product_detail['sku'] = $product->getSku ();
        $product_detail['status'] = $product->getStatus();
        $product_detail['name'] = $product->getName ();
        $product_detail['news_from_date'] = $product->getNewsFromDate ();
        $product_detail['news_to_date'] = $product->getNewsToDate ();
        $product_detail['product_type'] = $product->getTypeID();
        $product_detail['special_from_date'] = $product->getSpecialFromDate ();
        $product_detail['special_to_date'] = $product->getSpecialToDate ();
        $product_detail['image_url'] = $product->getImageUrl ();
        $product_detail['url_key'] = $product->getProductUrl ();
        $product_detail['regular_price_with_tax'] = number_format(Mage::helper('directory')->currencyConvert($product->getPrice(), $baseCurrency, $currentCurrency), 2, '.', '' );
        $product_detail['final_price_with_tax'] = number_format ( Mage::helper ( 'directory' )->currencyConvert ( $product->getSpecialPrice (), $baseCurrency, $currentCurrency ), 2, '.', '' );
//			'description' => nl2br ( $product->getDescription()),
        $product_detail['short_description'] = $product->getShortDescription();
        $product_detail['symbol'] = Mage::app ()->getLocale ()->currency ( Mage::app ()->getStore ()->getCurrentCurrencyCode () )->getSymbol ();
        $product_detail['options'] = $options;
        $product_detail['mediaGallery'] = $mediaGallery;

        echo json_encode(array('code'=>0, 'msg'=>null, 'model'=>$product_detail));
    }



} 