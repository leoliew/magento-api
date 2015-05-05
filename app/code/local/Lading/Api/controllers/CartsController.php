<?php

class SkyMazon_RestConnect_CartsController extends Mage_Core_Controller_Front_Action {

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

				//$params ['qty'] = 1; // 调试直接设为1

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

			$result = "{'result':'success'}";

			echo $result;

		} catch ( Exception $e ) {

			$result = "{'result':'error'";

			$result .= ", 'message': '" . $e->getMessage () . "'}";

			echo $result;

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
