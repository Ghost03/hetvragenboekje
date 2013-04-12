<?php

require_once('Sparx/Pdf/config/lang/eng.php');
require_once('Sparx/Pdf/tcpdf.php');
require_once('Sparx/Pdf/htmlcolors.php');

class Sparx_Pdf extends TCPDF {

    public $view;
    public $order;
    public $order_lines;
    public $customer;
    public $delivery;
    public $invoice;
    public $type;
    
    function __construct($orientation, $unit, $format) {
        parent::__construct($orientation, $unit, $format, true, 'UTF-8', false);

        # Set the page margins: 72pt on each side, 36pt on top/bottom.
        $this->SetMargins(52, 36, 52, true);
        $this->SetAutoPageBreak(true, 36);

        # Set document meta-information
        $this->SetCreator(PDF_CREATOR);
        $this->SetAuthor('5Minuten.tv (info@5Minuten.tv)');
        $this->SetTitle('Factuur ' . $this->order['id']);
        
        //set image scale factor
        $this->setImageScale(PDF_IMAGE_SCALE_RATIO);

        //set some language-dependent strings
        global $l;
        $this->setLanguageArray($l);
    }

    # Page header and footer code.

    public function Header() {
        
        // logo
        #$this->ImageEps($file='../assets/invoice/logo-3.ai', $x=200, $y=35, $w=190, $h='', $link='', $useBoundingBox=true, $align='L', $palign='', $border=0, $fitonpage=false);
        
        // MSI
        $style = array(
            'position' => '',
            'align' => 'R',
            'stretch' => false,
            'fitwidth' => true,
            'cellfitalign' => '',
            'border' => true,
            'hpadding' => 'auto',
            'vpadding' => 'auto',
            'fgcolor' => array(0,0,0),
            'bgcolor' => false,
            'text' => true,
            'font' => 'helvetica',
            'fontsize' => 8,
            'stretchtext' => 4
        );

        $this->setXY(500,65);
        //$this->write1DBarcode($this->order->order_id, 'MSI', '', '', '', 38, 1, $style, 'N');
        
    }

    public function Footer() {
        
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        //$this->Cell(0, 10, 'Scouph BV | www.scouph.com | KVK 53886410 | BTW Nr: NL851058978B01 | klantenservice@scouph.nl | +31(0)186 - 61715', 0, false, 'C', 0, '', 0, false, 'T', 'M');
        
    }

    public function CreateInvoice() {
        
        global $webcolor;
        
        $this->AddPage();
        $this->SetY(115, true);

        $this->SetFont('helvetica', '', 10);
        
        $delivery = $this->delivery->getData();
        $invoice  = $this->invoice ? $this->invoice->getData() : false;
        
        if($invoice) 
            $invoice = array(  'Factuuradres:', 
                                $invoice['name'], 
                                $invoice['street'] . ' ' . $invoice['number'], 
                                $invoice['zipcode'] . ' ' . $invoice['city'], 
                                $invoice['country']);
        else 
            $invoice = array(  'Factuuradres:', 
                                $delivery['name'], 
                                $delivery['street'] . ' ' . $delivery['number'], 
                                $delivery['zipcode'] . ' ' . $delivery['city'], 
                                $delivery['country']);
        
        // verzend adres              
        $delivery = array(  'Verzendadres:', 
                            $delivery['name'], 
                            $delivery['street'] . ' ' . $delivery['number'], 
                            $delivery['zipcode'] . ' ' . $delivery['city'], 
                            $delivery['country']);
        
        $i = 0;
        $this->SetFont('', 'b');
        for ($i = 0; $i < 5; $i++) {
            if($this->type == 'invoice') {
                $this->Cell(260, 20, $invoice[$i], 0, 0, 'L');
                $this->Cell(260, 20, $delivery[$i], 0, 0, 'L');
            } else {
                $this->Cell(260, 20, $delivery[$i], 0, 0, 'L');
                $this->Cell(260, 20, $invoice[$i], 0, 0, 'L');
            }
            $this->Ln();
            if ($i == 0)
                $this->SetFont('', '');
        }

        $this->Ln();
        $type = $this->type == 'invoice' ? $this->view->translate('Factuur') : $this->view->translate('Pakbon');
        $this->SetFont('', 'b');
        $this->Cell(230, 20, $type, 0, 0, 'L');
        $this->Ln();

        $this->SetFont('', 'n');
        // invoice info
        $data = array(
            'Factuur nr:' => $this->order->order_id,
            'Datum:' => date('d-m-Y',strtotime($this->order->getDate())),
          //  'Tijd:' => date('H:i',strtotime($this->order->getDate()))
        );
        foreach ($data as $var => $value) {
            $this->Cell(60, 20, $var, 0, 0, 'L');
            $this->Cell(100, 20, $value, 0, 0, 'L');
            $this->Ln();
        }

        $this->Ln();

        // betaalwijze 
        $this->SetFont('', 'b');
        $this->Cell(260, 20, 'Bezorgdatum:', 0, 0, 'L');
        $this->Cell(100, 20, 'Betaalwijze:', 0, 0, 'L');
        $this->Ln();

        $this->SetFont('', '');
        $this->Cell(260, 20, date('d-m-Y',strtotime($this->order->getDeliveryDate())), 0, 0, 'L');
        $this->Cell(100, 20, $this->order->getPaymentMethod(), 0, 0, 'L');
        $this->Ln();

        $this->Ln();
        $this->Ln();

                
        $this->SetFont('', 'b');

        $this->Cell(140, 20, 'Artikel', 0, 0, 'L');
        $this->Cell(90, 20, 'Kleur', 0, 0, 'L');
        $this->Cell(90, 20, 'Artikel nr.', 0, 0, 'L');
        if($this->type == 'invoice')
            $this->Cell(70, 20, 'Prijs', 0, 0, 'L');
        $this->Cell(50, 20, 'Aantal', 0, 0, 'L');
        if($this->type == 'invoice')
            $this->Cell(70, 20, 'Subtotaal', 0, 0, 'R');
        $this->Ln();
                
        $this->SetFont('', '');
        $this->setY($this->getY() + 5);        
        $this->SetLineStyle(array('width' => 1, 'color' => array($webcolor['black'])));
        $this->Line(50,$this->getY(),563,$this->getY());
        
        $this->setY($this->getY() + 5);        
        $total = 0;
        foreach($this->order_lines as $product) {            
            $this->Cell(140, 20, $product->name, 0, 0, 'L');
            $this->Cell(90, 20, substr($product->color,7), 0, 0, 'L');
            $this->Cell(90, 20, $product->number, 0, 0, 'L');
            if($this->type == 'invoice')
                $this->Cell(70, 20, $this->view->currency($product->price), 0, 0, 'L');
            $this->Cell(50, 20, $product->quantity, 0, 0, 'L');
            if($this->type == 'invoice')
                $this->Cell(70, 20, $this->view->currency($product->price * $product->quantity), 0, 0, 'R');
            $this->Ln();
            
            $total += $product->price * $product->quantity;
        }  
                
        if($this->type == 'invoice'):
        
            $this->setY($this->getY() + 5);        
            $this->SetLineStyle(array('width' => 1, 'color' => array($webcolor['black'])));
            $this->Line(365,$this->getY(),563,$this->getY());

            $this->setY($this->getY() + 5);

            $this->Cell(430, 20, 'Subtotaal van bestelling:', 0, 0, 'R');
            $this->Cell(80, 20, $this->view->currency($total), 0, 0, 'R');
            $this->Ln();

            $this->Cell(430, 20, 'Verzendkosten:', 0, 0, 'R');
            $this->Cell(80, 20, $total > 50 ? 'Gratis' : $this->view->currency(1.95), 0, 0, 'R');
            $this->Ln();
            
            $this->Cell(430, 20, '(Inclusief 19% BTW:', 0, 0, 'R');
            $this->Cell(80, 20, $this->view->currency(($this->order->getPrice() / 119)*19) . ')', 0, 0, 'R');
            $this->Ln();

            $this->setY($this->getY() + 5);
            $this->SetLineStyle(array('width' => 1, 'color' => array($webcolor['black'])));
            $this->Line(365,$this->getY(),563,$this->getY());
            $this->setY($this->getY() + 5);

            $discount = $this->order->discount;
            if($discount > 0) {
                $this->Cell(430, 20, 'Korting:', 0, 0, 'R');
                $this->Cell(80, 20, $this->view->currency( $discount ), 0, 0, 'R');
                $this->Ln();
                
                $this->setY($this->getY() + 5);
                $this->SetLineStyle(array('width' => 1, 'color' => array($webcolor['black'])));
                $this->Line(365,$this->getY(),563,$this->getY());
                $this->setY($this->getY() + 5);
            }
            
            if($this->order->transaction_price > 0) {
                
                $this->Cell(430, 20, 'Rembourskosten:', 0, 0, 'R');
                $this->Cell(80, 20, $this->view->currency( $this->order->transaction_price ), 0, 0, 'R');
                $this->Ln();
                
            }

            $this->Cell(430, 20, 'Totaal:', 0, 0, 'R');
            $this->Cell(80, 20, $this->view->currency( $this->order->getPrice() ), 0, 0, 'R');
            $this->Ln();
               
        endif;

        $extra = json_decode($this->order->extra,1);

        foreach($extra as $var => $value) {     

            $this->setY($this->getY() + 5);        
            $this->SetLineStyle(array('width' => 1, 'color' => array($webcolor['black'])));
            $this->Line(50,$this->getY(),563,$this->getY());

            $this->setY($this->getY() + 5);
            $this->Cell(140, 20, ucfirst($var) . ':', 0, 0, 'L');
            $this->Cell(200, 20, implode(',',$value), 0, 0, 'L');
            $this->Ln();

        }

    }
}