<?php

class Orders extends \Eloquent
{
    protected $table = 'orders';

    protected $fillable = ['status', 'orderID', 'DocID', 'Kurs', 'SrcPosID', 'CompID', 'CompName', 'ProdID', 'ProdName', 'CodeID3', 'UM', 'Qty', 'PriceMC', 'SumPrice', 'PLID', 'EmpID', 'StockID', 'created_at', 'updated_at'];
}