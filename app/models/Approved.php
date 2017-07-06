<?php

class Approved extends \Eloquent
{
    protected $table = 'transporter';

	protected $fillable = ['status', 'DocID', 'dateShipping', 'getCash', 'transporterID', 'transporterName', 'cityID', 'cityName', 'originator', 'addressee', 'payer', 'address', 'stockTransporter', 'payForm', 'specialNotes'];
}