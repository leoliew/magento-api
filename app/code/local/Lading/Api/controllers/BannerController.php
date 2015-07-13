<?php
class Lading_Api_BannerController extends Mage_Core_Controller_Front_Action {
    /**
     * get website info
     */
    public function getBannerAction() {
        $identifier  = Mage::app ()->getRequest ()->getParam('identifier');
        $model  = Mage::getModel('easybanner/banner')->load($identifier,'identifier');
        if ($model->getId()) {
            $banner_items = Mage::getModel('easybanner/banneritem')->getCollection()
                ->addFieldToFilter('status', true)
                ->addFieldToFilter('banner_id', $model->getBannerId())
                ->setOrder('banner_order','ASC');
            $bannerList = array();
            foreach ($banner_items as $banner_item) {
                $type = 0;
                if($banner_item->getLinkUrl()){
                    $type = 1;
                }
                if($banner_item->getContent() && strlen($banner_item->getContent()>0)){
                    $type = 2;
                }
                if($banner_item->getContent() && strrpos($banner_item->getContent(),',')){
                    $type = 3;
                }
                $temp_banner = array(
                    'banner_item_id' => $banner_item->getbannerItemId(),
                    'title' => $banner_item->getTitle(),
                    'image' => $banner_item->getImage(),
//                    'image_url' => $banner_item->getImageUrl(),
//                    'thumb_image' => $banner_item->getThumbImage(),
//                    'thumb_image_url'=> $banner_item->getThumbImageUrl(),
                    'content' => $banner_item->getContent(),
                    'link_url' => $banner_item->getLinkUrl(),
                    'type' => $type
                );
                if($type == 2){
                    $product = Mage::getModel ( "catalog/product" )->load ($banner_item->getContent());
                    $price = $price = Mage::getModel('mobile/currency')->getCurrencyPrice(($product->getSpecialPrice()) == null ? ($product->getPrice()) : ($product->getSpecialPrice()));
                    $temp_banner['price'] = number_format($price, 2, '.', '' );
                }
                array_push($bannerList,$temp_banner);
            }
            echo json_encode(array(
                'code'=>0,
                'msg'=>'get banners success!',
                'model'=>array(
                    'title'=> $model->getTitle(),
                    'content'=> $model->getContent(),
                    'width' => $model->getWidth(),
                    'height' => $model->getHeight(),
                    'delay'=> $model->getDelay(),
                    'status'=> $model->getStatus(),
                    'active_from'=> $model->getActiveFrom(),
                    'active_to' => $model->getActiveTo(),
                    'create_time'=> $model->getCreatedTime(),
                    'symbol'=> Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol(),
                    'banner_items'=> $bannerList
                )
            ));
        }else{
            echo json_encode ( array (
                'code'=>1,
                'msg'=>'please send banner id!',
                'model'=>array ()
            ));
        }
    }


    /**
     * get item by banner
     */
    public function getItemByBannerAction() {
        $baseCurrency = Mage::app ()->getStore ()->getBaseCurrency ()->getCode ();
        $currentCurrency = Mage::app ()->getStore ()->getCurrentCurrencyCode ();
        $store_id = Mage::app()->getStore()->getId();
        $return_result = array(
            'code' => 0,
            'msg' => 'get products success!',
            'model' => null
        );
        $banner_id  = Mage::app ()->getRequest ()->getParam('banner_id');
        $model  = Mage::getModel('easybanner/banneritem')->load($banner_id,'banner_item_id');
        if ($model->getId()) {
            $content = $model->getContent();
            $product_list =  explode(',', $content);
            $return_products = array();
            $products = Mage::getModel('catalog/product')->getCollection()->addAttributeToFilter('entity_id', array('in' => $product_list));
            $products->getSelect()->order("find_in_set(entity_id,'".implode(',',$product_list)."')");
            foreach($products as $product) {
                $product = Mage::getModel ( 'catalog/product' )->load ( $product ['entity_id'] );
                $summaryData = Mage::getModel('review/review_summary')->setStoreId($store_id)  ->load($product->getId());
                $price = ($product->getSpecialPrice()) == null ? ($product->getPrice()) : ($product->getSpecialPrice());
                $regular_price_with_tax = number_format ( Mage::helper ( 'directory' )->currencyConvert ( $product->getPrice (), $baseCurrency, $currentCurrency ), 2, '.', '' );
                $final_price_with_tax = number_format ( Mage::helper ( 'directory' )->currencyConvert ( $product->getSpecialPrice (), $baseCurrency, $currentCurrency ), 2, '.', '' );
                $temp_product = array(
                    'entity_id' => $product->getId (),
                    'sku' => $product->getSku (),
                    'name' => $product->getName (),
                    'rating_summary' => $summaryData->getRatingSummary(),
                    'reviews_count' => $summaryData->getReviewsCount(),
                    'news_from_date' => $product->getNewsFromDate (),
                    'news_to_date' => $product->getNewsToDate (),
                    'special_from_date' => $product->getSpecialFromDate (),
                    'special_to_date' => $product->getSpecialToDate (),
                    'image_url' => $product->getImageUrl (),
                    'url_key' => $product->getProductUrl (),
                    'price' => number_format(Mage::getModel('mobile/currency')->getCurrencyPrice($price),2,'.',''),
                    'regular_price_with_tax' =>  number_format(Mage::getModel('mobile/currency')->getCurrencyPrice($regular_price_with_tax),2,'.',''),
                    'final_price_with_tax' =>  number_format(Mage::getModel('mobile/currency')->getCurrencyPrice($final_price_with_tax),2,'.',''),
                    'symbol'=> Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol()
                );
                array_push($return_products,$temp_product);
            }
            $return_result['model'] = $return_products;
        }else{
            $return_result['code'] = 1;
            $return_result['msg'] = 'could not find this banner!';
        }
        echo json_encode($return_result);
    }

}
