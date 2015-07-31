<?php
/**
 * Created by PhpStorm.
 * User: Leo
 * Date: 15/6/4
 * Time: 下午11:04
 */

class Lading_Api_Model_Products extends Lading_Api_Model_Abstract {



    /**
     * Returns product information for child SKUs of product (colors, sizes, etc).
     * @method getProductVariations
     * @param int $productId
     * @return array
     */
    public function getProductVariations($productId){
        $product = Mage::getModel('catalog/product')->load((int) $productId);
        $children = Mage::getModel('catalog/product_type_configurable')->getUsedProducts(null, $product);
        $attributes = $product->getTypeInstance(true)->getConfigurableAttributesAsArray($product);
        $products = array('label' => array(), 'collection' => array());
        $collection = array();
        foreach ($children as $child) {
            foreach ($attributes as $attribute) {
                $products['label'][$attribute['store_label']] = $attribute['attribute_id'];
                foreach ($attribute['values'] as $value) {
                    $childValue = $child->getData($attribute['attribute_code']);
                    $child_product = Mage::getModel('catalog/product')->load($child->getId());
                    $stock_level = (int)Mage::getModel('cataloginventory/stock_item')->loadByProduct($child_product)->getQty();
                    if ($value['value_index'] == $childValue && $stock_level>0) {
//                        $products['collection'][] = array(
//                            'id'    => (int) $child->getId(),
//                            'labels' => $value['store_label'],
//                            'index_key' => $value['value_index']
//                        );
                        $temp_collection = array();
                        foreach($collection as $key=>$exist_collection) {
                            if ((int) $child->getId() == $exist_collection['id']){
                                $temp_collection['id'] = (int) $child->getId();
                                array_push($exist_collection['labels'],$value['store_label']);
                                $temp_collection['labels'] = $exist_collection['labels'];
                                array_push($exist_collection['index_key'],$value['value_index']);
                                $temp_collection['index_key'] = $exist_collection['index_key'];

                                $temp_image_url = Mage::getModel('catalog/product')->load((int) $temp_collection['id'])->getImageUrl ();  //add by wayne
                                $temp_collection['child_image_url'] = $temp_image_url;                                                    //add by wayne
                                unset($collection[$key]);
                                break;
                            }
                        }
                        if(empty($temp_collection)){
                            $temp_collection['id'] = (int) $child->getId();
                            $temp_collection['labels'] =  array($value['store_label']);
                            $temp_collection['index_key'] = array($value['value_index']);
                        }
                        array_push($collection,$temp_collection);
                    }
                }
            }
        }
        $exists_list = array();
        $image_list = array();          //add by wayne
        foreach($collection as $after_collection){
            $temp_item = array();
            $temp_image_item = $after_collection['index_key'];   //add by wayne
            array_push($temp_image_item,$after_collection['child_image_url']);  //add by wayne
            foreach($after_collection['index_key'] as $index_key){
                array_push($temp_item,$index_key);
                sort($temp_item);
            }
            array_push($image_list,$temp_image_item);    //add by wayne
            array_push($exists_list,$temp_item);
        }
        $products['collection'] = $exists_list;
        $products['child_image_url'] = $image_list;      //add by wayne
        return $products;
    }


    /**
     * get bundle product prices
     * @param $product
     * @return array
     */


    public function collectBundleProductPrices($product) {
        $selectionCollection = $product->getTypeInstance(true)->getSelectionsCollection(
            $product->getTypeInstance(true)->getOptionsIds($product), $product
        );
        $bundled_prices = array();
        foreach($selectionCollection as $option) {
            $child_product = Mage::getModel('catalog/product')->load($option->getProductId());
            $stock_level = (int)Mage::getModel('cataloginventory/stock_item')->loadByProduct($child_product)->getQty();
            if($stock_level>0){
                array_push($bundled_prices,Mage::getModel('mobile/currency')->getCurrencyPrice($option->getPrice()));
            }
        }

        return $this->getSortPrice($bundled_prices);
    }


    /**
     * get configurable product options
     * @param $product
     * @return array
     */
    public function getProductOptions($product) {
        $options   = $this->getProductVariations($product->getId());
        $options['labels_key'] = $this->getProductLabelsKey($product);
        $productAttributeOptions = $product->getTypeInstance(true)->getConfigurableAttributesAsArray($product);
        $attributeOptions = array();
        foreach ($productAttributeOptions as $productAttribute) {
            foreach($productAttribute['values'] as $attribute) {
                $attributeOptions[$productAttribute['label']][$attribute['value_index']] = $attribute['store_label'];
            };
        };
        return $options;
    }


    /**
     * get bundle product options
     * @param $product
     * @return array
     */
    public function getProductBundleOptions($product) {
        $bundle_option = array();
        $optionCollection = $product->getTypeInstance()->getOptionsCollection();
        $selectionCollection = $product->getTypeInstance()->getSelectionsCollection($product->getTypeInstance()->getOptionsIds());
        $options = $optionCollection->appendSelections($selectionCollection);
        foreach( $options as $option )
        {
            $temp_options = array();
            $temp_options['default_title'] = $option->getDefaultTitle();
            $temp_options['option_id'] = $option->getOptionId();
            $temp_options['required'] = $option->getRequired();
            $temp_options['type'] = $option->getType();
            $_selections = $option->getSelections();
            foreach( $_selections as $selection )
            {
                $temp_options['name'] = $selection->getName();
                $temp_options['selection_id'] = $selection->getSelectionId();
                $temp_options['option_id'] = $selection->getOptionId();
                $temp_options['parent_product_id'] = $selection->getParentProductId();
                $temp_options['product_id'] = $selection->getProductId();
                $temp_options['position'] = $selection->getPosition();
                $temp_options['is_default'] = $selection->getIsDefault();
                $temp_options['short_description'] = $selection->getShortDescription();
                $temp_options['price'] = $selection->getPrice();
                $child_product = Mage::getModel('catalog/product')->load($selection->getProductId());
                $stock_level = (int)Mage::getModel('cataloginventory/stock_item')->loadByProduct($child_product)->getQty();
                if($stock_level>0){
                    array_push($bundle_option,$temp_options);
                }

            }
        }
        return $bundle_option;
    }




    /**
     * get grouped products options
     * @param $product
     * @return array
     */
    public function getProductGroupedOptions($product) {
        if (!$product->getId()) {
            return array();
        }
        if (!$product->isSaleable()) {
            return array();
        }
        /**
         * Grouped (associated) products
         */
        $_associatedProducts = $product->getTypeInstance(true)->getAssociatedProducts($product);
        if (!sizeof($_associatedProducts)) {
            return array();
        }
        $grouped_option = array();
        foreach ($_associatedProducts as $_item) {
//            if (!$_item->isSaleable()) {
//                continue;
//            }
            $sku = array();
            $sku['sku_id'] = $_item->getId();
            $sku['sku'] = $_item->getSku();
            $sku['is_in_stock'] = $_item->isSaleable();
            $sku['mode'] = 'product';
            $sku['name'] = strip_tags($_item->getName());
            $sku['qty'] = $_item->getQty() * 1;
            $sku['is_editable'] = 1;
            /**
             * Process product price
             */
            if ($_item->getPrice() != $_item->getFinalPrice()) {
                $productPrice = $_item->getFinalPrice();
            } else {
                $productPrice = $_item->getPrice();
            }
            if ($productPrice > 0.00) {
                $sku['price'] = $productPrice;
            }
            $sku['values'] = array();
            array_push($grouped_option, $sku);
        }
        return $grouped_option;
    }


    /**
     * @param Mage_Catalog_Model_Product $product
     * @return array
     */
    public function getProductLabelsKey(Mage_Catalog_Model_Product $product) {
        $productAttributeOptions = $product->getTypeInstance(true)->getConfigurableAttributesAsArray($product);
        $attributeOptions = array();
        foreach ($productAttributeOptions as $productAttribute) {
            foreach ($productAttribute['values'] as $attribute) {
                $attributeOptions[$productAttribute['label']][$attribute['value_index']] = $attribute['store_label'];
            }
        }
        return $attributeOptions;
    }


    /**
     * price sort to get min and max price
     * @param $sort_price
     * @return mixed
     */
    protected function getSortPrice($sort_price){
        sort($sort_price);
        $minimum_price=$sort_price[0];
        $maximum_price_tmp=array_slice($sort_price, -1, 1, false);
        $maximum_price=$maximum_price_tmp[0];
        $price['min'] = number_format($minimum_price, 2, '.', '' );
        $price['max'] = number_format($maximum_price, 2, '.', '' );
        return $price;
    }

    /**
     * get additional information Visible on Product View Page on Front-end
     * @param $product
     * @return array
     * add by wayne
     */
    public function getAdditionalFront($t_product)
    {
        $data = array();
        $product = $t_product;
        $attributes = $product->getAttributes();
        foreach ($attributes as $attribute) {
            if ($attribute->getIsVisibleOnFront()) {
                $value = $attribute->getFrontend()->getValue($product);

                if (!$product->hasData($attribute->getAttributeCode())) {
                    $value = Mage::helper('catalog')->__('N/A');
                } elseif ((string)$value == '') {
                    $value = Mage::helper('catalog')->__('No');
                } elseif ($attribute->getFrontendInput() == 'price' && is_string($value)) {
                    $value = Mage::app()->getStore()->convertPrice($value, true);
                }

                if (is_string($value) && strlen($value)) {
                    $data[] = array(
                        $attribute->getStoreLabel(),
                        $value
                    );
                }
            }
        }
        return $data;
    }
    /********************end add************************************************/

}