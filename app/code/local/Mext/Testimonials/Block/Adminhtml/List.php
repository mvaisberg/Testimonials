<?php

class Mext_Testimonials_Block_Adminhtml_List extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'testimonials';
        $this->_controller = 'adminhtml_list';
        $this->_headerText = Mage::helper('testimonials')->__('Testimonials List');

        parent::__construct();
    }

}
