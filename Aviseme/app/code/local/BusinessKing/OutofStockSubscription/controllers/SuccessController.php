<?php

/**
 * Out of Stock Subscription index controller
 *
 * @category    BusinessKing
 * @package     BusinessKing_OutofStockSubscription
 */
class BusinessKing_OutofStockSubscription_SuccessController extends Mage_Core_Controller_Front_Action {
	public function indexAction() { 
		$this->loadLayout();
    	$this->renderLayout(); 
	}
}