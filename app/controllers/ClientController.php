<?php

class ClientController extends BaseController 
{
    public function saveContact()
    {
        $valP = Input::get('valueP');
        $valC = Input::get('valueC');
        $compID = Input::get('compID');
        $contObj = \CompContact::orderBy('id', 'asc')->get()->last();
        \CompContact::create(['CompID' => $compID, 'id' => $contObj, 'PhoneWork' => $valP, 'Contact' => $valC]);
        return 'update';
    }

    public function saveAddress()
    {
        $val = Input::get('value');
        $compID = Input::get('compID');
        $addObj = \CompAdd::orderBy('id', 'asc')->get()->last();
        \CompAdd::create(['id' => $addObj->id, 'CompID' => $compID, 'CompAdd' => $val]);
        return 'create';
    }

    public function editAddress()
    {
        $id = Input::get('id');
        $val = Input::get('value');
        $compID = Input::get('compID');
        \CompAdd::where('CompID', '=', $compID)
            ->where('id', '=', $id)
            ->update(['CompAdd' => $val]);
        return 'update';
    }

    public function editContact()
    {
        $id = Input::get('id');
        $valP = Input::get('valueP');
        $valC = Input::get('valueC');
        $compID = Input::get('compID');
        \CompContact::where('CompID', '=', $compID)
            ->where('id', '=', $id)
            ->update(['Contact' => $valC, 'PhoneWork' => $valP]);
        return 'update';
    }

    public function delAddress()
    {
        $id = Input::get('id');
        $compID = Input::get('compID');
        \CompAdd::where('CompID', '=', $compID)
            ->where('id', '=', $id)->delete();
        return 'delete';
    }

    public function delContact()
    {
        $id = Input::get('id');
        $compID = Input::get('compID');
        \CompContact::where('CompID', '=', $compID)
            ->where('id', '=', $id)->delete();
        return 'delete';
    }

    public function edit()
    {
        $compID = Input::get('compID');
        $compName = Input::get('compName');
        $address = \CompAdd::where('CompID', '=', Input::get('compID'))->get()->toArray();
        $contact = \CompContact::where('CompID', '=', Input::get('compID'))->get()->toArray();
        /*echo "<pre>";
        print_r($contact);
        print_r($address);
        echo "</pre>";
        die();*/
        return View::make('client.bookmarks', compact(['address', 'contact', 'compID', 'compName']));
    }

	public function index()
	{
        return View::make('client/new-client');
	}

    public function getCity()
    {
        $city = \City::where('regionID', '=', Input::get('id'))->get()->toArray();
        $cityID = [];
        foreach($city as $key => $value)
        {
            array_push($cityID, $value['cityID']);
        }
        return $cityID;
    }

	public function ListClient()
	{
        if(Auth::getUser()->status == 0) {
            $EmpID = Auth::getUser()->EmpID;
            $comps = \Comps::where('EmpID', '=', $EmpID)->get()->toArray();
        } elseif(Auth::getUser()->status == 1)
        {
            $comps = \Comps::get()->toArray();
        }
        return View::make('client.list', compact(['comps']));
	}
	
	public function newClient()
	{
        $city = \City::where('cityID', '=', Input::get('city'))->get()->last();
        $comp = \Comps::orderBy('id', 'desc')->get()->first()->toArray();
        $id = $comp['id']+1;
        \CompAdd::insert(
            [
                'id' => $id,
                'CompDefaultAdd' => 0,
                'CompAdd' => Input::get('address')
            ]
        );
        \CompContact::insert(
            [
                'id' => $id,
                'PhoneWork' => Input::get('phone'),
                'Contact' => Input::get('fullName'),
                'ContactAll' => Input::get('fullName').' '.Input::get('phone'),
                'eMail' => Input::get('email')
            ]
        );
        \Comps::insert(
            [
                'id' => $id,
                'CompName' => Input::get('clientName'),
                'EMail' => Input::get('email'),
                'City' => $city->cityName,
                'Code' => 0,
                'TaxRegNo' => 0,
                'TaxCode' => 0,
                'TaxPayer' => 0,
                'CodeID1' => 0,
                'CodeID2' => 0,
                'CodeID3' => 0,
                'CodeID4' => 0,
                'CodeID5' => 0,
                'PLID' => 0,
                'Discount' => 0,
                'PayDelay' => 0,
                'EmpID' => Auth::getUser()->EmpID,
                'TranPrc' => 0,
                'MorePrc' => 0,
                'FirstEventMode' => 0,
                'CompType' => 0,
                'SysTaxType' => 0,
                'InStopList' => 0,
                'CompGrID1' => $city->regionID,
                'CompGrID2' => 0,
                'CompGrID3' => 0,
                'CompGrID4' => 0,
                'CompGrID5' => 0,
                'CityID' => Input::get('city'),
                'CompNameFull' => Input::get('clientName'),
                'ETime' => Input::get('ETime'),
                'BTime' => Input::get('BTime')
            ]
        );
        $msg = 'Новое предприятие создано!';
        return View::make('msg', compact(['msg']));
    }

	/*public function newClient()
	{	
		$clientName = Input::get('clientName');
		$region = Input::get('region');
		$city = Input::get('city');
		$fullName = Input::get('fullName');
		$timeWork = Input::get('timeWork');
		$phone = Input::get('phone');
		$email = Input::get('email');
		$EmpName = \Emps::where('EmpID', '=', Auth::getUser()->EmpID)->get(['UAEmpName'])->toArray();
		$message = "\r\n".'Добрый день, прошу добавить нового клиента.'."\r\n".
		'От служащего: '.$EmpName[0]['UAEmpName'].".\r\n".
		'Код служащего: '.Auth::getUser()->EmpID.".\r\n".
		'Название предприятия: '.$clientName.".\r\n".
		'Область: '.$region.".\r\n".
		'Город: '.$city.".\r\n".
		'Контактное лицо: '.$fullName.".\r\n".
		'Время работы '.$timeWork.".\r\n".
		'Контактный email: '.$email.".\r\n".
		'Контактный номер телефон: '.$phone.'.';
		$to      = 'kurasova@alista.com.ua';
		$subject = '=?UTF-8?B?'.base64_encode('Добавление нового клиент').'?=';
		$headers = 'From: webmaster@metiz.alista.org.ua'."\r\n".
			'Cc: krutijk@alista.com.ua' . "\r\n".
    			//'Reply-To: krutijk@alista.org.ua' . "\r\n" .
    			'X-Mailer: PHP/' . phpversion();
		mail($to, $subject, $message, $headers);
		return View::make('client.email', compact(['clientName', 'region', 'city', 'fullName', 'timeWork', 'phone']));		
	}*/

}