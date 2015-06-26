<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 6/24/15
 * Time: 1:56 PM
 */

class Lading_Api_Model_Menu extends Lading_Api_Model_Abstract {


    public function _hasProducts($category_id) {
        $products = Mage::getModel('catalog/category')->load($category_id)
            ->getProductCollection()
            ->addAttributeToSelect('entity_id')
            ->addAttributeToFilter('status', 1)
            ->addAttributeToFilter('visibility', 4);
        return ( $products->count() > 0 )  ? true : false;
    }

}