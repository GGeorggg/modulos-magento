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
 * @package     Bullmkt_Correios
 * @copyright   Copyright (c) 2013 Bull Marketing <http://www.bullmarketing.com.br>
 * @license     http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * 
 * @author		Leandro Rosa <dev.leandrorosa@gmail.com>
 */
 
class Bullmkt_Correios_Adminhtml_UpdateController extends Mage_Adminhtml_Controller_action
 {
    protected function _initAction() {

        $this->loadLayout()
			->_setActiveMenu('correios/update');
		
        return $this;
    }
 
    public function indexAction() {
		$this->_initAction()
			->renderLayout();
    }
	
	public function updateAction()
	{
		$id = $this->getRequest()->getParam('id');
		$_item = Mage::getModel('correios/correios')->load($id);
		$content	= Mage::helper('correios')->accessCorreiosWs($_item);
		$xml 		= new SimpleXMLElement($content);
		
		if($xml)
		{
			
			foreach($xml as $item)
			{
				if (!$xml->Erro)
				{
					Mage::getModel('correios/correios')->doUpdating($_item, $xml);
					$this->__('Register was been updated');
				}
				else
				{
					Mage::getSingleton('adminhtml/session')->addError($this->__('Error in xml'));
				}
				
			}
		}
		
		else
		{
			Mage::getSingleton('adminhtml/session')->addError($this->__("Don't was possible created the xml file"));
		}
		
		$this->_redirect('*/*/index');
	}
	
	public function massUpdateAction()
	{
		$ids = $this->getRequest()->getParam('correios');
        if (!is_array($ids)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($ids as $id) 
				{
                    $_item 		= Mage::getModel('correios/correios')->load($id);					
					$content	= Mage::helper('correios')->accessCorreiosWs($_item);
					$xml 		= new SimpleXMLElement($content);
					
					if($xml)
					{
						foreach($xml as $item)
						{
							if (!$xml->Erro)
							{
								Mage::getModel('correios/correios')->doUpdating($_item, $xml);
								$this->__('Register was been updated');
							}
							else
							{
								Mage::getSingleton('adminhtml/session')->addError($this->__('Error in xml'));
							}
						}
					}
					else
					{
						Mage::getSingleton('adminhtml/session')->addError($this->__("Don't was possible created the xml file of the id %s", $_item->getIdCorreios()));
					}
                }
				
                $this->_getSession()->addSuccess(
					$this->__('Total of %d record(s) were successfully updated', count($ids))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
	}
 }