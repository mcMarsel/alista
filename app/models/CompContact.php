<?php

class CompContact extends \Eloquent
{
    protected $table = 'CompContacts';

	protected $fillable = ['id', 'CompID', 'Contact', 'ContactAll', 'PhoneWork', 'PhoneMob', 'PhoneHome', 'eMail', 'BTime', 'ETime'];
}