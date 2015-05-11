<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 6/5/15
 * Time: 3:17 PM
 */

class Lading_Api_Model_Address extends Lading_Api_Model_Abstract {

    /**
     * 获取用户地址列表
     * @param $customer
     * @return array
     */
    public function getCustomerAddressList($customer) {
        $default_billing_id = $customer->getDefaultBilling();
        $default_shipping_id = $customer->getDefaultShipping();
        $addressList = array();
        foreach ($customer->getAddresses() as $key=>$address) {
            $addressTemp = array(
                'entity_id' => $address->getId(),
                'entity_type_id' => $address->getEntityTypeId(),
                'name' => $address->getName(),
                'country' => $address->getCountry(),
                'attribute_set_id' => $address->getAttributeSetId(),
                'parent_id' => $address->getParentId(),
                'created_at' => $address->getCreatedAt(),
                'updated_at' => $address->getUpdatedAt(),
                'is_active' => $address->getIsActive(),
                'firstname' => $address->getFirstname(),
                'lastname' => $address->getLastname(),
                'company' => $address->getCompany(),
                'city' => $address->getCity(),
                'region' => $address->getRegion(),
                'postcode' => $address->getPostcode(),
                'country_id' => $address->getCountryId(),
                'telephone' => $address->getTelephone(),
                'fax' => $address->getFax(),
                'region_id' => $address->getRegionId(),
                'street' => $address->getStreet(),
                'customer_id' => $address->getCustomerId()
            );
            if ($default_billing_id == $address->getId()) {
                $addressTemp['is_default_billing'] = true;
            }
            if ($default_shipping_id == $address->getId()) {
                $addressTemp['is_default_shipping'] = true;
            }
            array_push($addressList, $addressTemp);
        }
        return $addressList;
    }



    public function getAddressById($address_id){
        $address = Mage::getModel('customer/address')->load($address_id);
        if (!$address->getId()) {
//            $result['code'] = 1;
//            $result['msg'] = 'not_exists';
//            json_encode($result);
            return 'not_exists';
        }
        $return_address = array(
            'entity_id' => $address->getId(),
            'entity_type_id' => $address->getEntityTypeId(),
            'name' => $address->getName(),
            'country' => $address->getCountry(),
            'attribute_set_id' => $address->getAttributeSetId(),
            'parent_id' => $address->getParentId(),
            'created_at' => $address->getCreatedAt(),
            'updated_at' => $address->getUpdatedAt(),
            'is_active' => $address->getIsActive(),
            'firstname' => $address->getFirstname(),
            'lastname' => $address->getLastname(),
            'company' => $address->getCompany(),
            'city' => $address->getCity(),
            'region' => $address->getRegion(),
            'postcode' => $address->getPostcode(),
            'country_id' => $address->getCountryId(),
            'telephone' => $address->getTelephone(),
            'fax' => $address->getFax(),
            'region_id' => $address->getRegionId(),
            'street' => $address->getStreet(),
            'customer_id' => $address->getCustomerId()
        );
        if ($customer = $address->getCustomer()) {
            $return_address['is_default_billing']  = $customer->getDefaultBilling() == $address->getId();
            $return_address['is_default_shipping'] = $customer->getDefaultShipping() == $address->getId();
        }
        return $return_address;
    }



}