<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::get('login', 'SessionsController@create');
Route::get('logout', 'SessionsController@destroy');
Route::resource('sessions', 'SessionsController');

Route::get('testv',
    [
        'as' => 'testv',
        'uses' => 'SettingController@testv'
    ]
);
//=========SettingController ROUTE
Route::get('setting-main',
    [
        'as' => 'setting-main',
        'uses' => 'SettingController@main'
    ]
);

Route::get('ot',
    [
        'as' => 'ot',
        'uses' => 'SettingController@ot'
    ]
);
//=========SettingController ROUTE
Route::get('setting-main',
    [
        'as' => 'setting-main',
        'uses' => 'SettingController@main'
    ]
);

Route::post('hidegr3',
    [
        'as' => 'hidegr3',
        'uses' => 'SettingController@hidegr3'
    ]
);

Route::post('showgr3',
    [
        'as' => 'showgr3',
        'uses' => 'SettingController@showgr3'
    ]
);

Route::post('saveKurs',
    [
        'as' => 'saveKurs',
        'uses' => 'SettingController@saveKurs'
    ]
);

Route::post('modalEdit',
    [
        'as' => 'modalEdit',
        'uses' => 'SettingController@modalEdit'
    ]
);

Route::post('spw',
    [
        'as' => 'spw',
        'uses' => 'SettingController@spw'
    ]
);

Route::post('saveProfile',
    [
        'as' => 'saveProfile',
        'uses' => 'SettingController@saveProfile'
    ]
);

Route::post('new_user',
    [
        'as' => 'new_user',
        'uses' => 'SettingController@new_user'
    ]
);

Route::post('rmUser',
    [
        'as' => 'rmUser',
        'uses' => 'SettingController@rmUser'
    ]
);

Route::post('degrade_head',
    [
        'as' => 'degrade_head',
        'uses' => 'SettingController@degrade_head'
    ]
);

Route::post('addHead',
    [
        'as' => 'addHead',
        'uses' => 'SettingController@addHead'
    ]
);

//=========ApprovedController ROUTE

Route::get('approved-list',
    [
        'as' => 'approved-list',
        'uses' => 'ApprovedController@index'
    ]
)->before('auth');

Route::post('approved-pdf',
    [
        'as' => 'approved-pdf',
        'uses' => 'ApprovedController@sendPDF'
    ]
)->before('auth');

Route::get('getCity{q?}', function ($q = 0) {
    $q = Input::get('q');
	if (is_numeric($q)) {
		$compObj = \City::where('cityID', 'LIKE', '%' . $q . '%')
            ->join('Region', 'Region.RegionID', '=', 'at_city.regionID')
            ->where('at_city.RegionID', '!=', 0)
            ->get()->toArray();
    } else {
		$compObj = \City::where('cityName', 'LIKE', '%' . $q . '%')
            ->join('Region', 'Region.RegionID', '=', 'at_city.regionID')
            ->where('at_city.RegionID', '!=', 0)
            ->get()->toArray();
    }
    $res = [];
    $count = count($compObj);
	foreach ($compObj as $key => $value) {
        $res[$key]['id'] = $value['cityID'];
        $res[$key]['name'] = $value['cityName'];
        $res[$key]['full_name'] = $value['cityName'];
        $res[$key]['description'] = $value['RegionName'];
        $res[$key]['owner']['id'] = $value['cityID'];
        $res[$key]['owner']['type'] = 'city';
        $res[$key]['created_at'] = $value['created_at'];
        $res[$key]['updated_at'] = $value['updated_at'];
        $res[$key]['gists_url'] = [];

    }
    return ['items' => $res, 'total_count' => $count];
});


//==========DeditController ROUTE

Route::get('debit',
    [
        'as' => 'debit',
        'uses' => 'DebitController@index'
    ]
)->before('auth');

Route::get('getColumns',
    [
        'as' => 'getColumns',
        'uses' => 'DebitController@getColumns'
    ]
);

Route::get('getRows',
    [
        'as' => 'getRows',
        'uses' => 'DebitController@getRows'
    ]
);


//============PriceController ROUTE
Route::get('rew', ['as' => 'rew', 'uses' => 'PriceListController@rew']
)->before('auth');

Route::any('tracker/{latitude}/{longitude}/{trackid}', 'SettingController@index');

Route::post('req', ['as' => 'req', 'uses' => 'PriceListController@req']
)->before('auth');

Route::post('sendPrice',
    [
        'as' => 'sendPrice',
        'uses' => 'PriceListController@sendPrice'
    ]
)->before('auth');

Route::post('load',
    [
        'as' => 'load',
        'uses' => 'PriceListController@load'
    ]
)->before('auth');


Route::get('price-list',
    [
        'as' => 'price-list',
        'uses' => 'PriceListController@index'
    ]
)->before('auth');

//=======AccRController ROUTE

Route::post('send-order',
    [
        'as' => 'send-order',
        'uses' => 'AccRController@sendOrderComp'
    ]
)->before('auth');

Route::post('send-order-to-emp',
    [
        'as' => 'send-order-to-emp',
        'uses' => 'AccRController@sendOrderMe'
    ]
)->before('auth');

Route::post('approvedDone',
    [
        'as' => 'approvedDone',
        'uses' => 'AccRController@approvedDone'
    ]
)->before('auth');

Route::post('getCompID',
    [
        'as' => 'getCompID',
        'uses' => 'AccRController@getCompID'
    ]
)->before('auth');

Route::post('approved-order',
    [
        'as' => 'approved-order',
        'uses' => 'AccRController@approvedOrder'
    ]
)->before('auth');

Route::post('approved',
    [
        'as' => 'approved',
        'uses' => 'AccRController@approved'
    ]
)->before('auth');

Route::post('view-order',
    [
        'as' => 'view-order',
        'uses' => 'AccRController@viewOrder'
    ]
)->before('auth');

Route::post('saveEditOrder',
    [
        'as' => 'saveEditOrder',
        'uses' => 'AccRController@saveEditOrder'
    ]
)->before('auth');

Route::post('addCateg',
    [
        'as' => 'addCateg',
        'uses' => 'AccRController@addCateg'
    ]
)->before('auth');

Route::post('addGoods',
    [
        'as' => 'addGoods',
        'uses' => 'AccRController@addGoods'
    ]
)->before('auth');

Route::post('edit-order',
    [
        'as' => 'edit-order',
        'uses' => 'AccRController@editOrder'
    ]
)->before('auth');

Route::get('updatestatus',
    [
        'as' => 'updatestatus',
        'uses' => 'MainController@update'
    ]
);

Route::post('update',
    [
        'as' => 'update',
        'uses' => 'MainController@update1'
    ]
);


//================ClientController ROUTE

Route::post('delContact',
    [
        'as' => 'delContact',
        'uses' => 'ClientController@delContact'
    ]
);

Route::post('delAddress',
    [
        'as' => 'delAddress',
        'uses' => 'ClientController@delAddress'
    ]
);

Route::post('saveContact',
    [
        'as' => 'saveContact',
        'uses' => 'ClientController@saveContact'
    ]
);

Route::post('saveAddress',
    [
        'as' => 'saveAddress',
        'uses' => 'ClientController@saveAddress'
    ]
);

Route::post('editAddress',
    [
        'as' => 'editAddress',
        'uses' => 'ClientController@editAddress'
    ]
);

Route::post('editContact',
    [
        'as' => 'editContact',
        'uses' => 'ClientController@editContact'
    ]
);

Route::post('getCity',
    [
        'as' => 'getCity',
        'uses' => 'ClientController@getCity'
    ]
);

Route::post('new-client',
    [
        'as' => 'new-client',
        'uses' => 'ClientController@newClient'
    ]
)->before('auth');

Route::get('list-client',
    [
        'as' => 'list-client',
        'uses' => 'ClientController@ListClient'
    ]
)->before('auth');

Route::get('addnew',
    [
        'as' => 'addnew',
        'uses' => 'ClientController@index'
    ]
)->before('auth');

Route::post('edit-comp',
    [
        'as' => 'edit-comp',
        'uses' => 'ClientController@edit'
    ]
)->before('auth');

//=========MainController ROUTE

Route::get('manager',
    [
        'as' => 'manager',
        'uses' => 'MainController@index'
    ]
)->before('auth');

Route::get('auth',
    [
        'as' => 'auth',
        'uses' => 'MainController@auth'
    ]
)->before('auth');

//===========GoodsManagerController ROUTE

Route::post('getKurs',
    [
        'as' => 'getKurs',
        'uses' => 'GoodsManagerController@getKurs'
    ]
);

Route::get('accr',
    [
        'as' => 'accr',
        'uses' => 'GoodsManagerController@accr'
    ]
)->before('auth');

Route::post('comps',
    [
        'as' => 'comps',
        'uses' => 'GoodsManagerController@comps'
    ]
)->before('auth');

Route::post('orders',
    [
        'as' => 'orders',
        'uses' => 'GoodsManagerController@orders'
    ]
)->before('auth');

Route::post('manager-order',
    [
        'as' => 'manager-order',
        'uses' => 'GoodsManagerController@managerOrder'
    ]
)->before('auth');

Route::post('categ',
    [
        'as' => 'categ',
        'uses' => 'GoodsManagerController@categ'
    ]
);

Route::post('category',
    [
        'as' => 'category',
        'uses' => 'GoodsManagerController@cat'
    ]
)->before('auth');

Route::post('cat',
    [
        'as' => 'cat',
        'uses' => 'GoodsManagerController@cat'
    ]
)->before('auth');

Route::post('getPL',
    [
        'as' => 'getPL',
        'uses' => 'GoodsManagerController@getPL'
    ]
);
Route::post('email',
    [
        'as' => 'email',
        'uses' => 'GoodsManagerController@email'
    ]
)->before('auth');

Route::post('send',
    [
        'as' => 'send',
        'uses' => 'GoodsManagerController@export'
    ]
)->before('auth');

Route::post('send1', function () {
    ini_set('memory_limit', '-1');
    $file = Input::file('file');
	$objPHPExcel = PHPExcel_IOFactory::load($file);
    //$objPHPExcel->setActiveSheetIndex(0);
    //$aSheet = $objPHPExcel->getActiveSheet();
    //$data = array();
    /*foreach($aSheet->getRowIterator() as $row)
    {
        $cellIterator = $row->getCellIterator();
        $item = array();
        foreach($cellIterator as $cell)
        {
            if (!empty($cell) && ($cell != null) && ($cell != '') && ($cell != '&#9')) {
                array_push($item, $cell->getCalculatedValue());
            }
        }
        array_push($data, $item);
    }*/
    echo "<pre>";
    //print_r($data);
    echo "</pre>";

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
    echo 'dsa';

})->before('auth');

Route::any('form',
    [
        'as' => 'form',
        'uses' => 'GoodsManagerController@pay'
    ]
)->before('auth');

Route::get('/',
    [
        'as' => '',
        'uses' => 'HomeController@index'
    ]
)->before('auth');

/*Route::any('testtest', function(){
    $arrOrder = \Orders::where('DocID', '=', 26600)->get()->last()->toArray();
    echo "<pre>";
    print_r($arrOrder);
    echo "</pre>";
    $compArr = \Comps::where('CompID', '=', 16523)
        ->get()->last()->toArray();
    echo "<pre>";
    print_r($compArr);
    echo "</pre>";

    $f = new \AccRController();
    $filename = $f->createPdf(26600);
    $orderID = 26600;

    return View::make('sendOrder', compact(['orderID', 'compArr', 'filename']));
    /*if($arrOrder['CompID'] != 0) {
        $filename = $this->createPdf($orderID);
        $orderArr = \Orders::where('DocID', '=', $orderID)
            ->get()->last()->toArray();
        $compArr = \Comps::where('CompID', '=', $orderArr['CompID'])
            ->get()->last()->toArray();
        return View::make('sendOrder', compact(['orderID', 'compArr', 'filename']));
    } else {
        $msg = 'В данного счета нет ИД! Обратитесь к администратору.';
        return View::make('msg', compact('msg'));
    }
});*/

Route::get('export', function () {
    return View::make('excel');
})->before('auth');

Route::any('testapp',
    [
        'as' => 'testapp',
        'uses' => 'TestController@approved'
    ]
);

Route::post('approvedDoneT',
    [
        'as' => 'approvedDoneT',
        'uses' => 'TestController@approvedDone'
    ]
)->before('auth');

