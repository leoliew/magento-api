<?php

/**
 * Class Lading_Api_SearchController
 */
class Lading_Api_SearchController extends Mage_Core_Controller_Front_Action {

    /**
     * get current user session
     * @return mixed
     */
	protected function _getSession(){
		return Mage::getSingleton ('catalog/session');
	}

    /**
     * search
     */
	public function indexAction() {
		$page = ($this->getRequest ()->getParam ( 'page' )) ? ($this->getRequest ()->getParam ( 'page' )) : 1;
		$limit = ($this->getRequest ()->getParam ( 'limit' )) ? ($this->getRequest ()->getParam ( 'limit' )) : 5;
		$order = ($this->getRequest ()->getParam ( 'order' )) ? ($this->getRequest ()->getParam ( 'order' )) : 'relevance';
		$dir = ($this->getRequest ()->getParam ( 'dir' )) ? ($this->getRequest ()->getParam ( 'dir' )) : 'desc';
		$query = Mage::helper ( 'catalogsearch' )->getQuery();
		$query->setStoreId ( Mage::app ()->getStore ()->getId () );
		if ($query->getQueryText () != '') {
			if (Mage::helper ( 'catalogsearch' )->isMinQueryLength ()){
				$query->setId( 0 )->setIsActive( 1 )->setIsProcessed( 1 );
			}else{
				if ($query->getId ()) {
					$query->setPopularity ( $query->getPopularity () + 1 );
				} else {
					$query->setPopularity ( 1 );
				}
				if ($query->getRedirect ()) {
					$query->save ();
					$this->getResponse ()->setRedirect ( $query->getRedirect () );
					return;
				} else {
					$query->prepare ();
				}
			}
			Mage::helper('catalogsearch')->checkNotes();
			$collection = $query->getResultCollection();
			$collection->setCurPage($page)->setPageSize($limit)->addAttributeToFilter('visibility', array('in' => array(
				Mage_Catalog_Model_Product_Visibility::VISIBILITY_IN_SEARCH,
				Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH,
			)))->joinField('qty',
				'cataloginventory/stock_item',
				'qty',
				'product_id=entity_id',
				'{{table}}.stock_id=1',
				'left')
				->addAttributeToFilter('qty', array("gt" => 0)) ->addAttributeToSort ( $order, $dir );
			$pages = $collection->setPageSize($limit)->getLastPageNumber();
			if($page <= $pages){
				$i = 1;
				$baseCurrency = Mage::app()->getStore()->getBaseCurrency()->getCode();
				$currentCurrency = Mage::app()->getStore()->getCurrentCurrencyCode();
				$store_id = Mage::app()->getStore()->getId();
				foreach($collection as $product){
					$product = Mage::getModel('catalog/product')->load($product->getId());
					$summaryData = Mage::getModel('review/review_summary')->setStoreId($store_id) ->load($product->getId());
					$price =($product->getSpecialPrice()) == null ? ($product->getPrice()) : ($product->getSpecialPrice());
					$regular_price_with_tax = $product->getPrice();
					$final_price_with_tax = $product->getSpecialPrice();
					$product_list [] = array(
						'entity_id' => $product->getId(),
						'sku' => $product->getSku(),
						'name' => $product->getName(),
						'rating_summary' => $summaryData->getRatingSummary(),
						'reviews_count' => $summaryData->getReviewsCount(),
						'news_from_date' => $product->getNewsFromDate (),
						'news_to_date' => $product->getNewsToDate(),
						'special_from_date' => $product->getSpecialFromDate(),
						'special_to_date' => $product->getSpecialToDate(),
						'image_url' => $product->getImageUrl(),
						'url_key' => $product->getProductUrl(),
						'price' =>  number_format(Mage::helper('directory')->currencyConvert($price, $baseCurrency, $currentCurrency), 2, '.', '' ),
						'regular_price_with_tax' => number_format(Mage::helper('directory')->currencyConvert($regular_price_with_tax, $baseCurrency, $currentCurrency), 2, '.', '' ),
						'final_price_with_tax' => number_format(Mage::helper('directory')->currencyConvert($final_price_with_tax, $baseCurrency, $currentCurrency), 2, '.', '' ),
						'symbol' => Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol(),
						'stock_level' => (int)Mage::getModel('cataloginventory/stock_item')->loadByProduct($product)->getQty()
					);
					$i ++;
				}
			}else{
				$product_list = array();
			}
			echo json_encode(
				array(
					'code'=>0,
					'msg'=>'search '.count($collection).' product success!',
					'model'=> array(
						'items'=> $product_list,
					)
				)
			);
			if(!Mage::helper('catalogsearch')->isMinQueryLength()){
				$query->save();
			}
		} else {
			echo json_encode(
				array(
					'code'=>0,
					'msg'=>null,
					'model'=>null,
					'error'=>'search keyword can not null!'
				)
			);
		}
	}



	/**
	 * get search number
	 */
	public function getSearchNumAction() {
		$query = Mage::helper ( 'catalogsearch' )->getQuery();
		$query->setStoreId ( Mage::app ()->getStore ()->getId () );
		if ($query->getQueryText () != '') {
			if (Mage::helper ( 'catalogsearch' )->isMinQueryLength ()){
				$query->setId( 0 )->setIsActive( 1 )->setIsProcessed( 1 );
			}else{
				if ($query->getId ()) {
					$query->setPopularity ( $query->getPopularity () + 1 );
				} else {
					$query->setPopularity ( 1 );
				}
				if ($query->getRedirect ()) {
					$query->save ();
					$this->getResponse ()->setRedirect ( $query->getRedirect () );
					return;
				} else {
					$query->prepare ();
				}
			}
			Mage::helper('catalogsearch')->checkNotes();
			$collection = $query->getResultCollection();
			$collection->addAttributeToFilter('visibility', array('in' => array(
				Mage_Catalog_Model_Product_Visibility::VISIBILITY_IN_SEARCH,
				Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH,
			)));
			echo json_encode(
				array(
					'code'=>0,
					'msg'=>'search '.count($collection).' product success!',
					'model'=> count($collection)
				)
			);
			if(!Mage::helper('catalogsearch')->isMinQueryLength()){
				$query->save();
			}
		} else {
			echo json_encode(
				array(
					'code'=>0,
					'msg'=>null,
					'model'=>null,
					'error'=>'search keyword can not null!'
				)
			);
		}
	}


}

