<?php

/**
 * Out of Stock Subscription index controller
 *
 * @category    BusinessKing
 * @package     BusinessKing_OutofStockSubscription
 */
class BusinessKing_OutofStockSubscription_RegisterController extends Mage_Core_Controller_Front_Action {
	public function formAction(){
		$this->loadLayout();
    	$this->renderLayout();
	}
}