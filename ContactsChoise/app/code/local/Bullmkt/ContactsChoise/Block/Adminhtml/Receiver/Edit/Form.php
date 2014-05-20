<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE_AFL.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Bullmkt
 * @package     Bullmkt_ContactsChoise
 * @copyright   Copyright (c) 2013 Bull Marketing <http://www.bullmarketing.com.br>
 * @license     http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * @author      Leandro Rosa <dev.leandrorosa@gmail.com>
 *
 */

class Bullmkt_ContactsChoise_Block_Adminhtml_Receiver_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    
	protected function _prepareForm()
    {
        if (Mage::getSingleton('adminhtml/session')->getReceiversData())
        {
            $data = Mage::getSingleton('adminhtml/session')->getReceiversData();
            Mage::getSingleton('adminhtml/session')->getReceiversData(null);
        }
        elseif (Mage::registry('receiver_data'))
        {
            $data = Mage::registry('receiver_data')->getData();
        }
        else
        {
            $data = array();
			echo "<script>alert('else')</script>";
        }
 
        $form = new Varien_Data_Form(array(
                'id' => 'edit_form',
                'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
                'method' => 'post',
                'enctype' => 'multipart/form-data',
        ));
 
        $form->setUseContainer(true);
 
        $this->setForm($form);
 
        $fieldset = $form->addFieldset('receiver_form', array(
             'legend' =>Mage::helper('contactschoise')->__('Create Receiver')
        ));
 
        $fieldset->addField('receiver_name', 'text', array(
             'label'     => Mage::helper('contactschoise')->__('Receiver Name'),
             'class'     => 'required-entry',
             'required'  => true,
             'name'      => 'receiver_name',
        ));
        
        $fieldset->addField('receiver_email', 'text', array(
             'label'     => Mage::helper('contactschoise')->__('Receiver Email'),
             'class'     => 'required-entry',
             'required'  => true,
             'name'      => 'receiver_email',
        ));
		
		
	
 
        $form->setValues($data);
 
        return parent::_prepareForm();
    }
	
}