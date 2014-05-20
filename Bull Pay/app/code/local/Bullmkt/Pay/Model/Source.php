<?php
class Bullmkt_Pay_Model_Source 
{
	public function toOptionArray()
	{
		return array(
			array('code' => 1, 'validation' => 4, 'label' =>'Visa'),
			array('code' => 2, 'validation' => 3, 'label' => 'MasterCard'),
		);
	}
}