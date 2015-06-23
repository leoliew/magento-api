<?php

/**
 * Class Lading_Api_OrderController
 * create by Terry
 * date 2015-05-11
 */
class Lading_Api_OrderController extends Mage_Core_Controller_Front_Action {
	/**
	 * get Orders
	 */
	public function getOrderAction() {
		if(Mage::getSingleton ( 'customer/session' )->isLoggedIn ()){
			$order_id = $this->getRequest ()->getParam ( 'order_id' );
			$order_info = Mage::getModel('mobile/order')->getOrderById($order_id);
			echo json_encode(array('code'=>0,'msg'=>null,'model'=>$order_info));
		}else{
			echo json_encode(array('code'=>5,'msg'=>'no user login','model'=>null));
		}
		
	}

	/**
	 * get order list
	 */
	public function getOrderListAction(){
		$status = $this->getRequest ()->getParam ( 'status' );
		$order = ($this->getRequest ()->getParam ( 'order' )) ? ($this->getRequest ()->getParam ( 'order' )) : 'created_at';
		$dir = ($this->getRequest ()->getParam ( 'dir' )) ? ($this->getRequest ()->getParam ( 'dir' )) : 'desc';
		if(Mage::getSingleton ( 'customer/session' )->isLoggedIn ()){
			$customer_id = Mage::getSingleton('customer/session')->getCustomer()->getId();
			if(is_null($status)){
				$orders = Mage::getModel("sales/order")->getCollection()
					->addAttributeToSelect('*')
					->addFieldToFilter('customer_id', $customer_id)
					->addAttributeToSort ( $order, $dir );
			}else{
				$orders = Mage::getModel("sales/order")->getCollection()
					->addAttributeToSelect('*')
					->addFieldToFilter('customer_id', $customer_id)
					->addFieldToFilter('status', $status)
					->addAttributeToSort ( $order, $dir );
			}
			$order_list = array();
			foreach ($orders as $order) {
				$order_list[] = array(
					'entity_id' => $order-> getEntityId(),
					'order_id' => $order->getRealOrderId(),
					'created_at' => Mage::getModel('core/date')->date('Y-m-d', strtotime($order->getCreatedAt())),
					'tax_amount' => $order->getTaxAmount(),
					'shipping_amount' => $order->getShippingAmount(),
					'discount_amount' => $order->getDiscountAmount(),
					'subtotal' => $order->getSubtotal(),
					'grand_total' => $order->getGrandTotal(),
					'symbol' => Mage::app ()->getLocale ()->currency ( Mage::app ()->getStore ()->getCurrentCurrencyCode () )->getSymbol (),
					'total_qty_ordered' => $order->getTotalQtyOrdered(),
					'shipping_address_name' => ($order->getShippingAddress()?$order->getShippingAddress()->getName():null),
					'status' => $order->getStatusLabel(),
				);
			}

			echo json_encode(array('code'=>0,'msg'=>null,'model'=>$order_list));

		}else{
			echo json_encode(array('code'=>5,'msg'=>'no user login','model'=>null));
		}
	}



//	/**
//	 * create order
//	 */
//	public function createOrderAction(){
//		$pay_method = $this->getRequest()->getParam ( 'pay_method' );
//		if (Mage::getSingleton('customer/session')->isLoggedIn()) {
//		    $customer = Mage::getSingleton('customer/session')->getCustomer();
//		    $customer->setWebsiteId(Mage::app()->getWebsite()->getId());
//		} else {
//		    // $customer = Mage::getModel('customer/customer');
//		    // $email = 'test@example.com';
//		    // $customer->setWebsiteId(Mage::app()->getWebsite()->getId());
//		    // $customer->setStoreId(Mage::app()->getStore()->getId());
//		    // $customer->loadByEmail($email);
//		    // Mage::getSingleton('customer/session')->loginById($customer->getId());
//		}
//		$customAddress = Mage::getModel('customer/address')->setCustomerId($customer->getId())->getCustomer();
//		$customAddressId = Mage::getSingleton('customer/session')->getCustomer()->getDefaultBilling();
//		if ($customAddressId) {
//		    $customAddress = Mage::getModel('customer/address')->load($customAddressId);
//		}
//		Mage::getSingleton('checkout/session')->getQuote()->setBillingAddress(Mage::getSingleton('sales/quote_address')->importCustomerAddress($customAddress))->setShippingAddress(Mage::getSingleton('sales/quote_address')->importCustomerAddress($customAddress));
//		$product = Mage::getModel('catalog/product')->setStoreId(Mage::app()->getStore()->getId())->load(378);
//		$cart = Mage::getSingleton('checkout/cart');
//		$cart->truncate();
//		try {
//		    $cart->addProduct($product, array('qty' => 2));
//		    $cart->save();
//		    $message = $this->__('%s was successfully added to your shopping cart.', $product->getName());
//		    Mage::getSingleton('checkout/session')->addSuccess($message);
//		} catch (Exception $ex) {
//		    echo $ex->getMessage();
//		}
//		$storeId = Mage::app()->getStore()->getId();
//		$checkout = Mage::getSingleton('checkout/type_onepage');
//		$checkout->initCheckout();
//		// $checkout->saveCheckoutMethod('register');
//		$checkout->saveShippingMethod('flatrate_flatrate');
//
//		try {
//			$checkout->savePayment(array('method' => $pay_method));
//		    $checkout->saveOrder();
//		} catch (Exception $ex) {
//		    echo $ex->getMessage();
//		}
//		$cart->truncate();
//		$cart->save();
//		$cart->getItems()->clear()->save();
//		// Mage::getSingleton('customer/session')->logout();
//	}
//
//
//
//	/**
//	 * test order
//	 */
//	public function testOrderAction(){
//		$payMethod = $this->getRequest()->getParam ( 'paymethod' );
//
//		if (Mage::getSingleton('customer/session')->isLoggedIn()) {
//			try{
//			    $customer = Mage::getSingleton('customer/session')->getCustomer();
//			    $customer->setWebsiteId(Mage::app()->getWebsite()->getId());
//			    $orderData = array(
//					'currency' => 'USD',
//					'billing_address' =>array(
//						'firstname' => 'terry',
//						'lastname' => 'wei',
//						'street' => 'xinhuajie',
//						'city' => 'guangzhou',
//						'country_id' => '10',
//						'region_id' => '5',
//						'postcode' => '002',
//						'telephone' => '123222'
//					),
//					'comment' => array(
//						'customer_note' => 'customerMessage :123'
//					)
//				);
//				$orderData['shipping_address'] = $orderData['billing_address'];
//				$paymentMethod = $payMethod;
//				$shippingMethod = 'flatrate_flatrate';
//
//				$customAddress = Mage::getModel('customer/address')->setCustomerId($customer->getId())->getCustomer();
//				$customAddressId = Mage::getSingleton('customer/session')->getCustomer()->getDefaultBilling();
//				if ($customAddressId) {
//				    $customAddress = Mage::getModel('customer/address')->load($customAddressId);
//				}
//
//				$customAddress->addData($orderData['billing_address']);
//				$customAddress->save();
//				Mage::getSingleton('checkout/session')->getQuote()->setBillingAddress(Mage::getSingleton('sales/quote_address')->importCustomerAddress($customAddress))->setShippingAddress(Mage::getSingleton('sales/quote_address')->importCustomerAddress($customAddress));
//				$product = Mage::getModel('catalog/product')->setStoreId(Mage::app()->getStore()->getId())->load(549);
//				$cart = Mage::getSingleton('checkout/cart');
//				$cart->truncate();
//				$cart->addProduct($product, array('qty' => 2));
//				$cart->save();
//				$checkout = Mage::getSingleton('checkout/type_onepage');
//				$checkout->initCheckout();
//				// $checkout->saveCheckoutMethod('register');
//				$checkout->saveShippingMethod('flatrate_flatrate');
//				$checkout->savePayment(array('method' => $payMethod));
//			    $checkout->saveOrder();
//			    $cart->truncate();
//			    $cart->save();
//			    echo json_encode(array('code'=>0,'msg'=>'create order success!!','model'=>null));
//			} catch (Exception $ex) {
//				echo json_encode(array('code'=>0,'msg'=>$ex->getMessage(),'model'=>null));
//			}
//
//		} else {
//			echo json_encode(array('code'=>1,'msg'=>'no user login in','model'=>null));
//			return false;
//		}
//	}
}