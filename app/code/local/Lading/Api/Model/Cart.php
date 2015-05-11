<?php
/**
 * Created by PhpStorm.
 * User: Leo
 * Date: 15/6/4
 * Time: 下午11:40
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 47605a6... add checkout flow address
=======
>>>>>>> 10cea00... # This is a combination of 11 commits.
=======
=======
>>>>>>> 47605a6... add checkout flow address
>>>>>>> 007a8c2... temp
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


<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 10cea00... # This is a combination of 11 commits.
=======
>>>>>>> 007a8c2... temp
}
=======
 */
>>>>>>> 90ff47e... add magento model
<<<<<<< HEAD
<<<<<<< HEAD
=======
}
>>>>>>> 47605a6... add checkout flow address
=======
>>>>>>> 10cea00... # This is a combination of 11 commits.
=======
=======
}
>>>>>>> 47605a6... add checkout flow address
>>>>>>> 007a8c2... temp
