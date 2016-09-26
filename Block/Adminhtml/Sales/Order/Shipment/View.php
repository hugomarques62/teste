<?php

class ArteDigital_PDF_Block_Adminhtml_Sales_Order_Shipment_View extends Mage_Adminhtml_Block_Sales_Order_Shipment_View {

   public function getShipment()
    {
        return Mage::registry('current_shipment');
    }
    /**
     * Get Print Url
     * @return string
     */
	public function getPrintUrl(){
		return $this->getUrl('adminhtml/print/shipment',array('shipment_id'=>$this->getShipment()->getId()));
	}

    public function  __construct() {

        parent::__construct();

        $this->_addButton('pdfad_print', array(
            'label'     => "Imprimir Envio em PDF",
            'onclick'   => 'setLocation(\''.$this->getPrintUrl().'\')',
            'class'     => 'scalable save'
        ), 0, 100, 'header', 'header');
    }
}