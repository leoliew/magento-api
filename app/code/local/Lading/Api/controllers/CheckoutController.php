<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 5/28/15
 * Time: 3:10 PM
 */


class Lading_Api_CheckoutController extends Mage_Core_Controller_Front_Action{


    /**
     * 获取用户地址信息
     */
    public function getAddressListAction(){
        $quote = Mage::getSingleton('checkout/session')->getQuote();
        $quote_shipping_address_id = $quote->getShippingAddress()->getCustomerAddressId();
        $quote_billing_address_id = $quote->getBillingAddress()->getCustomerAddressId();
        $customer = Mage::getSingleton('customer/session')->getCustomer();
        $addressList = Mage::getModel('mobile/address')->getCustomerAddressList($customer);
        foreach($addressList as $key=>$address){
            if($address['entity_id'] ==  $quote_shipping_address_id){
                $addressList[$key]['is_quote_shipping'] = true;
            }
            if($address['entity_id'] ==  $quote_billing_address_id){
                $addressList[$key]['is_quote_billing'] = true;
            }
        }
        echo json_encode(array(
            'code'=>0,
            'msg'=>'get order address success!',
            'model'=>$addressList
        ));
<<<<<<< HEAD
    }
<<<<<<< HEAD



    /**
     * 获取用户地址信息
     */
    public function getAddressByQuoteAction(){
        $quote = Mage::getSingleton('checkout/session')->getQuote();
        if($quote->getId()){
            $address = Mage::getModel('mobile/checkout')->getAddressByQuote($quote);
            echo json_encode(array(
                'code'=>0,
                'msg'=>' get quote address success!',
                'model'=>$address
            ));
        }else{
            echo json_encode(array(
                'code'=>1,
                'msg'=>'can not get quote!',
                'model'=>null
            ));
        }
    }




    /**
     * Get list of available shipping methods
     * @return array
     */
    public function getShippingMethodsListAction(){
        $shippingMethodLists = array();
        $return_result = array (
            'code' => 0,
            'msg' => 'get shipping method list success!',
            'model' => null
        );
        $quoteShippingAddress = Mage::getSingleton('checkout/session')->getQuote()->getShippingAddress();
        $shippingMethod = $quoteShippingAddress->getShippingMethod();
        if (is_null($quoteShippingAddress->getId())) {
            $return_result['msg'] = 'shipping_address_is_not_set';
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
            $return_result['code'] = 1;
<<<<<<< HEAD
<<<<<<< HEAD
            return;
        }
        $rates = $quoteShippingAddress->getShippingRatesCollection();
        foreach($rates as $rate){
            $temp_rates = array();
            $temp_rates['carrier'] = $rate->getCarrier();
            $temp_rates['carrier_title'] = $rate->getCarrierTitle();
            $temp_rates['code'] = $rate->getCode();
            $temp_rates['method'] = $rate->getMethod();
            $temp_rates['method_title'] = $rate->getMethodTitle();
            $temp_rates['price'] = $rate->getPrice();
            $temp_rates['method_description'] = $rate->getMethodDescription();
            if($rate->getCode() == $shippingMethod){
                $temp_rates['is_selected'] = true;
            }
            array_push($shippingMethodLists,$temp_rates);
        }
        $after_group = array();
        foreach ( $shippingMethodLists as $value ) {
            $after_group[$value['carrier_title']][] = $value;
        }
        $return_result['model'] = $after_group;
        echo json_encode($return_result);

=======
>>>>>>> 47605a6... add checkout flow address
    }



    /**
<<<<<<< HEAD
     * Get list of available shipping methods
     * @return array
     */
    public function getPayMethodsListAction(){
        $quote = Mage::getSingleton('checkout/session')->getQuote();
        $payment_methods = Mage::getModel('mobile/checkout')->getActivePaymentMethods($quote);
        echo json_encode(array(
            'code'=> 0,
            'msg'=> 'get payment methods success!',
            'model'=> $payment_methods
        ));
    }


    /**
     * Get list of available shipping methods
     * @return array
     */
    public function setPayMethodAction(){
        $return_result = array (
            'code' => 0,
            'msg' => 'save payment method success!',
            'model' => null
        );
        try {
            if ($this->getRequest()->isPost()) {
                $data = $this->getRequest()->getPost('payment', array());
                $saveResult = Mage::getSingleton('checkout/type_onepage')->savePayment($data);
                if (isset($saveResult['error'])) {
                    $result['success'] = false;
                    $result['messages'][] = $saveResult['message'];
                }
                Mage::getSingleton('checkout/type_onepage')->getQuote()->collectTotals()->save();
            } else {
                $result['code'] = 1;
                $result['msg'][] = 'Please specify payment method.';
            }
        } catch (Exception $e) {
            Mage::logException($e);
            $result['code'] = 1;
            $result['msg'][] = 'Unable to set Payment Method.';
        }
        echo json_encode($return_result);
=======
     * 获取用户地址信息
     */
    public function getAddressByQuoteAction(){
        $quote = Mage::getSingleton('checkout/session')->getQuote();
        if($quote->getId()){
            $address = Mage::getModel('mobile/checkout')->getAddressByQuote($quote);
            echo json_encode(array(
                'code'=>0,
                'msg'=>' get quote address success!',
                'model'=>$address
            ));
        }else{
            echo json_encode(array(
                'code'=>1,
                'msg'=>'can not get quote!',
                'model'=>null
            ));
        }
>>>>>>> 47605a6... add checkout flow address
    }



<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======

>>>>>>> 47605a6... add checkout flow address
    /**
     * Get list of available shipping methods
     * @return array
     */
    public function getShippingMethodsListAction(){
        $shippingMethodLists = array();
        $return_result = array (
            'code' => 0,
            'msg' => 'get shipping method list success!',
            'model' => null
        );
        $quoteShippingAddress = Mage::getSingleton('checkout/session')->getQuote()->getShippingAddress();
        $shippingMethod = $quoteShippingAddress->getShippingMethod();
        if (is_null($quoteShippingAddress->getId())) {
            $return_result['msg'] = 'shipping_address_is_not_set';
            echo json_encode($return_result);
=======
>>>>>>> f438ad5... add checkout address api
=======
=======
            echo json_encode($return_result);
>>>>>>> 3e74e95... temp
<<<<<<< HEAD
>>>>>>> fa319b9... temp
=======
=======
            $return_result['code'] = 1;
>>>>>>> a398721... temp
=======
            echo json_encode($return_result);
>>>>>>> c729d71... temp
=======
            $return_result['code'] = 1;
>>>>>>> 695332c... temp
>>>>>>> c50a252... temp
            return;
        }
        $rates = $quoteShippingAddress->getShippingRatesCollection();
        foreach($rates as $rate){
            $temp_rates = array();
            $temp_rates['carrier'] = $rate->getCarrier();
            $temp_rates['carrier_title'] = $rate->getCarrierTitle();
            $temp_rates['code'] = $rate->getCode();
            $temp_rates['method'] = $rate->getMethod();
            $temp_rates['method_title'] = $rate->getMethodTitle();
            $temp_rates['price'] = $rate->getPrice();
            $temp_rates['method_description'] = $rate->getMethodDescription();
            if($rate->getCode() == $shippingMethod){
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
                $temp_rates['is_selected'] = true;
=======
                $temp_rates['is_select'] = true;
>>>>>>> 3e74e95... temp
=======
                $temp_rates['is_selected'] = true;
>>>>>>> a398721... temp
=======
                $temp_rates['is_select'] = true;
>>>>>>> c729d71... temp
=======
                $temp_rates['is_selected'] = true;
>>>>>>> 695332c... temp
            }
            array_push($shippingMethodLists,$temp_rates);
        }
        $after_group = array();
        foreach ( $shippingMethodLists as $value ) {
            $after_group[$value['carrier_title']][] = $value;
        }
        $return_result['model'] = $after_group;
        echo json_encode($return_result);

    }



    /**
     * Get list of available shipping methods
     * @return array
     */
    public function getPayMethodsListAction(){
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> a398721... temp
=======
>>>>>>> 695332c... temp
        $quote = Mage::getSingleton('checkout/session')->getQuote();
        $payment_methods = Mage::getModel('mobile/checkout')->getActivePaymentMethods($quote);
        echo json_encode(array(
            'code'=> 0,
            'msg'=> 'get payment methods success!',
            'model'=> $payment_methods
        ));
    }
<<<<<<< HEAD
<<<<<<< HEAD

<<<<<<< HEAD
<<<<<<< HEAD


>>>>>>> 679a99c... add shipmethod

<<<<<<< HEAD
=======
    public function getAddress() {

         $_address = $this->getQuote()->getShippingAddress();
        return $_address;
    }

    public function getAddressShippingMethod() {
        return $this->getAddress()->getShippingMethod();
=======
>>>>>>> 47605a6... add checkout flow address
=======

    /**
     * Get list of available shipping methods
     * @return array
     */
    public function setPayMethodAction(){
        $return_result = array (
            'code' => 0,
            'msg' => 'save payment method success!',
            'model' => null
        );
        try {
            if ($this->getRequest()->isPost()) {
                $data = $this->getRequest()->getPost('payment', array());
                $saveResult = Mage::getSingleton('checkout/type_onepage')->savePayment($data);
                if (isset($saveResult['error'])) {
                    $result['success'] = false;
                    $result['messages'][] = $saveResult['message'];
                }
                Mage::getSingleton('checkout/type_onepage')->getQuote()->collectTotals()->save();
            } else {
                $result['code'] = 1;
                $result['msg'][] = 'Please specify payment method.';
            }
        } catch (Exception $e) {
            Mage::logException($e);
            $result['code'] = 1;
            $result['msg'][] = 'Unable to set Payment Method.';
        }
        echo json_encode($return_result);
<<<<<<< HEAD
>>>>>>> f438ad5... add checkout address api
=======
=======
        echo '12345';

>>>>>>> 3e74e95... temp
<<<<<<< HEAD
>>>>>>> fa319b9... temp
=======
=======

=======

>>>>>>> 695332c... temp

    /**
     * Get list of available shipping methods
     * @return array
     */
    public function setPayMethodAction(){
        $return_result = array (
            'code' => 0,
            'msg' => 'save payment method success!',
            'model' => null
        );
        try {
            if ($this->getRequest()->isPost()) {
                $data = $this->getRequest()->getPost('payment', array());
                $saveResult = Mage::getSingleton('checkout/type_onepage')->savePayment($data);
                if (isset($saveResult['error'])) {
                    $result['success'] = false;
                    $result['messages'][] = $saveResult['message'];
                }
                Mage::getSingleton('checkout/type_onepage')->getQuote()->collectTotals()->save();
            } else {
                $result['code'] = 1;
                $result['msg'][] = 'Please specify payment method.';
            }
        } catch (Exception $e) {
            Mage::logException($e);
            $result['code'] = 1;
            $result['msg'][] = 'Unable to set Payment Method.';
        }
        echo json_encode($return_result);
<<<<<<< HEAD
>>>>>>> a398721... temp
=======
        echo '12345';

>>>>>>> c729d71... temp
=======
>>>>>>> 695332c... temp
>>>>>>> c50a252... temp
    }




=======
>>>>>>> 47605a6... add checkout flow address



    /**
<<<<<<< HEAD
     * 获取订单详细
     */
    public function getOrderReviewAction(){
        $orderReviewArr = array();
        $quote = Mage::getSingleton('checkout/session')->getQuote();
        $cartItemsArr = array();
        $virtual_flag = false;
        foreach ($quote->getAllVisibleItems() as $item) {
            $renderer = new Mage_Checkout_Block_Cart_Item_Renderer();
            $renderer->setItem($item);
            $cartItemArr = array();
            $cartItemArr['item_id'] = $item->getProduct()->getId();
            $cartItemArr['cart_item_id'] = $item->getId();
            $cartItemArr['item_title'] = strip_tags($renderer->getProductName());
            $cartItemArr['qty'] = $renderer->getQty();
            $cartItemArr['product_type'] = $item->getProductType();
            if($item->getProductType()=='bundle'){
                $cartItemArr['bundle_option'] =  Mage::getModel('mobile/cart')->getProductBundleOptions($item);
            }
            if($item->getProductType()=='configurable'){
                $cartItemArr['custom_option'] =  Mage::getModel('mobile/cart')->getCustomOptions($item);
            }
            $icon = $item->getProduct()->getThumbnailUrl();
            $virtual_flag = $item->getProduct()->isVirtual();
            $cartItemArr['thumbnail_pic_url'] = $icon;
            $file = Mage::helper('mobileapi')->urlToPath($icon);
            $exclPrice = $inclPrice = 0.00;
            if (Mage::helper('tax')->displayCartPriceExclTax() || Mage::helper('tax')->displayCartBothPrices()) {
                if (Mage::helper('weee')->typeOfDisplay($item, array(0, 1, 4), 'sales') && $item->getWeeeTaxAppliedAmount()) {
                    $exclPrice = $item->getCalculationPrice() + $item->getWeeeTaxAppliedAmount() + $item->getWeeeTaxDisposition();
                } else {
                    $exclPrice = $item->getCalculationPrice();
                }
            }
            if (Mage::helper('tax')->displayCartPriceInclTax() || Mage::helper('tax')->displayCartBothPrices()) {
                $_incl = Mage::helper('checkout')->getPriceInclTax($item);
                if (Mage::helper('weee')->typeOfDisplay($item, array(0, 1, 4), 'sales') && $item->getWeeeTaxAppliedAmount()) {
                    $inclPrice = $_incl + $item->getWeeeTaxAppliedAmount();
                } else {
                    $inclPrice = $_incl - $item->getWeeeTaxDisposition();
                }
            }
            $exclPrice = Mage::helper('mobileapi')->formatPriceForXml($exclPrice);
            $formatedExclPrice = $quote->getStore()->formatPrice($exclPrice, false);
            $inclPrice = Mage::helper('mobileapi')->formatPriceForXml($inclPrice);
            $formatedInclPrice = $quote->getStore()->formatPrice($inclPrice, false);
            if (Mage::helper('tax')->displayCartBothPrices()) {
                $cartItemArr['price_excluding_tax'] = $exclPrice;
                $cartItemArr['price_including_tax'] = $inclPrice;
            } else {
                if (Mage::helper('tax')->displayCartPriceExclTax()) {
                    $cartItemArr['item_price'] = $exclPrice;
                }
                if (Mage::helper('tax')->displayCartPriceInclTax()) {
                    $cartItemArr['item_price'] = $inclPrice;
                }
            }
            if ($_options = $renderer->getOptionList()) {
                $optionsArr = array();
                foreach ($_options as $_option) {
                    $optionArr = array();
                    $_formatedOptionValue = $renderer->getFormatedOptionValue($_option);
                    $optionsArr = $optionsArr . strip_tags($_option['label']) . ':' . strip_tags($_formatedOptionValue['value']) . ',';
                }
                $optionsArr = substr($optionsArr, 0, strlen($optionsArr) - 1);
                $cartItemArr['skus'] = $optionsArr;
            }
            if ($messages = $renderer->getMessages()) {
                $itemMessagesArr = array();
                foreach ($messages as $message) {
                    $itemMessageArr = array();
                    $itemMessageArr['type'] = $message['type'];
                    $itemMessageArr['text'] = strip_tags($message['text']);
                    array_push($itemMessagesArr, $itemMessageArr);
                }
                $cartItemArr['item_messages'] = $itemMessagesArr;
            }
            array_push($cartItemsArr, $cartItemArr);
        }
        $orderReviewArr['cart_items'] = $cartItemsArr;
//        $orderReviewArr['order_id'] = $this->getOnepage()->getLastOrderId();
        $orderReviewArr['selected_coupon_id'] = $quote->getCouponCode();
//        $orderReviewArr['shipping_methods'] = $this->getShippingMethods();
        $orderReviewArr['selected_shipping_method_id'] = $quote->getShippingAddress()->getShippingMethod();
        $orderReviewArr['is_virtual'] = $virtual_flag;
        echo json_encode(array(
            'code'=> 0,
            'msg'=> 'get order review success!',
            'model'=> $orderReviewArr
        ));
=======
     * 获取用户地址信息
     */
    public function getAddressByQuoteAction(){
        $quote = Mage::getSingleton('checkout/session')->getQuote();
        if($quote->getId()){
            $address = Mage::getModel('mobile/checkout')->getAddressByQuote($quote);
            echo json_encode(array(
                'code'=>0,
                'msg'=>' get quote address success!',
                'model'=>$address
            ));
        }else{
            echo json_encode(array(
                'code'=>1,
                'msg'=>'can not get quote!',
                'model'=>null
            ));
        }
>>>>>>> 47605a6... add checkout flow address
    }


<<<<<<< HEAD
    public function getShippingMethodAction() {
>>>>>>> 238da50... add shipmethod


    /**
     * 获取订单详细
     */
    public function getOrderReviewAction(){
        $orderReviewArr = array();
        $quote = Mage::getSingleton('checkout/session')->getQuote();
        $cartItemsArr = array();
        $virtual_flag = false;
        foreach ($quote->getAllVisibleItems() as $item) {
            $renderer = new Mage_Checkout_Block_Cart_Item_Renderer();
            $renderer->setItem($item);
            $cartItemArr = array();
            $cartItemArr['item_id'] = $item->getProduct()->getId();
            $cartItemArr['cart_item_id'] = $item->getId();
            $cartItemArr['item_title'] = strip_tags($renderer->getProductName());
            $cartItemArr['qty'] = $renderer->getQty();
            $cartItemArr['product_type'] = $item->getProductType();
            if($item->getProductType()=='bundle'){
                $cartItemArr['bundle_option'] =  Mage::getModel('mobile/cart')->getProductBundleOptions($item);
            }
            if($item->getProductType()=='configurable'){
                $cartItemArr['custom_option'] =  Mage::getModel('mobile/cart')->getCustomOptions($item);
            }
            $icon = $item->getProduct()->getThumbnailUrl();
            $virtual_flag = $item->getProduct()->isVirtual();
            $cartItemArr['thumbnail_pic_url'] = $icon;
            $file = Mage::helper('mobileapi')->urlToPath($icon);
            $exclPrice = $inclPrice = 0.00;
            if (Mage::helper('tax')->displayCartPriceExclTax() || Mage::helper('tax')->displayCartBothPrices()) {
                if (Mage::helper('weee')->typeOfDisplay($item, array(0, 1, 4), 'sales') && $item->getWeeeTaxAppliedAmount()) {
                    $exclPrice = $item->getCalculationPrice() + $item->getWeeeTaxAppliedAmount() + $item->getWeeeTaxDisposition();
                } else {
                    $exclPrice = $item->getCalculationPrice();
                }
            }
            if (Mage::helper('tax')->displayCartPriceInclTax() || Mage::helper('tax')->displayCartBothPrices()) {
                $_incl = Mage::helper('checkout')->getPriceInclTax($item);
                if (Mage::helper('weee')->typeOfDisplay($item, array(0, 1, 4), 'sales') && $item->getWeeeTaxAppliedAmount()) {
                    $inclPrice = $_incl + $item->getWeeeTaxAppliedAmount();
                } else {
                    $inclPrice = $_incl - $item->getWeeeTaxDisposition();
                }
            }
            $exclPrice = Mage::helper('mobileapi')->formatPriceForXml($exclPrice);
            $formatedExclPrice = $quote->getStore()->formatPrice($exclPrice, false);
            $inclPrice = Mage::helper('mobileapi')->formatPriceForXml($inclPrice);
            $formatedInclPrice = $quote->getStore()->formatPrice($inclPrice, false);
            if (Mage::helper('tax')->displayCartBothPrices()) {
                $cartItemArr['price_excluding_tax'] = $exclPrice;
                $cartItemArr['price_including_tax'] = $inclPrice;
            } else {
                if (Mage::helper('tax')->displayCartPriceExclTax()) {
                    $cartItemArr['item_price'] = $exclPrice;
                }
                if (Mage::helper('tax')->displayCartPriceInclTax()) {
                    $cartItemArr['item_price'] = $inclPrice;
                }
            }
            if ($_options = $renderer->getOptionList()) {
                $optionsArr = array();
                foreach ($_options as $_option) {
                    $optionArr = array();
                    $_formatedOptionValue = $renderer->getFormatedOptionValue($_option);
                    $optionsArr = $optionsArr . strip_tags($_option['label']) . ':' . strip_tags($_formatedOptionValue['value']) . ',';
                }
                $optionsArr = substr($optionsArr, 0, strlen($optionsArr) - 1);
                $cartItemArr['skus'] = $optionsArr;
            }
            if ($messages = $renderer->getMessages()) {
                $itemMessagesArr = array();
                foreach ($messages as $message) {
                    $itemMessageArr = array();
                    $itemMessageArr['type'] = $message['type'];
                    $itemMessageArr['text'] = strip_tags($message['text']);
                    array_push($itemMessagesArr, $itemMessageArr);
                }
                $cartItemArr['item_messages'] = $itemMessagesArr;
            }
            array_push($cartItemsArr, $cartItemArr);
        }
        $orderReviewArr['cart_items'] = $cartItemsArr;
//        $orderReviewArr['order_id'] = $this->getOnepage()->getLastOrderId();
        $orderReviewArr['selected_coupon_id'] = $quote->getCouponCode();
//        $orderReviewArr['shipping_methods'] = $this->getShippingMethods();
        $orderReviewArr['selected_shipping_method_id'] = $quote->getShippingAddress()->getShippingMethod();
        $orderReviewArr['is_virtual'] = $virtual_flag;
        echo json_encode(array(
            'code'=> 0,
            'msg'=> 'get order review success!',
            'model'=> $orderReviewArr
        ));
=======
//            $methods = array(array('value'=>'','label'=>Mage::helper('adminhtml')->__('--Please Select--')));
//
//            $activeCarriers = Mage::getSingleton('shipping/config')->getActiveCarriers();
//            foreach($activeCarriers as $carrierCode => $carrierModel)
//            {
//                $options = array();
//                if( $carrierMethods = $carrierModel->getAllowedMethods() )
//                {
//                    foreach ($carrierMethods as $methodCode => $method)
//                    {
//                        $code= $carrierCode.'_'.$methodCode;
//                        $options[]=array('value'=>$code,'label'=>$method);
//
//                    }
//                    $carrierTitle = Mage::getStoreConfig('carriers/'.$carrierCode.'/title');
//
//                }
//                $methods[]=array('value'=>$options,'label'=>$carrierTitle);
//            }
//            echo json_encode($methods);

//        $shipMethodCollection = $this->getQuote()->getShippingAddress()->getShippingMethod();




//        echo $shipMethodCollection->getId();


//        $methods = Mage::getSingleton('shipping/config')->getActiveCarriers();
//        $options = array();
//        foreach($methods as $_code => $_method)
//        {
//            if(!$_title = Mage::getStoreConfig("carriers/$_code/title"))
//                $_title = $_code;
//
//            $options[] = array('value' => $_code, 'label' => $_title . " ($_code)");
//        }

        $this->getQuote()->getShippingAddress()->setCollectShippingRates(true);

        echo json_encode($this->getShippingRates());


>>>>>>> a61c5e3... get cart address api
    }

=======
>>>>>>> 47605a6... add checkout flow address



    /**
     * Get list of available shipping methods
     * @return array
     */
    public function getShippingMethodsListAction(){
        $shippingMethodLists = array();
        $return_result = array (
            'code' => 0,
            'msg' => 'get shipping method list success!',
            'model' => null
        );
        $quoteShippingAddress = Mage::getSingleton('checkout/session')->getQuote()->getShippingAddress();
        $shippingMethod = $quoteShippingAddress->getShippingMethod();
        if (is_null($quoteShippingAddress->getId())) {
            $return_result['msg'] = 'shipping_address_is_not_set';
            $return_result['code'] = 1;
            return;
        }
        $rates = $quoteShippingAddress->getShippingRatesCollection();
        foreach($rates as $rate){
            $temp_rates = array();
            $temp_rates['carrier'] = $rate->getCarrier();
            $temp_rates['carrier_title'] = $rate->getCarrierTitle();
            $temp_rates['code'] = $rate->getCode();
            $temp_rates['method'] = $rate->getMethod();
            $temp_rates['method_title'] = $rate->getMethodTitle();
            $temp_rates['price'] = $rate->getPrice();
            $temp_rates['method_description'] = $rate->getMethodDescription();
            if($rate->getCode() == $shippingMethod){
                $temp_rates['is_selected'] = true;
            }
            array_push($shippingMethodLists,$temp_rates);
        }
        $after_group = array();
        foreach ( $shippingMethodLists as $value ) {
            $after_group[$value['carrier_title']][] = $value;
        }
        $return_result['model'] = $after_group;
        echo json_encode($return_result);

    }



    /**
     * Get list of available shipping methods
     * @return array
     */
    public function getPayMethodsListAction(){
        $quote = Mage::getSingleton('checkout/session')->getQuote();
        $payment_methods = Mage::getModel('mobile/checkout')->getActivePaymentMethods($quote);
        echo json_encode(array(
            'code'=> 0,
            'msg'=> 'get payment methods success!',
            'model'=> $payment_methods
        ));
    }

<<<<<<< HEAD
<<<<<<< HEAD



<<<<<<< HEAD
=======
    public function getAddress() {

         $_address = $this->getQuote()->getShippingAddress();
        return $_address;
    }

    public function getAddressShippingMethod() {
        return $this->getAddress()->getShippingMethod();
=======
>>>>>>> 47605a6... add checkout flow address
=======

    /**
     * Get list of available shipping methods
     * @return array
     */
    public function setPayMethodAction(){
        $return_result = array (
            'code' => 0,
            'msg' => 'save payment method success!',
            'model' => null
        );
        try {
            if ($this->getRequest()->isPost()) {
                $data = $this->getRequest()->getPost('payment', array());
                $saveResult = Mage::getSingleton('checkout/type_onepage')->savePayment($data);
                if (isset($saveResult['error'])) {
                    $result['success'] = false;
                    $result['messages'][] = $saveResult['message'];
                }
                Mage::getSingleton('checkout/type_onepage')->getQuote()->collectTotals()->save();
            } else {
                $result['code'] = 1;
                $result['msg'][] = 'Please specify payment method.';
            }
        } catch (Exception $e) {
            Mage::logException($e);
            $result['code'] = 1;
            $result['msg'][] = 'Unable to set Payment Method.';
        }
        echo json_encode($return_result);
>>>>>>> f438ad5... add checkout address api
    }






<<<<<<< HEAD
    /**
     * 获取订单详细
     */
    public function getOrderReviewAction(){
        $orderReviewArr = array();
        $quote = Mage::getSingleton('checkout/session')->getQuote();
        $cartItemsArr = array();
        $virtual_flag = false;
        foreach ($quote->getAllVisibleItems() as $item) {
            $renderer = new Mage_Checkout_Block_Cart_Item_Renderer();
            $renderer->setItem($item);
            $cartItemArr = array();
            $cartItemArr['item_id'] = $item->getProduct()->getId();
            $cartItemArr['cart_item_id'] = $item->getId();
            $cartItemArr['item_title'] = strip_tags($renderer->getProductName());
            $cartItemArr['qty'] = $renderer->getQty();
            $cartItemArr['product_type'] = $item->getProductType();
            if($item->getProductType()=='bundle'){
                $cartItemArr['bundle_option'] =  Mage::getModel('mobile/cart')->getProductBundleOptions($item);
            }
            if($item->getProductType()=='configurable'){
                $cartItemArr['custom_option'] =  Mage::getModel('mobile/cart')->getCustomOptions($item);
            }
            $icon = $item->getProduct()->getThumbnailUrl();
            $virtual_flag = $item->getProduct()->isVirtual();
            $cartItemArr['thumbnail_pic_url'] = $icon;
            $file = Mage::helper('mobileapi')->urlToPath($icon);
            $exclPrice = $inclPrice = 0.00;
            if (Mage::helper('tax')->displayCartPriceExclTax() || Mage::helper('tax')->displayCartBothPrices()) {
                if (Mage::helper('weee')->typeOfDisplay($item, array(0, 1, 4), 'sales') && $item->getWeeeTaxAppliedAmount()) {
                    $exclPrice = $item->getCalculationPrice() + $item->getWeeeTaxAppliedAmount() + $item->getWeeeTaxDisposition();
                } else {
                    $exclPrice = $item->getCalculationPrice();
                }
            }
            if (Mage::helper('tax')->displayCartPriceInclTax() || Mage::helper('tax')->displayCartBothPrices()) {
                $_incl = Mage::helper('checkout')->getPriceInclTax($item);
                if (Mage::helper('weee')->typeOfDisplay($item, array(0, 1, 4), 'sales') && $item->getWeeeTaxAppliedAmount()) {
                    $inclPrice = $_incl + $item->getWeeeTaxAppliedAmount();
                } else {
                    $inclPrice = $_incl - $item->getWeeeTaxDisposition();
                }
            }
            $exclPrice = Mage::helper('mobileapi')->formatPriceForXml($exclPrice);
            $formatedExclPrice = $quote->getStore()->formatPrice($exclPrice, false);
            $inclPrice = Mage::helper('mobileapi')->formatPriceForXml($inclPrice);
            $formatedInclPrice = $quote->getStore()->formatPrice($inclPrice, false);
            if (Mage::helper('tax')->displayCartBothPrices()) {
                $cartItemArr['price_excluding_tax'] = $exclPrice;
                $cartItemArr['price_including_tax'] = $inclPrice;
            } else {
                if (Mage::helper('tax')->displayCartPriceExclTax()) {
                    $cartItemArr['item_price'] = $exclPrice;
                }
                if (Mage::helper('tax')->displayCartPriceInclTax()) {
                    $cartItemArr['item_price'] = $inclPrice;
                }
            }
            if ($_options = $renderer->getOptionList()) {
                $optionsArr = array();
                foreach ($_options as $_option) {
                    $optionArr = array();
                    $_formatedOptionValue = $renderer->getFormatedOptionValue($_option);
                    $optionsArr = $optionsArr . strip_tags($_option['label']) . ':' . strip_tags($_formatedOptionValue['value']) . ',';
                }
                $optionsArr = substr($optionsArr, 0, strlen($optionsArr) - 1);
                $cartItemArr['skus'] = $optionsArr;
            }
            if ($messages = $renderer->getMessages()) {
                $itemMessagesArr = array();
                foreach ($messages as $message) {
                    $itemMessageArr = array();
                    $itemMessageArr['type'] = $message['type'];
                    $itemMessageArr['text'] = strip_tags($message['text']);
                    array_push($itemMessagesArr, $itemMessageArr);
                }
                $cartItemArr['item_messages'] = $itemMessagesArr;
            }
            array_push($cartItemsArr, $cartItemArr);
        }
        $orderReviewArr['cart_items'] = $cartItemsArr;
//        $orderReviewArr['order_id'] = $this->getOnepage()->getLastOrderId();
        $orderReviewArr['selected_coupon_id'] = $quote->getCouponCode();
//        $orderReviewArr['shipping_methods'] = $this->getShippingMethods();
        $orderReviewArr['selected_shipping_method_id'] = $quote->getShippingAddress()->getShippingMethod();
        $orderReviewArr['is_virtual'] = $virtual_flag;
        echo json_encode(array(
            'code'=> 0,
            'msg'=> 'get order review success!',
            'model'=> $orderReviewArr
        ));
    }


<<<<<<< HEAD
    public function getShippingMethodAction() {
>>>>>>> 238da50... add shipmethod

<<<<<<< HEAD

<<<<<<< HEAD
=======


    /**
     * Get list of available shipping methods
     *
     * @param  $quoteId
     * @param  $store
     * @return array
     */
    public function getShippingMethodsList($quoteId, $store=null)
    {
        $quote = $this->_getQuote($quoteId, $store);
        $quoteShippingAddress = $quote->getShippingAddress();
        echo '123456';
        echo $quoteShippingAddress->getId();
        if (is_null($quoteShippingAddress->getId())) {
            $this->_fault("shipping_address_is_not_set");
        }
        try {
            $quoteShippingAddress->collectShippingRates()->save();
            $groupedRates = $quoteShippingAddress->getGroupedAllShippingRates();
            $ratesResult = array();
            foreach ($groupedRates as $carrierCode => $rates ) {
                echo json_encode($groupedRates);
                echo json_encode($carrierCode);
                echo json_encode($rates);
                $carrierName = $carrierCode;
                if (!is_null(Mage::getStoreConfig('carriers/'.$carrierCode.'/title'))) {
                    $carrierName = Mage::getStoreConfig('carriers/'.$carrierCode.'/title');
                }
                foreach ($rates as $rate) {
                    $rateItem = $this->_getAttributes($rate, "quote_shipping_rate");
                    $rateItem['carrierName'] = $carrierName;
                    $ratesResult[] = $rateItem;
                    unset($rateItem);
                }
            }
        } catch (Mage_Core_Exception $e) {
            echo json_encode($e);
            $this->_fault('shipping_methods_list_could_not_be_retrived', $e->getMessage());
        }
        return $ratesResult;
=======
//            $methods = array(array('value'=>'','label'=>Mage::helper('adminhtml')->__('--Please Select--')));
//
//            $activeCarriers = Mage::getSingleton('shipping/config')->getActiveCarriers();
//            foreach($activeCarriers as $carrierCode => $carrierModel)
//            {
//                $options = array();
//                if( $carrierMethods = $carrierModel->getAllowedMethods() )
//                {
//                    foreach ($carrierMethods as $methodCode => $method)
//                    {
//                        $code= $carrierCode.'_'.$methodCode;
//                        $options[]=array('value'=>$code,'label'=>$method);
//
//                    }
//                    $carrierTitle = Mage::getStoreConfig('carriers/'.$carrierCode.'/title');
//
//                }
//                $methods[]=array('value'=>$options,'label'=>$carrierTitle);
//            }
//            echo json_encode($methods);

//        $shipMethodCollection = $this->getQuote()->getShippingAddress()->getShippingMethod();




//        echo $shipMethodCollection->getId();


//        $methods = Mage::getSingleton('shipping/config')->getActiveCarriers();
//        $options = array();
//        foreach($methods as $_code => $_method)
//        {
//            if(!$_title = Mage::getStoreConfig("carriers/$_code/title"))
//                $_title = $_code;
//
//            $options[] = array('value' => $_code, 'label' => $_title . " ($_code)");
//        }

        $this->getQuote()->getShippingAddress()->setCollectShippingRates(true);

        echo json_encode($this->getShippingRates());


>>>>>>> a61c5e3... get cart address api
    }

=======
>>>>>>> 47605a6... add checkout flow address

<<<<<<< HEAD
>>>>>>> 6a7791a... # This is a combination of 26 commits.
=======
=======
>>>>>>> d27a6ca... add checkout address api
>>>>>>> 3e74e95... temp
}