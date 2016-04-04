<?php

class Mext_Testimonials_Block_List extends Mage_Core_Block_Template{

    public function __construct()
    {
        parent::__construct();
        $collection = Mage::getModel('mext_testimonials/testimonials')->getCollection()
            ->addFieldToSelect('*')
            ->addFieldToFilter('status', 1)
            ->setOrder('created_time', 'desc')
            ->addFieldToFilter('ce2.attribute_id', array('eq' => array(5)))
            ->addFieldToFilter('ce3.attribute_id', array('eq' => array(7)));
        $collection->getSelect()
            ->join( array('ce1' => 'customer_entity'), 'ce1.entity_id=main_table.customer_id', array('customer_email' => 'email'))
            ->join( array('ce2' => 'customer_entity_varchar'), 'ce2.entity_id=ce1.entity_id', array('first_name' => 'value'))
            ->join( array('ce3' => 'customer_entity_varchar'), 'ce3.entity_id=ce1.entity_id', array('last_name' => 'value'));
        $this->setCollection($collection);
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $pager = $this->getLayout()->createBlock('page/html_pager', 'testimonials.pager');
        $pager->setAvailableLimit(array(5=>5,10=>10,20=>20));
        $pager->setCollection($this->getCollection());

        $this->setChild('pager', $pager);
        $this->getCollection()->load();
        return $this;
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

}