<?php
/**
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 *
 * @category    Webgp
 * @package     Itaushopline
 * @author     Luciene S. <contato@webgp.com.br>
 *  * @copyright   Webgp (www.webgp.com.br) 
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Webgp_ItauShopline_Model_Standard extends Mage_Payment_Model_Method_Abstract
{
    const PAYMENT_TYPE_AUTH = 'AUTHORIZATION';
    const PAYMENT_TYPE_SALE = 'SALE';

  
    protected $_code  = 'itaushopline_standard';
    protected $_formBlockType = 'itaushopline/standard_form';
    protected $_allowCurrencyCode = array('BRL');
    
  	protected $_canUseInternal = true;
  	protected $_canCapture = true;
	
     /**
     */
    public function getSession()
    {
        return Mage::getSingleton('itaushopline/session');
    }

    /**
     * Get checkout session namespace
     *
     * @return Mage_Checkout_Model_Session
     */
    public function getCheckout()
    {
        return Mage::getSingleton('checkout/session');
    }

    /**
     * Get current quote
     *
     * @return Mage_Sales_Model_Quote
     */
    public function getQuote()
    {
        return $this->getCheckout()->getQuote();
    }

    /**
     * Using internal pages for input payment data
     *
     * @return bool
     */
    public function canUseInternal()
    {
        return true;
    }

    /**
     * Using for multiple shipping address
     *
     * @return bool
     */
    public function canUseForMultishipping()
    {
        return true;
    }

    public function createFormBlock($name)
    {
        $block = $this->getLayout()->createBlock('itaushopline/standard_form', $name)
            ->setMethod('itaushopline_standard')
            ->setPayment($this->getPayment())
            ->setTemplate('itaushopline/standard/form.phtml');

        return $block;
    }

	  public function getTransactionId()
    {
        return $this->getSessionData('transaction_id');
    }

    public function setTransactionId($data)
    {
        return $this->setSessionData('transaction_id', $data);
    }

    /*validate the currency code is avaialable to use for ItauShopline100 or not*/
    public function validate()
    {
        parent::validate();
        $currency_code = $this->getQuote()->getBaseCurrencyCode();
        if (!in_array($currency_code,$this->_allowCurrencyCode)) {
            Mage::throwException(Mage::helper('itaushopline')->__('A moeda selecionada ('.$currency_code.') não é compatível com o Itaú Shopline'));
        }
        return $this;
    }

    public function onOrderValidate(Mage_Sales_Model_Order_Payment $payment)
    {
       return $this;
    }

    public function onInvoiceCreate(Mage_Sales_Model_Invoice_Payment $payment)
    {
		return $this;
    }

    public function canCapture()
    {
        return true;
    }

    public function getOrderPlaceRedirectUrl()
    {
          return Mage::getUrl('itaushopline/standard/redirect');
    }

    public function getDadosCripto() {
        $orderIncrementId = $this->getCheckout()->getLastRealOrderId();
        $order = Mage::getModel('sales/order')->loadByIncrementId($orderIncrementId);

        $a  = $order->getBillingAddress();
        if ($order->getBillingAddress()->getEmail()) {
            $email = $order->getBillingAddress()->getEmail();
        } else {
            $email = $order->getCustomerEmail();
        }

    		$cep = substr(eregi_replace ("[^0-9]", "", $a->getPostcode()).'00000000',0,8);

  	    $a_date = explode ("-", date("Y-m-d"));
	      $s_dt_vencimento = date("dmY", mktime(0, 0, 0, $a_date[1], $a_date[2]+$this->getConfigData('dias_vencimento'), $a_date[0]));

        $shipping = sprintf('%.2f', $this->getQuote()->getShippingAddress()->getBaseShippingAmount());
		
  	    $items = $this->getQuote()->getAllItems();
  	    $total = 0;
        if ($items) {
                  $i = 1;
                  foreach($items as $item){
                      $total = $total + ($item->getBaseCalculationPrice() - $item->getBaseDiscountAmount());
                      $i++;
                  }
        }
		    $tot =  $total + $shipping;



       $s_dados_cripto = Mage::helper('itaushopline/cripto')->geraDados(
      		$this->getConfigData('codigo_loja'),
      		$this->getCheckout()->getLastRealOrderId(),
      		$tot,
      		$this->getConfigData('tp_obs'),
      		$this->getConfigData('chave'),
      		$a->getFirstname().' '.$a->getLastname(),
      		$this->getConfigData('codigo_inscricao'),
      		$a->getTaxvat(),
      		$a->getStreet(1).' '.$a->getStreet(2),
      		"",
      		$cep,
      		$a->getCity(),
      		$a->getState(),
      		$s_dt_vencimento,
      		$this->getConfigData('retorno'),
      		$this->getConfigData('obs1'),
      		$this->getConfigData('obs2'),
      		$this->getConfigData('obs3'));

       $s_dados_cripto = '';
			 $sArr = array('DC'    =>  $s_dados_cripto,);
       return $sArr;
    }

    public function getItauShoplineUrl()
    {
         $url='https://shopline.itau.com.br/shopline/shopline.asp';
         return $url;
    }


    public function getDebug()
    {
        return Mage::getStoreConfig('ItauShopline100/wps/debug_flag');
    }

}
