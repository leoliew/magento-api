<?php
/**
 * Created by PhpStorm.
 * User: Leo
 * Date: 15/6/4
 * Time: 下午11:41
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 47605a6... add checkout flow address
=======
>>>>>>> 10cea00... # This is a combination of 11 commits.
=======
=======
>>>>>>> 47605a6... add checkout flow address
>>>>>>> 007a8c2... temp
 */

class Lading_Api_Model_Checkout extends Lading_Api_Model_Abstract {

    /**
     * 获取账单
     * @return mixed
     */
    public function getQuote() {
        return Mage::getSingleton('checkout/session')->getQuote();
    }


<<<<<<< HEAD
<<<<<<< HEAD

    /**
     * 获取账单
     * @param $quote
     * @return array
=======
    /**
     * 获取账单
     * @return mixed
>>>>>>> 47605a6... add checkout flow address
=======

    /**
     * 获取账单
     * @param $quote
     * @return array
>>>>>>> f438ad5... add checkout address api
     */
    public function getAddressByQuote($quote) {
        $address = array();
        $shipping_address = $quote->getShippingAddress();
<<<<<<< HEAD
<<<<<<< HEAD
        $billing_address = $quote->getBillingAddress();
=======
<<<<<<< HEAD
        $billing_address = $quote->getShippingAddress();
>>>>>>> 932fc88... temp
=======
<<<<<<< HEAD
        $billing_address = $quote->getShippingAddress();
=======
        $billing_address = $quote->getBillingAddress();
>>>>>>> d27a6ca... add checkout address api
>>>>>>> 3e74e95... temp
        $address['shipping_address'] = array(
            'address_id' => $shipping_address->getCustomerAddressId(),
            'customer_id' =>$shipping_address->getCustomerId(),
            'address_type'=>$shipping_address->getAddressType(),
            'email'=>$shipping_address->getEmail(),
            'firstname'=>$shipping_address->getFirstname(),
            'lastname'=>$shipping_address->getLastname(),
            'company'=>$shipping_address->getCompany(),
            'street'=>$shipping_address->getStreet(),
            'city' =>$shipping_address->getCity(),
            'region' =>$shipping_address->getRegion(),
            'region_id'=>$shipping_address->getRegionId(),
            'postcode'=>$shipping_address->getPostcode(),
            'country_id'=>$shipping_address->getCountryId(),
            'telephone'=>$shipping_address->getTelephone(),
            'fax'=>$shipping_address->getFax(),
            'shipping_method'=>$shipping_address->getShippingMethod(),
            'shipping_description'=>$shipping_address->getShippingDescription(),
            'weight'=>$shipping_address->getWeight(),
            'subtotal'=>$shipping_address->getSubtotal(),
            'base_subtotal'=>$shipping_address->getBaseSubtotal(),
            'subtotal_with_discount' => $shipping_address->getSubtotalWithDiscount(),
            'base_subtotal_with_discount' => $shipping_address->getBaseSubtotalWithDiscount(),
            'tax_amount' => $shipping_address->getTaxAmount(),
            'base_tax_amount' => $shipping_address->getBaseTaxAmount(),
            'shipping_amount' =>$shipping_address->getShippingAmount(),
            'base_shipping_amount' =>$shipping_address->getBaseShippingAmount(),
            'shipping_tax_amount' =>$shipping_address->getShippingTaxAmount(),
            'base_shipping_tax_amount' =>$shipping_address->getBaseShippingTaxAmount(),
            'discount_amount' =>$shipping_address->getDiscountAmount(),
            'base_discount_amount' =>$shipping_address->getBaseDiscountAmount(),
            'grand_total' => $shipping_address->getGrandTotal(),
            'base_grand_total' =>$shipping_address->getBaseGrandTotal()
        );
        $address['billing_address'] = array(
            'address_id' => $billing_address->getCustomerAddressId(),
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
>>>>>>> 3e74e95... temp
//            'customer_id' =>$shipping_address>getCustomerId(),
//            'address_type'=>$shipping_address->getAddressType(),
//            'email'=>$shipping_address->getEmail(),
//            'firstname'=>$shipping_address->getFirstname(),
//            'lastname'=>$shipping_address->getLastname(),
//            'company'=>$shipping_address->getCompany(),
//            'street'=>$shipping_address->getStreet(),
//            'city' =>$shipping_address->getCity(),
//            'region' =>$shipping_address->getRegion(),
//            'region_id'=>$shipping_address->getRegionId(),
//            'postcode'=>$shipping_address->getPostcode(),
//            'country_id'=>$shipping_address->getCountryId(),
//            'telephone'=>$shipping_address->getTelephone(),
//            'fax'=>$shipping_address->getFax(),
//            'shipping_method'=>$shipping_address->getShippingMethod(),
//            'shipping_description'=>$shipping_address->getShippingDescription(),
//            'weight'=>$shipping_address->getWeight(),
//            'subtotal'=>$shipping_address->getSubtotal(),
//            'base_subtotal'=>$shipping_address->getBaseSubtotal(),
//            'subtotal_with_discount' => $shipping_address->getSubtotalWithDiscount(),
//            'base_subtotal_with_discount' => $shipping_address->getBaseSubtotalWithDiscount(),
//            'tax_amount' => $shipping_address->getTaxAmount(),
//            'base_tax_amount' => $shipping_address->getBaseTaxAmount(),
//            'shipping_amount' =>$shipping_address->getShippingAmount(),
//            'base_shipping_amount' =>$shipping_address->getBaseShippingAmount(),
//            'shipping_tax_amount' =>$shipping_address->getShippingTaxAmount(),
//            'base_shipping_tax_amount' =>$shipping_address->getBaseShippingTaxAmount(),
//            'discount_amount' =>$shipping_address->getDiscountAmount(),
//            'base_discount_amount' =>$shipping_address->getBaseDiscountAmount(),
//            'grand_total' => $shipping_address->getGrandTotal(),
//            'base_grand_total' =>$shipping_address->getBaseGrandTotal()
=======
        $billing_address = $quote->getBillingAddress();
        $address['shipping_address'] = array(
            'address_id' => $shipping_address->getCustomerAddressId(),
            'customer_id' =>$shipping_address->getCustomerId(),
            'address_type'=>$shipping_address->getAddressType(),
            'email'=>$shipping_address->getEmail(),
            'firstname'=>$shipping_address->getFirstname(),
            'lastname'=>$shipping_address->getLastname(),
            'company'=>$shipping_address->getCompany(),
            'street'=>$shipping_address->getStreet(),
            'city' =>$shipping_address->getCity(),
            'region' =>$shipping_address->getRegion(),
            'region_id'=>$shipping_address->getRegionId(),
            'postcode'=>$shipping_address->getPostcode(),
            'country_id'=>$shipping_address->getCountryId(),
            'telephone'=>$shipping_address->getTelephone(),
            'fax'=>$shipping_address->getFax(),
            'shipping_method'=>$shipping_address->getShippingMethod(),
            'shipping_description'=>$shipping_address->getShippingDescription(),
            'weight'=>$shipping_address->getWeight(),
            'subtotal'=>$shipping_address->getSubtotal(),
            'base_subtotal'=>$shipping_address->getBaseSubtotal(),
            'subtotal_with_discount' => $shipping_address->getSubtotalWithDiscount(),
            'base_subtotal_with_discount' => $shipping_address->getBaseSubtotalWithDiscount(),
            'tax_amount' => $shipping_address->getTaxAmount(),
            'base_tax_amount' => $shipping_address->getBaseTaxAmount(),
            'shipping_amount' =>$shipping_address->getShippingAmount(),
            'base_shipping_amount' =>$shipping_address->getBaseShippingAmount(),
            'shipping_tax_amount' =>$shipping_address->getShippingTaxAmount(),
            'base_shipping_tax_amount' =>$shipping_address->getBaseShippingTaxAmount(),
            'discount_amount' =>$shipping_address->getDiscountAmount(),
            'base_discount_amount' =>$shipping_address->getBaseDiscountAmount(),
            'grand_total' => $shipping_address->getGrandTotal(),
            'base_grand_total' =>$shipping_address->getBaseGrandTotal()
        );
        $address['billing_address'] = array(
            'address_id' => $billing_address->getCustomerAddressId(),
<<<<<<< HEAD
>>>>>>> 932fc88... temp
=======
=======
>>>>>>> d27a6ca... add checkout address api
>>>>>>> 3e74e95... temp
            'customer_id' =>$billing_address->getCustomerId(),
            'address_type'=>$billing_address->getAddressType(),
            'email'=>$billing_address->getEmail(),
            'firstname'=>$billing_address->getFirstname(),
            'lastname'=>$billing_address->getLastname(),
            'company'=>$billing_address->getCompany(),
            'street'=>$billing_address->getStreet(),
            'city' =>$billing_address->getCity(),
            'region' =>$billing_address->getRegion(),
            'region_id'=>$billing_address->getRegionId(),
            'postcode'=>$billing_address->getPostcode(),
            'country_id'=>$billing_address->getCountryId(),
            'telephone'=>$billing_address->getTelephone(),
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 007a8c2... temp
=======
>>>>>>> 081c1ed... temp
=======
>>>>>>> fa319b9... temp
=======
<<<<<<< HEAD
>>>>>>> c50a252... temp
            'fax'=>$billing_address->getFax()
=======
            'fax'=>$billing_address->getFax(),
>>>>>>> 47605a6... add checkout flow address
<<<<<<< HEAD
=======
            'fax'=>$billing_address->getFax()
>>>>>>> f438ad5... add checkout address api
=======
>>>>>>> 932fc88... temp
<<<<<<< HEAD
>>>>>>> 007a8c2... temp
=======
=======
=======
>>>>>>> 3e74e95... temp
=======
>>>>>>> a398721... temp
=======
>>>>>>> c729d71... temp
=======
>>>>>>> 695332c... temp
            'fax'=>$billing_address->getFax(),
>>>>>>> 47605a6... add checkout flow address
=======
            'fax'=>$billing_address->getFax()
>>>>>>> f438ad5... add checkout address api
<<<<<<< HEAD
>>>>>>> aa2bb30... temp
<<<<<<< HEAD
>>>>>>> 081c1ed... temp
=======
=======
=======
            'fax'=>$billing_address->getFax(),
>>>>>>> d27a6ca... add checkout address api
<<<<<<< HEAD
>>>>>>> 3e74e95... temp
<<<<<<< HEAD
>>>>>>> fa319b9... temp
=======
=======
=======
            'fax'=>$billing_address->getFax()
>>>>>>> 3316428... add checkout address api
<<<<<<< HEAD
>>>>>>> a398721... temp
=======
=======
            'fax'=>$billing_address->getFax(),
>>>>>>> 35d6aa1... Revert "add checkout address api"
<<<<<<< HEAD
>>>>>>> c729d71... temp
=======
=======
            'fax'=>$billing_address->getFax()
>>>>>>> 9ce3a5f... fix
>>>>>>> 695332c... temp
>>>>>>> c50a252... temp
        );
        return $address;
    }



<<<<<<< HEAD
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> f438ad5... add checkout address api
=======
>>>>>>> 9ce3a5f... fix
>>>>>>> c50a252... temp
    /**
     * get active payment method
     * @param $quote
     * @return array
     */
    public function getActivePaymentMethods($quote){
        $quote_payment_code = $quote->getPayment()->getMethodInstance()->getCode();
        $payments = Mage::getSingleton('payment/config')->getActiveMethods();
        $methods = array();
        foreach ($payments as $paymentCode=>$paymentModel) {
            $paymentTitle = Mage::getStoreConfig('payment/'.$paymentCode.'/title');
            if($paymentCode != 'free'){
                $methods[$paymentCode] = array(
                    'title'   => $paymentTitle,
                    'code' => $paymentCode
                );
                if($paymentCode == $quote_payment_code){
                    $methods[$paymentCode]['is_selected'] = true;
                }
            }
        }
        return $methods;
    }

<<<<<<< HEAD
<<<<<<< HEAD
=======

>>>>>>> 3316428... add checkout address api
=======
>>>>>>> 35d6aa1... Revert "add checkout address api"
=======

>>>>>>> 9ce3a5f... fix

<<<<<<< HEAD

<<<<<<< HEAD
}
=======
 */
>>>>>>> 90ff47e... add magento model
=======
<<<<<<< HEAD
=======
>>>>>>> f438ad5... add checkout address api

}
<<<<<<< HEAD
>>>>>>> 47605a6... add checkout flow address
=======
=======
 */
>>>>>>> 90ff47e... add magento model
>>>>>>> 10cea00... # This is a combination of 11 commits.
=======
}
>>>>>>> 47605a6... add checkout flow address
>>>>>>> 007a8c2... temp
