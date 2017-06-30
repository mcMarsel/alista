<?php

class ProdMP extends \Eloquent
{
    protected $table = 'ProdMP';

    protected $fillable = ['ProdID', 'PLID', 'PriceMC', 'MinPLID'];
}