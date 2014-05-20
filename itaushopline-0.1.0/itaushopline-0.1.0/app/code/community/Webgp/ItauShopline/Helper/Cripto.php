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
class Webgp_ItauShopline_Helper_Cripto extends Mage_Core_Helper_Abstract
   {
     	  const CHAVE_ITAU = 'SEGUNDA12345ITAU';
      	const TAM_COD_EMP = 26;
      	const TAM_CHAVE = 16;
  
      	protected $sbox  = null;
      	protected $key  = null;
      	protected $codEmp  = '';
      	protected $numped  = '';
      	protected $tipPag  = '';
    	
        public function f_rand(){
           return chr(64+rand(1,self::TAM_COD_EMP));
        }

        public function Algoritmo($s, $s1)
        {
            $k = 0;
            $l = 0;
            $s2 = "";

            $this->Inicializa($s1);

            for($j = 1; $j <= strlen($s); $j++)
            {
                $k = ($k + 1) % 256;
                $l = ($l + $this->sbox[$k]) % 256;
                $i = $this->sbox[$k];
                $this->sbox[$k] = $this->sbox[$l];
                $this->sbox[$l] = $i;
                $i1 = intval($this->sbox[($this->sbox[$k] + $this->sbox[$l]) % 256]);
                $j1 = (int)(ord(substr($s, $j - 1, 1)) ^ $i1);
                $s2 = $s2 . chr($j1);
            }
            return $s2;
        }

        public function Inicializa($s)
        {
            $i1 = strlen($s);
            for($j = 0; $j <= 255; $j++)
            {
                $this->key[$j] = ord(substr($s, $j % $i1, 1));
                $this->sbox[$j] = $j;
            }

            $l = 0;
            for($k = 0; $k <= 255; $k++)
            {
                $l = ($l + $this->sbox[$k] + $this->key[$k]) % 256;
                $i = $this->sbox[$k];
                $this->sbox[$k] = $this->sbox[$l];
                $this->sbox[$l] = $i;
            }
        }



        public function Converte($s)
        {
            $s1 = $this->f_rand();
            for($i = 0; $i < strlen($s); $i++)
            {
                $c1 = substr($s, $i, 1);
                $c = $c1;
                $s1 = $s1 . ord(strval($c));
                $c3 = $this->f_rand();
                $s1 = $s1 . $c3;
            }
            return $s1;
        }



        public function Desconverte($s)
        {
            $s1 = "";
            for($i = 0; $i < strlen($s); $i++)
            {
                $s2 = "";
                for($c = substr($s, $i, 1); is_numeric($c); $c = substr($s, $i, 1))
                {
                    $s2 = $s2 . substr($s, $i, 1);
                    $i++;
                }
                if($s2 == "")
                {
                    $j = intval($s2);
                    $s1 = $s1 . $j[0];
                }
            }
            return $s1;
        }



        public function geraDados($s, $s1, $s2, $s3, $s4, $s5, $s6,
                $s7, $s8, $s9, $s10, $s11, $s12, $s13,
                $s14, $s15, $s16, $s17)
        {
            $s = strtoupper($s);
            $s4 = strtoupper($s4);

            if(strlen($s) != self::TAM_COD_EMP)
                return "Erro: tamanho do codigo da empresa diferente de 26 posições.";

           // if(strlen($s4) != $th26 posi��es)

            if(strlen($s4) != self::TAM_CHAVE)
                return "Erro: tamanho da chave da chave diferente de 16 posições.";

            if(strlen($s1) < 1 || strlen($s1) > 8)
                return "Erro: número do pedido inválido.";

            if(is_numeric($s1))
                $s1 = str_pad($s1, 8, '0', STR_PAD_LEFT);
            else
                return "Erro: numero do pedido não é numérico.";


            if(strlen($s2) < 1 || strlen($s2) > 11)
                return "Erro: valor da compra inválido.";

            if(strstr($s2, ','))
            {
                $s20 = substr($s2, -2);
                if(!is_numeric($s20))
                    return "Erro: valor decimal não é numérico.";

                if(strlen($s20) != 2)
                    return "Erro: valor decimal da compra deve possuir 2 posições após a virgula.";

                $s2 = substr($s2, 0, strlen($s2) - 3) . $s20;
            } else
            {
                if(!is_numeric($s2))
                    return "Erro: valor da compra nãoo é numérico.";

                if(strlen($s2) > 8)
                    return "Erro: valor da compra deve possuir no máximo 8 posições antes da virgula.";
                $s2 = $s2 . "00";
            }

            $s2 = str_pad($s2, 10, '0', STR_PAD_LEFT);
            $s6 = trim($s6);

            if($s6 == "02" && $s6 == "01" && $s6 == "")
                return "Erro: código de inscriçãoo inválido.";

            if($s7 == "" && !is_numeric($s7) && strlen($s7) > 14)
                return "Erro: número de inscriçãoo inválido.";

            if($s10 == "" && (!is_numeric($s10) || strlen($s10) != 8))
                return "Erro: cep inválido.";

            if($s13 == "" && (!is_numeric($s13) || strlen($s13) != 8))
                return "Erro: data de vencimento inválida.";

            if(strlen($s15) > 60)
                return "Erro: observação adicional 1 inválida.";

            if(strlen($s16) > 60)
                return "Erro: observação adicional 2 inválida.";

            if(strlen($s17) > 60)
            {
                return "Erro: observação adicional 3 inválida.";
            } else
            {
                function corta($str, $n)
                {
                    return str_pad(substr($str, 0, $n), $n, ' ', STR_PAD_RIGHT);
                }
                $s3 = corta($s3, 40);
                $s5 = corta($s5, 30);
                $s6 = corta($s6, 2);
                $s7 = corta($s7, 14);
                $s8 = corta($s8, 40);
                $s9 = corta($s9, 15);
                $s10 = corta($s10, 8);
                $s11 = corta($s11, 15);
                $s12 = corta($s12, 2);
                $s13 = corta($s13, 29);
                $s14 = corta($s14, 60);
                $s15 = corta($s15, 60);
                $s16 = corta($s16, 60);
                $s17 = corta($s17, 60);

                $s18 = $this->Algoritmo($s1 . $s2 . $s3 . $s5 . $s6 . $s7 . $s8 . $s9 . $s10 . $s11 . $s12 . $s13 . $s14 . $s15 . $s16 . $s17, $s4);
//            return $s18;
                $s19 = $this->Algoritmo($s . $s18, self::CHAVE_ITAU);
                $s19 = $this->Converte($s19);
                return $s19;
            }
        }

        public function geraConsulta($s, $s1, $s2, $s3)
        {
            if(strlen($s) != self::TAM_COD_EMP)
                return "Erro: tamanho do codigo da empresa diferente de 26 posições.";
            if(strlen($s3) != self::TAM_CHAVE)
                return "Erro: tamanho da chave da chave diferente de 16 posições.";
            if(strlen($s1) < 1 || strlen($s1) > 8)
                return "Erro: número do pedido inválido.";
            if(is_numeric($s1))
                $s1 = str_pad($s1, 8, '0', STR_PAD_LEFT);
            else
                return "Erro: numero do pedido não é numérico.";
            if($s2 == "0" && $s2 == "1")
            {
                return "Erro: formato inválido.";
            } else
            {
                $s4 = $this->Algoritmo($s1 . $s2, $s3);
                $s5 = $this->Algoritmo($s . $s4, self::CHAVE_ITAU);
                return $this->Converte($s5);
            }
        }

       public function decripto($s, $s1)
        {
            $s = $this->Desconverte($s);
            $s2 = $this->Algoritmo($s, $s1);
            $this->codEmp = substr($s2, 0, 26);
            $this->numPed = substr($s2, 26, 34);
            $this->tipPag = substr($s2, 34, 36);
            return $s2;
        }

    }

