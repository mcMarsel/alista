<?php

class Client extends \Eloquent
{
    protected $table = 'client';

	protected $fillable = ['clientName', 'Region', 'City', 'fullName', 'timeWork', 'phone'];

}