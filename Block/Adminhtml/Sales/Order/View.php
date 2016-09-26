<?php

class ArteDigital_PDF_Block_Adminhtml_Sales_Order_View extends Mage_Adminhtml_Block_Sales_Order_View
{
    public function  __construct()
    {
        parent::__construct();

        $this->_addButton('pdfad_print', array(
            'label'     => "Imprimir Pedido em PDF",
            'onclick'   => 'setLocation(\''.$this->getPrintUrl().'\')',
            'class'     => 'scalable save'
        ), 0, 100, 'header', 'header');
    }

    public function getOrder()
    {
        return Mage::registry('current_order');
    }

    private function getPrintUrl()
    {
        return $this->getUrl('adminhtml/print/order', array('order_id' => $this->getOrder()->getId()));
    }
}
