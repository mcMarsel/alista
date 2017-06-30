<?php

namespace Admin;

class PdfOrders extends \fpdf\FPDF
{
    var $widths;
    var $aligns;
    var $orderID;
    var $date;
    var $_1_2 = [];
    var $_1_19 = [];
    var $des = [];
    var $hang = [];
    var $namecurr = [];
    var $nametho = [];
    var $namemil = [];
    var $namemrd = [];

    public function data($id, $date)
    {
        $this->orderID = $id;
        $this->date = $date;
    }

    function Header()
    {
        $this->AddFont('Tahoma-Bold', '', 'tahoma_bold.php');
        $this->SetFont('Tahoma-Bold', '', 14);
        $this->SetTextColor(128, 0, 0);
        $this->Cell(145, 10, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", 'Рахунок'), 0);
        $this->AddFont('Tahoma-Bold', '', 'tahoma_bold.php');
        $this->SetFont('Tahoma-Bold', '', 8);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(25, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", 'Номер счета: '), 0, 0, 'R');
        $this->Cell(25, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", $this->orderID), 0, 0, 'R');
        $this->Ln();
        $this->Cell(145, 0, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", ''), 0);
        $this->Cell(25, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", 'Дата: '), 0, 0, 'R');
        $this->Cell(25, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", $this->date), 0, 0, 'R');
        $this->Line(10, 20, 205, 20);
        $this->Ln();
    }

    function Footer()
    {
        $this->SetY(-15);
        $date = date('d.m.Y');
        $time = date('H:i:s');
        $this->AddFont('Tahoma', '', 'tahoma.php');
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Tahoma', '', 6);
        $this->Cell(150, 10, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", 'Отпечатано: ' . $date . ', ' . $time), 0, 0, 'L');
        $this->SetFont('Tahoma', '', 8);
        $this->Cell(45, 10, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", 'Сторінка' . $this->PageNo() . '/{nb}'), 0, 0, 'R');
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
        foreach ($data as $key => $value)
            if (isset($nd) && isset($data[$key])) {
                $nb = max($nb, $this->NbLines($this->widths[$key], $data[$$key]));
            }
        $h = 5 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        foreach ($data as $key => $value) {
            if (isset($this->widths[$key]))
                $w = $this->widths[$key];
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
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
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
            if ($c == ' ')
                $sep = $i;
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

    function RowExtended($data, $height = 10, $border = 1, $align = 'C', $rect = 0)
    {
        //Calculate the height of the row
        $nb = 0;
        foreach ($data as $key => $value)
            if (isset($nd) && isset($data[$key])) {
                $nb = max($nb, $this->NbLines($this->widths[$key], $data[$$key]));
            }
        $h = 5 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        foreach ($data as $key => $value) {
            if (isset($this->widths[$key]))
                $w = $this->widths[$key];
            $a = isset($this->aligns[$key]) ? $this->aligns[$key] : $align;
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            if ($rect == 1) {
                $this->Rect($x, $y, $w, $h);
            }
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
        foreach ($data as $key => $value)
            if (isset($nd) && isset($data[$key])) {
                $nb = max($nb, $this->NbLines($this->widths[$key], $data[$$key]));
            }
        $h = 5 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        foreach ($data as $key => $value) {
            if (isset($this->widths[$key]))
                $w = $this->widths[$key];
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
        foreach ($data as $key => $value)
            if (isset($nd) && isset($data[$key])) {
                $nb = max($nb, $this->NbLines($this->widths[$key], $data[$$key]));
            }
        $h = 5 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        foreach ($data as $key => $value) {
            if (isset($this->widths[$key]))
                $w = $this->widths[$key];
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

    function num2text_ua($num)
    {
        $num = trim(preg_replace('~s+~s', '', $num)); // отсекаем пробелы
        if (preg_match("/, /", $num)) {
            $num = preg_replace("/, /", ".", $num);
        } // преобразует запятую
        if (is_numeric($num)) {
            $num = round($num, 2); // Округляем до сотых (копеек)
            $num_arr = explode(".", $num);
            $amount = $num_arr[0]; // переназначаем для удобства, $amount - сумма без копеек
            if (strlen($amount) <= 3) {
                $res = implode(" ", $this->Triada($amount)) . $this->Currency($amount);
            } else {
                $amount1 = $amount;
                while (strlen($amount1) >= 3) {
                    $temp_arr[] = substr($amount1, -3); // засовываем в массив по 3
                    $amount1 = substr($amount1, 0, -3); // уменьшаем массив на 3 с конца
                }
                if ($amount1 != '') {
                    $temp_arr[] = $amount1;
                } // добавляем то, что не добавилось по 3
                $i = 0;
                foreach ($temp_arr as $temp_var) { // переводим числа в буквы по 3 в массиве
                    $i++;
                    if ($i == 3 || $i == 4) { // миллионы и миллиарды мужского рода, а больше миллирда вам все равно не заплатят
                        if ($temp_var == '000') {
                            $temp_res[] = '';
                        } else {
                            $temp_res[] = implode(" ", $this->Triada($temp_var, 1)) . $this->GetNum($i, $temp_var);
                        } # if
                    } else {
                        if ($temp_var == '000') {
                            $temp_res[] = '';
                        } else {
                            $temp_res[] = implode(" ", $this->Triada($temp_var)) . $this->GetNum($i, $temp_var);
                        } # if
                    } # else
                } # foreach
                $temp_res = array_reverse($temp_res); // разворачиваем массив
                $res = implode(" ", $temp_res) . $this->Currency($amount);
            }
            if (!isset($num_arr[1]) || $num_arr[1] == '') {
                $num_arr[1] = '00';
            }
            return $res . ', ' . $num_arr[1] . ' коп.';
        } # if
    }

    function Triada($amount, $case = null)
    {
        $this->setSymbNumb(); // объявляем массив переменных
        $count = strlen($amount);
        for ($i = 0; $i < $count; $i++) {
            $triada[] = substr($amount, $i, 1);
        }
        $triada = array_reverse($triada); // разворачиваем массив для операций
        if (isset($triada[1]) && $triada[1] == 1) { // строго для 10-19
            $triada[0] = $triada[1] . $triada[0]; // Объединяем в единицы
            $triada[1] = ''; // убиваем десятки
            $triada[0] = $this->_1_19[$triada[0]]; // присваиваем
        } else { // а дальше по обычной схеме
            if (isset($case) && ($triada[0] == 1 || $triada[0] == 2)) { // если требуется м.р.
                $triada[0] = $this->_1_2[$triada[0]]; // единицы, массив мужского рода
            } else {
                if ($triada[0] != 0) {
                    $triada[0] = $this->_1_19[$triada[0]];
                } else {
                    $triada[0] = '';
                } // единицы
            } # if
            if (isset($triada[1]) && $triada[1] != 0) {
                $triada[1] = $this->des[$triada[1]];
            } else {
                $triada[1] = '';
            } // десятки
        }
        if (isset($triada[2]) && $triada[2] != 0) {
            $triada[2] = $this->hang[$triada[2]];
        } else {
            $triada[2] = '';
        } // сотни
        $triada = array_reverse($triada); // разворачиваем массив для вывода
        $triada1 = [];
        foreach ($triada as $triada_) { // вычищаем массив от пустых значений
            if ($triada_ != '') {
                $triada1[] = $triada_;
            }
        } # foreach
        return $triada1;
    }

    public function setSymbNumb()
    {
        $this->_1_2[1] = "один";
        $this->_1_2[2] = "два";

        $this->_1_19[1] = "одна";
        $this->_1_19[2] = "дві";
        $this->_1_19[3] = "три";
        $this->_1_19[4] = "чотири";
        $this->_1_19[5] = "п'ять";
        $this->_1_19[6] = "шість";
        $this->_1_19[7] = "сім";
        $this->_1_19[8] = "вісім";
        $this->_1_19[9] = "дев'ять";
        $this->_1_19[10] = "десять";
        $this->_1_19[11] = "одинадцять";
        $this->_1_19[12] = "дванадцять";
        $this->_1_19[13] = "тринадцять";
        $this->_1_19[14] = "чотирнадцять";
        $this->_1_19[15] = "п'ятнадцять";
        $this->_1_19[16] = "шістнадцять";
        $this->_1_19[17] = "сімнадцять";
        $this->_1_19[18] = "вісімнадцять";
        $this->_1_19[19] = "дев'ятнадцять";

        $this->des[2] = "двадцять";
        $this->des[3] = "тридцять";
        $this->des[4] = "сорок";
        $this->des[5] = "п'ятдесят";
        $this->des[6] = "шістдесят";
        $this->des[7] = "сімдесят";
        $this->des[8] = "вісімдесят";
        $this->des[9] = "дев'яносто";

        $this->hang[1] = "сто";
        $this->hang[2] = "двісті";
        $this->hang[3] = "триста";
        $this->hang[4] = "чотириста";
        $this->hang[5] = "п'ятсот";
        $this->hang[6] = "шістсот";
        $this->hang[7] = "сімсот";
        $this->hang[8] = "вісімсот";
        $this->hang[9] = "дев'ятьсот";
    }

    function Currency($amount)
    {
        $this->setCurrData(); // объявляем масиив переменных
        $last2 = substr($amount, -2); // последние 2 цифры
        $last1 = substr($amount, -1); // последняя 1 цифра
        $last3 = substr($amount, -3); //последние 3 цифры
        if ((strlen($amount) != 1 && substr($last2, 0, 1) == 1) || $last1 >= 5 || $last3 == '000') {
            $curr = $this->namecurr[3];
        } // от 10 до 19
        else if ($last1 == 1) {
            $curr = $this->namecurr[1];
        } // для 1-цы
        else {
            $curr = $this->namecurr[2];
        } // все остальные 2, 3, 4
        return ' ' . $curr;
    }

    public function setCurrData()
    {
        $this->namecurr[1] = "гривня"; // 1
        $this->namecurr[2] = "гривні"; // 2, 3, 4
        $this->namecurr[3] = "гривень"; // >4
    }

    public function GetNum($level, $amount)
    {
        $this->setNameData(); // объявляем массив переменных
        if ($level == 1) {
            $num_arr = null;
        } else if ($level == 2) {
            $num_arr = $this->nametho;
        } else if ($level == 3) {
            $num_arr = $this->namemil;
        } else if ($level == 4) {
            $num_arr = $this->namemrd;
        } else {
            $num_arr = null;
        }
        if (isset($num_arr)) {
            $last2 = substr($amount, -2);
            $last1 = substr($amount, -1);
            if ((strlen($amount) != 1 && substr($last2, 0, 1) == 1) || $last1 >= 5) {
                $res_num = $num_arr[3];
            } // 10-19
            else if ($last1 == 1) {
                $res_num = $num_arr[1];
            } // для 1-цы
            else {
                $res_num = $num_arr[2];
            } // все остальные 2, 3, 4
            return ' ' . $res_num;
        } # if
    }

    public function setNameData()
    {
        $this->nametho[1] = "тисяча"; // 1
        $this->nametho[2] = "тисячі"; // 2, 3, 4
        $this->nametho[3] = "тисяч"; // >4

        $this->namemil[1] = "мільйон"; // 1
        $this->namemil[2] = "мільйона"; // 2, 3, 4
        $this->namemil[3] = "мільйонів"; // >4

        $this->namemrd[1] = "мільярд"; // 1
        $this->namemrd[2] = "мільярда"; // 2, 3, 4
        $this->namemrd[3] = "мільярдів"; // >4
    }

} 