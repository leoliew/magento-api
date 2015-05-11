<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 5/12/15
 * Time: 3:09 PM
 */

/**
 * Class Lading_Api_ReviewController
 */
class Lading_Api_ReviewController extends Mage_Core_Controller_Front_Action{

    /**
     * get product by id
     * @param $productId
     * @return bool
     */
    protected function _loadProduct($productId) {
        if (!$productId) {
            return false;
        }
        $product = Mage::getModel('catalog/product')
            ->setStoreId(Mage::app()->getStore()->getId())
            ->load($productId);
        if (!$product->getId() || !$product->isVisibleInCatalog() || !$product->isVisibleInSiteVisibility()) {
            return false;
        }
        return $product;
    }



    /**
     * Submit new review action
     *
     */
    public function addAction(){
        $data = array();
        $data['ratings'] = array();
//        $r = (int) $_REQUEST['rating'];
//        $data['ratings']['1'] = (string) $r;
//        $data['ratings']['2'] = (string) ($r + 5);
//        $data['ratings']['3'] = (string) ($r + 10);
        $customer = Mage::getSingleton('customer/session')->getCustomer();
        $data['nickname'] = trim($customer->firstname . ' ' . $customer->lastname);
        $data['nickname'] = empty($data['nickname']) ? 'Mobile' : $data['nickname'];
        $data['title'] = empty($_REQUEST['title']) ? 'From mobile' : $_REQUEST['title'];
        $data['detail'] = $_REQUEST['content'];
        $rating = $data['ratings'];
        if (($product = $this->_loadProduct($_REQUEST['item_id'])) && !empty($data)) {
            $review = Mage::getModel('review/review')->setData($data);
            $validate = $review->validate();
            if ($validate === true) {
                try {
                    $review->setEntityId($review->getEntityIdByCode(Mage_Review_Model_Review::ENTITY_PRODUCT_CODE))
                        ->setEntityPkValue($product->getId())
                        ->setStatusId(Mage_Review_Model_Review::STATUS_PENDING)
                        ->setCustomerId(Mage::getSingleton('customer/session')->getCustomerId())
                        ->setStoreId(Mage::app()->getStore()->getId())
                        ->setStores(array(Mage::app()->getStore()->getId()))
                        ->save();
                    foreach ($rating as $ratingId => $optionId) {
                        Mage::getModel('rating/rating')
                            ->setRatingId($ratingId)
                            ->setReviewId($review->getId())
                            ->setCustomerId(Mage::getSingleton('customer/session')->getCustomerId())
                            ->addOptionVote($optionId, $product->getId());
                    }
                    $review->aggregate();
                    echo json_encode(array('code'=>0,'msg'=>'Your review has been accepted for moderation.', 'model'=>true));
                } catch (Exception $e) {
                    echo json_encode(array('code'=>1,'msg'=>$e->getMessage(), 'model'=>false));
                }
            } else {
                if (is_array($validate)) {
                    $errors = array();
                    foreach ($validate as $errorMessage) {
                        array_push($errors, $errorMessage);
                    }
                    echo json_encode(array('code'=>2,'msg'=>$errors, 'model'=>false));
                } else {
                    echo json_encode(array('code'=>3,'msg'=>'Unable to post the review.', 'model'=>false));
                }
            }
        }
    }


    /**
     * Show list of product's reviews
     *
     */
    public function listAction(){
        $productId = $this->getRequest()->getParam('product_id');
        $pageNo = $this->getRequest()->getParam('page_no', 1);
        $pageSize = $this->getRequest()->getParam('page_size', 10);
        $block = Mage::getBlockSingleton('review/product_view');
        $block->setProductId($productId);
        $collection = $block->getReviewsCollection()
            ->setCurPage($pageNo)
            ->setPageSize($pageSize);
        $rate = Mage::getModel('rating/rating');
        $tradeRates = array();
        foreach ($collection->getItems() as $review) {
            $summary = $rate->getReviewSummary($review->getId());
            if ($summary->getCount() > 0) {
                $rating = round($summary->getSum() / $summary->getCount() / 20);
            } else {
                $rating = 0;
            }
            $tradeRates[] = array(
                'uname' => $review->getNickname(),
                'item_id' => $productId,
                'rate_score' => $rating,
                'rate_content' => $review->getDetail(),
                'rate_date' => $review->getCreatedAt(),
                'rate_title' => $review->getTitle()
            );
        }
        $result = array();
        $result['total_results'] = $collection->getSize();
        $result['trade_rates'] = $tradeRates;
        echo json_encode(array('code'=>0,'msg'=>'get reviews success!', 'model'=>$result));
    }

}
