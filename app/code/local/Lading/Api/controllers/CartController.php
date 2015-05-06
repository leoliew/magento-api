<?php
/**
 * Class Lading_Api_CartController
 */
class Lading_Api_CartController extends Mage_Core_Controller_Front_Action {
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
     * @param int $id
     * @return array
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
		Mage::getModel ( 'core/session' )->setProductToShoppingCart ( new Varien_Object ( array (
				'id' => $product->getId (),
				'qty' => Mage::app ()->getRequest ()->getParam ( 'qty', 1 ),
				'name' => $product->getName (),
				'price' => $product->getPrice (),
				'category_name' => Mage::getModel ( 'catalog/category' )->load ( $categories [0] )->getName () 
		) ) );
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
