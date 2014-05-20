<?php
class Bullmkt_Pay_Block_Form_Pay extends Mage_Payment_Block_Form
{
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('pay/form/pay.phtml');
    }
	
	public function getMonths()
	{
		$months = Array(
			1 	=> "Janeiro",
			2 	=> "Fevereiro",
			3 	=> "Março",
			4 	=> "Abril",
			5 	=> "Maio",
			6 	=> "Junho",
			7 	=> "Julho",
			8 	=> "Agosto",
			9	=> "Setembro",
			10	=> "Outubro",
			11	=> "Novembro",
			12	=> "Dezembro"
		);
		
		return $months;
	}
	
	public function getInstallmentQty()
	{
		$installment = Mage::getStoreConfig('payment/pay/installment_qty',Mage::app()->getStore());
		
		return $installment;
	}
	
	public function getYear()
	{	
		$years = array();
		$date = date('Y');
		$cond = $date+10;
		for($i=$date; $i<=$cond; $i++){
			$years[] = $i;
		}
		
		return $years;
	}
	
	public function getEnsign()
	{
		 $ensign = Mage::getModel('pay/source')->toOptionArray(); 
		 return $ensign;
	}
	
}