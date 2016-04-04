<?php
class Mext_Testimonials_Block_Adminhtml_List_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('testimonials_list');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('mext_testimonials/testimonials')->getCollection()
            ->addFieldToFilter('ce2.attribute_id', array('eq' => array(5)))
            ->addFieldToFilter('ce3.attribute_id', array('eq' => array(7)));
        $collection->getSelect()
            ->join( array('ce1' => 'customer_entity'), 'ce1.entity_id=main_table.customer_id', array('customer_email' => 'email'))
            ->join( array('ce2' => 'customer_entity_varchar'), 'ce2.entity_id=ce1.entity_id', array('customer_first_name' => 'value'))
            ->join( array('ce3' => 'customer_entity_varchar'), 'ce3.entity_id=ce1.entity_id', array('customer_last_name' => 'value'));


        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('entity_id', array(
            'header'   => Mage::helper('testimonials')->__('Id'),
            'index'    => 'entity_id',
            'width'    => 50
        ));

        $this->addColumn('customer_first_name', array(
            'header'   => Mage::helper('testimonials')->__('Name'),
            'index'    => 'customer_first_name',
            'renderer' => new Mext_Testimonials_Block_Adminhtml_List_Grid_Renderer_Name,
            'filter_condition_callback' => array($this, '_nameFilter'),
        ));

        $this->addColumn('customer_email', array(
            'header'   => Mage::helper('testimonials')->__('Email'),
            'index'    => 'customer_email',
            'filter_condition_callback' => array($this, '_emailFilter'),
        ));


        $this->addColumn('created_time', array(
            'header'   => Mage::helper('testimonials')->__('Created Time'),
            'index'    => 'created_time',
            'type' => 'datetime'
        ));

        $this->addColumn('update_time', array(
            'header'   => Mage::helper('testimonials')->__('Update Time'),
            'index'    => 'update_time',
            'type' => 'datetime'
        ));

        $statusArray = Mage::getModel('mext_testimonials/testimonials')->getStatus();

        $this->addColumn('status', array(
            'header'   => Mage::helper('testimonials')->__('Status'),
            'index'    => 'status',
            'type'     => 'options',
            'options'  => $statusArray
        ));
        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('testimonials');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'=> Mage::helper('testimonials')->__('Delete'),
             'url'  => $this->getUrl('*/*/massDelete'),
             'confirm' => Mage::helper('catalog')->__('Are you sure?')
        ));

        $this->getMassactionBlock()->addItem('approve', array(
            'label'=> Mage::helper('testimonials')->__('Approve'),
            'url'  => $this->getUrl('*/*/massApprove')
        ));

        return $this;
    }

    protected function _nameFilter($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return $this;
        }

        $this->getCollection()->getSelect()->where(new Zend_Db_Expr("(ce2.value like '%".$value."%' OR ce3.value like '%".$value."%')"));


        return $this;
    }

    protected function _emailFilter($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return $this;
        }

        $this->getCollection()->getSelect()->where(
            "ce1.email like ?"
            , "%$value%");


        return $this;
    }


    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('entity_id' => $row->getId()));
    }

}