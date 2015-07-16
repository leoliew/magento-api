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
     * Submit new review action
     *
     */
    public function postAction(){
        $product_id = $this->getRequest ()->getParam ('product_id');
        $return_result = array(
            'code'=> 0,
            'model'=> null,
        );
        if ($data = Mage::getSingleton('review/session')->getFormData(true)) {
            $rating = array();
            if (isset($data['ratings']) && is_array($data['ratings'])) {
                $rating = $data['ratings'];
            }
        } else {
            $data   = $this->getRequest()->getPost();
            $rating = $this->getRequest()->getParam('ratings', array());
        }
        $product = Mage::getModel('catalog/product')->setStoreId(Mage::app()->getStore()->getId())->load($product_id);
        if (($product) && !empty($data)) {
            $session    = Mage::getSingleton('core/session');
            /* @var $session Mage_Core_Model_Session */
            $review     = Mage::getModel('review/review')->setData($data);
            /* @var $review Mage_Review_Model_Review */
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
                    $return_result['msg'] = 'Your review has been accepted for moderation.';
                }
                catch (Exception $e) {
                    $return_result['code'] = 1;
                    $return_result['error'] = 'Unable to post the review.';
                }
            }
            else {
                $session->setFormData($data);
                if (is_array($validate)) {
                    foreach ($validate as $errorMessage) {
                        $return_result['error'] = $errorMessage;
                    }
                }
                else {
                    $return_result['error'] = 'Unable to post the review.';
                }
            }
        }
        echo json_encode($return_result);
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
                $rating = round($summary->getSum() / $summary->getCount());
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
