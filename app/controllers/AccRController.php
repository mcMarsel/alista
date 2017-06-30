<?php

require(__DIR__ . '/../../vendor/itbz/fpdf/makefont/makefont.php');
require(__DIR__ . '/../../vendor/itbz/fpdf/src/fpdf/FPDF.php');
require(__DIR__ . '/../../vendor/PHPMailer-master/class.phpmailer.php');
require(__DIR__ . '/../Admin/PdfOrders.php');

class AccRController extends BaseController
{

    public function approved()
    {
        echo "<pre>";
        print_r(Input::all());
        echo "</pre>";
    }

    public function createPdfApproved($dateShipping, $orderID, $transporterID, $specialNote, $city)
    {
        $arrDate = explode('-', $dateShipping);
        $strDate = $arrDate[2] . '.' . $arrDate[1] . '.' . $arrDate[0];
        $fpdf = new PDF_MC_Table();
        $fpdf->data($orderID, $strDate);
        $fpdf->AliasNbPages();
        $fpdf->Open();
        $fpdf->AddPage();
        $fpdf->SetAutoPageBreak(true, 15);
        $fpdf->AliasNbPages();
        $fpdf->SetMargins(10, 10, 10);
        $fpdf->SetTextColor(0, 0, 0);
        $fpdf->Ln();
        $fpdf->AddFont('Tahoma', '', 'tahoma.php');
        $fpdf->SetFont('Tahoma', '', 10);
        $header[0] = [0 => 'Дата відвантаження', 1 => 'Перевізник', 2 => 'Місто'];
        $fpdf->SetWidths([35, 55, 105]);
        foreach ($header as $key => $value) {
            $fpdf->RowExtended($value, 15, 1, 'C');
            $fpdf->Ln();
        }
        $transporter = \Transporter::where('transporterID', '=', $transporterID)
            ->get(['transporterName'])->last()->toArray();
        $order = \Orders::where('DocID', '=', $orderID)
            ->where('status', '=', 1)
            ->get()->last()->toArray();
        $orderArr = \Orders::where('DocID', '=', $orderID)
            ->where('status', '=', 1)
            ->get()->toArray();
        $comp = \Comps::where('CompID', '=', $order['CompID'])->get()->last()->toArray();
        $headerP[0] = [0 => $strDate, 1 => $transporter['transporterName'], 2 => trim($city)];
        $fpdf->AddFont('Tahoma-Bold', '', 'tahoma_bold.php');
        $fpdf->SetFont('Tahoma-Bold', '', 10);
        $fpdf->SetWidths([35, 55, 105]);
        foreach ($headerP as $key => $value) {
            $fpdf->RowExtended($value, 15, 1, 'C');
            $fpdf->Ln();
        }
        $fpdf->AddFont('Tahoma', '', 'tahoma.php');
        $fpdf->SetFont('Tahoma', '', 10);
        $fpdf->Cell(195, 10, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", 'Особливі відмітки'), 1, 0, 'C');
        $fpdf->Ln();
        $fpdf->AddFont('Tahoma-Bold', '', 'tahoma_bold.php');
        $fpdf->SetFont('Tahoma-Bold', '', 14);
        $specialNotes = [0 => $specialNote];
        $fpdf->SetWidths([195]);
        $fpdf->RowExtended($specialNotes, 5, 1, 'C');
        $fpdf->Ln(30);
        $headerOur[0] = [0 => 'Фірма', 1 => 'Алиста', 2 => 1];
        $headerComp[0] = [0 => 'Предприятие', 1 => $comp['CompName'], 2 => ''];
        $headerTr[0] = [0 => 'Відправник товару', 1 => 'Склад метизов', 2 => $order['StockID']];
        $headerAd[0] = [0 => 'Адреса', 1 => 'Днепропетровск, вул. Героїв Сталінграда, буд.147', 2 => ''];
        $fpdf->AddFont('Tahoma-Bold', '', 'tahoma_bold.php');
        $fpdf->SetFont('Tahoma-Bold', '', 8);

        $fpdf->SetWidths([45, 105, 45]);
        foreach ($headerOur as $key => $value) {
            $fpdf->Row($value);
            $fpdf->Ln();
        }
        $fpdf->AddFont('Tahoma', '', 'tahoma.php');
        $fpdf->SetFont('Tahoma', '', 8);
        foreach ($headerComp as $row => $col) {
            $fpdf->Cell(45, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", $col[0]), 1, 0, 'C');
            $fpdf->Cell(105, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", $col[1]), 1, 0, 'C');
            $fpdf->Cell(45, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", $col[2]), 1, 0, 'C');
            $fpdf->Ln();
        }
        $fpdf->AddFont('Tahoma', '', 'tahoma.php');
        $fpdf->SetFont('Tahoma', '', 8);
        foreach ($headerTr as $row => $col) {
            $fpdf->Cell(45, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", $col[0]), 1, 0, 'C');
            $fpdf->Cell(105, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", $col[1]), 1, 0, 'C');
            $fpdf->Cell(45, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", $col[2]), 1, 0, 'C');
            $fpdf->Ln();
        }
        $fpdf->AddFont('Tahoma', '', 'tahoma.php');
        $fpdf->SetFont('Tahoma', '', 8);
        foreach ($headerAd as $row => $col) {
            $fpdf->Cell(45, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", $col[0]), 1, 0, 'C');
            $fpdf->Cell(105, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", $col[1]), 1, 0, 'C');
            $fpdf->Cell(45, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", $col[2]), 1, 0, 'C');
            $fpdf->Ln();
        }
        $fpdf->AddFont('Tahoma', '', 'tahoma.php');
        $fpdf->SetFont('Tahoma', '', 8);
        $prodHead[0] = [0 => 'Код', 1 => 'Товар', 2 => 'Дод.Од.Вим.', 3 => 'Дод.кільк.', 4 => 'Од.Вим.',
            5 => 'Кількість', 6 => 'Загальна кількість'];
        $orders = \Orders::where('DocID', '=', $orderID)
            ->where('status', '!=', 10)
            ->get(['ProdID', 'ProdName', 'UM', 'Qty', 'UM'])->toArray();
        $prodBody = [];
        $totalWeight = '';
        foreach ($orders as $key => $value) {
            $prod = \Prods::where('ProdID', '=', $value['ProdID'])
                ->get(['Weight'])->last();
            $Weight = $prod['Weight'] * $value['Qty'];
            $totalWeight += $Weight;
        }
        foreach ($orders as $key => $value) {
            $rem = '';
            $prodBody[$key][] = $value['ProdID'];
            $prodBody[$key][] = $value['ProdName'];
            $prodBody[$key][] = $value['UM'];
            $prodBody[$key][] = round($value['Qty'], 1);
            $prodBody[$key][] = $value['UM'];
            $prodBody[$key][] = round($value['Qty'], 1);
            $arrRem = \Rem::where('StockID', '=', $order['StockID'])
                ->where('ProdID', '=', $value['ProdID'])->get()->toArray();
            foreach ($arrRem as $k => $val) {
                $rem += $val['RemCash'];
                $rem += $val['RemUncash'];
            }
            $prodBody[$key][] = round($rem, 2);
        }
        $fpdf->AddFont('Tahoma-Bold', '', 'tahoma_bold.php');
        $fpdf->SetFont('Tahoma-Bold', '', 8);
        $fpdf->Ln(10);
        $fpdf->SetWidths([10, 75, 20, 20, 20, 20, 30]);
        foreach ($prodHead as $key => $value) {
            $fpdf->RowExtended($value, 5, 1, 'C');
            $fpdf->Ln();
        }
        $fpdf->AddFont('Tahoma', '', 'tahoma.php');
        $fpdf->SetFont('Tahoma', '', 8);
        $fpdf->SetWidths([10, 75, 20, 20, 20, 20, 30]);
        if (empty($prodBody)) {
            return ['error' => 'Нет партии для товаров'];
        } else {
            foreach ($prodBody as $key => $value) {
                $fpdf->RowExtended($value, 7, 1, 'L');
                $fpdf->Ln();
            }
            $fpdf->Ln(5);
            $totalQty = '';
            foreach ($orders as $key => $value) {
                $totalQty += $value['Qty'];
            }
            $fpdf->AddFont('Tahoma-Bold', '', 'tahoma_bold.php');
            $fpdf->SetFont('Tahoma-Bold', '', 8);
            $fpdf->Cell(180, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", 'Кількість'), 0, 0, 'R');
            $fpdf->Cell(15, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", $totalQty), 0, 0);
            $fpdf->Ln();
            $fpdf->Cell(180, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", 'Додаткова Кількість'), 0, 0, 'R');
            $fpdf->Cell(15, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", $totalQty), 0, 0);
            $fpdf->Ln();
            $fpdf->Cell(180, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", 'Вага'), 0, 0, 'R');
            $fpdf->Cell(15, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", $totalWeight), 0, 0);
            $fpdf->Ln(5);
            $signers = [0 => 'Дозволив', 1 => 'Відпустив', 2 => 'Узгодив'];
            $lineArr = [0 => '_______________________', 1 => '_______________________', 2 => '_______________________'];
            $signersPart = [0 => 'ПІБ Підпис', 1 => 'ПІБ Підпис', 2 => 'ПІБ Підпис'];
            $fpdf->SetWidths([65, 65, 65]);
            $fpdf->AddFont('Tahoma-Bold', '', 'tahoma_bold.php');
            $fpdf->SetFont('Tahoma-Bold', '', 8);
            $fpdf->RowExtended($signers, 10, 0, 'L');
            $fpdf->Ln(7);
            $fpdf->RowExtended($lineArr, 10, 0, 'L');
            $fpdf->Ln(3);
            $fpdf->AddFont('Tahoma', '', 'tahoma.php');
            $fpdf->SetFont('Tahoma', '', 5);
            $fpdf->RowExtended($signersPart, 10, 0, 'C');
            $fpdf->Footer();
            $fileName = 'Заявка на відбір товару.pdf';
            $fpdf->Output($fileName, false);
            $pdfMerge = new \Clegginabox\PDFMerger\PDFMerger;
            $pdfMerge->addPDF($fileName, 'all');
            $pdfMerge->merge('file', $fileName, 'P');
            return $fileName;
        }

    }

    public function approvedDone()
    {
        $orderID = Input::get('orderID');
        if (Input::get('dateShipping')) {
            $dateShipping = Input::get('dateShipping');
        } else {
            $dateShipping = '';
        }
        if (Input::get('originator')) {
            $originator = Input::get('originator');
        } else {
            $originator = '';
        }
        if (Input::get('transporterID')) {
            $transporterID = Input::get('transporterID');
            $transporter = \Transporter::where('transporterID', '=', $transporterID)
                ->get(['transporterName'])->last()->toArray();
        } else {
            $transporterID = '';
            $transporter = '';
        }
        if (Input::get('city')) {
            $cityID = Input::get('city');
            $city = \City::where('cityID', '=', $cityID)->get(['cityName'])->last()->toArray();
        } else {
            $cityID = '';
            $city['cityName'] = '';
        }
        if ($transporterID == 1 && Input::get('StockID') == 118) {
            $cityID = 1000;
            $city['cityName'] = 'Киев';

        } else if ($transporterID == 1 && Input::get('StockID') == 110) {
            $cityID = 49000;
            $city['cityName'] = 'Днепропетровск';
        }
        if (Input::get('getCash')) {
            $getCash = Input::get('getCash');
            if ($getCash == 0) {
                $getCash = 'На карту';
            } else if ($getCash == 1) {
                $getCash = 'По факту';
            } else if ($getCash == 2) {
                $getCash = 'Наложенный платеж';
            } else {
                $getCash = '';
            }
        } else {
            $getCash = '';
        }
        if (Input::get('address')) {
            $address = Input::get('address');
            \CompAdd::where('CompID', '=', Input::get('CompID'))
                ->update(['CompAdd' => $address]);
        } else if (Input::get('addressSel')) {
            $address = Input::get('addressSel');
        } else {
            $address = '';
        }
        if (Input::get('addressee')) {
            $addressee = Input::get('addressee');
            \CompContact::where('CompID', '=', Input::get('CompID'))
                ->update(['Contact' => $addressee]);
        } else if (Input::get('addresseeSel')) {
            $addressee = Input::get('addresseeSel');
        } else {
            $addressee = '';
        }

        if (Input::get('payer')) {
            $payer = Input::get('payer');
        } elseif (Input::get('payerT')) {
            $payer = Input::get('payerT');
        } else {
            $payer = '';
        }
        if (Input::get('payForm')) {
            $payForm = Input::get('payForm');
        } else {
            $payForm = '';
        }
        if (Input::get('specialNotes')) {
            $specialNotes = Input::get('specialNotes');
        } else {
            $specialNotes = '';
        }
        if (Input::get('stockTransporter')) {
            $stockTransporter = Input::get('stockTransporter');
        } else {
            $stockTransporter = '';
        }
        //$orderID, $dateShipping, $getCash, $transporterID, $transporterName, $cityID, $cityName,
        //$originator, $addressee, $payer, $address, $stockTransporter, $payForm, $specialNotes
        /*$filename = $this->createPdfApproved(
            $dateShipping,
            $orderID,
            $transporterID,
            $specialNotes,
            $city['cityName']
        );*/
        /*if(is_array($filename))
        {
            $msg = 'По всем позиция нет подходящей партии с нужным количеством. Проверьте количество';
            return View::make('msg', compact(['msg']));
        } else {*/
        $this->approvedToDB(
            $orderID,
            $dateShipping,
            $getCash,
            $transporterID,
            $transporter['transporterName'],
            $cityID,
            $city['cityName'],
            $originator,
            $addressee,
            $payer,
            $address,
            $stockTransporter,
            $payForm,
            $specialNotes
        );
        $msg = 'Заявка в процесе формирования. Чтобы отправить заявку на склад перейдите в реестр заявок на отбор используя навигацию.';
        //$this->sendApproved($filename, $orderID);
        return View::make('msg', compact(['msg']));
        //}
    }

    public function approvedToDB($orderID, $dateShipping, $getCash, $transporterID, $transporterName, $cityID, $cityName, $originator, $addressee, $payer, $address, $stockTransporter, $payForm, $specialNotes)
    {
        $approved = \Approved::create(
            [
                'DocID' => $orderID,
                'dateShipping' => $dateShipping,
                'getCash' => $getCash,
                'transporterID' => $transporterID,
                'transporterName' => $transporterName,
                'cityID' => $cityID,
                'cityName' => $cityName,
                'originator' => $originator,
                'addressee' => $addressee,
                'payer' => $payer,
                'address' => $address,
                'stockTransporter' => $stockTransporter,
                'payForm' => $payForm,
                'specialNotes' => $specialNotes
            ]
        );
        $approved->save();
        \Orders::where('DocID', '=', $orderID)->update(['status' => 2]);
    }

    public function getCompID()
    {

        $compID = \Orders::where('orderID', '=', Input::get('id'))->get(['CompID'])->toArray();
        if (empty($compID)) {
            $compID = \Orders::where('DocID', '=', Input::get('id'))->get(['CompID'])->last()->toArray();
        } else {
            $compID = \Orders::where('orderID', '=', Input::get('id'))->get(['CompID'])->last()->toArray();
        }
        return $compID['CompID'];
    }

    public function approvedOrder()
    {
        clearstatcache(true, 'public/packages/manager/approved-order.js');
        $orderID = Input::get('orderID');
        $ord = \Orders::where('orderID', '=', $orderID)->get()->toArray();
        if (empty($ord)) {
            $orderType = 'DocID';
        } else {
            $orderType = 'orderID';
        }
        $order = \Orders::where($orderType, '=', $orderID)->get()->last()->toArray();
        $CodeID3 = $order['CodeID3'];
        $StockID = $order['StockID'];
        $CompID = $order['CompID'];
        $CompName = $order['CompName'];
        $compAdd = \CompAdd::where('CompID', '=', $CompID)->get()->toArray();
        $compContact = \CompContact::where('CompID', '=', $CompID)->get()->toArray();
        $compAddID = [];
        $compAddName = [];
        $compContactID = [];
        $compContactName = [];
        foreach ($compAdd as $key => $value) {
            array_push($compAddID, $value['CompAdd']);
            array_push($compAddName, $value['CompAdd']);
        }
        unset($compAdd);
        $compAdd = array_combine($compAddID, $compAddName);
        foreach ($compContact as $key => $value) {
            array_push($compContactID, $value['ContactAll']);
            array_push($compContactName, $value['ContactAll']);
        }
        unset($compContact);
        $compContact = array_combine($compContactID, $compContactName);
        $transporter = \Transporter::get()->toArray();
        $transporterID = [];
        $transporterName = [];
        foreach ($transporter as $key => $value) {
            array_push($transporterID, $value['transporterID']);
            array_push($transporterName, $value['transporterName']);
        }
        unset($transporter);
        $transporter = array_combine($transporterID, $transporterName);

        /*echo "<pre>";
        print_r($compAdd);
        print_r($compContact);
        echo "</pre>";*/
        /*if(empty($compContact)){

        }*/
        return View::make('accr.approved', compact(
            [
                'StockID',
                'orderID',
                'CodeID3',
                'compAdd',
                'compContact',
                'transporter',
                'CompID',
                'CompName'
            ]
        ));
    }

    public function addGoods()
    {
        $pgrID3 = Input::get('categ');
        $stock = Input::get('stock');
        $currency = \Currency::where('appointment', '=', 4)->get(['value'])->first()->value;
        $prods = \Prods::where('PGrID3', '=', $pgrID3)->get(['ProdID', 'ProdName', 'ShortProdName', 'UM'])->toArray();
        $goods = [];
        foreach ($prods as $key => $value) {
            $good = [];
            $pl = \ProdMP::where('ProdID', '=', $value['ProdID'])
                ->where('PLID', '!=', 100)
                ->orderBy('PLID', 'asc')->get(['PLID', 'PriceMC', 'MinPLID'])->toArray();
            $rem = \Rem::where('ProdID', '=', $value['ProdID'])
                ->where('StockID', '=', $stock)
                ->groupBy('ProdID')->get(['RemCash', 'ResCash', 'RemUncash', 'ResUncash'])->toArray();
            if (!empty($rem) && !empty($pl)) {
                array_push($good, $value, $pl, $rem);
                array_push($goods, $good);
            } else {
                continue;
            }
        }
        $html = '';
        foreach ($goods as $key => $value) {
            $html .= '<tr><th><div class="shortName">' . $value[0]['ShortProdName'] . '</div></th>';
            $html .= '<th><div class="name">' . $value[0]['ProdName'] . '</div></th>';
            $html .= '<th><input class="quantity" type="number" autocorrect="off" pattern="\d*" novalidate></th>';
            $html .= '<th><div class="UM">' . $value[0]['UM'] . '</div></th>';
            $html .= '<th><span style="width: 100%; height: 100%" class="btn price" name="price' . $key . '" id="price' . $key . '"></span></th>';
            $html .= '<th><div class="remains_cashless" name="residue' . $key . '" >' . round(($value[2][0]['RemUncash'] - $value[2][0]['ResUncash']), 2) . '</div></th>';
            $html .= '<th><div class="remains_cash" name="residue' . $key . '" >' . round(($value[2][0]['RemCash'] - $value[2][0]['ResCash']), 2) . '</div></th>';
            if (count($value[1]) == 10) {
                $html .= '<th hidden="hidden" class="p1" plid="' . $value[1][0]['PLID'] . '" minpl="' . $value[1][0]['MinPLID'] . '">' . ceil(($value[1][0]['PriceMC'] * $currency / 6) * 100) / 100 * 6 . '</th>';
                $html .= '<th hidden="hidden" class="p2" plid="' . $value[1][1]['PLID'] . '" minpl="' . $value[1][1]['MinPLID'] . '">' . ceil(($value[1][1]['PriceMC'] * $currency / 6) * 100) / 100 * 6 . '</th>';
                $html .= '<th hidden="hidden" class="p3" plid="' . $value[1][2]['PLID'] . '" minpl="' . $value[1][2]['MinPLID'] . '">' . ceil(($value[1][2]['PriceMC'] * $currency / 6) * 100) / 100 * 6 . '</th>';
                $html .= '<th hidden="hidden" class="p4" plid="' . $value[1][3]['PLID'] . '" minpl="' . $value[1][3]['MinPLID'] . '">' . ceil(($value[1][3]['PriceMC'] * $currency / 6) * 100) / 100 * 6 . '</th>';
                $html .= '<th hidden="hidden" class="p5" plid="' . $value[1][4]['PLID'] . '" minpl="' . $value[1][4]['MinPLID'] . '">' . ceil(($value[1][4]['PriceMC'] * $currency / 6) * 100) / 100 * 6 . '</th>';
                $html .= '<th hidden="hidden" class="p6" plid="' . $value[1][5]['PLID'] . '" minpl="' . $value[1][5]['MinPLID'] . '">' . ceil(($value[1][5]['PriceMC'] * $currency / 6) * 100) / 100 * 6 . '</th>';
                $html .= '<th hidden="hidden" class="p7" plid="' . $value[1][6]['PLID'] . '" minpl="' . $value[1][6]['MinPLID'] . '">' . ceil(($value[1][6]['PriceMC'] * $currency / 6) * 100) / 100 * 6 . '</th>';
                $html .= '<th hidden="hidden" class="p8" plid="' . $value[1][7]['PLID'] . '" minpl="' . $value[1][7]['MinPLID'] . '">' . ceil(($value[1][7]['PriceMC'] * $currency / 6) * 100) / 100 * 6 . '</th>';
                $html .= '<th hidden="hidden" class="p9" plid="' . $value[1][8]['PLID'] . '" minpl="' . $value[1][8]['MinPLID'] . '">' . ceil(($value[1][8]['PriceMC'] * $currency / 6) * 100) / 100 * 6 . '</th>';
                $html .= '<th hidden="hidden" class="p10" plid="' . $value[1][9]['PLID'] . '" minpl="' . $value[1][9]['MinPLID'] . '">' . ceil(($value[1][9]['PriceMC'] * $currency / 6) * 100) / 100 * 6 . '</th>';
                $html .= '<th hidden="hidden" class="p0"> - </th>';
            } elseif (count($value[1]) == 11) {
                $html .= '<th hidden="hidden" class="p0" plid="' . $value[1][0]['PLID'] . '" minpl="' . $value[1][0]['MinPLID'] . '">' . ceil(($value[1][0]['PriceMC'] * $currency / 6) * 100) / 100 * 6 . '</th>';
                $html .= '<th hidden="hidden" class="p1" plid="' . $value[1][1]['PLID'] . '" minpl="' . $value[1][1]['MinPLID'] . '">' . ceil(($value[1][1]['PriceMC'] * $currency / 6) * 100) / 100 * 6 . '</th>';
                $html .= '<th hidden="hidden" class="p2" plid="' . $value[1][2]['PLID'] . '" minpl="' . $value[1][2]['MinPLID'] . '">' . ceil(($value[1][2]['PriceMC'] * $currency / 6) * 100) / 100 * 6 . '</th>';
                $html .= '<th hidden="hidden" class="p3" plid="' . $value[1][3]['PLID'] . '" minpl="' . $value[1][3]['MinPLID'] . '">' . ceil(($value[1][3]['PriceMC'] * $currency / 6) * 100) / 100 * 6 . '</th>';
                $html .= '<th hidden="hidden" class="p4" plid="' . $value[1][4]['PLID'] . '" minpl="' . $value[1][4]['MinPLID'] . '">' . ceil(($value[1][4]['PriceMC'] * $currency / 6) * 100) / 100 * 6 . '</th>';
                $html .= '<th hidden="hidden" class="p5" plid="' . $value[1][5]['PLID'] . '" minpl="' . $value[1][5]['MinPLID'] . '">' . ceil(($value[1][5]['PriceMC'] * $currency / 6) * 100) / 100 * 6 . '</th>';
                $html .= '<th hidden="hidden" class="p6" plid="' . $value[1][6]['PLID'] . '" minpl="' . $value[1][6]['MinPLID'] . '">' . ceil(($value[1][6]['PriceMC'] * $currency / 6) * 100) / 100 * 6 . '</th>';
                $html .= '<th hidden="hidden" class="p7" plid="' . $value[1][7]['PLID'] . '" minpl="' . $value[1][7]['MinPLID'] . '">' . ceil(($value[1][7]['PriceMC'] * $currency / 6) * 100) / 100 * 6 . '</th>';
                $html .= '<th hidden="hidden" class="p8" plid="' . $value[1][8]['PLID'] . '" minpl="' . $value[1][8]['MinPLID'] . '">' . ceil(($value[1][8]['PriceMC'] * $currency / 6) * 100) / 100 * 6 . '</th>';
                $html .= '<th hidden="hidden" class="p9" plid="' . $value[1][9]['PLID'] . '" minpl="' . $value[1][9]['MinPLID'] . '">' . ceil(($value[1][9]['PriceMC'] * $currency / 6) * 100) / 100 * 6 . '</th>';
                $html .= '<th hidden="hidden" class="p10" plid="' . $value[1][10]['PLID'] . '" minpl="' . $value[1][10]['MinPLID'] . '">' . ceil(($value[1][10]['PriceMC'] * $currency / 6) * 100) / 100 * 6 . '</th>';
            }
            $html .= '<th><input type="button" class="btnAddGood btn btn-primary" value="Добавить"></th></tr>';
        }
        return $html;
    }

    public function addCateg()
    {
        $pgr3Obj = \ProdGr3::where('status', '=', 1)
            ->orderBy('PGrName3', 'asc')
            ->get(['PGrID3', 'PGrName3'])->toArray();
        $pgrName3 = [];
        $pgrID3 = [];
        foreach ($pgr3Obj as $key => $value) {
            array_push($pgrName3, $value['PGrName3']);
            array_push($pgrID3, $value['PGrID3']);
        }
        unset($pgr3Obj);
        $pgr3Obj = array_combine($pgrID3, $pgrName3);
        return $pgr3Obj;
    }

    public function sendApproved($filename, $orderID)
    {
        $mailer = new PHPMailer();
        $orderObj = \Orders::where('DocID', '=', $orderID)
            ->get()->last()->toArray();
        if ($orderObj['StockID'] == 110) {
            $user = \Emps::where('EmpID', '=', Auth::getUser()->EmpID)->get()->last()->toArray();
            $mailer->CharSet = 'utf-8';
            $mailer->AddReplyTo(Auth::getUser()->email, $user['EmpName']);
            $mailer->SetFrom('tsipa@const.dp.ua', $user['EmpName']);
            $mailer->AddAddress('kyzmenkos@const.dp.ua', "Кузьменко Сергей Иванович");
            $mailer->AddAddress('kurasova@alista.com.ua', "Курасова Светлана Васильевна");
            $mailer->AddCC('kurasova@alista.com.ua', "Курасова Светлана Васильевна");
            $mailer->AddAddress('davydov@alista.com.ua', "Давыдов Денис Александрович");
            $mailer->AddCC('davydov@alista.com.ua', "Давыдов Денис Александрович");
            $mailer->AddAddress('tsebrenko@alista.com.ua', "Цебренко Алина Витальевна");
            $mailer->AddCC('tsebrenko@alista.com.ua', "Цебренко Алина Витальевна");
            $mailer->AddAddress('krutijk@alista.com.ua', "Крутий Константин Игоревич");
            $mailer->AddCC('krutijk@alista.com.ua', "Крутий Константин Игоревич");
            $mailer->AddAddress('glazunov@alista.com.ua', "Глазунов Петр Алимович");
            $mailer->AddCC('glazunov@alista.com.ua', "Глазунов Петр Алимович");
            $mailer->Subject = "Заявка на " . $orderObj['CompName'];
            $mailer->AltBody = "Заявка на " . $orderObj['CompName'];
            $mailer->MsgHTML('<h1>Заявка на ' . $orderObj['CompName'] . '</h1>');
            $mailer->AddAttachment($filename);
            if (!$mailer->Send()) {
                return "Mailer Error: " . $mailer->ErrorInfo;
            } else {
                return "Message sent!";
            }
        } else {
            $user = \Emps::where('EmpID', '=', Auth::getUser()->EmpID)->get()->last()->toArray();
            $mailer->CharSet = 'utf-8';
            $mailer->AddReplyTo(Auth::getUser()->email, $user['EmpName']);
            $mailer->SetFrom('tsipa@const.dp.ua', $user['EmpName']);
            $mailer->AddAddress('kyzmenkos@const.dp.ua', "Кузьменко Сергей Иванович");
            $mailer->AddAddress('kurasova@alista.com.ua', "Курасова Светлана Васильевна");
            $mailer->AddCC('kurasova@alista.com.ua', "Курасова Светлана Васильевна");
            $mailer->AddAddress('davydov@alista.com.ua', "Давыдов Денис Александрович");
            $mailer->AddCC('davydov@alista.com.ua', "Давыдов Денис Александрович");
            $mailer->AddAddress('tsebrenko@alista.com.ua', "Цебренко Алина Витальевна");
            $mailer->AddCC('tsebrenko@alista.com.ua', "Цебренко Алина Витальевна");
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
            if (!$mailer->Send()) {
                return "Mailer Error: " . $mailer->ErrorInfo;
            } else {
                return "Message sent!";
            }
        }
    }

    /*public function createPdf($orderID)
    {
        $pdf = new \Admin\PdfOrders();
        //$orderID = Input::get('orderID');
        $pdf->SetAutoPageBreak(true, 15);
        $arrOrder = \Orders::where('DocID', '=', $orderID)->get()->last()->toArray();
        $arrProd = \Orders::where('DocID', '=', $orderID)
            //->where('status', '!=', 10)
            ->get()->toArray();
        $date = $arrOrder['created_at'];
        $arrDate = explode('-',$date);
        $partDate = explode(' ', $arrDate[2]);
        $strDate = $partDate[0].'.'.$arrDate[1].'.'.$arrDate[0];
        $typeInv = $arrOrder['CodeID3'];
        $pdf->AddFont('Tahoma','','tahoma.php');
        $pdf->AddFont('Tahoma-bold','','tahoma_bold.php');
        $pdf->SetAutoPageBreak(true, 20);
        $pdf->AliasNbPages();
        $pdf->data($orderID, $strDate);
        $pdf->Open();
        $pdf->AddPage();
        if($typeInv == 4)
        {
            $pdf->SetFont('Tahoma-bold','',8);
            $pdf->Cell(120, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE",
                'ПУБЛІЧНЕ АКЦІОНЕРНЕ ТОВАРИСТВО "ДНІПРОПОЛІМЕРМАШ"'), 0, 0, 'L');
            $pdf->SetFont('Tahoma','',8);
            $pdf->Cell(75, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", 'р/с 2600718904'), 0, 0, 'R');
            $pdf->Ln();
            $pdf->Cell(120, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", '49033, м. Дніпропетровськ'), 0, 0, 'L');
            $pdf->Cell(75, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", 'ПАТ «ПУМБ», м. Дніпропетровськ'), 0, 0, 'R');
            $pdf->Ln();
            $pdf->Cell(120, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", 'вул. Героїв Сталінграда,147'), 0, 0, 'L');
            $pdf->SetFont('Tahoma-bold','',8);
            $pdf->Cell(75, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", 'МФО 334851'), 0, 0, 'R');
            $pdf->Ln();
            $pdf->Cell(120, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE",
                'Податковий код: 002186104027, Свідоцтво: 100335408'), 0, 0, 'L');
            $pdf->SetFont('Tahoma','',8);
            $pdf->Cell(75, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", 'Код ОКПО 00218615'), 0, 0, 'R');
            $pdf->Ln();
        } else {
            $pdf->SetFont('Tahoma','',8);
            $pdf->Cell(15, 10, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE",'Алиста'), 0, 0, 'L');
            $pdf->Ln(20);
        }
        $pdf->Ln();
        if(\Comps::where('comps.CompID', '=', $arrOrder['CompID'])
            ->join('CompAdd', 'CompAdd.CompID', '=', 'comps.CompID')
            ->get()->toArray())
        {
            $comp = \Comps::where('CompID', '=', $arrOrder['CompID'])
                ->get()->last()->toArray();
            $compAdd = \CompAdd::where('CompID', '=', $arrOrder['CompID'])
                ->get()->last()->toArray();
        } else {
            $comp = \Comps::where('CompID', '=', $arrOrder['CompID'])
                ->get()->last()->toArray();
            $compAdd = ['CompAdd' => ''];
        }
        $pdf->Rect($pdf->GetX(), $pdf->GetY(), 40, 20);
        $pdf->Rect($pdf->GetX()+40, $pdf->GetY(), 115, 20);
        $pdf->Rect($pdf->GetX()+155, $pdf->GetY(), 40, 20);
        $pdf->SetFont('Tahoma-bold','',8);
        $pdf->Cell(40, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", 'Підприємство:'), 0, 0, 'R');
        $pdf->Cell(115, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", $comp['CompName']), 0, 0, 'L');
        $pdf->Cell(40, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", $comp['CompID']), 0, 0, 'L');
        $pdf->Ln();
        $pdf->SetFont('Tahoma','',8);
        $pdf->Cell(40, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", 'Адреса:'), 0, 0, 'R');
        $pdf->Cell(115, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", $compAdd['CompAdd']), 0, 0, 'L');
        $pdf->Cell(40, 2, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", '72'), 0, 0, 'L');
        $pdf->Ln();
        $pdf->Cell(155, 0, '', 0, 0, 'R');
        $pdf->Cell(40, 3, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", '1'), 0, 0, 'L');
        $pdf->Ln();
        $pdf->Cell(40, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", 'Місто:'), 0, 0, 'R');
        $pdf->Cell(115, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", $comp['City']), 0, 0, 'L');
        $pdf->Cell(40, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", $typeInv), 0, 0, 'L');
        $pdf->Ln();
        $pdf->Cell(40, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", 'Телефон:'), 0, 0, 'R');
        $pdf->Cell(115, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", ''), 0, 0, 'L');
        $pdf->Cell(40, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", '0'), 0, 0, 'L');
        $pdf->Ln(15);
        $prodHead = [0 => 'Код', 1 => 'Назва товарів, (робіт, послуг)', 2 => 'Од.Вим.',
            3 => 'Кількість', 4 => 'Ціна без ПДВ', 5 => 'Сума без ПДВ', 6 => 'Ціна з ПДВ', 7 => 'Сума з ПДВ'];
        $prodBody = [];
        $totalWeight = '';
        $totalQty = '';
        $totalPriceCCnt = '';
        $totalPriceWithTax = '';
        foreach($arrProd as $key => $value)
        {
            $prodBody[$key][] = $value['ProdID'];
            $prodBody[$key][] = $value['ProdName'];
            $prodBody[$key][] = $value['UM'];
            $prodBody[$key][] = round($value['Qty'], 0);
            $prodBody[$key][] = str_replace('.',',',round(($value['PriceMC']/1.2), 2));
            $prodBody[$key][] = str_replace('.',',',round(($value['PriceMC']/1.2)*$value['Qty'], 2));
            $prodBody[$key][] = str_replace('.',',',round($value['PriceMC'], 2));
            $prodBody[$key][] = str_replace('.',',',round($value['PriceMC']*$value['Qty'], 2));
            $prod = \Prods::where('ProdID', '=', $value['ProdID'])
                ->get(['Weight'])->last();
            $Weight = $prod['Weight'] * $value['Qty'];
            $PriceCCnt = (($value['PriceMC']/1.2)*$value['Qty']);
            $PriceWithTax = ($value['PriceMC']*$value['Qty']);
            $totalQty += $value['Qty'];
            $totalWeight += $Weight;
            $totalPriceCCnt += $PriceCCnt;
            $totalPriceWithTax += $PriceWithTax;
        }
        $pdf->SetWidths([10, 85, 13, 13, 20, 20, 17, 17]);
        $pdf->RowExtended($prodHead, 7, 1, 'C', 1);
        $pdf->Ln();
        foreach($prodBody as $key => $value)
        {
            $pdf->RowExtended($value, 8, 1, 'L');
            $pdf->Ln();
        }
        $pdf->AddFont('Tahoma-bold','','tahoma-bold.php');
        $pdf->SetFont('Tahoma-bold','',8);
        $pdf->Ln(5);
        $pdf->Cell(150, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", 'Кількість: '. round($totalQty,0)), 0, 0, 'L');
        $pdf->Cell(20, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", 'Сума без НДС:'), 0, 0, 'R');
        $pdf->Cell(25, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", str_replace('.',',',round($totalPriceCCnt, 2))), 0, 0, 'R');
        $pdf->Ln();
        $pdf->Cell(150, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", 'Загальна вага: '. str_replace('.',',',$totalQty).' кг.'), 0, 0, 'L');
        $pdf->Cell(20, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", 'Сума НДС:'), 0, 0, 'R');
        $pdf->Cell(25, 5, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", str_replace('.',',',round(($totalPriceWithTax/6), 2))), 0, 0, 'R');
        $pdf->Ln(10);
        $pdf->SetFont('Tahoma-bold','',10);
        $pdf->SetWidths([25, 150, 20]);
        $footerOrder = [0 => 'Сума з ПДВ:', 1 => $pdf->num2text_ua($totalPriceWithTax), 2 => str_replace('.',',',round($totalPriceWithTax, 2))];
        $pdf->RowExtended($footerOrder, 8, 1, 'C');
        $pdf->Ln();
        $pdf->SetFont('Tahoma-bold','',8);
        $pdf->Cell(195, 10, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE",
                'Вiдхилення кiлькостi одиниць товару в упаковцi може складати +/-3% вiд кiлькостi, зазначеної на упаковці'),
            0, 0, 'L');
        $pdf->Ln(20);
        $pdf->Cell(50, 10, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", 'Директор:'), 0, 0, 'L');
        $pdf->Ln(15);
        $pdf->Cell(50, 10, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", 'М П'), 0, 0, 'L');
        $pdf->Ln(10);
        $pdf->SetFont('Tahoma-bold','',14);
        $pdf->SetTextColor(255, 0, 0);
        $pdf->Cell(195, 15, iconv("UTF-8//IGNORE", "Windows-1251//IGNORE", 'Увага!!! Нові реквізити!!!'), 0, 0, 'C');
        $pdf->Ln();
        $fileName = 'Счет на оплату товара.pdf';
        $pdf->Output($fileName, false);
        $pdfMerge = new \Clegginabox\PDFMerger\PDFMerger;
        $pdfMerge->addPDF($fileName, 'all');
        $pdfMerge->merge('file', $fileName, 'P');
        return $fileName;
    }*/

    public function sendOrderComp()
    {
        $filename = Input::get('filename');
        $orderID = Input::get('orderID');
        $email = Input::get('email');
        $mailer = new PHPMailer();
        $orderObj = \Orders::where('DocID', '=', $orderID)
            ->get()->last()->toArray();
        \Comps::where('CompID', '=', $orderObj['CompID'])->update(['EMail' => $email]);
        $user = \Emps::where('EmpID', '=', Auth::getUser()->EmpID)->get()->last()->toArray();
        $mailer->CharSet = 'utf-8';
        $mailer->AddReplyTo(Auth::getUser()->email, $user['EmpName']);
        $mailer->SetFrom('tsipa@const.dp.ua', $user['EmpName']);
        $mailer->AddAddress($email, "");
        $mailer->Subject = "Счет на " . $orderObj['CompName'];
        $mailer->AltBody = "Счет на " . $orderObj['CompName'];
        $mailer->MsgHTML('<h1> Счет на ' . $orderObj['CompName'] . '</h1>');
        $mailer->AddAttachment($filename);
        if (!$mailer->Send()) {
            $msg = "Произошла ошибка при отправке: " . $mailer->ErrorInfo . '.';
            $msg .= '<br/>Обратитесь к администратору';
            return View::make('msg', compact(['msg']));
        } else {
            $msg = 'Письмо отправленно!';
            return View::make('msg', compact(['msg']));
        }
    }

    public function sendOrderMe()
    {
        $filename = Input::get('filename');
        $orderID = Input::get('orderID');
        $email = Input::get('email');
        $mailer = new PHPMailer();
        $orderObj = \Orders::where('DocID', '=', $orderID)
            ->get()->last()->toArray();
        $user = \Emps::where('EmpID', '=', Auth::getUser()->EmpID)->get()->last()->toArray();
        $mailer->CharSet = 'utf-8';
        $mailer->AddReplyTo(Auth::getUser()->email, $user['EmpName']);
        $mailer->SetFrom('tsipa@const.dp.ua', $user['EmpName']);
        $mailer->AddAddress($email, "");
        $mailer->Subject = "Счет на " . $orderObj['CompName'];
        $mailer->AltBody = "Счет на " . $orderObj['CompName'];
        $mailer->MsgHTML('<h1> Счет на ' . $orderObj['CompName'] . '</h1>');
        $mailer->AddAttachment($filename);
        if (!$mailer->Send()) {
            $msg = "Произошла ошибка при отправке: " . $mailer->ErrorInfo . '.';
            $msg .= '<br/>Обратитесь к администратору';
            return View::make('msg', compact(['msg']));
        } else {
            $msg = 'Письмо отправленно!';
            return View::make('msg', compact(['msg']));
        }
    }

    public function viewOrder()
    {
        $orderID = Input::get('orderID');
        $arrOrder = \Orders::where('DocID', '=', $orderID)->get()->last()->toArray();
        if ($arrOrder['CompID'] != 0) {
            $filename = $this->createPdf($orderID);
            $orderArr = \Orders::where('DocID', '=', $orderID)
                ->get()->last();
            $compArr = \Comps::where('CompID', '=', $orderArr->CompID)
                ->get()->last();
            $contactArr = \CompContact::where('CompID', '=', $orderArr->CompID)
                ->get()->last();
            $compName = $compArr->CompName;
            if ($compArr->EMail) {
                $emailComp = $compArr->EMail;
                return View::make('sendOrder', compact(['orderID', 'emailComp', 'filename', 'compName']));
            } else if (!empty($contactArr->eMail)) {
                $emailComp = $contactArr->eMail;
                return View::make('sendOrder', compact(['orderID', 'emailComp', 'filename', 'compName']));
            } else {
                $emailComp = '';
                return View::make('sendOrder', compact(['orderID', 'emailComp', 'filename', 'compName']));
            }
        } else {
            $msg = 'В данного счета нет  Кода предприятия! Обратитесь к администратору.';
            return View::make('msg', compact('msg'));
        }
    }

    public function createPdf($DocID)
    {
        $order = \Orders::where('DocID', '=', $DocID)
            ->join('prods', 'prods.ProdID', '=', 'orders.ProdID')
            ->get(
                [
                    'orders.DocID',
                    'orders.ProdID',
                    'orders.CodeID3',
                    'orders.Kurs',
                    'orders.CompID',
                    'orders.CompName',
                    'orders.ProdID',
                    'orders.ProdName',
                    'orders.UM',
                    'orders.Qty',
                    'orders.PriceMC',
                    'orders.SumPrice',
                    'orders.PLID',
                    'orders.EmpID',
                    'orders.StockID',
                    'prods.Weight',
                    'orders.created_at'
                ])->toArray();
        $filename = 'Счет на оплату.pdf';
        $DocDate = explode(' ', $order[0]['created_at']);
        $arrDate = explode('-', $DocDate[0]);
        $strDate = $arrDate[2] . '.' . $arrDate[1] . '.' . $arrDate[0];
        $CompID = $order[0]['CompID'];
        $CompName = $order[0]['CompName'];
        $comp = \Comps::where('CompID', '=', $CompID)->get()->last();
        $compAdd = \CompAdd::where('CompID', '=', $CompID)->get()->toArray();
        $compContact = \CompContact::where('CompID', '=', $CompID)->get()->toArray();
        $CityName = $comp->City;
        $TSum_wt = '';
        $TSum_nt = '';
        $TQty = '';
        $TWeight = '';
        $pdf = new \Admin\PdfOrders();
        if (\Comps::where('comps.CompID', '=', $CompID)
            ->join('CompAdd', 'CompAdd.CompID', '=', 'comps.CompID')
            ->get()->toArray()
        ) {
            $comp = \Comps::where('CompID', '=', $CompID)
                ->get()->last()->toArray();
            $compAdd = \CompAdd::where('CompID', '=', $CompID)
                ->get()->last()->toArray();
        } else {
            $comp = \Comps::where('CompID', '=', $CompID)
                ->get()->last()->toArray();
            $compAdd = ['CompAdd' => ''];
        }
        $CompAdd = $compAdd['CompAdd'];
        foreach ($order as $key => $value) {
            $PWeight = '';
            $PWeight = $value['Qty'] * $value['Weight'];
            $TSum_wt += $value['SumPrice'];
            $TSum_nt += $value['SumPrice'] / 1.2;
            $TQty += $value['Qty'];
            $TWeight += $PWeight;
        }
        $TPrice_wt = str_replace('.', ',', round($TSum_wt, 2));
        $numberChar = $pdf->num2text_ua($TSum_wt);
        if ($order[0]['CodeID3'] == 4) {
            $html = View::make('order-template', compact(
                [
                    'order',
                    'DocID',
                    'strDate',
                    'CompID',
                    'CompName',
                    'CityName',
                    'TSum_wt',
                    'TSum_nt',
                    'TQty',
                    'TPrice_wt',
                    'numberChar',
                    'CompAdd',
                    'TWeight'
                ]
            ))->render();
            $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
            $bpdf = BPDF::loadHTML($html, 'UTF-8');
            $bpdf->setPaper('a4')->setOrientation('portrait')->setWarnings(false)->save('Счет на оплату.pdf')->stream('opdf.pdf');
            return $filename;
        } else {
            $html = View::make('order-templateCASH', compact(
                [
                    'order',
                    'DocID',
                    'strDate',
                    'CompID',
                    'CompName',
                    'CityName',
                    'TSum_wt',
                    'TSum_nt',
                    'TQty',
                    'TPrice_wt',
                    'numberChar',
                    'CompAdd',
                    'TWeight'
                ]
            ))->render();
            $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
            $bpdf = BPDF::loadHTML($html, 'UTF-8');
            $bpdf->setPaper('a4')->setOrientation('portrait')->setWarnings(false)->save('Счет на оплату.pdf')->stream('opdf.pdf');
            return $filename;
        }
    }

    public function editOrder()
    {
        $orderID = Input::get('orderID');
        $ord = \Orders::where('orderID', '=', $orderID)->get()->toArray();
        if (empty($ord)) {
            $orderType = 'DocID';
        } else {
            $orderType = 'orderID';
        }
        $EmpPL = \Emps::where('EmpID', '=', Auth::getUser()->EmpID)->get(['PLID'])->first()->PLID;
        if (Auth::getUser()->status == 1) {
            $Emps = \Emps::orderBy('EmpName', 'desc')->get()->toArray();
            $empName = [];
            $empID = [];
            foreach ($Emps as $key => $value) {
                array_push($empName, $value['EmpName']);
                array_push($empID, $value['EmpID']);
            }
            unset($Emps);
            $Emps = array_combine($empID, $empName);
        } else {
            $empID = Auth::getUser()->EmpID;
            $empNameObj = \Emps::where('EmpID', '=', $empID)->get()->toArray();
            $empName = $empNameObj[0]['EmpName'];
            $Emps = [$empID => $empName];
        }
        $totalPricePos = '';
        $comps = \Comps::orderBy('CompName', 'asc')->get(['CompName', 'CompID'])->toArray();
        $compName = [];
        $compID = [];
        foreach ($comps as $key => $value) {
            if ($value['CompName'] == NULL) {
                continue;
            } else {
                array_push($compName, $value['CompName']);
                array_push($compID, $value['CompID']);
            }
        }
        unset($comps);
        $comps = array_combine($compID, $compName);
        $curComp = \Orders::where($orderType, '=', $orderID)
            ->groupBy('CompID')
            ->get()->last();
        $curCompID = $curComp->CompID;
        $curCompName = $curComp->CompName;
        $aboutOrder = \Orders::where($orderType, '=', $orderID)
            ->join('Emps', 'Emps.EmpID', '=', 'orders.EmpID')
            ->join('status_inv', 'status_inv.statusType', '=', 'orders.status')
            ->get(['orders.status', 'Emps.EmpName', 'orders.EmpID'])
            ->last()
            ->toArray();
        $orders = \Orders::where($orderType, '=', $orderID)
            ->groupBy('SrcPosID')
            ->join('ProdMP', 'ProdMP.ProdID', '=', 'orders.ProdID')
            ->join('prods', 'prods.ProdID', '=', 'orders.ProdID')
            ->get(['prods.ShortProdName', 'orders.orderID', 'orders.DocID', 'orders.Kurs', 'orders.CompID',
                'orders.CompName', 'orders.ProdID', 'orders.ProdName', 'orders.CodeID3', 'orders.UM',
                'orders.Qty', 'orders.PriceMC', 'orders.PLID', 'orders.StockID',
                'orders.SrcPosID', 'orders.status'])
            ->toArray();
        foreach ($orders as $key => $value) {
            if ($value['status'] == 10) {
                $orders[$key]['color'] = '#EE8F48';
            } else if ($value['status'] == 5) {
                $orders[$key]['color'] = '#FF4500';
            } else {
                $orders[$key]['color'] = '';
            }
            $orders[$key]['totalPricePosCC'] = $value['Qty'] * $value['PriceMC'];
            $orders[$key]['totalPricePosMC'] = $value['Qty'] * $value['PriceMC'] / $value['Kurs'];
        }
        foreach ($orders as $key => $value) {
            $pl = \ProdMP::where('ProdID', '=', $value['ProdID'])
                ->orderBy('PLID', 'asc')
                ->get(['PLID', 'PriceMC'])
                ->toArray();
            $orders[$key]['pl'] = $pl;
        }
        $currency = \Currency::where('appointment', '=', 4)->get(['value'])->first()->value;
        return View::make('accr.edit-order', compact(['EmpPL', 'aboutOrder', 'orders', 'orderID', 'comps',
            'curCompName', 'curCompID', 'currency', 'Emps']));
    }

    public function saveEditOrder()
    {
        $res = Input::get('res');
        if (\Orders::where('orderID', '=', Input::get('orderID'))->get()->toArray()) {
            $DocIdArr = \Orders::where('orderID', '=', Input::get('orderID'))->get(['DocID'])->last()->toArray();
            $DocID = $DocIdArr['DocID'];
            $orderID = Input::get('orderID');
            \Orders::where('orderID', '=', Input::get('orderID'))->delete();
        } else {
            $orderIdArr = \Orders::where('DocID', '=', Input::get('orderID'))->get(['orderID'])->last()->toArray();
            $orderID = $orderIdArr['orderID'];
            $DocID = Input::get('orderID');
            \Orders::where('DocID', '=', Input::get('orderID'))->delete();
        }
        if (empty($res)) {
            return ['message' => ['error' => 'Нет позиций в счете']];
        }
        $pos = 1;
        $result = [];
        foreach ($res as $key => $value) {
            $goods = \Prods::where('ProdName', '=', $value['name'])->get()->first()->toArray();
            if (empty($goods)) {
                return ['message' => ['error' => 'Нет товара']];
            }
            $comp = \Comps::where('CompID', '=', $value['CompID'])->get()->first()->toArray();
            if (empty($comp)) {
                return ['message' => ['error' => 'Нет предприятия']];
            }
            $rem = \Rem::where('ProdID', '=', $goods['ProdID'])->get()->first()->toArray();
            if (empty($rem)) {
                return ['message' => ['error' => 'Нет остатков']];
            }
            $price = \ProdMP::where('ProdID', '=', $goods['ProdID'])->where('PLID', '=', $value['pl'])->get(['PriceMC'])->toArray();
            if (empty($price)) {
                return ['message' => ['error' => 'Нет цены']];
            } else {
                $price = \ProdMP::where('ProdID', '=', $goods['ProdID'])->where('PLID', '=', $value['pl'])->get(['PriceMC'])->last()->toArray();
            }
            if ($value['typeInv'] == 1) {
                $currency = \Currency::where('appointment', '=', 1)->get(['value'])->first()->value;
            } else {
                $currency = \Currency::where('appointment', '=', 4)->get(['value'])->first()->value;
            }
            \Orders::create(
                [
                    'status' => 0,
                    'DocID' => $DocID,
                    'orderID' => $orderID,
                    'SrcPosID' => $pos,
                    'ProdID' => $goods['ProdID'],
                    'ProdName' => $value['name'],
                    'UM' => $value['um'],
                    'CompName' => $comp['CompName'],
                    'CompID' => $value['CompID'],
                    'StockID' => $value['stock'],
                    'CodeID3' => $value['typeInv'],
                    'EmpID' => $value['EmpID'],
                    'PLID' => $value['pl'],
                    'PriceMC' => ceil(($value['price'] / 6) * 100) / 100 * 6,
                    'SumPrice' => $value['quantity'] * ceil(($value['price'] / 6) * 100) / 100 * 6,
                    'Qty' => $value['quantity'],
                    'Kurs' => $currency,
                    'created_at' => date("Y-m-d")
                ]
            );
            $pos++;
            $prod =
                [
                    'orderID' => $orderID,
                    'DocID' => $DocID,
                    'SrcPosID' => $pos,
                    'ProdID' => $goods['ProdID'],
                    'ProdName' => $value['name'],
                    'UM' => $value['um'],
                    'CompName' => $comp['CompName'],
                    'CompID' => $value['CompID'],
                    'StockID' => $value['stock'],
                    'CodeID3' => $value['typeInv'],
                    'EmpID' => $value['EmpID'],
                    'PLID' => $value['pl'],
                    'PriceMC' => ceil(($value['price'] / 6) * 100) / 100 * 6,
                    'SumPrice' => $value['quantity'] * ceil(($value['price'] / 6) * 100) / 100 * 6,
                    'Qty' => $value['quantity'],
                    'Kurs' => $currency
                ];
            $result[$key] = ['state' => 'success', 'prod' => $prod];
        }
        return $result;
    }

    public function exampleOrder()
    {
        $filename = 'test1.xls';
        //$xml = simplexml_load_file('test1.xml');
        //$xml = new PHPExcel_Reader_Excel2003XML();
        echo "<pre>";
        //print_r($xml->Workbook->Worksheet);
        echo "</pre>";
        //PHPExcel_IOFactory::createWriter()
        /*$xls = PHPExcel_IOFactory::load($filename);
        $xls->setActiveSheetIndex(0);
        $sheet = $xls->getActiveSheet();
        $rowIterator = $sheet->getRowIterator();
        $i = 1;
        $data = array();
        foreach ($rowIterator as $row) {
            if ($i > 0) {
                $cellIterator = $row->getCellIterator();
                $j = 1;
                $temp = array();
                foreach ($cellIterator as $cell) {
                    if (!empty($cell) && ($cell != null) && ($cell != '') && ($cell != '&#9')) {
                        array_push($temp, $cell->getCalculatedValue());
                        $j++;
                    }
                }
                array_push($data, $temp);
            }
            $i++;
        }
        $orderID = Input::get('orderID');
        $orders = \Orders::where('DocID', '=', $orderID)
            ->join('prods', 'prods.ProdID', '=', 'orders.ProdID')
            ->get()->toArray();
        $docDate = '';
        foreach($orders as $key => $value)
        {
            $docDate = $value['created_at'];
            $orders[$key]['totalPricePosMC'] = $value['Qty']*$value['PriceMC'];
            $orders[$key]['totalPricePosCC'] = $value['Qty']*$value['PriceMC']/$value['Kurs'];
        }
        foreach($data as $key => $value)
        {
            foreach($value as $k => $val)
            {
                if($val == 'DocID')
                {
                    $data[$key][$k] = $orderID;
                }
            }
        }
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $sheet = $objPHPExcel->getSheet(0);
        foreach($data as $key => $value)
        {
            foreach($value as $k => $val)
            {
                $sheet->setCellValueByColumnAndRow($k, $key, $val);
            }
        }
        $objWriter = new PHPExcel_Writer_Excel2007($xls);
        $objWriter->save('some_excel.xlsx');
        echo "<pre>";
        print_r($xls);
        echo "</pre>";*/
        //$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        //$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        //$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
        //$orderID = Input::get('orderID');
        $totalPricePos = '';
        /*$orders = \Orders::where('DocID', '=', $orderID)
            ->join('prods', 'prods.ProdID', '=', 'orders.ProdID')
            ->get()->toArray();
        $docDate = '';
        foreach($orders as $key => $value)
        {
            $docDate = $value['created_at'];
            $orders[$key]['totalPricePosMC'] = $value['Qty']*$value['PriceMC'];
            $orders[$key]['totalPricePosCC'] = $value['Qty']*$value['PriceMC']/$value['Kurs'];
        }
        $i = 6;
        $sheet = $objPHPExcel->getSheet(0);
        $sheet->mergeCells('B1:T2');
        $sheet->setTitle('Data');
        $sheet->setCellValue('B1', 'Рахунок');
        $sheet->mergeCells('U1:X1');
        $sheet->setCellValue('U1', 'Номер:');
        $sheet->mergeCells('Z1:AC1');
        $sheet->setCellValue('Z1', $orderID);
        $sheet->mergeCells('U2:X2');
        $sheet->setCellValue('U2', 'Дата:');
        $sheet->mergeCells('Z2:AC2');
        $sheet->setCellValue('Z2', $docDate, PHPExcel_Cell_DataType::TYPE_STRING);*/

        /*foreach($orders as $key => $value)
        {
            $sheet->setCellValue('A5', 'Код');
            $sheet->setCellValue('A'.$i, $value['ProdID']);
            $sheet->setCellValue('B5', 'Назва товарів, (робіт, послуг)');
            $sheet->setCellValue('B'.$i, $value['ProdName']);
            $sheet->setCellValue('C5', 'Од.Вим.');
            $sheet->setCellValue('C'.$i, $value['UM']);
            $sheet->setCellValue('D5', 'Кількість');
            $sheet->setCellValue('D'.$i, $value['Qty']);
            $sheet->setCellValue('E5', 'Ціна без ПДВ');
            $sheet->setCellValue('E'.$i, $value['PriceMC']);
            $sheet->setCellValue('F5', 'Сума без ПДВ');
            $sheet->setCellValue('F'.$i, $value['totalPricePosMC']);
            $i++;
        }*/
        /*        $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setAutoSize(true);
                $sheet->getColumnDimension('D')->setAutoSize(true);
                $sheet->getColumnDimension('E')->setAutoSize(true);
                $sheet->getColumnDimension('F')->setAutoSize(true);*/

        //$objPHPExcel->getActiveSheet()->SetCellValue('L'.$i, $value10[$key]);
//
        //return View::make('accr.view-order');
    }

}

