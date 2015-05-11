<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 5/14/15
 * Time: 2:27 PM
 */


/**
 * Class Lading_Api_CustomerController
 */
class Lading_Api_AddressController extends Mage_Core_Controller_Front_Action
{

    /**
     * 获取用户地址列表
     */
    public function getAddressListAction(){
        $result = array (
            'code' => 0,
            'msg' => null,
            'model' => null
        );
        $session = Mage::getSingleton('customer/session');
        if (!$session->isLoggedIn()) {
            $result['code'] = 5;
            $result['msg'] = 'user is not login';
            echo json_encode($result);
            return;
        }
        $customer = Mage::getSingleton('customer/session')->getCustomer();
        $addressList = Mage::getModel('mobile/address')->getCustomerAddressList($customer);
        echo json_encode(
            array(
                'code' => 0,
                'msg' => 'get user address list success!',
                'model' => $addressList
            )
        );
    }



    /**
     * 获取用户地址
     */
    public function getAddressAction(){
        $result = array (
            'code' => 0,
            'msg' => null,
            'model' => null
        );
        $session = Mage::getSingleton('customer/session');
        if (!$session->isLoggedIn()) {
            $result['code'] = 5;
            $result['msg'] = 'user is not login';
            echo json_encode($result);
            return;
        }
        $addressId = $this->getRequest()->getParam( 'address_id' );
        $return_address = Mage::getModel('mobile/address')->getAddressById($addressId);
        echo json_encode(
            array(
                'code' => 0,
                'msg' => 'get user address success!',
                'model' => $return_address
            )
        );
    }




    /**
     * Delete address
     * @return boolean
     */
    public function deleteAction(){
        $addressId = $this->getRequest()->getParam ( 'address_id' );
        $result = array (
            'code' => 0,
            'msg' => null,
            'model' => true
        );
        $address = Mage::getModel('customer/address')
            ->load($addressId);
        if (!$address->getId()) {
            $result['msg'] = 'not_exists';
            $result['model'] = false;
        }
        try {
            $address->delete();
        } catch (Mage_Core_Exception $e) {
            $result['msg'] = $e->getMessage();
            $result['model'] = false;
        }
        echo json_encode($result);
    }

    /**
     * Create new address for customer
     * @return mixed
     */
    public function createAction(){
        $session = Mage::getSingleton('customer/session');
        $result = array (
            'code' => 0,
            'msg' => null,
            'model' => null
        );
        if (!$session->isLoggedIn()) {
            $result['code'] = 5;
            $result['msg'] = 'user is not login';
            echo json_encode($result);
            return;
        }
        $addressData = array();
        $addressData['address_book_id'] = $_REQUEST['address_book_id'];
        $addressData['address_type'] = $_REQUEST['address_type'];
        $addressData['lastname'] = $_REQUEST['lastname'];
        $addressData['firstname'] = $_REQUEST['firstname'];
        $addressData['suffix'] = $_REQUEST['suffix'];
        $addressData['telephone'] = $_REQUEST['telephone'];
        $addressData['company'] = $_REQUEST['company'];
        $addressData['fax'] = $_REQUEST['fax'];
        $addressData['postcode'] = $_REQUEST['postcode'];
        $addressData['city'] = $_REQUEST['city'];
        $addressData['address1'] = $_REQUEST['address1'];
        $addressData['address2'] = $_REQUEST['address2'];
        $addressData['country_name'] = $_REQUEST['country_name'];
        $addressData['country_id'] = $_REQUEST['country_id'];
        $addressData['state'] = $_REQUEST['state'];
        $addressData['zone_name'] = $_REQUEST['zone_name'];
        $addressData['zone_id'] = $_REQUEST['zone_id'];
        if (!is_null($addressData)) {
            $customer = $session->getCustomer();
            $address = Mage::getModel('customer/address');
            $addressId = $addressData['address_book_id'];
            if ($addressId) {
                $existsAddress = $customer->getAddressById($addressId);
                if ($existsAddress->getId() && $existsAddress->getCustomerId() == $customer->getId()) {
                    $address->setId($existsAddress->getId());
                }
            }
            $errors = array();
            try {
                $addressType = explode(',', $addressData['address_type']);
                $address->setCustomerId($customer->getId())
                    ->setIsDefaultBilling(strtolower($addressType[0]) == 'billing' || strtolower($addressType[1]) == 'billing')
                    ->setIsDefaultShipping(strtolower($addressType[0]) == 'shipping' || strtolower($addressType[1]) == 'shipping');
                $address->setLastname($addressData['lastname']);
                $address->setFirstname($addressData['firstname']);
                $address->setSuffix($addressData['suffix']);
                $address->setTelephone($addressData['telephone']);
                $address->setCompany($addressData['company']);
                $address->setFax($addressData['fax']);
                $address->setPostcode($addressData['postcode']);
                $address->setCity($addressData['city']);
                $address->setStreet(array($addressData['address1'], $addressData['address2']));
                $address->setCountry($addressData['country_name']);
                $address->setCountryId($addressData['country_id']);
                if (isset($addressData['state'])) {
                    $address->setRegion($addressData['state']);
                    $address->setRegionId(null);
                } else {
                    $address->setRegion($addressData['zone_name']);
                    $address->setRegionId($addressData['zone_id']);
                }
                $addressErrors = $address->validate();
                if ($addressErrors !== true) {
                    $errors = array_merge($errors, $addressErrors);
                }
                $addressValidation = count($errors) == 0;
                if (true === $addressValidation) {
                    $address->save();
                    $result['code'] = 0;
                    $result['msg'] = 'save or update user address success!';
                    echo json_encode($result);
                    return;
                } else {
                    if (is_array($errors)) {
                        $result['code'] = 3;
                        $result['msg'] = $errors;
                    } else {
                        $result['code'] = 3;
                        $result['msg'] = 'Can\'t save or update address';
                    }
                    echo json_encode($result);
                    return;
                }
            } catch (Mage_Core_Exception $e) {
                $result['code'] = 4;
                $result['msg'] = $e->getMessage();
                echo json_encode($result);
                return;
            } catch (Exception $e) {
                $result['code'] = 5;
                $result['msg'] = $e->getMessage();
                echo json_encode($result);
                return;
            }
        } else {
            $result['code'] = 6;
            $result['msg'] = 'address data is null!';
            echo json_encode($result);
            return;
        }
    }
}

