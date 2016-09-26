<?php

class ArteDigital_PDF_Block_Adminhtml_Sales_Order_Invoice_View extends Mage_Adminhtml_Block_Sales_Order_Invoice_View {

	public function getInvoice()
    {
        return Mage::registry('current_invoice');
    }
    /**
     * Get Print Url
     * @return string
     */
	public function getPrintUrl(){
		return $this->getUrl('adminhtml/print/invoice',array('invoice_id'=>$this->getInvoice()->getId()));
	}



    public function  __construct() {

        parent::__construct();

        $this->_addButton('pdfad_print', array(
            'label'     => "Imprimir Fatura em PDF",
            'onclick'   =>'setLocation(\''.$this->getPrintUrl().'\')',
            'class'     => 'scalable save'
        ), 0, 100, 'header', 'header');
    }
}