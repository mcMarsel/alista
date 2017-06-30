<?php

class Currency extends \Eloquent
{
    protected $table = 'currency';

    protected $fillable = ['appointment', 'value', 'name', 's_name'];

}