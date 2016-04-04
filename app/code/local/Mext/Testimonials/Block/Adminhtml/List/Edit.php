<?php
class Mext_Testimonials_Block_Adminhtml_List_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {

        $this->_blockGroup = 'testimonials';
        $this->_objectId   = 'entity_id';
        $this->_controller = 'adminhtml_list';

        parent::__construct();

        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save and Continue Edit'),
            'onclick'   => 'saveAndContinueEdit(\''.$this->_getSaveAndContinueUrl().'\')',
            'class'     => 'save',
        ), -100);
        $this->_formScripts[] = "
             function saveAndContinueEdit(){
                editForm.submit($('edit_form').action + 'back/edit/');
             }";

    }

    public function getHeaderText()
    {
        if (Mage::registry('testimonials_data')->getId()) {
            return Mage::helper('testimonials')->__("Edit Testimonial");
        }
        else {
            return Mage::helper('testimonials')->__('New Testimonial');
        }
    }


    public function getSaveUrl()
    {
        return $this->getUrl('*/*/save', array(
            '_current' => true
        ));
    }

    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl('*/*/save', array(
            '_current'   => true,
            'back'       => 'edit',
        ));
    }

    protected function _getApproveUrl()
    {
        return $this->getUrl('*/*/approve', array(
            '_current'   => true
        ));
    }


}