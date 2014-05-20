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
 
class Bullmkt_Correios_IndexController extends Mage_Core_Controller_Front_Action {

    public function indexAction() 
	{
		$collection = Mage::getModel('correios/correios')->getCollection();
		
		echo '<pre>';
		var_dump( $collection );
		echo '</pre>';
    }
	
	public function updateAction()
	{
		$collection = Mage::getModel('correios/updates')->updateCarrierTable();
		foreach($collection as $item)
		{
			$cep_destino = $row->cep_dest_ref;
			$peso = $row->peso;
			$url_d = $url."&nCdEmpresa=".$nCdEmpresa."&sDsSenha=".$sDsSenha."&nCdFormato=1&nCdServico=".$nCdServico."&nVlComprimento=".$nVlComprimento."&nVlAltura=".$nVlAltura."&nVlLargura=".$nVlLargura."&sCepOrigem=".$cep_origem."&sCdMaoPropria=N&sCdAvisoRecebimento=N&nVlValorDeclarado=0&nVlPeso=".$peso."&sCepDestino=".$cep_destino;

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url_d);
			curl_setopt($ch, CURLOPT_HEADER, 0);

			ob_start();
			curl_exec($ch);
			curl_close($ch);
			$content = ob_get_contents();
			ob_end_clean();

			if( ($xml = new SimpleXMLElement($content)) ) 
			  foreach($xml->cServico as $servico) {
			   if ($servico->Erro == "0") {
				$sql = "UPDATE frete SET
					 valor='".str_replace(",",".",$servico->Valor)."',
					 prazo='".$servico->PrazoEntrega."',
					 lastupdate=NOW()
					WHERE id='".$row->id."'
				";
				if (mysql_query($sql)) {
					$total_updated++;
				}
				else $total_fail++;
			   } else {
				echo "<script type='text/javascript'>
					alert('".$servico->MsgErro."');
					document.location.href='./index.php';
					  </script>
				";
				exit;
			   }
			  }
			else $erro = "Correios fora do ar ?";
		}
	}

}