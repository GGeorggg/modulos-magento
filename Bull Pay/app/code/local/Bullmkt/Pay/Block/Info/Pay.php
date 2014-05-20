<?php
class Bullmkt_Pay_Block_Info_Pay extends Mage_Payment_Block_Info
{
    protected function _prepareSpecificInformation($transport = null)
    {
        if (null !== $this->_paymentSpecificInformation) {
            return $this->_paymentSpecificInformation;
        }
		
        $info = $this->getInfo();
        $transport = new Varien_Object();
        $transport = parent::_prepareSpecificInformation($transport);
		
        $transport->addData(array(
            Mage::helper('payment')->__('Card Name') => $info->getCardName(),
            Mage::helper('payment')->__('Card Ensign') => $info->getCardEnsign(),
			Mage::helper('payment')->__('Card Number') => $info->getCardNumber(),
			Mage::helper('payment')->__('Month Expiry') => $info->getMonthExpiry(),
			Mage::helper('payment')->__('Year Expiry') => $info->getYearExpiry(),
			Mage::helper('payment')->__('Secret Number') => $info->getSecretNumber(),
			Mage::helper('payment')->__('Installment Qty') => $info->getInstallmentQty()
        ));
        return $transport;
    }

}