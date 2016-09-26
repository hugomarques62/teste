<?php
class ArteDigital_PDF_Model_Order  {

	public function createHtml($order){

        $customer = Mage::getModel("customer/customer")->load($order->getCustomerId());

        $newDate = date("d/m/Y", strtotime($order->getCreatedAt()));

        $html ='<div class="logo-container"><img src="http://www.easypdfinvoice.com/media/ves_pdfpros/logo_print_18.jpgd"/></div>
<div class="invoice-header">
    Pedido #'.$order->getIncrementId() .'<br />
    '.$newDate  .'
</div><br>

<table cellspacing="0" cellpadding="0" style="border-top: 1px solid #808080; border-right: 1px solid #808080; border-bottom:1px solid #808080;  border-left:1px solid #808080; width:100% ">
    <tr valign="top">
        <td>
            <h3>Informações de Cobrança</h3>
            '. $order->getCustomerName() .' <br><br>

          CPF: '.$customer->getData('taxvat') .'
          <br />
          RG: '. $customer->getData('rg') .'
          <br />
          e-mail: '. $customer->getData('email') .'
          <br />
          Data de nascimento:  '. $customer->getData('dob') .'
        </td>

    </tr>
</table>
<br><br>

<table class="tbl-info" style="border-top: 1px solid #808080; border-right: 1px solid #808080; border-bottom:1px solid #808080;  border-left:1px solid #808080; width: 100%;" cellspacing="0" cellpadding="0">
    <tr valign="top" style="width: 100%;">
        <td style="width: 60%;">
            <h3>Informações de Pagamento</h3>
            '.$order->getPayment()->getMethodInstance()->getTitle() .'
        </td>
        <td style="width: 40%;">
            <h3>Método de Envio</h3>
            '.$order->getShippingDescription().'
        </td>
    </tr></table><br><br><br>
<table class="items" style="width: 100%;" cellspacing="0">
    <thead>
    <tr>
        <th class="header" style="border-left: 1px solid #808080;">Produto</th>
        <th class="header">Sku</th>
        <th class="header">Preço</th>
        <th class="header">Qtd</th>
        <th class="header" style="border-right: 1px solid #808080;">Subtotal</th>
    </tr>
    </thead>
    <tbody>';
    foreach ($order->getAllVisibleItems() as $Item) {



         $html .= '<tr>
                <td style="border-top: 1px solid #808080; border-right: 1px solid #808080;">
                    '.$Item->getProduct()->getName().'<br>';

                    foreach($Item->getProductOptions()['attributes_info'] as $_option ){
                        $html .= $_option['label'].': ';
                        $html .= $_option['value'].'<br>';

                    }

                    $html .='
                    </td>
                <td style="border-top: 1px solid #808080; border-right: 1px solid #808080; text-align:center; margin-top:0px; margin-bottom: 10px;">'.$Item->getProduct()->getSku().'</td>
                <td style="border-top: 1px solid #808080; border-right: 1px solid #808080; text-align:center; margin-top:0px; margin-bottom: 10px;">'. Mage::helper('core')->currency($Item->getOriginalPrice(), true, false) .'</td>
                <td style="border-top: 1px solid #808080; border-right: 1px solid #808080; text-align:center; margin-top:0px; margin-bottom: 10px;">'. $Item->getQtyToShip() .'</td>

                <td style="border-top: 1px solid #808080; border-right: 1px solid #808080; text-align:center; margin-top:0px; margin-bottom: 10px;">'. Mage::helper('core')->currency($Item->getOriginalPrice() * $Item->getQtyToShip(), true, false) .'</td>
            </tr>';
}
$html .= '</tbody></table>

<br><br>

                        <table cellspacing="0" cellpadding="0" width="100%">
                            <tbody>

                                <tr>
                                    <td width="50%">
                                       Preço:
                                    </td>
                                    <td>'.Mage::helper('core')->currency($order->getSubtotal()).'</td>
                                </tr>
                                 <tr>
                                    <td width="50%">
                                       Frete:
                                    </td>
                                    <td>'.Mage::helper('core')->currency($order->getShippingAmount()).'</td>
                                </tr>';

                                if($order->getDiscountAmount()!=0){
                                    $html .= '  <tr>
                                                    <td width="50%">
                                                       Desconto:
                                                    </td>
                                                    <td>'.Mage::helper('core')->currency($order->getDiscountAmount()).'</td>
                                                </tr>';
                                }
                          $html.=  '</tbody>
                            <tfoot>

                                <tr>
                                    <td width="50%">
                                      Valor total:
                                    </td>
                                    <td>'.Mage::helper('core')->currency($order->getGrandTotal()).'</td>
                                </tr>

                            </tfoot>
                        </table><br><br>';




$address = $order->getShippingAddress();
$customerAddress = Mage::getModel('customer/address')->load($customer->getDefaultShipping());

$html .='<table class="tbl-entrega" cellspacing="0" cellpadding="0" width:"100px;" style="border-top: 1px solid #808080; border-right: 1px solid #808080; border-bottom:1px solid #808080;  border-left:1px solid #808080;">

                <tr valign="top">
                    <td style ="float: left; text-align: left; margin-top:30px;   ">
                        <h3>Endereço de entrega</h3>

                    <td>
                </tr>
                <tr><td>
                    '.
                            $address->getName().'<br>'.
                            $address->getStreetFull().', '.
                            $customerAddress->getData('postcode'). ', '.
                            $address->getRegion().' - '.
                            $address->getCountry()
                        .'
                </td></tr>

          </table>
';


return $html;

	}





}