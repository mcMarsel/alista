<?php

class Rem extends \Eloquent
{
    protected $table = 'Rem';

    protected $fillable = ['StockID', 'ProdID', 'RemCash', 'ResCash', 'RemUncash', 'ResUncash'];
}