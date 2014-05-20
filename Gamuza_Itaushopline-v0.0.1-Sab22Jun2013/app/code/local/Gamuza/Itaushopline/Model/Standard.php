<?php
/*
 * Gamuza Itau ShopLine - Itau ShopLine for Magento platform.
 * Copyright (C) 2013 Gamuza Technologies (http://www.gamuza.com.br/)
 * Author: Eneias Ramos de Melo <eneias@gamuza.com.br>
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Library General Public
 * License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Library General Public License for more details.
 *
 * You should have received a copy of the GNU Library General Public
 * License along with this library; if not, write to the
 * Free Software Foundation, Inc., 51 Franklin St, Fifth Floor,
 * Boston, MA  02110-1301, USA.
 */

/*
 * See the AUTHORS file for a list of people on the Gamuza Team.
 * See the ChangeLog files for a list of changes.
 * These files are distributed with Gamuza_Itaushopline at http://code.google.com/p/gamuzaopen/.
 */

class Gamuza_Itaushopline_Model_Standard
extends Mage_Payment_Model_Method_Abstract
{

protected $_code = 'itaushopline_standard';

protected $_canAuthorize = true;
protected $_canCapture = true;

protected $_formBlockType = 'itaushopline/standard_form';
protected $_infoBlockType = 'itaushopline/standard_info';

const ITAU_SHOPLINE_SUBMIT_TRANSACTION_LENGTH = 1698;
const ITAU_SHOPLINE_QUERY_TRANSACTION_LENGTH = 127;

public function _getOrderIncrementPrefix ($order_store_id)
{
    $order_entity_type = Mage::getModel('eav/entity_type')->loadByCode ('order');
    $order_entity_type_id = $order_entity_type->getId ();
    $order_entity_type_increment_per_store = $order_entity_type->getIncrementPerStore ();
    if ($order_entity_type_increment_per_store)
    {
	$order_entity_type_pad_length = $order_entity_type->getIncrementPadLength ();
	$order_entity_type_pad_char = $order_entity_type->getIncrementPadChar ();
	$order_entity_store_increment_prefix = Mage::getModel ('eav/entity_store')->loadByEntityStore ($order_entity_type_id, $order_store_id)->getIncrementPrefix ();
	
	return $order_entity_store_increment_prefix . str_pad ('0', $order_entity_type_pad_length, $order_entity_type_pad_char);
    }
    
    return 0;
}

public function _getStoreConfig ($field)
{
    return Mage::getStoreConfig ("payment/itaushopline_settings/$field");
}

public function authorize (Varien_Object $payment, $amount)
{
    $order = $payment->getOrder ();
    $order_id = $order->getId ();
    $order_increment_id = $order->getIncrementId ();
    $quote = $order->getQuote ();
    $store_id = $order->getStoreId ();
    
    $ccType = $payment->getCcType ();
    
    $code = $this->_getStoreConfig ('code');
    $key = $this->_getStoreConfig ('key');
    $obs = $this->_getStoreConfig ('obs');
    $obsadd1 = $this->_getStoreConfig ('obsadd1');
    $obsadd2 = $this->_getStoreConfig ('obsadd2');
    $obsadd3 = $this->_getStoreConfig ('obsadd3');
    $tax_vat = $order->getCustomer()->getTaxvat ();
    $address = $quote->getBillingAddress();
    $name = $address->getName ();
    $street1 = $address->getStreet1 ();
    $street2 = $address->getStreet2 ();
    $postcode = $address->getPostcode ();
    $city = $address->getCity ();
    $region = $address->getRegion ();
    $expiration = strtotime ('+' . $this->_getStoreConfig ('expiration') . 'days');
    $bank_expiration = date ('dmY', $expiration);
    $transaction_expiration = date ('Y-m-d', $expiration);
    $return_url = $this->_getStoreConfig ('return_url');
    $increment = $this->_getStoreConfig ('order_id_increment');
    
    $order_increment_prefix = $this->_getOrderIncrementPrefix ($store_id);
    $number = ($order_increment_id - $order_increment_prefix) + $increment;
    
    $submit_dc = Mage::getModel ('itaushopline/itaucripto')->geraDados(
    $code, $number, str_replace ('.', "", number_format ($amount, 2, ',', '.')), $obs, $key, $name, '01' /* 01:CPF, 02:CNPJ */, $tax_vat,
    $street1, $street2, $postcode, $city, $region, $bank_expiration, $return_url,
    $obsadd1, $obsadd2, $obsadd3
    );
    
    if (strlen ($submit_dc) < self::ITAU_SHOPLINE_SUBMIT_TRANSACTION_LENGTH)
    {
    Mage::throwException (Mage::helper ('itaushopline')->__('Unable to generate submit transaction code. Please check your settings.'));
    }
    
    $query_dc = Mage::getModel ('itaushopline/itaucripto')->geraConsulta(
    $code, $number, '0' /* 0:HTML, 1:XML */, $key
    );
    if (strlen ($query_dc) < self::ITAU_SHOPLINE_QUERY_TRANSACTION_LENGTH)
    {
    Mage::throwException (Mage::helper ('itaushopline')->__('Unable to generate query transaction code. Please check your settings.'));
    }
    
    $data = array ('order_id' => $order_id, 'amount' => $amount, 'expiration' => $transaction_expiration, 'number' => $number,
                   'submit_dc' => $submit_dc, 'query_dc' => $query_dc);
    $result = Mage::getModel ('utils/sql')->insert ('gamuza_itaushopline_transactions', $data);
    if (!$result)
    {
     Mage::throwException(Mage::helper ('itaushopline')->__('Unable to save the Itau ShopLine informations. Please verify your database.'));
    }
    
    $this->setStore($payment->getOrder()->getStoreId());
    $payment->setAmount($amount);
    $payment->setLastTransId($order_id);
    $payment->setStatus(self::STATUS_APPROVED);
    
    return $this;
}

}

