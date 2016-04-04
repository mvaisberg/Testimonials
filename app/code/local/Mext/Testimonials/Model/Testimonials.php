<?php
class Mext_Testimonials_Model_Testimonials extends Mage_Core_Model_Abstract
{

    const STATUS_PENDING = 2;
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    public function __construct()
    {
        $this->_init('mext_testimonials/testimonials');
        parent::_construct();
    }

    public function getStatus()
    {
        $status = array(
            $this::STATUS_PENDING => Mage::helper('testimonials')->__('Pending'),
            $this::STATUS_ENABLED => Mage::helper('testimonials')->__('Enabled'),
            $this::STATUS_DISABLED => Mage::helper('testimonials')->__('Disabled')
        );

        return $status;
    }
}