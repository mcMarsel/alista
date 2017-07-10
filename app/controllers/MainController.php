<?php

class MainController extends BaseController 
{

	public function auth() 
	{
		$n = 'krutijk';
		$data = [
    			'customer' => 'John Smith',
    			'url' => 'http://laravel.com'
		];
		if(\User::where('username','=', $n)->exists())
		{
			/*Mailgun::send('example', $data, function($message)
			{
    				$message->to('glazunov@alista.com.ua', '')->subject('Welcome!');
			});*/
			return 'sds';
		} else {
		return 'sds';
		}
	}
	
	public function index()
	{
        $pgr2Obj = \ProdGr2::get(['PGrID2', 'PGrName2'])->toArray();
		$pgrID = [];
		foreach($pgr2Obj as $key => $value)
		{
			array_push($pgrID,$value['PGrID2']);
		}
		$pgrName = [];
		foreach($pgr2Obj as $key => $value)
		{
			array_push($pgrName,$value['PGrName2']);
		}
		$empsName = [];
		$empsID = [];
        
		if(Auth::getUser()->status == 0)
		{
			$EmpID = Auth::getUser()->EmpID;
			$comps = \Comps::orderBy('CompName', 'asc')->get(['CompName', 'CompID'])->toArray();
			$EmpName = \Emps::where('EmpID', '=', $EmpID)->get(['EmpName'])->first()->EmpName;
			$EmpPL = \Emps::where('EmpID', '=', $EmpID)->get(['PLID'])->first()->PLID;
			$compName = [];
			$compID = [];
            foreach($comps as $key => $value)
            {
                if($value['CompName'] == NULL)
                {
                    continue;
                } else {
                    array_push($compName,$value['CompName']);
                    array_push($compID,$value['CompID']);
                }
            }
            unset($comps);
            $comps = array_combine($compID, $compName);
            asort($comps, SORT_STRING);

            $pgr3Obj = \ProdGr3::where('status', '=', 1)
            ->orderBy('PGrName3', 'asc')
            ->get(['PGrID3', 'PGrName3'])->toArray();
            $pgrName3 = [];
            $pgrID3 = [];
	        foreach($pgr3Obj as $key => $value)
			{
				array_push($pgrName3, $value['PGrName3']); 
				array_push($pgrID3, $value['PGrID3']); 	
			}
			unset($pgr3Obj);
			$pgr3Obj = array_combine($pgrID3, $pgrName3);
            $currency = \Currency::where('appointment', '=', 4)->get(['value'])->first()->value;
            return View::make('manager', compact(['EmpPL', 'currency', 'pgr3Obj', 'newOrder', 'EmpName', 'EmpID', 'comps']));
        } else {
            $Emps = \Emps::where('DepID', '=', 2150)->orderBy('EmpName', 'asc')->get(['EmpName', 'EmpID'])->toArray();
            $EmpPL = \Emps::where('EmpID', '=', Auth::getUser()->EmpID)->get(['PLID'])->first()->PLID;
            foreach($Emps as $key => $value)
			{
				array_push($empsName, $value['EmpName']); 
				array_push($empsID, $value['EmpID']); 	
			}
			unset($Emps);
			$Emps = array_combine($empsID, $empsName);
			$comps = \Comps::/*whereIn('EmpID', $empsID)->*/orderBy('CompName', 'asc')->get(['CompName'])->toArray();
            $pgr3Obj = \ProdGr3::where('status', '=', 1)
	        	->orderBy('PGrName3', 'asc')
	        	->get(['PGrID3', 'PGrName3'])->toArray();
	        	$pgrName3 = [];
	        	$pgrID3 = [];
            foreach($pgr3Obj as $key => $value)
			{
				array_push($pgrName3, $value['PGrName3']); 
				array_push($pgrID3, $value['PGrID3']); 	
			}
			unset($pgr3Obj);
			$comp = [];
			$pgr3Obj = array_combine($pgrID3, $pgrName3);
			foreach($comps as $key => $value)
            {
                if($value['CompName'] == NULL)
                {
                    continue;
                } else {
                    array_push($comp,$value['CompName']);
                }
            }
            asort($comp, SORT_STRING);
            /*echo "<pre>";
            print_r($comps);
            echo "</pre>";
            die();*/
            $currency = \Currency::where('appointment', '=', 4)->get(['value'])->first()->value;
			return View::make('heads', compact(['EmpPL', 'currency', 'pgr3Obj', 'newOrder', 'Emps']));
        }
	}

    public function update()
    {
        return View::make('update');
    }

    public function update1()
    {
        \Orders::where('DocID', '=', Input::get('DocID'))->update(['status' => Input::get('status')]);
        $msg = 'Выполнено';
        return View::make('msg', compact('msg'));
    }
}