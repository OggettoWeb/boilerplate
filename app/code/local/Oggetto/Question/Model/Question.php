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
 * Question model
 *
 * @category   Oggetto
 * @package    Oggetto_Question
 * @subpackage Model
 * @author     Danil Pavlov <dpavlov@oggettoweb.com>
 */
class Oggetto_Question_Model_Question extends Mage_Core_Model_Abstract
{

    protected function _construct()
    {
        $this->_init('question/question');
    }

    /**
     * Trying to create new question
     *
     * @param array $data - post data
     *
     * @return array|void Array of validation errors if any occurred
     * @throws \Exception
     * @throws \Mage_Core_Exception
     */
    public function create($data)
    {
        $helper = Mage::helper('question');

        if (isset($data['name'])) {
            $this->setData('name', $data['name']);
        } else {
            Mage::throwException($helper->__('Please enter name'));
        }

        if (isset($data['email'])) {
            $this->setData('email', $data['email']);
        } else {
            Mage::throwException($helper->__('Please enter email'));
        }

        if (isset($data['question'])) {
            $this->setData('question', $data['question']);
        } else {
            Mage::throwException($helper->__('Please enter question'));
        }

        $errors = $this->validate();
        if ($errors) {
            return $errors;
        }
        $this->setCreatedAt(Mage::getModel('core/date')->gmtDate());
        $this->save();
    }

    public function validate()
    {
        $helper = Mage::helper('question');
        $errors = array();

        if (!Zend_Validate::is($this->getEmail(), 'EmailAddress')) {
            $errors[] = $helper->__('Invalid email address "%s"', $this->getEmail());
        }

        return (!empty($errors)) ? $errors : false ;
    }

}