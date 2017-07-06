<?php

class City extends \Eloquent
{
    protected $table = 'at_city';

	protected $fillable = ['cityID', 'cityName', 'regionID', 'Notes', 'TelCode', 'PostIndex'];
}