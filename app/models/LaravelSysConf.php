<?php

class LaravelSysConf extends \Eloquent
{
    protected $table = 'laravel_systemconfig';

    protected $fillable = ['appointment', 'value'];

}