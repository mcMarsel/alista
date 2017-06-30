<?php

class GoodsManagerController extends \BaseController
{
    public function getKurs()
    {
        $type = Input::get('type');
        $currency = \Currency::where('appointment', '=', $type)
            ->get()->last();
        return round($currency['value'], 2);
    }

    public function managerOrder()
    {
        error_reporting(E_ALL | E_STRICT);
        ini_set('display_errors', 1);
        set_time_limit(0);
        //ignore_user_abort(1);
        $res = Input::get('res');
        $EmpID = Auth::user()->EmpID;
        //$newOrd = \Orders::orderBy('orderID', 'desc')->get()->first()->toArray();
        $newOrd = DB::select('SELECT * FROM  orders ORDER BY orderID DESC LIMIT 1');
        $result = json_decode(json_encode($newOrd), true);
        $newOrder = $result[0]['orderID'] + 1;

        if (empty($res)) {
            return ['message' => ['error' => 'Нет позиций в счете']];
        }
        $pos = 1;
        $goodsArr = [];
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
            $price = \ProdMP::where('ProdID', '=', $goods['ProdID'])->where('PLID', '=', $value['pl'])->get(['PriceMC'])->first()->toArray();
            if (empty($price)) {
                return ['message' => ['error' => 'Нет цены']];
            }
            if ($value['CodeID3'] == 1) {
                $currency = \Currency::where('appointment', '=', 1)->get(['value'])->first()->value;
            } else {
                $currency = \Currency::where('appointment', '=', 4)->get(['value'])->first()->value;
            }
            \Orders::create([
                'status' => 0,
                'orderID' => $newOrder,
                'SrcPosID' => $pos,
                'ProdID' => $goods['ProdID'],
                'ProdName' => $value['name'],
                'UM' => $value['um'],
                'CompName' => $comp['CompName'],
                'CompID' => $value['CompID'],
                'StockID' => $value['stockID'],
                'CodeID3' => $value['CodeID3'],
                'EmpID' => $EmpID,
                'PLID' => $value['pl'],
                'PriceMC' => ceil(($value['price'] / 6) * 100) / 100 * 6,
                'SumPrice' => $value['quantity'] * ceil(($value['price'] / 6) * 100) / 100 * 6,
                'Qty' => $value['quantity'],
                'Kurs' => $currency,
                'created_at' => date("Y-m-d")
            ]);
            $pos++;
            $prod =
                [
                    'orderID' => $newOrder,
                    'SrcPosID' => $pos,
                    'ProdID' => $goods['ProdID'],
                    'ProdName' => $value['name'],
                    'UM' => $value['um'],
                    'CompName' => $comp['CompName'],
                    'CompID' => $value['CompID'],
                    'StockID' => $value['stockID'],
                    'CodeID3' => $value['CodeID3'],
                    'EmpID' => $EmpID,
                    'PLID' => $value['pl'],
                    'PriceMC' => ceil(($price['PriceMC'] / 6) * 100) / 100 * 6,
                    'SumPrice' => $value['quantity'] * ceil(($value['price'] / 6) * 100) / 100 * 6,
                    'Qty' => $value['quantity'],
                    'Kurs' => $currency
                ];
            $result[$key] = ['state' => 'success', 'prod' => $prod];
        }
        return $result;
    }

    public function accr()
    {
        set_time_limit(0);
        ignore_user_abort(1);
        $bpdf = new BPDF();
        if (Auth::check()) {
            if (Auth::getUser()->status == 0) {
                $EmpID = Auth::getUser()->EmpID;
                $lastmonth = date('Y-m-d 00:00:00', mktime(0, 0, 0, date('m') - 1, date('d'), date('Y')));
                $ordersObj = DB::select("SELECT o.Qty, o.PriceMC, o.SumPrice, o.orderID, o.DocID, o.StockID, o.CodeID3, "
                    . "o.CompID, o.CompName, o.Kurs, o.created_at, e.EmpID, e.EmpName, i.statusType, i.statusName, "
                    . "SUM(o.SumPrice) as totalPriceCC FROM  orders o"
                    . " JOIN status_inv i ON o.status = i.statusType"
                    . " JOIN Emps e ON e.EmpID = o.EmpID"
                    . " WHERE o.EmpID = " . $EmpID
                    . " AND (o.created_at BETWEEN '" . $lastmonth . "' AND '" . date('Y-m-d 00:00:00') . "') "
                    . " GROUP BY o.DocID, o.orderID"
                    . " ORDER BY o.orderID DESC");
                foreach ($ordersObj as $key => $value) {
                    if ($value->statusType == 10) {
                        $ordersObj[$key]->color = '#EE8F48';
                    } else if ($value->statusType == 5) {
                        $ordersObj[$key]->color = '#FF4500';
                    } else {
                        $ordersObj[$key]->color = '';
                    }
                    $totalPrice = '';
                    if ($value->orderID == NULL) {
                        $orderID = $value->DocID;
                        $orderType = 'DocID';
                    } else {
                        $orderID = $value->orderID;
                        $orderType = 'orderID';
                    }
                    if ($value->Kurs != 0) {
                        $ordersObj[$key]->totalPriceMC = $value->totalPriceCC / $value->Kurs;
                    } else if ($value->totalPriceCC == 0) {
                        $ordersObj[$key]->totalPriceMC = 'Цена равна НУЛЮ!';
                    } else {
                        $ordersObj[$key]->totalPriceMC = 'Курс равен НУЛЮ!';
                    }
                }
            } else {
                $lastmonth = date('Y-m-d 00:00:00', mktime(0, 0, 0, date('m') - 1, date('d'), date('Y')));
                $ordersObj = DB::select("SELECT o.Qty, o.PriceMC, o.SumPrice, o.orderID, o.DocID, o.StockID, o.CodeID3, o.CompID, "
                    . "o.CompName, o.Kurs, o.created_at, e.EmpID, e.EmpName, i.statusType, i.statusName, "
                    . "SUM(o.SumPrice) as totalPriceCC FROM  orders o"
                    . " JOIN status_inv i ON o.status = i.statusType"
                    . " JOIN Emps e ON e.EmpID = o.EmpID"
                    . " WHERE (o.created_at BETWEEN '" . $lastmonth . "' AND '" . date('Y-m-d 00:00:00') . "') "
                    . " GROUP BY o.DocID, o.orderID"
                    . " ORDER BY o.orderID DESC");
                foreach ($ordersObj as $key => $value) {
                    if ($value->statusType == 10) {
                        $ordersObj[$key]->color = '#EE8F48';
                    } else if ($value->statusType == 5) {
                        $ordersObj[$key]->color = '#FF4500';
                    } else {
                        $ordersObj[$key]->color = '';
                    }
                    $totalPrice = '';
                    if ($value->orderID == NULL) {
                        $orderID = $value->DocID;
                        $orderType = 'DocID';
                    } else {
                        $orderID = $value->orderID;
                        $orderType = 'orderID';
                    }
                    $ordersObj[$key]->totalPriceMC = $value->totalPriceCC / $value->Kurs;
                }
            }
            $order = [];
            foreach ($ordersObj as $key => $value) {
                $order[$key] = (array)$value;
            }
            unset($ordersObj);
            $ordersObj = $order;
            /*echo "<pre>";
            print_r($ordersObj);
            echo "</pre>";
            die();*/
            return View::make('accr', compact('ordersObj'));
        } else {
            return Redirect::guest('login');
        }
    }

    public function comps()
    {
        $empID = Input::get('emp');
        $comps = \Comps::orderBy('CompName', 'asc')->get(['CompName', 'CompID'])->toArray();
        //$comps = \Comps::where('EmpID', $empID)->orderBy('CompName', 'asc')->get(['CompName', 'CompID'])->toArray();
        $compsName = [];
        $compsID = [];
        foreach ($comps as $key => $value) {
            array_push($compsName, $value['CompName']);
            array_push($compsID, $value['CompID']);
        }
        unset($comps);
        $comps = array_combine($compsID, $compsName);
        asort($comps, SORT_STRING);
        return $comps;
    }

    public function categ()
    {
        $categ = Input::get('categ');
        $cat = \ProdGr2::where('PGrName2', '=', $categ)->get(['PGrID2'])->toArray()[0];
        $subgr = \Prods::where('PGrID2', '=', $cat['PGrID2'])->groupBy('PGrID3')->get(['PGrID3'])->toArray();
        $subgroup = [];
        $sub = [];
        foreach ($subgr as $key => $value) {
            array_push($sub, \ProdGr3::where('PGrID3', '=', $value['PGrID3'])->get(['PGrName3'])->toArray());
        }
        for ($i = 0; $i < count($sub); $i++) {
            for ($j = 0; $j < count($sub[$i]); $j++) {
                array_push($subgroup, $sub[$i][$j]['PGrName3']);
            }
        }
        /*foreach($subgr as $key => $value)
        {
            if($value['PGrID3'] == 0)
            {
            	continue;
            } else {
            	array_push($subgroup,$value['PGrID3']);
            }
        }*/
        return $subgroup;
    }

    public function getPL()
    {
        $goodid = Input::get('goodid');
        $PL = \ProdMP::where('ProdID', '=', $goodid)
            ->orderBy('PLID', 'asc')->get()->toArray();
        return $PL;
    }

    public function cat()
    {
        $pgrID3 = Input::get('categ');
        $stock = Input::get('stockID');
        $currency = Input::get('kurs');
        $prods = \Prods::where('PGrID3', '=', $pgrID3)
            ->orderBy('ShortProdName', 'asc')
            ->get(['ProdID', 'ProdName', 'ShortProdName', 'UM'])->toArray();
        $goods = [];
        foreach ($prods as $key => $value) {
            $good = [];
            $pl = \ProdMP::where('ProdID', '=', $value['ProdID'])
                ->where('PLID', '!=', 100)
                ->orderBy('PLID', 'asc')->get(['PLID', 'PriceMC', 'MinPLID'])->toArray();
            $rem = \Rem::where('ProdID', '=', $value['ProdID'])->where('StockID', '=', $stock)->groupBy('ProdID')->get(['RemCash', 'ResCash', 'RemUncash', 'ResUncash'])->toArray();
            if (!empty($rem) || !empty($pl)) {
                array_push($good, $value, $pl, $rem);
                array_push($goods, $good);
            } else {
                continue;
            }
        }
        $html = '';
        /*echo "<pre>";
        print_r($goods);
        echo "</pre>";
        die();*/
        foreach ($goods as $key => $value) {
            if (empty($value[2]) || empty($value[1])) {
                continue;
            } else {
                $html .= '<tr><th><div class="shortName">' . $value[0]['ShortProdName'] . '</div></th>';
                $html .= '<th><div class="name">' . $value[0]['ProdName'] . '</div></th>';
                $html .= '<th><input class="quantity" type="number" autocorrect="off" pattern="\d*" novalidate></th>';
                $html .= '<th><div class="UM">' . $value[0]['UM'] . '</div></th>';
                $html .= '<th><span style="width: 100%; height: 100%" goodid="' . $value[0]['ProdID'] . '" class="btn price" name="price' . $key . '" id="price' . $key . '"></span></th>';
                $html .= '<th><div class="remains_cashless" name="residue' . $key . '" >' . round(($value[2][0]['RemUncash'] - $value[2][0]['ResUncash']), 2) . '</div></th>';
                $html .= '<th><div class="remains_cash" name="residue' . $key . '" >' . round(($value[2][0]['RemCash'] - $value[2][0]['ResCash']), 2) . '</div></th>';
                if (count($value[1]) == 10) {
                    $html .= '<th hidden="hidden" class="p0" plid="' . $value[1][0]['PLID'] . '" minpl="' . $value[1][0]['MinPLID'] . '">' . /*sprintf("%.2f", ($value[1][0]['PriceMC'] * $currency))*/
                        ceil(($value[1][0]['PriceMC'] * $currency / 6) * 100) / 100 * 6 . '</th>';
                    $html .= '<th hidden="hidden" class="p1" plid="' . $value[1][1]['PLID'] . '" minpl="' . $value[1][1]['MinPLID'] . '">' . /*sprintf("%.2f", ($value[1][1]['PriceMC'] * $currency))*/
                        ceil(($value[1][1]['PriceMC'] * $currency / 6) * 100) / 100 * 6 . '</th>';
                    $html .= '<th hidden="hidden" class="p2" plid="' . $value[1][2]['PLID'] . '" minpl="' . $value[1][2]['MinPLID'] . '">' . /*sprintf("%.2f", ($value[1][2]['PriceMC'] * $currency))*/
                        ceil(($value[1][2]['PriceMC'] * $currency / 6) * 100) / 100 * 6 . '</th>';
                    $html .= '<th hidden="hidden" class="p3" plid="' . $value[1][3]['PLID'] . '" minpl="' . $value[1][3]['MinPLID'] . '">' . /*sprintf("%.2f", ($value[1][3]['PriceMC'] * $currency))*/
                        ceil(($value[1][3]['PriceMC'] * $currency / 6) * 100) / 100 * 6 . '</th>';
                    $html .= '<th hidden="hidden" class="p4" plid="' . $value[1][4]['PLID'] . '" minpl="' . $value[1][4]['MinPLID'] . '">' . /*sprintf("%.2f", ($value[1][4]['PriceMC'] * $currency))*/
                        ceil(($value[1][4]['PriceMC'] * $currency / 6) * 100) / 100 * 6 . '</th>';
                    $html .= '<th hidden="hidden" class="p5" plid="' . $value[1][5]['PLID'] . '" minpl="' . $value[1][5]['MinPLID'] . '">' . /*sprintf("%.2f", ($value[1][5]['PriceMC'] * $currency))*/
                        ceil(($value[1][5]['PriceMC'] * $currency / 6) * 100) / 100 * 6 . '</th>';
                    $html .= '<th hidden="hidden" class="p6" plid="' . $value[1][6]['PLID'] . '" minpl="' . $value[1][6]['MinPLID'] . '">' . /*sprintf("%.2f", ($value[1][6]['PriceMC'] * $currency))*/
                        ceil(($value[1][6]['PriceMC'] * $currency / 6) * 100) / 100 * 6 . '</th>';
                    $html .= '<th hidden="hidden" class="p7" plid="' . $value[1][7]['PLID'] . '" minpl="' . $value[1][7]['MinPLID'] . '">' . /*sprintf("%.2f", ($value[1][7]['PriceMC'] * $currency))*/
                        ceil(($value[1][7]['PriceMC'] * $currency / 6) * 100) / 100 * 6 . '</th>';
                    $html .= '<th hidden="hidden" class="p8" plid="' . $value[1][8]['PLID'] . '" minpl="' . $value[1][8]['MinPLID'] . '">' . /*sprintf("%.2f", ($value[1][8]['PriceMC'] * $currency))*/
                        ceil(($value[1][8]['PriceMC'] * $currency / 6) * 100) / 100 * 6 . '</th>';
                    $html .= '<th hidden="hidden" class="p9" plid="' . $value[1][9]['PLID'] . '" minpl="' . $value[1][9]['MinPLID'] . '">' . /*sprintf("%.2f", ($value[1][9]['PriceMC'] * $currency))*/
                        ceil(($value[1][9]['PriceMC'] * $currency / 6) * 100) / 100 * 6 . '</th>';
                    $html .= '<th hidden="hidden" class="p10"> - </th>';
                } elseif (count($value[1]) == 11) {
                    $html .= '<th hidden="hidden" class="p0" plid="' . $value[1][0]['PLID'] . '" minpl="' . $value[1][0]['MinPLID'] . '">' . /*sprintf("%.2f", ($value[1][0]['PriceMC'] * $currency))*/
                        ceil(($value[1][0]['PriceMC'] * $currency / 6) * 100) / 100 * 6 . '</th>';
                    $html .= '<th hidden="hidden" class="p1" plid="' . $value[1][1]['PLID'] . '" minpl="' . $value[1][1]['MinPLID'] . '">' . /*sprintf("%.2f", ($value[1][1]['PriceMC'] * $currency))*/
                        ceil(($value[1][1]['PriceMC'] * $currency / 6) * 100) / 100 * 6 . '</th>';
                    $html .= '<th hidden="hidden" class="p2" plid="' . $value[1][2]['PLID'] . '" minpl="' . $value[1][2]['MinPLID'] . '">' . /*sprintf("%.2f", ($value[1][2]['PriceMC'] * $currency))*/
                        ceil(($value[1][2]['PriceMC'] * $currency / 6) * 100) / 100 * 6 . '</th>';
                    $html .= '<th hidden="hidden" class="p3" plid="' . $value[1][3]['PLID'] . '" minpl="' . $value[1][3]['MinPLID'] . '">' . /*sprintf("%.2f", ($value[1][3]['PriceMC'] * $currency))*/
                        ceil(($value[1][3]['PriceMC'] * $currency / 6) * 100) / 100 * 6 . '</th>';
                    $html .= '<th hidden="hidden" class="p4" plid="' . $value[1][4]['PLID'] . '" minpl="' . $value[1][4]['MinPLID'] . '">' . /*sprintf("%.2f", ($value[1][4]['PriceMC'] * $currency))*/
                        ceil(($value[1][4]['PriceMC'] * $currency / 6) * 100) / 100 * 6 . '</th>';
                    $html .= '<th hidden="hidden" class="p5" plid="' . $value[1][5]['PLID'] . '" minpl="' . $value[1][5]['MinPLID'] . '">' . /*sprintf("%.2f", ($value[1][5]['PriceMC'] * $currency))*/
                        ceil(($value[1][5]['PriceMC'] * $currency / 6) * 100) / 100 * 6 . '</th>';
                    $html .= '<th hidden="hidden" class="p6" plid="' . $value[1][6]['PLID'] . '" minpl="' . $value[1][6]['MinPLID'] . '">' . /*sprintf("%.2f", ($value[1][6]['PriceMC'] * $currency))*/
                        ceil(($value[1][6]['PriceMC'] * $currency / 6) * 100) / 100 * 6 . '</th>';
                    $html .= '<th hidden="hidden" class="p7" plid="' . $value[1][7]['PLID'] . '" minpl="' . $value[1][7]['MinPLID'] . '">' . /*sprintf("%.2f", ($value[1][7]['PriceMC'] * $currency))*/
                        ceil(($value[1][7]['PriceMC'] * $currency / 6) * 100) / 100 * 6 . '</th>';
                    $html .= '<th hidden="hidden" class="p8" plid="' . $value[1][8]['PLID'] . '" minpl="' . $value[1][8]['MinPLID'] . '">' . /*sprintf("%.2f", ($value[1][8]['PriceMC'] * $currency))*/
                        ceil(($value[1][8]['PriceMC'] * $currency / 6) * 100) / 100 * 6 . '</th>';
                    $html .= '<th hidden="hidden" class="p9" plid="' . $value[1][9]['PLID'] . '" minpl="' . $value[1][9]['MinPLID'] . '">' . /*sprintf("%.2f", ($value[1][9]['PriceMC'] * $currency))*/
                        ceil(($value[1][9]['PriceMC'] * $currency / 6) * 100) / 100 * 6 . '</th>';
                    $html .= '<th hidden="hidden" class="p10" plid="' . $value[1][10]['PLID'] . '" minpl="' . $value[1][10]['MinPLID'] . '">' . /*sprintf("%.2f", ($value[1][10]['PriceMC'] * $currency))*/
                        ceil(($value[1][10]['PriceMC'] * $currency / 6) * 100) / 100 * 6 . '</th>';
                }
                $html .= '<th><input type="button" id="' . $value[0]['ProdID'] . '" class="addGood btn btn-primary" value="Добавить"></th></tr>';
            }
        }
        return $html;
    }

    public function export()
    {
        ini_set('memory_limit', '-1');
        $file = Input::file('file');
        $objPHPExcel = PHPExcel_IOFactory::load($file);
        $objPHPExcel->setActiveSheetIndex(0);
        $aSheet = $objPHPExcel->getActiveSheet();
        $data = array();
        foreach ($aSheet->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            $item = array();
            foreach ($cellIterator as $cell) {
                if (!empty($cell) && ($cell != null) && ($cell != '') && ($cell != '&#9')) {
                    array_push($item, $cell->getCalculatedValue());

                }
            }
            print_r($item);
            array_push($data, $item);
        }
        /*foreach($data as $key => $value)
        {
            foreach($value as $k => $v)
            {
                if(!empty($value[$k]))
                {
                    \AlistaGoods::insert(['group_id' => $value[0], 'goods' => $value[1], 'title' => $value[2],
                        'short_name' => $value[3], 'remains_cashless' => $value[4], 'reserve_cashless' => $value[5],
                        'remains_cash' => $value[6], 'reserve_cash' => $value[7], 'p101' => $value[8],
                        'p102' => $value[9], 'p103' => $value[10], 'p104' => $value[11], 'p105' => $value[12],
                        'p106' => $value[13], 'p107' => $value[14], 'p108' => $value[15], 'p109' => $value[16],
                        'p110' => $value[17]]);
                } else {
                    continue;
                }
            }
        }*/
        /*for($i = 0; $i < count($data[0]); $i++)
        {
            for($j = 0; $j < count($data); $j++)
            {
                if(!empty($data[$i][$j]))
                {
                    \AlistaGoods::insert(['group_id' => $data[$i][0], 'goods' => $data[$i][1], 'title' => $data[$i][2],
                        'short_name' => $data[$i][3], 'remains_cashless' => $data[$i][4], 'reserve_cashless' => $data[$i][5],
                        'remains_cash' => $data[$i][6], 'reserve_cash' => $data[$i][7], 'p101' => $data[$i][8],
                        'p102' => $data[$i][9], 'p103' => $data[$i][10], 'p104' => $data[$i][11], 'p105' => $data[$i][12],
                        'p106' => $data[$i][13], 'p107' => $data[$i][14], 'p108' => $data[$i][15], 'p109' => $data[$i][16],
                        'p110' => $data[$i][17]]);
                } else {
                    continue;
                }
            }
        }*/
        return ['msg' => 'export done'];
    }

    public function email()
    {
        //require_once( '../html2pdf/html2pdf.class.php');
        //require_once( $_SERVER['DOCUMENT_ROOT'].'/public/packages/PHPMailer-master/PHPMailerAutoload.php');

        $dom = '<table class="table table-hover table-bordered table-striped">
        <tr>
            <th rowspan="2"><h3>Рахунок</h3></th>
            <th>Номер:</th>
            <th colspan="2">19170</th>
        </tr>
        <tr>
            <th>Дата:</th>
            <th colspan="2">15.12.2015</th>
        </tr>
        <tr>
            <th>ТОВАРИСТВО З ОБМЕЖЕНОЮ ВІДПОВІДАЛЬНІСТЮ "ТОРГОВА КОМПАНІЯ "АЛИСТА"</th>
            <th colspan="3">р/с 26002000032507</th>
        </tr>
        <tr>
            <th>49083, м. Дніпропетровськ</th>
            <th colspan="3">Акціонерний банк "Південний" м. Одеса</th>
        </tr>
        <tr>
            <th>вул. Собінова, буд. 1</th>
            <th colspan="3">МФО 328209</th>
        </tr>
        <tr>
            <th>Податковий код: 372595704614, Свідоцтво: 100324872</th>
            <th colspan="3">ОКПО 37259577</th>
        </tr>
        <tr>
            <th>Підприємство:</th>
            <th> ТОВАРИСТВО З ОБМЕЖЕНОЮ ВІДПОВІДАЛЬНІСТЮ "КАПЕКС"</th>
            <th colspan="2"> 16282<br>72<br>1<br>102</th>
        </tr>
        <tr>
            <th>Адреса:</th>
            <th colspan="3"> вул. Космонавта Комарова, буд. 10</th>
        </tr>
        <tr>
            <th>Місто:</th>
            <th colspan="3"> м. Одеса  65043</th>
        </tr>
    </table>
    <table class="table table-hover table-bordered table-striped">
        <tr>
            <th>Телефон:</th>
            <th></th>
            <th>Факс:</th>
            <th></th>
        </tr>
    </table>
    <br/>
    <table class="table table-hover table-bordered table-striped">
        <thead>
            <tr>
                <th>Код</th>
                <th>Назва товарів, (робіт, послуг)</th>
                <th>Од.Вим.</th>
                <th>Кількість</th>
                <th>Ціна без ПДВ</th>
                <th>Сума без ПДВ</th>
                <th>Ціна з ПДВ</th>
                <th>Сума з ПДВ</th>
            </tr>
        </thead>
        <tbody>
                            <tr>
                    <th>436-6090-2</th>
                    <th>Шуруп универсальный, потай, цж, 6*90</th>
                    <th></th>
                    <th>120</th>
                    <th>79.1</th>
                    <th>9492</th>
                    <th>88.592</th>
                    <th>10631.04</th>
                </tr>
                    </tbody>
    </table>
    <table class="table table-hover table-bordered table-striped">
        <tr>
            <th>Кількість: </th>
            <th>Сума без НДС: </th>
        </tr>
        <tr>
            <th>Загальна вага: </th>
            <th>Сума НДС: </th>
        </tr>
        <tr>
            <th>Сума з ПДВ:</th>
            <th>десять тисяч шiстсот тридцять одна гривня 4 коп.</th>
            <th>10 631,04</th>
        </tr>
    </table>';

        /*$html2pdf = new HTML2PDF('L','A4','en');
        $html2pdf->sethefaultFont('freesans');
        $html2pdf->WriteHTML($dom);
        print_r($html2pdf);*/
        //$Mail = new PHPMailer();
        /*file_put_contents()
        $Mail->addAttachment($tempfile, $filename);
        $Mail->IsMail();
        $Mail->IsHTML(true);
        $Mail->CharSet = 'utf-8';
        $Mail->From = 'metiz.alista.org.ua';
        $Mail->FromName = ' Отдел метизов';
        $oMail_user->Subject = 'Видаткова накладна';
        $oMail_user->Body = $modx->getChunk('email-sales-invoice');
        $oMail_user->addAddress($tsvshop['EmailForInvoices']);

        if (!$oMail_user->send()) {
            $out = json_encode(array(
                'status' => 'error',
                'message' => 'Во время отправки письма произошла ошибка'
            ));
        }*/
        $status = ['status' => 'done'];
        return $status;
        //$tempfile = $_SERVER['DOCUMENT_ROOT'].'/assets/docs/'. session_name() .'-pdf-for-mail-order.pdf';
        //$html2pdf->Output($tempfile, 'F');
    }

    public function orders()
    {
        $res = Input::get('res');

        $newOrd = DB::select('SELECT * FROM  orders ORDER BY orderID DESC LIMIT 1');
        $result = json_decode(json_encode($newOrd), true);
        $newOrder = $result[0]['orderID'] + 1;

        if (empty($res)) {
            return ['message' => ['error' => 'Нет позиций в счете']];
        }
        $pos = 1;
        $goodsArr = [];
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
            $price = \ProdMP::where('ProdID', '=', $goods['ProdID'])->where('PLID', '=', $value['pl'])->get(['PriceMC'])->first()->toArray();
            if (empty($price)) {
                return ['message' => ['error' => 'Нет цены']];
            }
            if ($value['CodeID3'] == 1) {
                $currency = \Currency::where('appointment', '=', 1)->get(['value'])->first()->value;
            } else {
                $currency = \Currency::where('appointment', '=', 4)->get(['value'])->first()->value;
            }
            \Orders::create([
                'status' => 0,
                'orderID' => $newOrder,
                'SrcPosID' => $pos,
                'ProdID' => $goods['ProdID'],
                'ProdName' => $value['name'],
                'UM' => $value['um'],
                'CompName' => $comp['CompName'],
                'CompID' => $value['CompID'],
                'StockID' => $value['stockID'],
                'CodeID3' => $value['CodeID3'],
                'EmpID' => $value['empID'],
                'PLID' => $value['pl'],
                'PriceMC' => $value['price'],
                'SumPrice' => $value['quantity'] * ceil(($value['price'] / 6) * 100) / 100 * 6,
                'Qty' => $value['quantity'],
                'Kurs' => $currency,
                'created_at' => date("Y-m-d")
            ]);
            $pos++;
            $prod =
                [
                    'orderID' => $newOrder,
                    'SrcPosID' => $pos,
                    'ProdID' => $goods['ProdID'],
                    'ProdName' => $value['name'],
                    'UM' => $value['um'],
                    'CompName' => $comp['CompName'],
                    'CompID' => $value['CompID'],
                    'StockID' => $value['stockID'],
                    'CodeID3' => $value['CodeID3'],
                    'EmpID' => $value['empID'],
                    'PLID' => $value['pl'],
                    'PriceMC' => $value['price'],
                    'SumPrice' => sprintf("%.2f", $value['quantity'] * $value['price']),
                    'Qty' => $value['quantity'],
                    'Kurs' => $currency
                ];
            $result[$key] = ['state' => 'success', 'prod' => $prod];
        }
        return $result;
    }

}