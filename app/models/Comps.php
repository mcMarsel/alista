<?php

class Comps extends \Eloquent
{
    protected $table = 'comps';

    protected $fillable =
        [
            'id', 'CompID', 'CompName', 'EMail', 'City', 'Code', 'TaxRegNo', 'TaxCode', 'TaxPayer', 'CodeID1',
            'CodeID2', 'CodeID3', 'CodeID4', 'CodeID5', 'PLID', 'Discount', 'PayDelay', 'EmpID', 'TranPrc',
            'MorePrc', 'FirstEventMode', 'CompType', 'SysTaxType', 'InStopList', 'CompGrID1', 'CompGrID2',
            'CompGrID3', 'CompGrID4', 'CompGrID5', 'CityID', 'CompNameFull', 'ETime', 'BTime'
        ];

}
