<?php

class Mext_Testimonials_Block_List extends Mage_Core_Block_Template{

    public function __construct()
    {
        parent::__construct();
        $collection = Mage::getModel('mext_testimonials/testimonials')->getCollection()
            ->addFieldToSelect('*')
            ->addFieldToFilter('status', 1)
            ->setOrder('created_time', 'desc');
        $this->setCollection($collection);
    }

    protected function getTestimonialsCollection()
    {
        $testimonials = $this->getCollection();
        foreach ($testimonials as $i => $testimonial) {
            $data[$i] = $testimonial->getData();
            $customer = Mage::getModel('customer/customer')->load($testimonial->getData('customer_id'));
            $data[$i]['name'] = $customer->getData('firstname').' '.$customer->getData('lastname');
        }
        return $data;
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $pager = $this->getLayout()->createBlock('page/html_pager', 'testimonials.pager')
            ->setCollection($this->getCollection());
        $pager->setAvailableLimit(array(5=>5,10=>10,20=>20));

        $this->setChild('pager', $pager);
        $this->getCollection()->load();
        return $this;
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

}