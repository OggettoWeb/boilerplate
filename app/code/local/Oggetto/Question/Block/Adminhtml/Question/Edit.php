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
 * Question form container block
 *
 * @category   Oggetto
 * @package    Oggetto_Question
 * @subpackage Block
 * @author     Danil Pavlov <dpavlov@oggettoweb.com>
 */
class Oggetto_Question_Block_Adminhtml_Question_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Construct questions grid container
     *
     * @return Oggetto_Question_Block_Adminhtml_Question_Edit
     */
    public function __construct()
    {
        $this->_blockGroup = 'question';
        $this->_controller = 'adminhtml_question';
        $this->_headerText = $this->__('Customer Question Edit Form');
        parent::__construct();
    }
}