<?php

class Mext_Testimonials_Helper_Data extends Mage_Core_Helper_Abstract{

    public function getCustomerData(){
        $collection = Mage::getModel('customer/customer')->getCollection()
            ->addAttributeToSelect('email')
            ->addAttributeToSelect('firstname')
            ->addAttributeToSelect('lastname')
            ->addAttributeToSort('email', 'ASC');
        if($collection->getSize() > 0){
            foreach($collection as $c){
                $data[$c->getId()] = $c->getData('firstname').' '.$c->getData('lastname');
            }
        }else{
            return false;
        }
        return $data;
    }

}