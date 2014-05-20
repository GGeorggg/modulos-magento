<?php
class Bullmkt_Pay_Model_Pay extends Mage_Payment_Model_Method_Abstract
{
	protected $_code = 'pay';
	protected $_formBlockType = 'pay/form_pay';
	protected $_infoBlockType = 'pay/info_pay';
	
	public function assignData($data)
    {
		parent::assignData();
		
        if (!($data instanceof Varien_Object)) {
            $data = new Varien_Object($data);
        }
		
        $info = $this->getInfoInstance(); 
		
        $info->setCardName($data->getCardName())
			 ->setCardEnsign($data->getCardEnsign())
			 ->setCardNumber($data->getCardNumber())
			 ->setMonthExpiry($data->getMonthExpiry())
			 ->setYearExpiry($data->getYearExpiry())
			 ->setSecretNumber($data->getSecretNumber())
			 ->setInstallmentQty($data->getInstallmentQty());

		return $this;
    }
 
 
    public function validate()
    {
        parent::validate();
 
        $info = $this->getInfoInstance();
 
        $card_name = $info->getCardName();
		$card_ensign = $info->getCardEnsign();
		$card_number = $info->getCardNumber();
		$month_expiry = $info->getMonthExpiry();
		$year_expiry = $info->getYearExpiry();
		$secret_number = $info->getSecretNumber();
		$installment_qty = $info->getInstallmentQty();
		
		
        if(empty($card_name) || empty($card_ensign) || empty($month_expiry) || empty($year_expiry) || empty($secret_number) || empty($installment_qty) || empty($card_number)){
            $errorCode = 'invalid_data';
            $errorMsg = $this->_getHelper()->__('Card Name: %s ; Card Ensign: %s;, Card Number: %s; Month Expiry: %s; Year Expiry: %s; Secret Number: %s; Installment Qty: %s', $card_name, $card_ensign, $card_number, $month_expiry, $year_expiry, $secret_number, $installment_qty);
        }
 
        if($errorMsg){
            Mage::throwException($errorMsg);
        }
		
        return $this;
    }
	
}
?>
