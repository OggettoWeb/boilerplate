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
     * Create new question action
     *
     * @return void
     */
    public function createAction()
    {
        if ($this->getRequest()->isPost()) {
            $data    = $this->getRequest()->getParams();
            $model   = Mage::getModel('question/question');
            $session = Mage::getSingleton('core/session');

            try {
                $result = $model->create($data);
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
        $this->_forward('index');
    }
}
