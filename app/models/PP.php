<?php

class PP extends \Eloquent
{
    protected $table = "PP";

    protected $fillible = ['StockID', 'PPID', 'ProdID', 'WOAccQty', 'AccQty', 'ExcQty', 'RemQty', 'CodeID3', 'ProdDate'];
}