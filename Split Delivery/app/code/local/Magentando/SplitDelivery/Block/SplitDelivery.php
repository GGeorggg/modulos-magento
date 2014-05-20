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
 * @category    Magentando
 * @package     Magentando_SplitDelivery
 * @copyright   Copyright (c) 2014 Magentando <http://www.magentando.com.br>
 * @license     http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * @author      Leandro Rosa <dev.leandrorosa@gmail.com>
 *
 */
class Magentando_SplitDelivery_Block_SplitDelivery extends Mage_Core_Block_Template
{
    protected static $_interval = 0;

    protected $_splitDeliveryItems = array();

    public function setSplitDelivery($item)
    {
        $this->_splitDeliveryItems[] = $item;
    }

    public function saveSplitDeliveryItems()
    {
        $splitDeliveryitems = Mage::helper('core')->jsonEncode($this->_splitDeliveryItems);

        Mage::getModel('splitdelivery/items')
            ->setQuoteSplitDeliveryItems($splitDeliveryitems);

//        return Mage::helper('core')->jsonDecode(Mage::getSingleton('checkout/cart')->getQuote()->getSplitdelivery());
    }

    protected function _prepareLayout()
    {
        $this->_injectCalendarControlJsCSSInHTMLPageHead();
        return parent::_prepareLayout();
    }

    private function _injectCalendarControlJsCSSInHTMLPageHead()
    {
        $this->getLayout()->getBlock('head')->append(
            $this->getLayout()->createBlock(
                'Mage_Core_Block_Html_Calendar',
                'html_calendar',
                array('template' => 'page/js/calendar.phtml')
            )
        );
        $this->getLayout()->getBlock('head')
            ->addItem('js_css', 'calendar/calendar-win2k-1.css')
            ->addJs('calendar/calendar.js')
            ->addJs('calendar/calendar-setup.js');
        return $this;
    }

    public function getItems()
    {
        $items = array_chunk(
            Mage::getModel('splitdelivery/items')->getItems(),
            $this->getQtyProductsDelivery()
        );

        return $items;
    }

    public function getQtyProductsDelivery()
    {
        $qtyProductDelivery = Mage::getStoreConfig(
            'shipping/splitdelivery/qty_delivery_product',
            Mage::app()->getStore()
        );

        if (Mage::getSingleton('core/session')->getQtyPeople()) {
            $qtyProductDelivery = $qtyProductDelivery * Mage::getSingleton('core/session')->getQtyPeople();
        }

        return $qtyProductDelivery;
    }

    public function setInterval($interval)
    {
        self::$_interval = self::$_interval + $interval;
    }

    public function getInterval()
    {
        return self::$_interval;
    }

    public function getDeliveryDay()
    {
        $interval = (int) Mage::helper('splitdelivery')->getInterval();
        $firstDay = Mage::getSingleton('core/session')->getDeliveryDay();

        if (!$this->getInterval()) {
            $deliveryDay = $this->giveWeekday($firstDay);
            $this->setInterval($interval);
        } else {
            $month =  substr("$firstDay", 3, 5);
            $day =  substr("$firstDay", 0, 2) + $this->getInterval();
            $deliveryDay = $this->giveWeekday(
                date(
                    'd/m',
                    mktime(0, 0, 0, $month, $day)
                )
            );

            $this->setInterval($interval);


        }
        return $deliveryDay;
    }

    /**
     * @param $currentday
     * @return bool|string
     */
    public function giveWeekday($currentday)
    {
        $month =  substr("$currentday", 3, 5);
        $day =  substr("$currentday", 0, 2);
        $deliveryDay = date("d/m", mktime(0, 0, 0, $month, $day));

        for ($i=1; $i<=2; $i++) {
            $week = date("w", mktime(0, 0, 0, $month, $day));
            if (in_array($week, Mage::helper('splitdelivery')->getWeekend())) {
                $this->setInterval(1);
                $day = $day+1;
                $i = 1;
                $deliveryDay = date("d/m", mktime(0, 0, 0, $month, $day));
                continue;
            } else {
                break;
            }
        }
        return $deliveryDay;
    }
}
