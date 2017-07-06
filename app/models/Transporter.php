<?php

class Transporter extends \Eloquent
{
    protected $table = 'at_transporter';

	protected $fillable = ['transporterID', 'transporterName'];
}