<?php

/**
 * Class Lading_Api_ProductsController
 */
class Lading_Api_ProductsController extends Mage_Core_Controller_Front_Action {

	public function getcustomoptionAction() {

		$baseCurrency = Mage::app ()->getStore ()->getBaseCurrency ()->getCode ();

		$currentCurrency = Mage::app ()->getStore ()->getCurrentCurrencyCode ();

		$productid = $this->getRequest ()->getParam ( 'productid' );

		$product = Mage::getModel ( "catalog/product" )->load ( $productid );

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

			// echo "----------------------------------<br/>";

		}

		echo json_encode ( array('code'=>0, 'msg'=>null, 'model'=>$select) );

	}

	public function array_flatten($array){
	   while (($v = array_shift($array)) !== null) {
	       if (is_array($v)) {
	           $array = array_merge($v, $array);
	       } else {
	           $tmp[] = $v;
	       }
	   }
	   
	   return $tmp;
	}

	public function getproductdetailAction() {

		$productdetail = array ();

		$baseCurrency = Mage::app ()->getStore ()->getBaseCurrency ()->getCode ();

		$currentCurrency = Mage::app ()->getStore ()->getCurrentCurrencyCode ();

		$productid = $this->getRequest ()->getParam ( 'productid' );

		$product = Mage::getModel ( "catalog/product" )->load ( $productid );

		$options = array();

		if ($product->getTypeId() === 'configurable') {

            $options   = $this->getProductVariations($productid);

            $productIds = $this->array_flatten(array_map(function($product) {

                return $product['id'];

            }, $options['collection']));

            // foreach ($productIds as $productid) {

            //     array_push($options, $this->getProduct($productid));

            // }
        }


        $productAttributeOptions = $product->getTypeInstance(true)->getConfigurableAttributesAsArray($product);
		$attributeOptions = array();
		foreach ($productAttributeOptions as $productAttribute) {
			foreach($productAttribute['values'] as $attribute) {
				$attributeOptions[$productAttribute['label']][$attribute['value_index']] = $attribute['store_label'];
			};
		};

		$productdetail = array (
			'code' => 0,
			'msg' => null,
			'model' =>array(

				'entity_id' => $product->getId (),

				'sku' => $product->getSku (),

				'status' => $product->getStatus(),

				'name' => $product->getName (),

				'news_from_date' => $product->getNewsFromDate (),

				'news_to_date' => $product->getNewsToDate (),

				'special_from_date' => $product->getSpecialFromDate (),

				'special_to_date' => $product->getSpecialToDate (),

				'image_url' => $product->getImageUrl (),

				'url_key' => $product->getProductUrl (),

				'regular_price_with_tax' => number_format ( Mage::helper ( 'directory' )->currencyConvert ( $product->getPrice (), $baseCurrency, $currentCurrency ), 2, '.', '' ),

				'final_price_with_tax' => number_format ( Mage::helper ( 'directory' )->currencyConvert ( $product->getSpecialPrice (), $baseCurrency, $currentCurrency ), 2, '.', '' ),

				'description' => nl2br ( $product->getDescription () ),

				'symbol' => Mage::app ()->getLocale ()->currency ( Mage::app ()->getStore ()->getCurrentCurrencyCode () )->getSymbol () ,

				'options' => $options['collection'],

				'$attributeOptions' => $attributeOptions
			)
		);

		echo json_encode ( array('code'=>0, 'msg'=>null, 'model'=>$productdetail) );

	}


	/**
     * Returns product information for child SKUs of product (colors, sizes, etc).
     * 
     * @method getProductVariations
     * @param int $productId
     * @return array
     */
    public function getProductVariations($productId)
    {
        
        $product = Mage::getModel('catalog/product')->load((int) $productId);
        
        $children = Mage::getModel('catalog/product_type_configurable')->getUsedProducts(null, $product);
        
        $attributes = $product->getTypeInstance(true)->getConfigurableAttributesAsArray($product);

        $products = array('label' => null, 'collection' => array());

        foreach ($children as $child) {
            foreach ($attributes as $attribute) {

                $products['label'] = $attribute['store_label'];

                foreach ($attribute['values'] as $value) {

                    $childValue = $child->getData($attribute['attribute_code']);

                    if ($value['value_index'] == $childValue) {

                        $products['collection'][] = array(

                            'id'    => (int) $child->getId(),

                            'label' => $value['store_label']
                        );
                    }
                }
            }
        }
        return $products;
    }



	public function gettest(){

		$attributes = Mage::getSingleton('eav/config')->getEntityType(Mage_Catalog_Model_Product::ENTITY)->getAttributeCollection();

		// Localize attribute label (if you need it)

		$attributes->addStoreLabel(Mage::app()->getStore()->getId());

		// Loop over all attributes

		foreach ($attributes as $attr) {

			/* @var $attr Mage_Eav_Model_Entity_Attribute */

			// get the store label value

			$label = $attr->getStoreLabel() ? $attr->getStoreLabel() : $attr->getFrontendLabel();

			echo "Attribute: {$label}\n<br>";

			// If it is an attribute with predefined values

			if ($attr->usesSource()) {

	

			// Get all option values ans labels

			$options = $attr->getSource()->getAllOptions();

	

			// Output all option labels and values

			foreach ($options as $option)

			{

			echo "&nbsp;&nbsp;&nbsp;&nbsp;{$option['label']} =========> (Value {$option['value']})\n<br>";

				}

			}

			else

			{

			// Just for clarification of the debug code

				echo "    No select or multiselect attribute\n<br>";

			}

		}

	}

} 