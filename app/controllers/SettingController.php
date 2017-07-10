<?php

require(__DIR__.'/../Admin/PdfOrders.php');

class SettingController extends BaseController
{

    public function  ot()//($DocID)
    {
        $DocID = 30573;//Input::get('appID');
        $order = \Orders::where('DocID', '=', $DocID)
            ->get()->toArray();
        $DocDate = explode(' ', $order[0]['created_at']);
        $arrDate = explode('-',$DocDate[0]);
        $strDate = $arrDate[2].'.'.$arrDate[1].'.'.$arrDate[0];
        $CompID = $order[0]['CompID'];
        $CompName = $order[0]['CompName'];
        $comp = \Comps::where('CompID', '=', $CompID)->get()->last();
        $compAdd = \CompAdd::where('CompID', '=', $CompID)->get()->toArray();
        $compContact = \CompContact::where('CompID', '=', $CompID)->get()->toArray();
        $CityName = $comp->City;
        $TSum_wt = '';
        $TSum_nt = '';
        $TQty = '';
        $pdf = new \Admin\PdfOrders();
        if(\Comps::where('comps.CompID', '=', $CompID)
            ->join('CompAdd', 'CompAdd.CompID', '=', 'comps.CompID')
            ->get()->toArray())
        {
            $comp = \Comps::where('CompID', '=', $CompID)
                ->get()->last()->toArray();
            $compAdd = \CompAdd::where('CompID', '=', $CompID)
                ->get()->last()->toArray();
        } else {
            $comp = \Comps::where('CompID', '=', $CompID)
                ->get()->last()->toArray();
            $compAdd = ['CompAdd' => ''];
        }
        $CompAdd =  $compAdd['CompAdd'];
        /*echo "<pre>";
        print_r($order);
        echo "</pre>";
        die();*/
        foreach($order as $key => $value)
        {
            $TSum_wt += $value['SumPrice'];
            $TSum_nt += $value['SumPrice']/1.2;
            $TQty += $value['Qty'];
        }
        $TPrice_wt = str_replace('.',',',round($TSum_wt, 2));
        $numberChar = $pdf->num2text_ua($TSum_wt);
        //die();
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
                'CompAdd'
            ]
        ))->render();
        $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
        $bpdf = BPDF::loadHTML($html, 'UTF-8');
        $bpdf->setPaper('a4')->setOrientation('portrait')->setWarnings(false)->save('Счет на оплату.pdf')->stream('opdf.pdf');

        return View::make('order-template', compact(
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
                'CompAdd'
            ]
        ));
    }

    public function  testv()
    {
        $appID = 21108470;//Input::get('appID');
        $appArr = \Approved::where('AppID', '=', $appID)
            ->get()->last();
        $orderID = $appArr->DocID;
        $dateShipping = explode(' ',$appArr->dateShipping);
        $arrDate = explode('-',$dateShipping[0]);
        $strDate = $arrDate[2].'.'.$arrDate[1].'.'.$arrDate[0];
        $date = explode(' ', $appArr->created_at);
        $dateArr = explode('-', $date[0]);
        $strCDate = $dateArr[2].'.'.$dateArr[1].'.'.$dateArr[0];
        $order = \Orders::where('DocID', '=', $orderID)
            ->where('status', '=', 3)
            ->get()->last();
        $orders = \Orders::where('DocID', '=', $orderID)
            ->where('status', '=', 3)
            ->get()->toArray();
        $comp = \Comps::where('CompID', '=', $order->CompID)->get()->last();
        $compName = $comp->CompName;
        $transporter = \Transporter::where('transporterID', '=', $appArr->transporterID)
            ->get(['transporterName'])->last();
        $city = trim($appArr->cityName);
        $StockID = $order->StockID;
        $TWeight = '';
        $strTransporter = $transporter->transporterName;
        foreach($orders as $key => $value)
        {
            $prod = \Prods::where('ProdID', '=', $value['ProdID'])
                ->get(['Weight'])->last();
            $Weight = $prod->Weight * $value['Qty'];
            $TWeight += $Weight;
        }
        $prodBody = [];
        $TQty = '';
        foreach($orders as $key => $value)
        {
            $rem ='';
            $TQty += $value['Qty'];
            $prodBody[$key][] = $value['ProdID'];
            $prodBody[$key][] = $value['ProdName'];
            $prodBody[$key][] = $value['UM'];
            $prodBody[$key][] = round($value['Qty'],1);
            $prodBody[$key][] = $value['UM'];
            $prodBody[$key][] = round($value['Qty'],1);
            $arrRem = \Rem::where('StockID', '=', $order->StockID)
                ->where('ProdID', '=', $value['ProdID'])->get()->toArray();
            foreach($arrRem as $k => $val)
            {
                $rem += $val['RemCash'];
                $rem += $val['RemUncash'];
            }
            $prodBody[$key][] = round($rem, 2);
        }
        unset($orders);
        $orders = $prodBody;
        unset($prodBody);
        $specialNotes = $appArr->specialNotes;
        $filename = $this->trer(
            $appID,
            $strCDate,
            $strDate,
            $strTransporter,
            $city,
            $appArr->specialNotes,
            $compName,
            $StockID,
            $orders,
            $TWeight,
            $TQty
        );
        return View::make('testv', compact(['appID','strCDate','strDate','strTransporter','city','specialNotes','compName','StockID','orders','TWeight','TQty']));
    }

	public function trer($AppID,$StrCDate,$StrDate,$StrTransporter,$City,$SpecialNotes,$CompName,$stockID,$Orders,$tWeight,$tQty)
    {
        $appID = $AppID; $strCDate = $StrCDate; $strDate = $StrDate; $strTransporter = $StrTransporter;
        $city = $City; $specialNotes = $SpecialNotes; $compName = $CompName; $StockID = $stockID;
        $orders = $Orders; $TWeight = $tWeight; $TQty = $tQty;
        $bpdf = new BPDF();
        $fileName = 'Заявка на відбір товару.pdf';
        $html = View::make('testv', compact(['appID','strCDate','strDate','strTransporter','city','specialNotes','compName','StockID','orders','TWeight','TQty']))
	            ->render();
        $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
        $bpdf = BPDF::loadHTML($html, 'UTF-8');
        $bpdf->setPaper('a4')->setOrientation('portrait')->setWarnings(false)->save('Заявка на відбір товару.pdf')->stream('bpdf.pdf');
        return $fileName;
    }

	public function index($latitude, $longitude, $trackid)
	{
        echo "<pre>";
        print_r(Input::all());
        print_r($latitude);
        print_r($longitude);
        print_r($trackid);
        echo "</pre>";
		return View::make('track');
	}

    public function main() {
        if(Auth::user()->status == 0)
        {
            return View::make('default');
        } else {
            $pgr3Obj = \ProdGr3::orderBy('PGrName3', 'asc')
                ->get(['PGrID3', 'PGrName3', 'status'])->toArray();
            $users = \User::join('Emps', 'Emps.EmpID', '=', 'users.EmpID')
                ->get(['users.id','users.username', 'users.EmpID', 'Emps.EmpName', 'users.status', 'users.EMail', 'Emps.UAEmpName'])->toArray();
            $head = \Head::get()->toArray();
            $hName = [];
            $hID = [];
            foreach($head as $key => $value)
            {
                array_push($hName, $value['EmpName']);
                array_push($hID, $value['HeadID']);
            }
            $heads = array_combine($hID, $hName);
            $emp = \Emps::whereNotIn('EmpID', function($e){
                $e->select(['EmpID'])->from('HeadBranch');
                return $e;
            })->get()->toArray();
            $empName = [];
            $empID = [];
            foreach($emp as $key => $value)
            {
                array_push($empName, $value['EmpName']);
                array_push($empID, $value['EmpID']);
            }
            unset($emp);
            $emp = array_combine($empID, $empName);
            return View::make('setting.setting-main', compact(['pgr3Obj', 'users', 'head', 'emp', 'heads']));
        }
    }

    public function degrade_head() {
        $id = Input::get('id');
        \Head::where('id', '=', $id)
            ->delete();
        return ['status' => 1];
    }

    public function showgr3()
    {
        $id = Input::get('id');
        $p = \ProdGr3::where('PGrID3', '=', $id)
            ->update(['status' => 1]);
        return $p;
    }

    public function hidegr3()
    {
        $id = Input::get('id');
        /*$p = \ProdGr3::where('PGrID3', '=', $id)
            ->get()->last();*/
        $p = \ProdGr3::where('PGrID3', '=', $id)
            ->update(['status' => 0]);
        return $p;
    }

    public function changeStatus()
    {
        $id = Input::get('id');
        $status = Input::get('status');
        \User::where('id', '=', $id)
            ->update(['status' => $status]);
        return $status;
    }

    public function saveKurs()
    {
        /*echo "<pre>";
        print_r(Input::get('cash'));
        print_r(Input::get('uncash'));
        echo "</pre>";*/
        if(Input::get('cash') && Input::get('uncash'))
        {
            $cash = Input::get('cash');
            $uncash = Input::get('uncash');
            \Currency::where('appointment', '=', 4)
                ->update(['value' => $uncash]);
            \Currency::where('appointment', '=', 1)
                ->update(['value' => $cash]);
            return ['status' => 1];
        } else if(Input::get('uncash') && !Input::get('cash'))
        {
            $cashObj = \Currency::where('s_name', '=', 1)->get()->last();
            $cash = $cashObj->value;
            $uncash = Input::get('uncash');
            \Currency::where('appointment', '=', 4)
                ->update(['value' => $uncash]);
            \Currency::where('appointment', '=', 1)
                ->update(['value' => $cash]);
            return ['status' => 1];
        } else if(!Input::get('uncash') && Input::get('cash'))
        {
            $uncashObj = \Currency::where('s_name', '=', 102)->get()->last();
            $uncash = $uncashObj->value;
            $cash = Input::get('cash');
            \Currency::where('appointment', '=', 4)
                ->update(['value' => $uncash]);
            \Currency::where('appointment', '=', 1)
                ->update(['value' => $cash]);
            return ['status' => 1];
        }
        else {
            return ['status' => 0];
        }
    }

    public function modalEdit()
    {
        $id = Input::get('id');
        $user = User::where('id', '=', $id)
            ->get()->last();
        $emp = \Emps::where('EmpID', '=', $user->EmpID)
            ->get()->last();
        $empJSON = json_encode($emp);
        $userJSON = json_encode($user);
        return ['emp' => $empJSON, 'user' => $userJSON];
    }

    public function spw()
    {
        $pw = Input::get('password');
        $id = Input::get('id');
        \User::where('id', '=', $id)
            ->update(['password' => Hash::make($pw)]);
        return ['status' => 1];
    }

    public function saveProfile()
    {
        $obj = Input::get('obj');
        $userOld = \User::where('id', '=', $obj['id'])->get()->last();
        if(!empty($obj['password'])) {
            \User::where('id', '=', $obj['id'])
                ->update(['password' => $obj['password']]);
        }
        \User::where('id', '=', $obj['id'])
            ->update(['username' => $obj['username'], 'status' => 0, 'email' => $obj['EMail'], 'EmpID' => $obj['EmpID']]);
        \Emps::where('EmpID', '=', $userOld->EmpID)
            ->update(
                [
                    'EmpID' => $obj['EmpID'],
                    'EmpName' => $obj['EmpName'],
                    'UAEmpName' => $obj['UAEmpName'],
                    'EmpGrID' => $obj['EmpGrID'],
                    'HeadID' => $obj['HeadID'],
                    'PLID' => $obj['PLID'],
                    'DepID' => $obj['DepID'],
                    'EMail' => $obj['EMail']
                ]
            );
        return ['status' => 1];
    }

    public function new_user()
    {
        $userObj = Input::get('obj');
        $userName = explode('@',$userObj['EMail']);
        $e = \Emps::create(
            [
                'EmpID' => $userObj['EmpID'],
                'EmpName' => $userObj['EmpName'],
                'UAEmpName' => $userObj['UAEmpName'],
                'DepID' => 2150,
                'HeadID' => $userObj['HeadID'],
                'PLID' => $userObj['PLID'],
                'EMail' => $userObj['EMail'],
                'EmpGrID' => 3
            ]
        );
        $e->save();
        $u = \User::create(
            [
                'username' => $userName[0],
                'password' => Hash::make($userObj['password']),
                'status' => 0,
                'EmpID' => $userObj['EmpID'],
                'email' => $userObj['EMail']
            ]
        );
        $u->save();
        return ['status' => 1];
    }

    public function rmUser()
    {
        $id = Input::get('id');
        $userObj = \User::where('id', '=', $id)
            ->get()->last();
        \Emps::where('EmpID', '=', $userObj->EmpID)
            ->delete();
        \User::where('id', '=', $id)
            ->delete();
        return ['status' => 1];
    }

    public function addHead()
    {
        $selEmp = Input::get('selEmp');
        $emp = \Emps::where('EmpID', '=', $selEmp)
            ->get()->last();
        $last = \Head::orderBy('HeadID', 'asc')->get(['HeadID'])->last();
        $h = \Head::create(['EmpName' => $emp->EmpName, 'EmpID' => $emp->EmpID, 'HeadID' => $last->HeadID+1]);
        $h->save();
        return ['status' => 1];
    }

}