<?php

require(__DIR__.'/../../vendor/itbz/fpdf/makefont/makefont.php');
require(__DIR__.'/../../vendor/itbz/fpdf/src/fpdf/FPDF.php');
require(__DIR__.'/../../vendor/PHPMailer-master/class.phpmailer.php');
require(__DIR__.'/../Admin/PdfOrders.php');

class ApprovedController extends BaseController
{
	
	public function index()
	{
        if(Auth::getUser()->status == 1)
        {
            $approvedOnce = \Approved::where('AppID', '!=', 0)
                ->join('orders', 'orders.DocID', '=', 'transporter.DocID')
                ->join('status_inv', 'status_inv.statusType', '=', 'orders.status')
                //->where('orders.EmpID', '=', Auth::getUser()->EmpID)
                ->groupBy('orders.DocID')
                ->get(
                    [
                        'orders.created_at',
                        'orders.DocID',
                        'transporter.AppID',
                        'transporter.dateShipping',
                        'transporter.created_at',
                        'orders.CompName',
                        'orders.CompID',
                        'orders.StockID',
                        'status_inv.statusName',
                        'orders.status',
                        'orders.Kurs',
                        'orders.Qty',
                        'orders.PriceMC',
                        'orders.ProdID'
                    ]
                )->toArray();
        } else {
            $approvedOnce = \Approved::where('AppID', '!=', 0)
                ->join('orders', 'orders.DocID', '=', 'transporter.DocID')
                ->join('status_inv', 'status_inv.statusType', '=', 'orders.status')
                ->where('orders.EmpID', '=', Auth::getUser()->EmpID)
                ->groupBy('orders.DocID')
                ->get(
                    [
                        'orders.created_at',
                        'orders.DocID',
                        'transporter.AppID',
                        'transporter.dateShipping',
                        'transporter.created_at',
                        'orders.CompName',
                        'orders.CompID',
                        'orders.StockID',
                        'status_inv.statusName',
                        'orders.status',
                        'orders.Kurs',
                        'orders.Qty',
                        'orders.PriceMC',
                        'orders.ProdID'
                    ]
                )->toArray();
        }
        $total = '';
        $totalMC = '';
        $totalCC = '';
        $price = [];
        foreach($approvedOnce as $key => $value)
        {
            $totalCC += $total/$value['Kurs'];
            $total = $value['Qty']*$value['PriceMC'];
            $totalMC += $total;
            $price[$value['DocID']] = round($totalMC, 2);
        }
        foreach($approvedOnce as $key => $value)
        {
            foreach($price as $k => $val)
            {
                if($k == $value['DocID'])
                {
                    $approvedOnce[$key]['totalPriceMC'] = $val;
                }
            }
        }
        return View::make('approved-list', compact('approvedOnce'));
	}

    public function sendPDF()
    {
        $appID = Input::get('appID');
        $this->createPdfApproved($appID);
        $msg = 'Заявка отправлена';
        $this->sendApproved('Заявка на відбір товару.pdf', $appID);
        return View::make('msg', compact(['msg']));
    }

    public function createPdfApproved($appID)
    {
        $appArr = \Approved::where('AppID', '=', $appID)
            ->get()->last();
        $orderID = $appArr->DocID;
        $dateShipping = explode(' ',$appArr->dateShipping);
        $arrDate = explode('-',$dateShipping[0]);
        $strDate = $arrDate[2].'.'.$arrDate[1].'.'.$arrDate[0];
        $date = explode(' ', $appArr->created_at);
        $dateArr = explode('-', $date[0]);
        $strCDate = $dateArr[2].'.'.$dateArr[1].'.'.$dateArr[0];
        $orders = \Orders::where('DocID', '=', $orderID)
            ->join('prods', 'prods.ProdID', '=', 'orders.ProdID')
            ->where('status', '=', 3)
            ->groupBy('ProdID')
            ->get(
                [
                    'orders.DocID',
                    'orders.Kurs',
                    'orders.CompID',
                    'orders.CompName',
                    'orders.ProdID',
                    'prods.ProdName',
                    'orders.CodeID3',
                    'orders.UM',
                    'orders.Qty',
                    'orders.PriceMC',
                    'orders.SumPrice',
                    'orders.PLID',
                    'orders.EmpID',
                    'orders.StockID'
                ]
            )->toArray();
        $compName = $orders[0]['CompName'];
        $transporter = \Transporter::where('transporterID', '=', $appArr->transporterID)
            ->get(['transporterName'])->last();
        $city = trim($appArr->cityName);
        $StockID = $orders[0]['StockID'];
        $TWeight = '';
        $prodBody = [];
        $TQty = '';
        $strTransporter = $transporter->transporterName;
        $specialNotes = $appArr->specialNotes;
        $html = '';
        $html .= '<!doctype html><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <style>
            * {
                    font-family: DejaVu Sans, font-size: 5px;
                }
            table
            {
                margin: 0;
                padding: 0;
                border-collapse: collapse;
            }
            td, th
            {
                padding: .1em 1em;
                border: 1px solid #999;
            }
            .table-container
            {
                width: 100%;
                _overflow: auto;
                margin: 0 0;
            }
        </style></head><body>
        <table style="border: 1px solid white;  border-collapse: collapse; width: 100%;">
            <tr style="border: 1px solid white;  border-collapse: collapse; ">
                <td rowspan="2" style="width: 80%; font-size: 14px; font-weight: bold; border: 1px solid white;  border-collapse: collapse;">Заявка на відбір товару</td>
                <td style="width: 20%; font-size: 10px; font-weight: bold; border: 1px solid white;  border-collapse: collapse;">Номер: </td>
                <td style="width: 20%; font-size: 10px; font-weight: bold; border: 1px solid white;  border-collapse: collapse;">'.$appID.'</td>
            </tr>
            <tr style="border: 1px solid white;  border-collapse: collapse;">
                <td style="width: 20%; font-size: 10px; font-weight: bold; border: 1px solid white;  border-collapse: collapse;">Дата: </td>
                <td style="width: 20%; font-size: 10px; font-weight: bold; border: 1px solid white;  border-collapse: collapse;">'.$strCDate.'</td>
            </tr>
        </table><hr>
        <div class="table-container">
            <table style="width: 100%;">
                <thead>
                    <tr>
                        <td style="align-content: center; text-align: center; font-size: 10px;">Дата відвантаження</td>
                        <td style="align-content: center; text-align: center; font-size: 10px;">Перевізник</td>
                        <td style="align-content: center; text-align: center; font-size: 10px;">Місто</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="align-content: center; text-align: center; font-size: 14px; font-weight: bold;">'.$strDate.'</td>
                        <td style="align-content: center; text-align: center; font-size: 14px; font-weight: bold;">'.$strTransporter.'</td>
                        <td style="align-content: center; text-align: center; font-size: 14px; font-weight: bold;">'.$city.'</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr style="width: 100%;">
                        <td colspan="3" style="text-align: center; align-content: center; font-size: 10px;">Особливі відмітки</td>
                    </tr>
                    <tr style="width: 100%;">
                        <td colspan="3" style="text-align: center; align-content: center; font-size: 14px; font-weight: bold;">'.$specialNotes.'</td>
                    </tr>
                </tfoot>
            </table><br/><br/>
            <table style="width: 100%;">
                <thead>
                    <tr>
                        <td style="text-align: center; align-content: center; font-size: 12px; font-weight: bold;">Фірма</td>
                        <td style="text-align: center; align-content: center; font-size: 12px; font-weight: bold;">Алиста</td>
                        <td style="text-align: center; align-content: center; font-size: 12px; font-weight: bold;">1</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align: center; align-content: center; font-size: 12px;">Предприятие</td>
                        <td style="text-align: center; align-content: center; font-size: 12px;">'.$compName.'</td>
                        <td style="text-align: center; align-content: center; font-size: 12px;"></td>
                    </tr>
                    <tr>
                        <td style="text-align: center; align-content: center; font-size: 12px;">Відправник товару</td>
                        <td style="text-align: center; align-content: center; font-size: 12px;">Скдад метизов</td>
                        <td style="text-align: center; align-content: center; font-size: 12px;">'.$StockID.'</td>
                    </tr>
                    <tr>
                        <td style="text-align: center; align-content: center; font-size: 12px;">Адреса</td>
                        <td style="text-align: center; align-content: center; font-size: 12px;">Дніпропетровськ, вул. Героїв Сталінграда, буд.147</td>
                        <td style="text-align: center; align-content: center; font-size: 12px;"></td>
                    </tr>
                </tbody>
            </table><br/><br/>
            <table style="width: 100%;">
                <thead>
                    <tr>
                        <td style="text-align: center; align-content: center; font-size: 12px; font-weight: bold; overflow-y: hidden; margin: 0; padding: 0;">Код</td>
                        <td style="text-align: center; align-content: center; font-size: 12px; font-weight: bold; overflow-y: hidden; margin: 0; padding: 0;">Товар</td>
                        <td style="text-align: center; align-content: center; font-size: 12px; font-weight: bold; overflow-y: hidden; margin: 0; padding: 0;">Дод.Од.Вим.</td>
                        <td style="text-align: center; align-content: center; font-size: 12px; font-weight: bold; overflow-y: hidden; margin: 0; padding: 0;">Дод.кількість</td>
                        <td style="text-align: center; align-content: center; font-size: 12px; font-weight: bold; overflow-y: hidden; margin: 0; padding: 0;">Од.Вим.</td>
                        <td style="text-align: center; align-content: center; font-size: 12px; font-weight: bold; overflow-y: hidden; margin: 0; padding: 0;">Кількість</td>
                        <td style="text-align: center; align-content: center; font-size: 12px; font-weight: bold; overflow-y: hidden; margin: 0; padding: 0;">Загальна кількість</td>
                </tr></thead><tbody>';
        foreach($orders as $key => $value)
        {
            $TQty += $value['Qty'];
            $prod = DB::select("SELECT Weight FROM prods WHERE ProdID =".$value['ProdID']);
            $Weight = $prod[0]->Weight * $value['Qty'];
            $TWeight += $Weight;
            $arrRem = DB::select("SELECT SUM(r.RemUnCash + r.RemCash) as Rem FROM  Rem r"
                ." WHERE r.ProdID = ". $value['ProdID']
                ." AND r.StockID =".$orders[0]['StockID']);
            $prodBody[$key][] = $arrRem[0]->Rem;
            $html .= '<tr>
                <td style="text-align: center; align-content: center; font-size: 12px; overflow-y: hidden; margin: 0; padding: 0;">'.$value['ProdID'].'</td>
                <td style="text-align: center; align-content: center; font-size: 12px; overflow-y: hidden; margin: 0; padding: 0;">'.$value['ProdName'].'</td>
                <td style="text-align: center; align-content: center; font-size: 12px; overflow-y: hidden; margin: 0; padding: 0;">'.$value['UM'].'</td>
                <td style="text-align: center; align-content: center; font-size: 12px; overflow-y: hidden; margin: 0; padding: 0;">'.round($value['Qty'],2).'</td>
                <td style="text-align: center; align-content: center; font-size: 12px; overflow-y: hidden; margin: 0; padding: 0;">'.$value['UM'].'</td>
                <td style="text-align: center; align-content: center; font-size: 12px; overflow-y: hidden; margin: 0; padding: 0;">'.round($value['Qty'],2).'</td>
                <td style="text-align: center; align-content: center; font-size: 12px; overflow-y: hidden; margin: 0; padding: 0;">'.$arrRem[0]->Rem.'</td>
            </tr>';
        }
        $html .= '</tbody></table><br/>
        <table style="border: 1px solid white;  border-collapse: collapse; width: 100%;">
            <tr style="border: 1px solid white;  border-collapse: collapse; ">
                <td rowspan="3" style="border: 1px solid white;  border-collapse: collapse; width: 70%;"></td>
                <td style="font-size: 10px; font-weight: bold; border: 1px solid white;  border-collapse: collapse;">Кількість: </td>
                <td style="font-size: 10px; font-weight: bold; border: 1px solid white;  border-collapse: collapse;">'.$TQty.'</td>
            </tr>
            <tr style="border: 1px solid white;  border-collapse: collapse;">
                <td style="font-size: 10px; font-weight: bold; border: 1px solid white;  border-collapse: collapse;">Додаткова кількість: </td>
                <td style="font-size: 10px; font-weight: bold; border: 1px solid white;  border-collapse: collapse;">'.$TQty.'</td>
            </tr>
            <tr style="font-size: 10px; font-weight: bold; border: 1px solid white;  border-collapse: collapse;">
                <td style="font-size: 10px; font-weight: bold; border: 1px solid white;  border-collapse: collapse;">Вага: </td>
                <td style="font-size: 10px; font-weight: bold; border: 1px solid white;  border-collapse: collapse;">'.$TWeight.'</td>
            </tr>
        </table>
        <br/>
        <table style="border: 1px solid white;  border-collapse: collapse; width: 100%;">
            <tr style="border: 1px solid white;  border-collapse: collapse;">
                <th style="margin: 20px; padding: 20px; font-size: 12px; font-weight: bold; border: 1px solid white; border-collapse: collapse;">Дозволив</th>
                <th style="margin: 20px; padding: 20px; font-size: 12px; font-weight: bold; border: 1px solid white; border-collapse: collapse;">Відпустив</th>
                <th style="margin: 20px; padding: 20px; font-size: 12px; font-weight: bold; border: 1px solid white; border-collapse: collapse;">Узгодив</th>
            </tr>
            <tr style="border: 1px solid white;  border-collapse: collapse;">
                <th style="border: 1px solid white; border-collapse: collapse;"><hr></th>
                <th style="border: 1px solid white; border-collapse: collapse;"><hr></th>
                <th style="border: 1px solid white; border-collapse: collapse;"><hr></th>
            </tr>
            <tr  style="border: solid white;  border-collapse: collapse;">
                <td style="font-size: 8px; text-align: right; border: 1px solid white; border-collapse: collapse;">ПІБ Підпис</td>
                <td style="font-size: 8px; text-align: right; border: 1px solid white; border-collapse: collapse;">ПІБ Підпис</td>
                <td style="font-size: 8px; text-align: right; border: 1px solid white; border-collapse: collapse;">ПІБ Підпис</td>
            </tr>
        </table></div></body></html>';
        $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
        $bpdf = \BPDF::loadHTML($html, 'UTF-8');
        $bpdf->setPaper('a4')->setOrientation('portrait')->setWarnings(false)->save('Заявка на відбір товару.pdf');
    }

    public function sendApproved($filename, $appID)
    {

        $mailer = new PHPMailer();
        $appArr = \Approved::where('AppID', '=', $appID)->get(['DocID'])->last();
        $orderObj = \Orders::where('DocID', '=', $appArr->DocID)->get()->last();
        if($orderObj->StockID == 110)
        {
            $user = \Emps::where('EmpID', '=', Auth::getUser()->EmpID)->get()->last();
            $mailer->CharSet = 'utf-8';
            $mailer->AddReplyTo(Auth::getUser()->email, $user->EmpName);
            $mailer->SetFrom('webmaster@metiz.alista.org.ua', $user->EmpName);
            $mailer->AddAddress('kyzmenkos@const.dp.ua', "Кузьменко Сергей Иванович");
            $mailer->AddCC('kyzmenkos@const.dp.ua', "Кузьменко Сергей Иванович");
            $mailer->AddAddress('afanasyevd@alista.com.ua', "Афанасьев Дмитрий Вадимович");
            $mailer->AddCC('afanasyevd@alista.com.ua', "Афанасьев Дмитрий Вадимович");
            $mailer->AddAddress('kurasova@alista.com.ua', "Курасова Светлана Васильевна");
            $mailer->AddCC('kurasova@alista.com.ua', "Курасова Светлана Васильевна");
            $mailer->AddAddress('tsebrenko@alista.com.ua', "Цебренко Алина Витальевна");
            $mailer->AddCC('tsebrenko@alista.com.ua', "Цебренко Алина Витальевна");
            $mailer->AddAddress('krutijk@alista.com.ua', "Крутий Константин Игоревич");
            $mailer->AddCC('krutijk@alista.com.ua', "Крутий Константин Игоревич");
            $mailer->AddAddress('glazunov@alista.com.ua', "Глазунов Петр Алимович");
            $mailer->AddCC('glazunov@alista.com.ua', "Глазунов Петр Алимович");
            $mailer->addBCC('glazunov@alista.com.ua', "Глазунов Петр Алимович");
            $mailer->Subject = "Заявка на ".$orderObj->CompName;
            $mailer->AltBody = "Заявка на ".$orderObj->CompName;
            $mailer->MsgHTML('<h1>Заявка на '.$orderObj->CompName.'</h1>');
            $mailer->AddAttachment($filename);
            if(!$mailer->Send()) {
                return "Mailer Error: " . $mailer->ErrorInfo;
            } else {
                return "Message sent!";
            }
        } else {
            $user = \Emps::where('EmpID', '=', Auth::getUser()->EmpID)->get()->last();
            $mailer->CharSet = 'utf-8';
            $mailer->AddReplyTo(Auth::getUser()->email, $user->EmpName);
            $mailer->SetFrom('webmaster@metiz.alista.org.ua', $user->EmpName);
            $mailer->AddAddress('kyzmenkos@const.dp.ua', "Кузьменко Сергей Иванович");
            $mailer->AddCC('kyzmenkos@const.dp.ua', "Кузьменко Сергей Иванович");
            $mailer->AddAddress('kurasova@alista.com.ua', "Курасова Светлана Васильевна");
            $mailer->AddCC('kurasova@alista.com.ua', "Курасова Светлана Васильевна");
            $mailer->AddAddress('tsebrenko@alista.com.ua', "Цебренко Алина Витальевна");
            $mailer->AddCC('tsebrenko@alista.com.ua', "Цебренко Алина Витальевна");
            $mailer->AddAddress('afanasyevd@alista.com.ua', "Афанасьев Дмитрий Вадимович");
            $mailer->AddCC('afanasyevd@alista.com.ua', "Афанасьев Дмитрий Вадимович");
            $mailer->AddAddress('melnik@alista.com.ua', "Мельник Александр Александрович");
            $mailer->AddCC('melnik@alista.com.ua', "Мельник Александр Александрович");
            $mailer->AddAddress('krutijk@alista.com.ua', "Крутий Константин Игоревич");
            $mailer->AddCC('krutijk@alista.com.ua', "Крутий Константин Игоревич");
            $mailer->AddAddress('glazunov@alista.com.ua', "Глазунов Петр Алимович");
            $mailer->AddCC('glazunov@alista.com.ua', "Глазунов Петр Алимович");
            $mailer->addBCC('glazunov@alista.com.ua', "Глазунов Петр Алимович");
            $mailer->Subject = "Заявка на отбор товара";
            $mailer->AltBody = "Заявка на отбор товара";
            $mailer->MsgHTML('<h1> Заявка на отбор товара </h1>');
            $mailer->AddAttachment($filename);
            if(!$mailer->Send()) {
                return "Mailer Error: " . $mailer->ErrorInfo;
            } else {
                return "Message sent!";
            }
        }
    }

}

class PDF_MC_Table extends \fpdf\FPDF
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
        $this->AddFont('Tahoma-Bold','','tahoma_bold.php');
        $this->SetFont('Tahoma-Bold','',14);
        $this->Cell(145, 10, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", 'Заявка на відбір товару'), 0);
        $this->AddFont('Tahoma-Bold','','tahoma_bold.php');
        $this->SetFont('Tahoma-Bold','',8);
        $this->Cell(25, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", 'Номер: '), 0, 0, 'R');
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
        $this->AddFont('Tahoma','','tahoma.php');
        $this->SetFont('Tahoma','',5);
        $this->Cell(0,10, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE",'Сторінка').$this->PageNo().'/{nb}',0,0,'R');
    }

    function SetWidths($w)
    {
        //Set the array of column widths
        $this->widths=$w;
    }

    function SetAligns($a)
    {
        //Set the array of column alignments
        $this->aligns=$a;
    }

    function Row($data)
    {
        //Calculate the height of the row
        $nb=0;
        foreach($data as $key => $value)
            if(isset($nd) && isset($data[$key]))
            {
                $nb=max($nb, $this->NbLines($this->widths[$key], $data[$$key]));
            }
        $h=5*$nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        foreach($data as $key => $value)
        {
            if(isset($this->widths[$key]))
                $w=$this->widths[$key];
            $a=isset($this->aligns[$key]) ? $this->aligns[$key] : 'C';
            //Save the current position
            $x=$this->GetX();
            $y=$this->GetY();
            //Draw the border
            $this->Rect($x, $y, $w, $h);
            //Print the text
            $this->MultiCell($w, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE",$data[$key]), 1, $a);
            //Put the position to the right of the cell
            $this->SetXY($x+$w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function RowExtended($data, $height=10, $border=1, $align='C')
    {
        //Calculate the height of the row
        $nb=0;
        foreach($data as $key => $value)
            if(isset($nd) && isset($data[$key]))
            {
                $nb=max($nb, $this->NbLines($this->widths[$key], $data[$$key]));
            }
        $h=5*$nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        foreach($data as $key => $value)
        {
            if(isset($this->widths[$key]))
                $w=$this->widths[$key];
            $a=isset($this->aligns[$key]) ? $this->aligns[$key] : $align;
            //Save the current position
            $x=$this->GetX();
            $y=$this->GetY();
            //Draw the border
            //Print the text
            $this->MultiCell($w, $height, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE",$data[$key]), $border, $a);
            //Put the position to the right of the cell
            $this->SetXY($x+$w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function RowWithoutBorder($data)
    {
        //Calculate the height of the row
        $nb=0;
        foreach($data as $key => $value)
            if(isset($nd) && isset($data[$key]))
            {
                $nb=max($nb, $this->NbLines($this->widths[$key], $data[$$key]));
            }
        $h=5*$nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        foreach($data as $key => $value)
        {
            if(isset($this->widths[$key]))
                $w=$this->widths[$key];
            $a=isset($this->aligns[$key]) ? $this->aligns[$key] : 'C';
            //Save the current position
            $x=$this->GetX();
            $y=$this->GetY();
            //Draw the border
            //Print the text
            $this->MultiCell($w, 10, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE",$data[$key]), 0, $a);
            //Put the position to the right of the cell
            $this->SetXY($x+$w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function RowToSigners($data)
    {
        //Calculate the height of the row
        $nb=0;
        foreach($data as $key => $value)
            if(isset($nd) && isset($data[$key]))
            {
                $nb=max($nb, $this->NbLines($this->widths[$key], $data[$$key]));
            }
        $h=5*$nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        foreach($data as $key => $value)
        {
            if(isset($this->widths[$key]))
                $w=$this->widths[$key];
            $a=isset($this->aligns[$key]) ? $this->aligns[$key] : 'L';
            //Save the current position
            $x=$this->GetX();
            $y=$this->GetY();
            //Draw the border
            //Print the text
            $this->MultiCell($w, 10, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE",$data[$key]), 0, $a);
            //Put the position to the right of the cell
            $this->SetXY($x+$w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h)
    {
        //If the height h would cause an overflow, add a new page immediately
        if($this->GetY()+$h>$this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w, $txt)
    {
        //Computes the number of lines a MultiCell of width w will take
        $cw=&$this->CurrentFont['cw'];
        if($w==0)
            $w=$this->w-$this->rMargin-$this->x;
        $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
        $s=str_replace("\r", '', $txt);
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

}