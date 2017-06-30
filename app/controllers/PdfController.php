<?php
/*
require(__DIR__.'/../../vendor/itbz/fpdf/makefont/makefont.php');

class PdfController  extends BaseController {

    var $fontType = 'Tahoma';
    var $fontName = 'tahoma.php';
    var $PdfObj;
    var $widths;
    var $aligns;

    public function __construct()
    {
        $this->PdfObj = new \fpdf\FPDF("P", "mm", "A4");
    }

    public function Header()
    {
        $this->PdfObj->SetMargins(10, 10, 10);
        //$this->PdfObj->Image('../images/doc_background_simple1.png', 0, 0, $this->w);
        $this->PdfObj->SetFont($this->$fontType,'',$this->$titleSize);
        $this->PdfObj->Ln();
        $this->PdfObj->Write(10, '');
        $this->PdfObj->SetFont($fontType,'',14);
        $this->PdfObj->SetTextColor(100, 100, 100);
        $this->PdfObj->Ln();
        $this->PdfObj->Ln();
    }
    public function SetWidths($w)
    {
        $this->widths=$w;
    }

    public function SetAligns($a)
    {
        $this->aligns=$a;
    }
    public function NbLines($w,$txt)
    {
        $cw=&$this->PdfObj->CurrentFont['cw'];
        if($w==0)
            $w=$this->PdfObj->w-$this->PdfObj->rMargin-$this->PdfObj->x;
        $wmax=($w-2*$this->PdfObj->cMargin)*1000/$this->PdfObj->FontSize;
        $s=str_replace("\r",'',$txt);
        $nb=strlen($s);
        if($nb>0 and $s[$nb-1]=="\n")
            $nb--;
        $sep=-1;
        $i=0;
        $j=0;
        $l=0;
        $nl=1;
        while($i<$nb)
        {
            $c=$s[$i];
            if($c=="\n")
            {
                $i++;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
                continue;
            }
            if($c==' ')
                $sep=$i;
            $l+=$cw[$c];
            if($l>$wmax)
            {
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                }
                else
                    $i=$sep+1;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }
    public function Row($data)
    {
        $nb=0;
        for($i=0;$i<count($data);$i++)
            $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
        $h=7*$nb;
        $this->CheckPageBreak($h);
        for($i=0;$i<count($data);$i++)
        {
            $w=$this->widths[$i];
            $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            $x=$this->PdfObj->GetX();
            $y=$this->PdfObj->GetY();
            $this->PdfObj->Rect($x,$y,$w,$h);
            $this->PdfObj->MultiCell($w,7,$data[$i],0,$a);
            $this->PdfObj->SetXY($x+$w,$y);
        }
        $this->PdfObj->Ln($h);
    }
    public function CheckPageBreak($h)
    {
        if($this->PdfObj->GetY()+$h>$this->PdfObj->PageBreakTrigger)
            $this->PdfObj->AddPage($this->PdfObj->CurOrientation);
    }
} */