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
 * Questions grid container block
 *
 * @category   Oggetto
 * @package    Oggetto_Question
 * @subpackage Block
 * @author     Danil Pavlov <dpavlov@oggettoweb.com>
 */
class Oggetto_Question_Block_Adminhtml_Question_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Construct questions grid
     *
     * @return Oggetto_Question_Block_Adminhtml_Question_Grid
     */
    public function __construct()
    {
        $this->setId('questionGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('DESC');
        $this->setUseAjax(true);
        $this->setSaveParametersInSession(true);
    }

    /**
     * Prepare collection
     *
     * @return Oggetto_Question_Block_Adminhtml_Question_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('questions/question')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('id', array(
            'type'      => 'number',
            'index'     => 'id',
            'header'    => $this->__('Id'),
        ));

        $this->addColumn('question', array(
            'type'      => 'text',
            'index'     => 'question',
            'header'    => $this->__('Question'),
        ));

        $this->addColumn('name', array(
            'type'      => 'text',
            'index'     => 'name',
            'header'    => $this->__('Name'),
        ));

        $this->addColumn('email', array(
            'type'      => 'text',
            'index'     => 'email',
            'header'    => $this->__('Email'),
        ));

        $this->addColumn('email', array(
            'type'      => 'text',
            'index'     => 'email',
            'header'    => $this->__('Email'),
        ));

        $this->addColumn('created_at', array(
            'type'      => 'datetime',
            'index'     => 'created_at',
            'header'    => $this->__('Created At'),
        ));

        $this->addColumn('status', array(
            'type'      => 'options',
            'index'     => 'status',
            'header'    => $this->__('Created At'),
            'options'   => Mage::getModel('question/question_status')->getStatusOptions(),
        ));
    }
}