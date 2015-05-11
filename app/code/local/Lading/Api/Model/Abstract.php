<?php
/**
 * Created by PhpStorm.
 * User: Leo
 * Date: 15/6/4
 * Time: 下午11:05
 */

abstract class  Lading_Api_Model_Abstract extends Mage_Core_Model_Abstract {

    protected $_attributes;

    public function getAttributes() {
        if (is_null($this->_attributes)) {
            $this->_attributes = array();
            $config = Mage::getSingleton('eav/config');
            foreach ($config->getEntityAttributeCodes('customer_address') as $attributeCode) {
                $this->_attributes[$attributeCode] = $config->getAttribute('customer_address', $attributeCode);
            }
        }
        return $this->_attributes;
    }

}