<?php

namespace Admin;

class PDFConvertor extends \fpdf\FPDF
{
    var $widths;
    var $aligns;
    var $orderID;
    var $date;
    public function data($id, $date)
    {
        $this->orderID = $id;
        $this->date = $date;
    }

    function Header()
    {
		$this->AddFont('Tahoma-Bold', '', 'tahoma_bold.php');
		$this->SetFont('Tahoma-Bold', '', 14);
        $this->Cell(145, 10, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", 'Заявка на відбір товару'), 0);
		$this->AddFont('Tahoma-Bold', '', 'tahoma_bold.php');
		$this->SetFont('Tahoma-Bold', '', 8);
        $this->Cell(25, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", 'Номер счета: '), 0, 0, 'R');
        $this->Cell(25, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", $this->orderID), 0, 0, 'R');
        $this->Ln();
        $this->Cell(145, 0, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", ''), 0);
        $this->Cell(25, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", 'Дата: '), 0, 0, 'R');
        $this->Cell(25, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", $this->date), 0, 0, 'R');
        $this->Line(10, 20, 205, 20);
        $this->Ln(10);
    }
    function Footer()
    {
        $this->SetY(-15);
		$this->AddFont('Tahoma', '', 'tahoma.php');
		$this->SetFont('Tahoma', '', 5);
		$this->Cell(0, 10, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", 'Сторінка') . $this->PageNo() . '/{nb}', 0, 0, 'R');
    }
    function SetWidths($w)
    {
        //Set the array of column widths
		$this->widths = $w;
    }

    function SetAligns($a)
    {
        //Set the array of column alignments
		$this->aligns = $a;
    }

    function Row($data)
    {
        //Calculate the height of the row
		$nb = 0;
		foreach ($data as $key => $value) if (isset($nd) && isset($data[$key])) {
			$nb = max($nb, $this->NbLines($this->widths[$key], $data[$$key]));
            }
		$h = 5 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
		foreach ($data as $key => $value) {
			if (isset($this->widths[$key])) $w = $this->widths[$key];
			$a = isset($this->aligns[$key]) ? $this->aligns[$key] : 'C';
            //Save the current position
			$x = $this->GetX();
			$y = $this->GetY();
            //Draw the border
            $this->Rect($x, $y, $w, $h);
            //Print the text
			$this->MultiCell($w, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", $data[$key]), 1, $a);
            //Put the position to the right of the cell
			$this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function NbLines($w, $txt)
    {
        //Computes the number of lines a MultiCell of width w will take
		$cw =& $this->CurrentFont['cw'];
		if ($w == 0) $w = $this->w - $this->rMargin - $this->x;
		$wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
		$s = str_replace("\r", '', $txt);
		$nb = strlen($s);
		if ($nb > 0 and $s[$nb - 1] == "\n")
            $nb--;
		$sep = -1;
		$i = 0;
		$j = 0;
		$l = 0;
		$nl = 1;
		while ($i < $nb) {
			$c = $s[$i];
			if ($c == "\n") {
                $i++;
				$sep = -1;
				$j = $i;
				$l = 0;
                $nl++;
                continue;
            }
			if ($c == ' ') $sep = $i;
			$l += $cw[$c];
			if ($l > $wmax) {
				if ($sep == -1) {
					if ($i == $j)
                        $i++;
				} else
					$i = $sep + 1;
				$sep = -1;
				$j = $i;
				$l = 0;
                $nl++;
			} else
                $i++;
        }
        return $nl;
    }

    function CheckPageBreak($h)
    {
        //If the height h would cause an overflow, add a new page immediately
		if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

	function RowExtended($data, $height = 10, $border = 1, $align = 'C')
    {
        //Calculate the height of the row
		$nb = 0;
		foreach ($data as $key => $value) if (isset($nd) && isset($data[$key])) {
			$nb = max($nb, $this->NbLines($this->widths[$key], $data[$$key]));
            }
		$h = 5 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
		foreach ($data as $key => $value) {
			if (isset($this->widths[$key])) $w = $this->widths[$key];
			$a = isset($this->aligns[$key]) ? $this->aligns[$key] : $align;
            //Save the current position
			$x = $this->GetX();
			$y = $this->GetY();
            //Draw the border
            //Print the text
			$this->MultiCell($w, $height, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", $data[$key]), $border, $a);
            //Put the position to the right of the cell
			$this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function RowWithoutBorder($data)
    {
        //Calculate the height of the row
		$nb = 0;
		foreach ($data as $key => $value) if (isset($nd) && isset($data[$key])) {
			$nb = max($nb, $this->NbLines($this->widths[$key], $data[$$key]));
            }
		$h = 5 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
		foreach ($data as $key => $value) {
			if (isset($this->widths[$key])) $w = $this->widths[$key];
			$a = isset($this->aligns[$key]) ? $this->aligns[$key] : 'C';
            //Save the current position
			$x = $this->GetX();
			$y = $this->GetY();
            //Draw the border
            //Print the text
			$this->MultiCell($w, 10, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", $data[$key]), 0, $a);
            //Put the position to the right of the cell
			$this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function RowToSigners($data)
    {
        //Calculate the height of the row
		$nb = 0;
		foreach ($data as $key => $value) if (isset($nd) && isset($data[$key])) {
			$nb = max($nb, $this->NbLines($this->widths[$key], $data[$$key]));
            }
		$h = 5 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
		foreach ($data as $key => $value) {
			if (isset($this->widths[$key])) $w = $this->widths[$key];
			$a = isset($this->aligns[$key]) ? $this->aligns[$key] : 'L';
            //Save the current position
			$x = $this->GetX();
			$y = $this->GetY();
            //Draw the border
            //Print the text
			$this->MultiCell($w, 10, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", $data[$key]), 0, $a);
            //Put the position to the right of the cell
			$this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }
}