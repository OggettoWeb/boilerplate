<?php
/**
 * Oggetto Web extenstion for Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade
 * the Oggetto Question module to newer versions in the future.
 * If you wish to customize the Oggetto Question module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Oggetto
 * @package    Oggetto_Question
 * @copyright  Copyright (C) 2014 Oggetto Web (http://oggettoweb.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Question index controller
 *
 * @category   Oggetto
 * @package    Oggetto_Question
 * @subpackage controller
 * @author     Danil Pavlov <dpavlov@oggettoweb.com>
 */

class Oggetto_Question_Adminhtml_QuestionController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Index action
     *
     * @return void
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Ajax grid action
     *
     * @return void
     */
    public function gridAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function massDeleteAction()
    {
        $session = $this->_getSession();
        try {
            $ids = $this->getRequest()->getParam('ids');
            foreach ($ids as $id) {
                Mage::getModel('question/question')->setId($id)->delete();
                $session->addSuccess($this->__('Question #%s has been deleted', $id));
            }
        } catch (Exception $e) {
            $session->addError($this->__('Error on deleting question'));
            Mage::logException($e);
        }
        $this->_redirect('*/*/');
    }

    public function massChangeStatusAction()
    {
        $session = $this->_getSession();
        try {
            $ids = $this->getRequest()->getParam('ids');
            $status = $this->getRequest()->getParam('status');
            foreach ($ids as $id) {
                Mage::getModel('question/question')->setId($id)->changeStatus($status);
            }
            $session->addSuccess($this->__('Status has been changed'));
        } catch (Mage_Core_Exception $e) {
            $session->addError($e->getMessage());
        } catch (Exception $e) {
            $session->addError($this->__('Error on changing question status'));
            Mage::logException($e);
        }
        $this->_redirect('*/*/');
    }

    /**
     * Create new question action
     *
     * @return void
     */
    public function saveAction()
    {
        if ($this->getRequest()->isPost()) {
            $data    = $this->getRequest()->getParams();
            $model   = Mage::getModel('question/question');
            $session = Mage::getSingleton('core/session');

            try {
                $result = $model->edit($data);
                if (is_array($result)) {
                    foreach ($result as $message) {
                        $session->addError($message);
                    }
                } else {
                    $session->addSuccess($this->__('Question has been successfully created'));
                }
            } catch (Mage_Core_Exception $e) {
                $session->addError($this->__('Failed to create question: %s',
                    $e->getMessage()));
            } catch (Exception $e) {
                $session->addError($this->__('Failed to create question'));
            }
        }
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        $session = $this->_getSession();
        try {
            $id = $this->getRequest()->getParam('id');
            Mage::getModel('question/question')->setId($id)->delete();
            $session->addSuccess($this->__('Question #%s has been deleted', $id));
        } catch (Exception $e) {
            $session->addError($this->__('Error on deleting question'));
            Mage::logException($e);
        }
        $this->_redirect('*/*/');
    }

    /**
     * New question action
     *
     * @return void
     */
    public function newAction()
    {
        $this->_forward('edit');
    }

    /**
     * Edit question action
     *
     * @return void
     */
    public function editAction()
    {
        $this->_init();
        $this->loadLayout();
        $this->renderLayout();
    }



    /**
     * Init data for question edit form
     *
     * @return $this
     */
    private function _init()
    {
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            $item = Mage::getModel('question/question')->load($id);

            Mage::register('question_data', $item);

            return $this;
        }
    }
}
