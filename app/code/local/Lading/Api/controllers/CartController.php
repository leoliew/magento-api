<?php
/**
 * Class Lading_Api_CartController
 */
class Lading_Api_CartController extends Mage_Core_Controller_Front_Action {
	///mobileapi/cart/add?product=421&qty=5&super_attribute[92]=21&super_attribute[180]=78
    /**
     * 添加商品到购物车
     */
	public function addAction() {
		$result = array (
			'code' => 1,
			'msg' => null,
			'model' => null
		);
		if(Mage::getSingleton ( 'customer/session' )->isLoggedIn ()){
			try {
				$product_id = $this->getRequest ()->getParam ( 'product_id' );
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
					$result['code'] = 1;
					$result['msg'] = 'Product Not Added The SKU you entered" .$product_id. "was not found.';
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
				return;
			} catch ( Exception $e ) {
				$result = array("code"=>1, "msg"=>$e->getMessage () , "model"=>null);
				echo json_encode($result);
				return;
			}
		}else{
			$result['code'] = 5;
			$result['msg'] = 'not user login';
			echo json_encode($result);
		}
	}

    /**
     * @method removeCartItem
     */
    public function removeCartAction(){
    	$id = $this->getRequest ()->getParam ( 'cart_item_id' );
		$return_result = array(
			'code' => 0,
			'msg'  => 'delete cart '.$id.' from carts success',
			'model' => null
		);
		if(Mage::getSingleton ( 'customer/session' )->isLoggedIn ()){
			Mage::getSingleton('checkout/cart')->removeItem($id)->save();
			Mage::getModel('checkout/cart')->save();
			$return_result['model'] = array(
				'items_qty' => $items_qty = floor (Mage::getModel('checkout/cart')->getQuote()->getItemsQty())
			);
		}else{
			$return_result['code'] = 5;
			$return_result['msg'] = 'not user login';
		}
		echo json_encode($return_result);
    }

    /**
     * @method updateAction
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
		if(Mage::getSingleton ( 'customer/session' )->isLoggedIn ()){
			$result = array (
				'code' => 0,
				'msg' => 'get coupon detail success',
				'model' => $this->_getCartTotal()
			);
			echo json_encode ($result);
		}else{
			echo json_encode(array(
				'code' => 5,
				'msg' => 'not user login',
				'model'=>array ()
			));
		}
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
				'code' => 1,
				'msg' => "You can't use coupon code with an empty shopping cart"
			) );
			return;
		}
		$oldCouponCode = $cart->getQuote()->getCouponCode();
		if (! strlen ( $couponCode ) && ! strlen ( $oldCouponCode )) {
			echo json_encode ( array (
				'code' => 2,
				'msg' => "coupon code is Empty."
			));
			return;
		}
		try {
			$codeLength = strlen ( $couponCode );
			$isCodeLengthValid = $codeLength && $codeLength <= Mage_Checkout_Helper_Cart::COUPON_CODE_MAX_LENGTH;
			$cart->getQuote()->getShippingAddress()->setCollectShippingRates ( true );
			$cart->getQuote()->setCouponCode($isCodeLengthValid ? $couponCode : '')->collectTotals()->save();
			if ($codeLength) {
				if ($isCodeLengthValid && $couponCode == $cart->getQuote ()->getCouponCode ()) {
					$messages = array (
						'code' => 0,
						'msg' => $this->__ ( 'Coupon code "%s" was applied.', Mage::helper ( 'core' )->escapeHtml ( $couponCode ) )
					);
				} else {
					$messages = array (
						'code' => 1,
						'msg' => $this->__ ( 'Coupon code "%s" is not valid.', Mage::helper ( 'core' )->escapeHtml ( $couponCode ) )
					);
				}
			} else {
				$messages = array (
					'code' => 0,
					'msg' => $this->__ ( 'Coupon code was canceled.' )
				);
			}
		} catch ( Mage_Core_Exception $e ) {
			$messages = array (
				'code' => 3,
				'msg' => $e->getMessage ()
			);
		} catch ( Exception $e ) {
			$messages = array (
				'code' => 4,
				'msg' => $this->__ ( 'Cannot apply the coupon code.' ),
                'err' => $e
			);
		}
		$messages['model'] = $this->_getCartTotal();
		echo json_encode ($messages);
	}


    /**
     * 获取购物车信息
     */
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
			$cartInfo ['symbol'] = Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol();
			echo json_encode (array('code'=>0, 'msg'=>$message, 'model'=>$cartInfo));
		}else{
			echo json_encode(array(
				'code' => 5,
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
		$grand_total = round ( $totals ["grand_total"]->getValue () ); // Grandtotal value
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
			'grand_total' => $grand_total,
			'discount' => $discount,
			'tax' => $tax,
			'coupon_code' => $oldCouponCode,
			'coupon_rule' => array(
				'rule_id' => $oRule->getData()['rule_id'],
				'name' => $oRule->getData()['name'],
				'description'=> $oRule->getData()['description'],
				'from_date'=> $oRule->getData()['from_date'],
				'to_date'=> $oRule->getData()['to_date'],
				'uses_per_customer'=> $oRule->getData()['uses_per_customer'],
				'is_active'=> $oRule->getData()['is_active'],
				'is_advanced'=> $oRule->getData()['is_advanced'],
				'product_ids'=> $oRule->getData()['product_ids'],
				'simple_action'=> $oRule->getData()['simple_action'],
				'discount_amount'=> $oRule->getData()['discount_amount'],
				'discount_qty'=> $oRule->getData()['discount_qty'],
				'discount_step'=> $oRule->getData()['discount_step'],
				'simple_free_shipping'=> $oRule->getData()['simple_free_shipping'],
				'apply_to_shipping'=> $oRule->getData()['apply_to_shipping'],
				'times_used'=> $oRule->getData()['times_used'],
				'is_rss'=> $oRule->getData()['is_rss'],
				'coupon_type'=> $oRule->getData()['coupon_type'],
				'use_auto_generation'=> $oRule->getData()['use_auto_generation'],
				'uses_per_coupon'=> $oRule->getData()['uses_per_coupon']
			)
		);
	}

    /**
     * @return array
     */
    //TODO:add method comment
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

    /**
     * 获取购物车支付信息
     * @return array
     */
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

    /**
     * 获取购物车商品
     * @return array
     */
	public function _getCartItems() {
		$cartItemsArr = array ();
		$cart = Mage::getSingleton ( 'checkout/cart' );
		$quote = $cart->getQuote();
		$currency = $quote->getquote_currency_code ();
		$displayCartPriceInclTax = Mage::helper ( 'tax' )->displayCartPriceInclTax ();
		$displayCartPriceExclTax = Mage::helper ( 'tax' )->displayCartPriceExclTax ();
		$displayCartBothPrices = Mage::helper ( 'tax' )->displayCartBothPrices ();
		$items=$quote->getAllVisibleItems();
		foreach ( $items as $item ) {
			$cartItemArr = array ();
			if($item->getProductType()=='bundle'){
				$cartItemArr['bundle_option'] =  Mage::getModel('mobile/cart')->getProductBundleOptions($item);
			}
			$cartItemArr ['cart_item_id'] = $item->getId ();
			$cartItemArr ['sku'] = $item->getSku ();
			$cartItemArr ['currency'] = $currency;
			$cartItemArr ['product_type'] = $item->getProductType ();
			$cartItemArr ['item_id'] = $item->getProduct ()->getId ();
			$cartItemArr ['item_title'] = strip_tags ( $item->getProduct ()->getName () );
			$cartItemArr ['qty'] = $item->getQty ();
			$cartItemArr ['thumbnail_pic_url'] = ( string ) Mage::helper('catalog/image')->init($item->getProduct(), 'thumbnail')->resize ( 250 );
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
	public function _getCustomOptions($item){
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

    /**
     * 获取购物车商品数量
     */
	public function getQtyAction() {
		if(Mage::getSingleton ( 'customer/session' )->isLoggedIn ()){
			$items_qty = floor ( Mage::getModel ( 'checkout/cart' )->getQuote ()->getItemsQty () );
			echo json_encode(
                array(
                    'code'=>0,
                    'msg'=>null,
                    'model'=>array(
                        'num'=>$items_qty
                    )
                )
            );
		}else{
			echo json_encode(array(
				'code' => 5,
				'msg' => 'not user login',
				'model'=>array () 
			));
		}
	}



    /**
     * get shopping car url
     */
	public function getCartUrlAction() {
		if(Mage::getSingleton ( 'customer/session' )->isLoggedIn ()){
			$productid = $this->getRequest ()->getParam ( 'productid' );
			$product = Mage::getModel ( "catalog/product" )->load ( $productid );
			$url = Mage::helper ( 'checkout/cart' )->getAddUrl ( $product );
			$cart = Mage::helper ( 'checkout/cart' )->getCart ();
			$item_qty = $cart->getItemsQty ();
			$summarycount = $cart->getSummaryCount ();
			echo json_encode(array(
				'code' => 0,
				'url' => $url,
				'item_qty' => $item_qty,
				'summary_count' =>  $summarycount
			));
		}else{
			echo json_encode(array(
				'code' => 5,
				'msg' => 'not user login',
				'model'=>array ()
			));
		}
	}
} 
