<?php

require_once(Mage::getBaseDir()."/lib/ArteDigital/MPDF57/mpdf.php");

class ArteDigital_PDF_Helper_Gerar extends Mage_Core_Helper_Abstract
{



    public function printPDF($html, $id){

         $mpdf=new mPDF();
         $mpdf->WriteHTML($html);
         $mpdf->Output($id,'D');
    }


}