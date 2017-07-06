<?php

class DebitController extends BaseController
{

	public function index()
	{
		//if(Auth::getUser()->status == 0)
		//{
		//$Receivables = \Receivables::where('EmpID', '=', Auth::getUser()->EmpID)->get();
		//return View::make('debit', compact(['Receivables']));
		//} else {
		/*$Receivables = \Receivables::where('EmpID', '=', '1967')->get()->take(5);
		foreach($Receivables as $key => $value)
		{
			echo "<pre>";
			print_r(str_replace(' 00:00:00', '', $value->DocDate));
			echo "</pre>";
		}*/
		return View::make('debit');
		//}
	}

    public function getColumns()
    {
        $res =
            [0 => ["name" => "status", "title" => "Статус", "breakpoints" => "xs", "type" => "number", "style" => ["width" => 80, "maxWidth" => 80]], 1 => ["name" => "iddoc", "title" => "ИД документа", "breakpoints" => "xs", "style" => ["width" => 80, "maxWidth" => 80]], 2 => ["name" => "empid", "title" => "ИД служащего", "breakpoints" => "xs", "type" => "number", "style" => ["width" => 80, "maxWidth" => 80]], 3 => ["name" => "empName", "title" => "Имя служащего", "breakpoints" => "xs", "style" => ["width" => 80, "maxWidth" => 80]],
                //2 => ["name"=>"DocID","title"=>"ИД РД"],
                //3 => ["name"=>"DocDate","title"=>"Дата РД"],
                /*4 => ["name"=>"TSumCC","title"=>"Сумма РД, грн","data-breakpoints"=>"xs"],
                5 => ["name"=>"TSumCC","title"=>"Сумма РД, $","data-breakpoints"=>"xs"],
                6 => ["name"=>"ArrearsCC","title"=>"Сумма задолженности, грн","data-breakpoints"=>"xs"],
                7 => ["name"=>"ArrearsMC","title"=>"Сумма задолженности, $","data-breakpoints"=>"xs"]*/
            ];
        $r = '{"name":"CompName","title":"Имя предприятия"}},
        {"name":"EmpName","title":"Имя служащего"},
        {"name":"DocID","title":"ИД РД", "data-breakpoints":"xs", "data-type":"number"},
        {"name":"DocDate","title":"Дата РД","data-breakpoints":"xs sm md", "data-type":"date"},
        {"name":"TSumCC","title":"Сумма РД, грн","data-breakpoints":"xs"}},
        {"name":"TSumMC","title":"Сумма РД, $","data-breakpoints":"xs"},
        {"name":"ArrearsCC","title":"Сумма задолженности, грн","data-breakpoints":"xs"},
        {"name":"ArrearsMC","title":"Сумма задолженности, $","data-breakpoints":"xs"}';
        return $res;
    }

    public function getRows()
    {
        //{"id":1,"firstName":"Annemarie","lastName":"Bruening","something":1381105566987,"jobTitle":"Cloak Room Attendant","started":1367700388909,"dob":122365714987,"status":"Suspended"},
        $res = [];
        $Receivables = \Orders::orderBy('DocID', 'desc')->get();
		foreach ($Receivables as $key => $value) {
            /*echo "<pre>";
            print_r($value);
            echo "</pre>";*/
            $res[$key]['status'] = $value->status;
            $res[$key]['iddoc'] = $value->DocID;
            $res[$key]['empid'] = $value->EmpID;
			$res[$key]['empName'] = $value->CompName;
            //$res[$key]['DocID'] = $value->DocID;
            //$res[$key]['DocDate'] = $value->DocDate;
        }
        return $res;
    }

}