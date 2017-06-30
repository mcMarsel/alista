<?php

class Head extends \Eloquent
{
    protected $table = 'HeadBranch';

    protected $fillable = ['EmpID', 'HeadID', 'EmpName', 'MinPLID'];
}