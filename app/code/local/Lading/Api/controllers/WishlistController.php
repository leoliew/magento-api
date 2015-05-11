<?php
class Lading_Api_WishlistController extends Mage_Core_Controller_Front_Action {
    /**
     * add item to user wish list
     */
	public function addToWishlistAction() {
		$response = array ();
		if (! Mage::getStoreConfigFlag('wishlist/general/active')) {
			$response ['code'] = 1;
			$response ['msg'] = $this->__('Wishlist Has Been Disabled By Admin');
		}
		if (! Mage::getSingleton('customer/session')->isLoggedIn()) {
			$response ['code'] = 5;
			$response ['msg'] = $this->__('Please Login First');
		}
		if (empty ( $response )) {
			$session = Mage::getSingleton('customer/session');
			$wishlist = $this->_getWishlist();
			if (! $wishlist) {
				$response ['code'] = 2;
				$response ['msg'] = $this->__('Unable to Create Wishlist');
			} else {
				$productId = ( int ) $this->getRequest()->getParam('product');
				if (! $productId) {
					$response ['code'] = 2;
					$response ['msg'] = $this->__('Product Not Found');
				} else {
					$product = Mage::getModel('catalog/product' )->load($productId);
					if (! $product->getId() || ! $product->isVisibleInCatalog()) {
						$response ['code'] = 2;
						$response ['msg'] = $this->__('Cannot specify product.');
					} else {
						try {
							$requestParams = $this->getRequest()->getParams();
							$buyRequest = new Varien_Object($requestParams);
							$result = $wishlist->addNewItem($product, $buyRequest);
							if (is_string($result)){
								Mage::throwException( $result );
							}
							$wishlist->save ();

							Mage::dispatchEvent('wishlist_add_product', array (
								'wishlist' => $wishlist,
								'product' => $product,
								'item' => $result
							));
							Mage::helper( 'wishlist' )->calculate();
							$message = $this->__ ( '%1$s has been added to your wishlist.', $product->getName (), $referer );
							$response ['code'] = 0;
							$response ['msg'] = $message;
							Mage::unregister ( 'wishlist' );
						} catch ( Mage_Core_Exception $e ) {
							$response ['code'] = 2;
							$response ['msg'] = $this->__ ( 'An error occurred while adding item to wishlist: %s', $e->getMessage () );
						} catch ( Exception $e ) {
							mage::log ( $e->getMessage () );
							$response ['code'] = 2;
							$response ['msg'] = $this->__ ( 'An error occurred while adding item to wishlist.' );
						}
					}
				}
			}
		}
		// echo $this->getResponse ()->setBody ( Mage::helper ( 'core' )->jsonEncode ( $response ) );
		echo json_encode( $response );
		return;
	}

    /**
     * get user wish list action
     */
	public function getWishlistAction(){
		if (Mage::getSingleton('customer/session')->isLoggedIn()) {
			echo json_encode(
				array(
					'code' => 0,
					'msg' => 'get user wish list success!',
					'model' => $this->_getWishlist()
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
     * get wish list method
     * @return array|bool
     */
	protected function _getWishlist() {
		$wishlist = Mage::registry ( 'wishlist' );
		$baseCurrency = Mage::app ()->getStore ()->getBaseCurrency ()->getCode ();
		$currentCurrency = Mage::app ()->getStore ()->getCurrentCurrencyCode ();
		if ($wishlist) {
			return $wishlist;
		}
		try {
			$wishlist = Mage::getModel ( 'wishlist/wishlist' )->loadByCustomer ( Mage::getSingleton ( 'customer/session' )->getCustomer (), true );
			Mage::register ( 'wishlist', $wishlist );
		} catch ( Mage_Core_Exception $e ) {
			Mage::getSingleton ( 'wishlist/session' )->addError ( $e->getMessage () );
		} catch ( Exception $e ) {
			Mage::getSingleton ( 'wishlist/session' )->addException ( $e, Mage::helper ( 'wishlist' )->__ ( 'Cannot create wishlist.' ) );
			return false;
		}
		$items = array ();
		foreach ( $wishlist->getItemCollection () as $item ) {
			$item = Mage::getModel ( 'catalog/product' )->setStoreId ( $item->getStoreId () )->load ( $item->getProductId () );
			if ($item->getId ()) {
				$items [] = array (
					'name' => $item->getName (),
					'entity_id' => $item->getId (),
					'regular_price_with_tax' => number_format ( Mage::helper ( 'directory' )->currencyConvert ( $item->getPrice (), $baseCurrency, $currentCurrency ), 2, '.', '' ),
					'final_price_with_tax' => number_format ( Mage::helper ( 'directory' )->currencyConvert ( $item->getSpecialPrice (), $baseCurrency, $currentCurrency ), 2, '.', '' ),
					'sku' => $item->getSku () ,
					'symbol' => Mage::app ()->getLocale ()->currency ( Mage::app ()->getStore ()->getCurrentCurrencyCode () )->getSymbol ()
				);
			}
		}
		return array (
			'wishlist' => $wishlist->getData (),
			'items' => $items
		);
	}
} 
