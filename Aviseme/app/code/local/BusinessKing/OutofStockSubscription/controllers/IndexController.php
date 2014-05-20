<?php

/**
 * Out of Stock Subscription index controller
 *
 * @category    BusinessKing
 * @package     BusinessKing_OutofStockSubscription
 */
class BusinessKing_OutofStockSubscription_IndexController extends Mage_Core_Controller_Front_Action {
	public function indexAction() { 
		
		$productId = $this->getRequest()->getPost('product');
		$email = $this->getRequest()->getPost('subscription_email');
		
		if ($email && $productId) {
			 
			if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
				Mage::getModel('outofstocksubscription/info')->saveSubscrition($productId, $email);
				$this->_redirect('outofstocksubscription/success/index');
			}
			else {
				$this->_redirect('outofstocksubscription/error/mail');
			}	
		}
		else {
			$this->_redirect('outofstocksubscription/error');
		}	

	} 
	
    protected function _getSession() {
        return Mage::getSingleton('checkout/session');
    }
}