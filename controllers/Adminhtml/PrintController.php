<?php
class ArteDigital_PDF_Adminhtml_PrintController extends Mage_Adminhtml_Controller_Action
{


    public function orderAction(){
    	 $orderId = $this->getRequest()->getParam('order_id');

     	if (empty($orderId)) {
		 	Mage::getSingleton('adminhtml/session')->addError('There is no order to process');
		 	$this->_redirect('adminhtml/sales_order');
		 	return;
		 }
		 $order = Mage::getModel('sales/order')->load($orderId);
         $html = Mage::getModel('pdf/order')->createHtml($order);
         Mage::helper('pdf/gerar')->printPDF($html, "Pedido: #".$order->getIncrementId().".pdf");


    }
    public function invoiceAction(){
		$invoiceId = $this->getRequest()->getParam('invoice_id');
		$invoice = Mage::getModel("sales/order_invoice")->load($invoiceId);
        if (!$invoice->getId()) {
        	$this->_getSession()->addError($this->__('The invoice no longer exists.'));
            $this->_forward('no-route');
            return;
		}
        $html = Mage::getModel('pdf/invoice')->createHtml($invoice);
        Mage::helper('pdf/gerar')->printPDF($html, "Fatura: #".$invoice->getIncrementId().".pdf");
	}
	public function shipmentAction(){
		$shipmentId = $this->getRequest()->getParam('shipment_id');
		$shipment 	= Mage::getModel('sales/order_shipment')->load($shipmentId);
        if (!$shipment->getId()) {
        	$this->_getSession()->addError($this->__('The shipment no longer exists.'));
            $this->_forward('no-route');
            return;
		}
         $html = Mage::getModel('pdf/invoice')->createHtml($shipment);
        Mage::helper('pdf/gerar')->printPDF($html, "Envio: #".$shipment->getIncrementId().".pdf");

	}
}