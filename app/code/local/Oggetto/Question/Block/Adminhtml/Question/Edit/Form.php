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
 * Question form block
 *
 * @category   Oggetto
 * @package    Oggetto_Question
 * @subpackage Block
 * @author     Danil Pavlov <dpavlov@oggettoweb.com>
 */
class Oggetto_Question_Block_Adminhtml_Question_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Construct questions grid container
     *
     * @return Oggetto_Question_Block_Adminhtml_Question_Edit_Form
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();

        $fieldset = $form->addFieldset('base_fieldset', array('legend' => $this->__('Question data')));

        $fieldset->addField('name', 'text', array(
            'name'  => 'name',
            'label' => $this->__('Name'),
            'title' => $this->__('Name'),
            'required' => true,
        ));

        $fieldset->addField('email', 'text', array(
            'name'  => 'email',
            'label' => $this->__('Email'),
            'title' => $this->__('Email'),
            'required' => true,
        ));

        $fieldset->addField('status', 'select', array(
            'name'  => 'status',
            'label' => $this->__('Status'),
            'title' => $this->__('Status'),
            'required' => true,
            'values'    => Mage::getModel('question/question_status')->getStatusOptions()
        ));

        $dateFormatIso = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);
        $fieldset->addField('created_at', 'date', array(
            'label' => $this->__('Created At'),
            'title' => $this->__('Created At'),
            'required' => true,
            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'input_format' => Varien_Date::DATE_INTERNAL_FORMAT,
            'format' => $dateFormatIso,
        ));

        $fieldset->addField('question', 'textarea', array(
            'name'  => 'question',
            'label' => $this->__('Question'),
            'title' => $this->__('Question'),
            'required' => true,
        ));

        $fieldset->addField('answer', 'textarea', array(
            'name'  => 'answer',
            'label' => $this->__('Answer'),
            'title' => $this->__('Answer'),
//            'required' => true,
        ));

        $form->setAction($this->getUrl('*/*/save', array('_current' => true)));
        $form->setMethod('post');
        $form->setUseContainer(true);
        $form->setId('edit_form');

        if (Mage::registry('question_data')) {
            $data = Mage::registry('question_data');
            $form->setValues($data);
        }

        $this->setForm($form);

        return parent::_prepareForm();
    }
}