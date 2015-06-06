<?php
/**
 * Created by PhpStorm.
 * User: Leo
 * Date: 15/6/4
 * Time: 下午11:40
 */


class Lading_Api_Model_Cart extends Lading_Api_Model_Abstract {

    /**
     * 获取账单
     * @return mixed
     */
    public function getProductBundleOptions($item) {
        $bundle_option = array();
        $options = $item->getProduct()->getTypeInstance(true)->getOrderOptions($item->getProduct());
        foreach ( $options['bundle_options'] as $option ) {
            $temp_options = array();
            $temp_options['label'] = $option['label'];
            foreach ($option['value'] as $sub){
                $temp_options['value'] =  $sub['qty'] . " x " . $sub['title'] . " " . $sub['price'];
            }
            array_push($bundle_option,$temp_options);
        }
        return $bundle_option;
    }


    /**
     * @param $item
     * @return array
     */
    public function getCustomOptions($item){
        $options=$item->getProduct()->getTypeInstance(true)->getOrderOptions($item->getProduct());
        $result=array();
        if($options){
            if(isset($options['options'])){
                $result=array_merge($result,$options['options']);
            }
            if(isset($options['additional_options'])){
                $result=$result=array_merge($result,$options['additional_options']);
            }
            if(!empty($options['attributes_info'])){
                $result=$result=array_merge($result,$options['attributes_info']);
            }
        }
        return $result;
    }


}