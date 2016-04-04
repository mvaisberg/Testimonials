<?php

class Mext_Testimonials_Model_Resource_Testimonials_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('mext_testimonials/testimonials');
    }
}