<?php

class Emps extends \Eloquent
{
    protected $table = 'Emps';

    protected $fillable = ['EmpID', 'DepID', 'EmpGrID', 'EMail', 'EmpName', 'UAEmpName'];
}