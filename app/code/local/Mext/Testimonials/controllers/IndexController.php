<?php

class Mext_Testimonials_IndexController extends Mage_Core_Controller_Front_Action
{
    public function preDispatch()
    {
        parent::preDispatch();
        if (!Mage::getStoreConfigFlag('testimonials/general/enabled', null)) {
            $this->setFlag('', 'no-dispatch', true);
            $this->_redirect('noRoute');
        }
    }

    public function indexAction(){
        $this->loadLayout();
        $this->renderLayout();
    }

    public function saveAction()
    {
        if (!$data = $this->getRequest()->getParams()) {
            $this->_redirect('*/*/');
            return;
        }

        if(!Mage::getSingleton('customer/session')->isLoggedIn()){
            Mage::getSingleton('customer/session')->setBeforeAuthUrl($this->helper('core/url')->getCurrentUrl());
            $this->_redirect('customer/account/login');
            return;
        }

        $model = Mage::getModel('mext_testimonials/testimonials');
        if ($id = $this->getRequest()->getParam('entity_id')) {
            $model->load($id);
        }

        try {
            $store = Mage::app()->getStore();
            $approveAuto = Mage::getStoreConfig('testimonials/general/approve', $store);
            if($approveAuto){
                $data['status'] = $model::STATUS_ENABLED;
            }else{
                $data['status'] = $model::STATUS_PENDING;
            }
            $model->addData($data);
            $model->save();

            Mage::getSingleton('core/session')->addSuccess(
                Mage::helper('testimonials')->__('Testimonial has been saved.')
            );
            Mage::getSingleton('core/session')->setFormData(false);
            if ($this->getRequest()->getParam('back')) {
                $this->_redirect('*/*/edit', array('testimonial_id' => $model->getId(), '_current' => true));
                return;
            }
            $this->_redirect('*/*/');
            return;
        } catch (Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        }
        $this->_getSession()->setFormData($data);
        $this->_redirect('*/*/edit', array('entity_id' => $this->getRequest()->getParam('entity_id'), '_current'=>true));
    }

}