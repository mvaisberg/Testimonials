<?php

class Mext_Testimonials_Block_Adminhtml_List_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareForm()
    {
        $model = Mage::registry('testimonials_data');
        $form = new Varien_Data_Form(array(
            'id'        => 'edit_form',
            'action'    => $this->getData('action'),
            'method'    => 'post',
            'enctype'   => 'multipart/form-data'
        ));

        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend' => Mage::helper('testimonials')->__('Testimonial Information'),
            'class' => 'fieldset-wide'
        ));

        if ($model->getId()) {
            $fieldset->addField('entity_id', 'hidden', array(
                'name'  => 'entity_id'
            ));
        }

        $customerData = Mage::helper('testimonials/data')->getCustomerData();

        $fieldset->addField('customer_id', 'select', array(
            'name'     => 'customer_id',
            'label'    => Mage::helper('catalog')->__('Customer'),
            'title'    => Mage::helper('catalog')->__('Customer'),
            'required' => true,
            'values' => $customerData,
        ));


        $fieldset->addField('message', 'textarea', array(
            'name'     => 'message',
            'label'    => Mage::helper('catalog')->__('Message'),
            'title'    => Mage::helper('catalog')->__('Message'),
            'required' => true,
        ));

        $statusArray = Mage::getModel('mext_testimonials/testimonials')->getStatus();

        $fieldset->addField('status', 'select', array(
            'name'     => 'status',
            'label'    => Mage::helper('catalog')->__('Status'),
            'title'    => Mage::helper('catalog')->__('Status'),
            'required' => true,
            'values' => $statusArray,
        ));

        if ($model->getId()) {
            $form->setValues($model->getData());
        }


        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }

}
