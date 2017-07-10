<?php

class PriceListController extends BaseController 
{
    public function load()
    {
        echo "<pre>";
        print_r(Input::all());
        echo "</pre>";
    }

    public function sendPrice()
    {

        echo "<pre>";
        print_r(Input::get('res'));
        echo "</pre>";
    }

    public function index()
	{
		$pl = \PriceList::orderBy('PLID')->get()->toArray();
		$PLID = [];
		$PLName = [];
		foreach($pl as $key => $value)
	        {
	        	array_push($PLName,$value['PLName']);
	        	array_push($PLID,$value['PLID']);	
	        }
	        unset($pl);
	        $pl = array_combine($PLID, $PLName);
		$pgr = \ProdGr3::orderBy('PGrName3')
			->get(['PGrID3', 'PGrName3'])->toArray();
		$pr = \Prods::orderBy('PGrID3')
			->get(['ProdID', 'ProdName', 'PGrID3'])->toArray();
		return View::make('pl', compact(['pl', 'pr', 'pgr']));
	}
	
	public function rew()
	{
		return View::make('excel');
	}
	
	public function req()
	{
		$file = Input::file('file');
	        $xls = PHPExcel_IOFactory::load($file);
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
	                    array_push($temp, $cell->getCalculatedValue());
	                    $j++;
	                }
	                array_push($data, $temp);
	            }
	            $i++;
	        }
	        echo "<pre>";
	        print_r($data);
	        echo "</pre>";
	}
}