<?php
class Mext_Testimonials_Adminhtml_IndexController extends Mage_Adminhtml_Controller_Action
{

    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('mext/testimonials')
            ->_addBreadcrumb(Mage::helper('testimonials')->__('Testimonials'), Mage::helper('testimonials')->__('Testimonials List'));
        return $this;
    }

    public function indexAction()
    {
        $this->_title($this->__('Mext'))
            ->_title($this->__('Testimonials'));

        $this->_initAction();
        $this->_addContent($this->getLayout()->createBlock('testimonials/adminhtml_list'));
        $this->renderLayout();
    }

    public function newAction()
    {
        $this->editAction();
    }

    public function editAction()
    {
        $this->_title($this->__('Mext'))
            ->_title($this->__('Edit Testimonials'));

        $id = $this->getRequest()->getParam('entity_id');
        $model = Mage::getModel('mext_testimonials/testimonials');

        if ($id) {
            $model->load($id);
            if (! $model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('testimonials')->__('This page no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }

        $this->_title($model->getId() ? $model->getName() : $this->__('New Testimonial'));

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (! empty($data)) {
            $model->setData($data);
        }

        Mage::register('testimonials_data', $model);

        $this->_initAction();
        $this->_addContent($this->getLayout()->createBlock('testimonials/adminhtml_list_edit'));
        $this->renderLayout();
    }

    public function saveAction()
    {
        if (!$data = $this->getRequest()->getParams()) {
            $this->_redirect('*/*/');
            return;
        }

        $model = Mage::getModel('mext_testimonials/testimonials');
        if ($id = $this->getRequest()->getParam('entity_id')) {
            $model->load($id);
        }

        try {
            $model->addData($data);
            $model->save();

            Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('testimonials')->__('Testimonial has been saved.')
            );
            Mage::getSingleton('adminhtml/session')->setFormData(false);
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


    public function deleteAction()
    {
        if ($id = $this->getRequest()->getParam('entity_id')) {
            try {
                $model = Mage::getModel('mext_testimonials/testimonials');
                $model->load($id);
                $model->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('testimonials')->__('The testimonial has been deleted.'));
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('entity_id' => $id));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('testimonials')->__('Unable to find a testimonial to delete.'));
        $this->_redirect('*/*/');
    }

    public function massDeleteAction()
    {
        $testimonialsIds = $this->getRequest()->getParam('testimonials');
        if (!is_array($testimonialsIds)) {
            $this->_getSession()->addError($this->__('Please select testimonial(s).'));
        } else {
            if (!empty($testimonialsIds)) {
                try {
                    foreach ($testimonialsIds as $testimonialId) {
                        $testimonial = Mage::getModel('mext_testimonials/testimonials')->load($testimonialId);
                        $testimonial->delete();
                    }
                    $this->_getSession()->addSuccess(
                        $this->__('Total of %d record(s) have been deleted.', count($testimonialsIds))
                    );
                } catch (Exception $e) {
                    $this->_getSession()->addError($e->getMessage());
                }
            }
        }
        $this->_redirect('*/*/index');
    }

    public function massApproveAction()
    {
        $testimonialsIds = $this->getRequest()->getParam('testimonials');
        if (!is_array($testimonialsIds)) {
            $this->_getSession()->addError($this->__('Please select testimonial(s).'));
        } else {
            if (!empty($testimonialsIds)) {
                try {
                    foreach ($testimonialsIds as $testimonialId) {
                        $testimonial = Mage::getModel('mext_testimonials/testimonials')->load($testimonialId);
                        $testimonial->setStatus(1);
                        $testimonial->save();
                    }
                    $this->_getSession()->addSuccess(
                        $this->__('Total of %d record(s) have been updated.', count($testimonialsIds))
                    );
                } catch (Exception $e) {
                    $this->_getSession()->addError($e->getMessage());
                }
            }
        }
        $this->_redirect('*/*/index');
    }
}