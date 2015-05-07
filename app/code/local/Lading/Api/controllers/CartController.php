<?php
/**
 * Class Lading_Api_CartController
 */
class Lading_Api_CartController extends Mage_Core_Controller_Front_Action {
	///mobileapi/cart/add?product=421&qty=5&super_attribute[92]=21&super_attribute[180]=78
	public function addAction() {
		try {
			$product_id = $this->getRequest ()->getParam ( 'product' );
			$params = $this->getRequest ()->getParams ();
			if (isset ( $params ['qty'] )) {
				$filter = new Zend_Filter_LocalizedToNormalized ( array (
						'locale' => Mage::app ()->getLocale ()->getLocaleCode () 
				) );
				$params ['qty'] = $filter->filter ( $params ['qty'] );
			} else 
			// $params ['qty'] = 1; // 调试直接设为1
			// $param=$this->getRequest ()->getParam ( 'param' );
			// $qty = $this->getRequest ()->getParam ( 'qty' );
			if ($product_id == '') {
				$session->addError ( "Product Not Added
					The SKU you entered ($sku) was not found." );
			}
			$request = Mage::app ()->getRequest ();
			$product = Mage::getModel ( 'catalog/product' )->load ( $product_id );
			$session = Mage::getSingleton ( 'core/session', array (
					'name' => 'frontend' 
			) );
			$cart = Mage::helper ( 'checkout/cart' )->getCart ();
			// $cart->addProduct ( $product, $qty );
			$cart->addProduct ( $product, $params );
			$session->setLastAddedProductId ( $product->getId () );
			$session->setCartWasUpdated ( true );
			$cart->save ();
			$items_qty = floor ( Mage::getModel ( 'checkout/cart' )->getQuote ()->getItemsQty () );
			$result = array("code"=>0, "msg"=> null, "model"=>array("items_qty"=>$items_qty));
			echo json_encode($result);
		} catch ( Exception $e ) {
			$result = array("code"=>0, "msg"=>$e->getMessage () , "model"=>null);
			echo json_encode($result);
		}
	}

	/**
     * @method removeCartItem
     * 
     */
    public function removeCartAction(){

    	$id = $this->getRequest ()->getParam ( 'cart_item_id' );
        
        Mage::getSingleton('checkout/cart')->removeItem($id)->save();
        echo json_encode(array(
            'code' => 0,
            'msg'  => Mage::getModel('checkout/cart')->save(),
            'model' => null
        ));
    }
    /**
     * @method updateAction
     *
     */
	public function updateAction() {
		$itemId = ( int ) $this->getRequest ()->getParam ( 'cart_item_id', 0 );
		$qty = ( int ) $this->getRequest ()->getParam ( 'qty', 0 );
		$oldQty = 0;
		$item = null;
		try {
			if ($itemId && $qty > 0) {
				$cartData = array ();
				$cartData [$itemId] ['qty'] = $qty;
				$cart = Mage::getSingleton ( 'checkout/cart' );
				/* * ****** if update fail rollback ********* */
				if ($cart->getQuote ()->getItemById ( $itemId )) {
					$item = $cart->getQuote ()->getItemById ( $itemId );
				} else {
					echo json_encode ( array (
							'code' => 1,
							'msg' => 'a wrong cart_item_id was given.',
							'model' => null 
					) );
					return false;
				}
				$oldQty = $item->getQty ();
				if (! $cart->getCustomerSession ()->getCustomer ()->getId () && $cart->getQuote ()->getCustomerId ()) {
					$cart->getQuote ()->setCustomerId ( null );
				}
				$cart->updateItems ( $cartData )->save ();
				if ($cart->getQuote ()->getHasError ()) { // apply for 1.7.0.2
					$mesg = current ( $cart->getQuote ()->getErrors () );
					Mage::throwException ( $mesg->getText () );
					return false;
				}
			}
			$session = Mage::getSingleton ( 'checkout/session' );
			$session->setCartWasUpdated ( true );
		} catch ( Mage_Core_Exception $e ) { // rollback $quote->collectTotals()->save();
			$item && $item->setData ( 'qty', $oldQty );
			$cart->getQuote ()->setTotalsCollectedFlag ( false ); // reflash price
			echo json_encode (array(
				'code' => 1,
				'msg' => $e->getMessage (),
				'model' => null
			));
			return false;
		} catch ( Exception $e ) {
			echo json_encode (array(
				'code' => 1,
				'msg' => $e->getMessage (),
				'model' => null
			) );
			return false;
		}
		return $this->getCartInfoAction ();
	}


	/**
	 * 1.24 取购物车中总金额及优惠券使用情况
	 */
	public function getCouponDetailAction() {
		$result = array (
			'code' => 0,
			'msg' => 'get coupon detail success',
			'model' => $this->_getCartTotal()
		);
		echo json_encode ($result);
	}

	/**
	 * 在购物车中使用和取消coupon 优惠券
	 * @return bool
	 */
	public function useCouponAction() {
		$couponCode = ( string ) Mage::app ()->getRequest ()->getParam ( 'coupon_code' );
		$cart = Mage::helper ( 'checkout/cart' )->getCart ();
		if (! $cart->getItemsCount ()) {
			echo json_encode ( array (
				'code' => '0X0001',
				'message' => "You can't use coupon code with an empty shopping cart"
			) );
			return false;
		}
		if (Mage::app ()->getRequest ()->getParam ( 'remove' ) == 1) {
			$couponCode = '';
		}
		$oldCouponCode = $cart->getQuote ()->getCouponCode ();
		if (! strlen ( $couponCode ) && ! strlen ( $oldCouponCode )) {
			echo json_encode ( array (
				'code' => '0X0002',
				'message' => "Emptyed."
			) );
			return false;
		}
		try {
			$codeLength = strlen ( $couponCode );
			$isCodeLengthValid = $codeLength && $codeLength <= Mage_Checkout_Helper_Cart::COUPON_CODE_MAX_LENGTH;

			$cart->getQuote ()->getShippingAddress ()->setCollectShippingRates ( true );
			$cart->getQuote ()->setCouponCode ( $isCodeLengthValid ? $couponCode : '' )->collectTotals ()->save ();

			if ($codeLength) {
				if ($isCodeLengthValid && $couponCode == $cart->getQuote ()->getCouponCode ()) {
					$messages = array (
						'code' => '0',
						'message' => $this->__ ( 'Coupon code "%s" was applied.', Mage::helper ( 'core' )->escapeHtml ( $couponCode ) )
					);
				} else {
					$messages = array (
						'code' => '1',
						'message' => $this->__ ( 'Coupon code "%s" is not valid.', Mage::helper ( 'core' )->escapeHtml ( $couponCode ) )
					);
				}
			} else {
				$messages = array (
					'code' => '2',
					'message' => $this->__ ( 'Coupon code was canceled.' )
				);
			}
		} catch ( Mage_Core_Exception $e ) {
			$messages = array (
				'code' => '3',
				'message' => $e->getMessage ()
			);
		} catch ( Exception $e ) {
			$messages = array (
				'code' => '4',
				'message' => $this->__ ( 'Cannot apply the coupon code.' )
			);
		}
		echo json_encode ( array_merge ( $messages, $this->_getCartTotal () ) );
	}



	public function getCartInfoAction() {
		if(Mage::getSingleton ( 'customer/session' )->isLoggedIn ()){
			$cart = Mage::getSingleton ( 'checkout/cart' );
			if ($cart->getQuote ()->getItemsCount ()) {
				$cart->init ();
				$cart->save ();
			}
			$cart->getQuote ()->collectTotals ()->save ();
			$cartInfo = array ();
			$cartInfo ['is_virtual'] = Mage::helper ( 'checkout/cart' )->getIsVirtualQuote ();
			$cartInfo ['cart_items'] = $this->_getCartItems ();
			$message = sizeof ( $this->errors ) ? $this->errors : $this->_getMessage ();
			$cartInfo ['cart_items_count'] = Mage::helper ( 'checkout/cart' )->getSummaryCount ();
			$cartInfo ['payment_methods'] = $this->_getPaymentInfo ();
			$cartInfo ['allow_guest_checkout'] = Mage::helper ( 'checkout' )->isAllowedGuestCheckout ( $cart->getQuote () );
			
			echo json_encode (array('code'=>0, 'msg'=>$message, 'model'=>$cartInfo));
		}else{
			echo json_encode(array(
				'code' => 1,
				'msg' => 'not user login',
				'model'=>array () 
			));
		} 
	
	}

	/**
	 * 获取购物车详情（总金额以及优惠券使用情况）
	 * @return array
	 */
	protected function _getCartTotal() {
		$cart = Mage::getSingleton ( 'checkout/cart' );
		$totalItemsInCart = Mage::helper ( 'checkout/cart' )->getItemsCount (); // total items in cart
		$totals = Mage::getSingleton ( 'checkout/session' )->getQuote ()->getTotals (); // Total object
		$oldCouponCode = $cart->getQuote ()->getCouponCode ();
		$oCoupon = Mage::getModel ( 'salesrule/coupon' )->load ( $oldCouponCode, 'code' );
		$oRule = Mage::getModel ( 'salesrule/rule' )->load ( $oCoupon->getRuleId () );

		$subtotal = round ( $totals ["subtotal"]->getValue () ); // Subtotal value
		$grandtotal = round ( $totals ["grand_total"]->getValue () ); // Grandtotal value
		if (isset ( $totals ['discount'] )) { // $totals['discount']->getValue()) {
			$discount = round ( $totals ['discount']->getValue () ); // Discount value if applied
		} else {
			$discount = '';
		}
		if (isset ( $totals ['tax'] )) { // $totals['tax']->getValue()) {
			$tax = round ( $totals ['tax']->getValue () ); // Tax value if present
		} else {
			$tax = '';
		}
		return array (
			'subtotal' => $subtotal,
			'grandtotal' => $grandtotal,
			'discount' => $discount,
			'tax' => $tax,
			'coupon_code' => $oldCouponCode,
			'coupon_rule' => $oRule->getData ()
		);
	}

	public function _getMessage() {
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
	private function _getPaymentInfo() {
		$cart = Mage::getSingleton ( 'checkout/cart' );
		$methods = $cart->getAvailablePayment();
		foreach ($methods as $method) {
			if ($method->getCode() == 'paypal_express') {
				return array('paypalec');
			}
		}
	
		return array();
	}
	public function _getCartItems() {
		$cartItemsArr = array ();
		$cart = Mage::getSingleton ( 'checkout/cart' );
		$quote = $cart->getQuote ();
		$currency = $quote->getquote_currency_code ();
		$displayCartPriceInclTax = Mage::helper ( 'tax' )->displayCartPriceInclTax ();
		$displayCartPriceExclTax = Mage::helper ( 'tax' )->displayCartPriceExclTax ();
		$displayCartBothPrices = Mage::helper ( 'tax' )->displayCartBothPrices ();
		$items=$quote->getAllVisibleItems();
		foreach ( $items as $item ) {
			$cartItemArr = array ();
			$cartItemArr ['cart_item_id'] = $item->getId ();
			$cartItemArr ['currency'] = $currency;
			$cartItemArr ['entity_type'] = $item->getProductType ();
			$cartItemArr ['item_id'] = $item->getProduct ()->getId ();
			$cartItemArr ['item_title'] = strip_tags ( $item->getProduct ()->getName () );
			$cartItemArr ['qty'] = $item->getQty ();
			$cartItemArr ['thumbnail_pic_url'] = ( string ) Mage::helper('catalog/image')->init($item->getProduct(), 'thumbnail')->resize ( 75 );
			$cartItemArr ['custom_option']=$this->_getCustomOptions($item);
			if ($displayCartPriceExclTax || $displayCartBothPrices) {
				if (Mage::helper ( 'weee' )->typeOfDisplay ( $item, array (
						0,
						1,
						4 
				), 'sales' ) && $item->getWeeeTaxAppliedAmount ()) {
					$exclPrice = $item->getCalculationPrice () + $item->getWeeeTaxAppliedAmount () + $item->getWeeeTaxDisposition ();
				} else {
					$exclPrice = $item->getCalculationPrice ();
				}
			}
			
			if ($displayCartPriceInclTax || $displayCartBothPrices) {
				$_incl = Mage::helper ( 'checkout' )->getPriceInclTax ( $item );
				if (Mage::helper ( 'weee' )->typeOfDisplay ( $item, array (
						0,
						1,
						4 
				), 'sales' ) && $item->getWeeeTaxAppliedAmount ()) {
					$inclPrice = $_incl + $item->getWeeeTaxAppliedAmount ();
				} else {
					$inclPrice = $_incl - $item->getWeeeTaxDisposition ();
				}
			}
			
			$cartItemArr ['item_price'] = max ( $exclPrice, $inclPrice ); // only display one
			
			array_push ( $cartItemsArr, $cartItemArr );
		}
		
		return $cartItemsArr;
	}

	/**
	 * @param $item
	 * @return array
	 */
	protected function _getCustomOptions($item){
		$session = Mage::getSingleton('checkout/session');
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
	public function getQtyAction() {
		if(Mage::getSingleton ( 'customer/session' )->isLoggedIn ()){

			$items_qty = floor ( Mage::getModel ( 'checkout/cart' )->getQuote ()->getItemsQty () );

			echo json_encode(array('code'=>0, 'msg'=>null, 'model'=>array('num'=>$items_qty)) );
		}else{
			echo json_encode(array(
				'code' => 1,
				'msg' => 'not user login',
				'model'=>array () 
			));
		}
	}
	public function test1Action() {
		$cart = $this->_getCart ();
		$params = $this->getRequest ()->getParams ();
		if ($params ['isAjax'] == 1) {
			$response = array ();
			try {
				if (isset ( $params ['qty'] )) {
					$filter = new Zend_Filter_LocalizedToNormalized ( array (
							'locale' => Mage::app ()->getLocale ()->getLocaleCode () 
					) );
					$params ['qty'] = $filter->filter ( $params ['qty'] );
				}
				$params ['qty'] = 1; // 调试直接设为1
				$product = $this->_initProduct ();
				$related = $this->getRequest ()->getParam ( 'related_product' );
				/**
				 * Check product availability
				 */
				if (! $product) {
					$response ['status'] = 'ERROR';
					$response ['message'] = $this->__ ( 'Unable to find Product ID' );
				}
				$cart->addProduct ( $product, $params );
				if (! empty ( $related )) {
					$cart->addProductsByIds ( explode ( ',', $related ) );
				}
				$cart->save ();
				$this->_getSession ()->setCartWasUpdated ( true );
				/**
				 *
				 * @todo remove wishlist observer processAddToCart
				 */
				Mage::dispatchEvent ( 'checkout_cart_add_product_complete', array (
						'product' => $product,
						'request' => $this->getRequest (),
						'response' => $this->getResponse () 
				) );
				if (! $this->_getSession ()->getNoCartRedirect ( true )) {
					if (! $cart->getQuote ()->getHasError ()) {
						$message = $this->__ ( '%s was added to your shopping cart.', Mage::helper ( 'core' )->htmlEscape ( $product->getName () ) );
						$response ['status'] = 'SUCCESS';
						$response ['message'] = $message;
					}
				}
			} catch ( Mage_Core_Exception $e ) {
				$msg = "";
				if ($this->_getSession ()->getUseNotice ( true )) {
					$msg = $e->getMessage ();
				} else {
					$messages = array_unique ( explode ( "\n", $e->getMessage () ) );
					foreach ( $messages as $message ) {
						$msg .= $message . '<br>';
					}
				}
				$response ['status'] = 'ERROR';
				$response ['message'] = $msg;
			} catch ( Exception $e ) {
				$response ['status'] = 'ERROR';
				$response ['message'] = $this->__ ( 'Cannot add the item to shopping cart.' );
				Mage::logException ( $e );
			}
			$this->getResponse ()->setBody ( Mage::helper ( 'core' )->jsonEncode ( $response ) );
			return;
		} else {
			return parent::addAction ();
		}
	}
	public function test2Action() {
		$product = Mage::getModel ( 'catalog/product' )->load ( Mage::app ()->getRequest ()->getParam ( 'product', 0 ) );
		if (! $product->getId ()) {
			return;
		}
		$categories = $product->getCategoryIds ();
		$attrs = $product->getAttributes();
		foreach ($attrs as $attribute) {
		    if ($attribute->getIsVisibleOnFront()) {
		        $value = $attribute->getValue($product);
		        // do something with $value here
		    }
		}

		$_helper2 = Mage::getModel('catalog/product_type_configurable')->setProduct($product);
		$_subproducts = $_helper2->getUsedProductCollection()->addAttributeToSelect('*')->addFilterByRequiredOptions();
		$_colors = array();
        $_color_id = array();
        foreach ($_subproducts as $_subproduct) {
        	$label = $_subproduct->getAttributeText('color');
          	$_colors[] = $label;

			if (!isset($_color_id[$label])) {
				$_color_id[$label] = $_subproduct->getData('color');
			}
        }
        $_color_swatch = array_unique($_colors);

		// $product = Mage::getModel('catalog/product')->load($product->getId ());
		// $configurable= Mage::getModel('catalog/product_type_configurable')->setProduct($product);
		// $simpleCollection = $configurable->getUsedProductCollection()->addAttributeToSelect('*')->addFilterByRequiredOptions();

		$test1 = array();
		$test2 = array();
		// $test3 = array();
		// $test4 = array();
		// $test5 = array();
		// $test6 = array();
		// $test7 = array();
		// $test8 = array();
		// foreach($simpleCollection as $simple){
		//    $test1[] = $simple->getAttributeText('color');
		//    $test2[] = $simple->getAttributeText('size');
		//    $test3[] = $simple->getData('color');
		//    $test4[] = $simple->getData('size');
		//    $test5[] = $simple->getAttributeText('fit');
		//    $test6[] = $simple->getData('fit');
		//    $test7[] = $simple->getAttributeText('color');
		//    $test8[] = $simple->getAttributeText('color');
		// }


  //       $attribute = Mage::getModel('eav/config')->getAttribute('catalog_product', 'color');  
		// foreach ($attribute->getSource()->getAllOptions(true) as $option) {
		//     $test1[] = $option['value'] ;
		//     $test2[] = $option['label'] ;
		// }

		// Collect options applicable to the configurable product
		$productAttributeOptions = $product->getTypeInstance(true)->getConfigurableAttributesAsArray($product);
		$attributeOptions = array();
		foreach ($productAttributeOptions as $productAttribute) {
			foreach($productAttribute['values'] as $attribute) {
				$attributeOptions[$productAttribute['label']][$attribute['value_index']] = $attribute['store_label'];
			};
		};

		// Mage::getModel ( 'core/session' )->setProductToShoppingCart ( new Varien_Object ( array (
		// 		'id' => $product->getId (),
		// 		'qty' => Mage::app ()->getRequest ()->getParam ( 'qty', 1 ),
		// 		'name' => $product->getName (),
		// 		'price' => $product->getPrice (),
		// 		'category_name' => Mage::getModel ( 'catalog/category' )->load ( $categories [0] )->getName () 
		// ) ) );
		echo json_encode(
			array(
				'id' => $product->getId (),
				'qty' => Mage::app ()->getRequest ()->getParam ( 'qty', 1 ),
				'price' => $product->getPrice (),
				'name' => $product->getName (),
				'category_name' => Mage::getModel ( 'catalog/category' )->load ( $categories [0] )->getName (),
				'getUrlModel' => $product->getUrlModel(),
				'getTypeId' => $product->getTypeId(),
				'getStatus' => $product->getStatus(),
				'getLinkInstance' => $product->getLinkInstance(),
				'getCategoryId' => $product->getCategoryId(),
				'getCategory' => $product->getCategory(),
				'getRelatedProducts' => $product->getRelatedProducts(),
				'getRelatedProductIds' => $product->getRelatedProductIds(),
				'getRelatedProductCollection' => $product->getRelatedProductCollection(),
				'getUpSellProducts' => $product->getUpSellProducts(),
				'getUpSellProductIds' => $product->getUpSellProductIds(),
				'getUpSellProductCollection' => $product->getUpSellProductCollection(),
				'getCrossSellProducts' => $product->getCrossSellProducts(),
				'getCrossSellProductIds' => $product->getCrossSellProductIds(),
				'getCrossSellProductCollection' => $product->getCrossSellProductCollection(),
				'getMediaAttributes' => $product->getMediaAttributes(),
				'getMediaGalleryImages' => $product->getMediaGalleryImages(),
				'getCrossSellProductCollection' => $product->getCrossSellProductCollection(),
				'getOptionById' => $product->getOptionById(),
				'getOptions' => $product->getOptions(),
				'getThumbnailUrl' => $product->getThumbnailUrl(),
				'_subproducts' => $_subproducts,
				'values' => $value,
				'_color_swatch' => $_color_swatch,
				'test1' => $test1,
				'test2' => $test2,
				'$attributeOptions' => $attributeOptions



				
				
			)
		);
	}
	public function getaddurlAction() {
		$productid = $this->getRequest ()->getParam ( 'productid' );
		$product = Mage::getModel ( "catalog/product" )->load ( $productid );
		$url = Mage::helper ( 'checkout/cart' )->getAddUrl ( $product );
		echo "{'url':'" . $url . "'}";
		$cart = Mage::helper ( 'checkout/cart' )->getCart ();
		$item_qty = $cart->getItemsQty ();
		echo "{'item_qty':'" . $item_qty . "'}";
		$summarycount = $cart->getSummaryCount ();
		echo "{'summarycount':'" . $summarycount . "'}";
	}
} 
