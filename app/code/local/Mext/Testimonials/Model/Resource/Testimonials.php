<?php

class Mext_Testimonials_Model_Resource_Testimonials extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('mext_testimonials/testimonials','entity_id');
    }

}