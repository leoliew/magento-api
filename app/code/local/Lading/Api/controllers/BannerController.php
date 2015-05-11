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
            foreach ($banner_items as $banner_item) {
                $bannerList [] = array(
                    'banner_item_id' => $banner_item->getbannerItemId(),
                    'title' => $banner_item->getTitle(),
                    'image' => $banner_item->getImage(),
                    'image_url' => $banner_item->getImageUrl(),
                    'thumb_image' => $banner_item->getThumbImage(),
                    'thumb_image_url'=> $banner_item->getThumbImageUrl(),
                    'content' => $banner_item->getContent(),
                    'price' => $banner_item->getPrice(),
                    'link_url' => $banner_item->getLinkUrl(),
                );
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
}
