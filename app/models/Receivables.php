<?php

class Receivables extends \Eloquent
{
    protected $table = 'Receivables';

    protected $fillable = ['CompID', 'CompName', 'EmpID', 'EmpName', 'DocID', 'DocDate', 'TSumMC', 'TSumCC', 'ArrearsMC', 'ArrearsCC'];
}