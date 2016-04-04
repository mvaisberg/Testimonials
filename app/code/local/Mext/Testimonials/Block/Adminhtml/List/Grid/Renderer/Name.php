<?php
class Mext_Testimonials_Block_Adminhtml_List_Grid_Renderer_Name extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

    public function render(Varien_Object $row)
    {
        $value =  $row->getData('customer_first_name').' '.$row->getData('customer_last_name');
        return $value;

    }

}
