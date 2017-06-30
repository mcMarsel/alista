<?php

class AlistaGoods extends \Eloquent
{
    protected $table = 'alista_goods';

    //protected $fillable = ['code', 'title', 'goods', 'name_goods', 'short_name', 'residue', 'p101', 'p102', 'p103', 'p104', 'p105', 'p106', 'p107', 'p108', 'p109', 'p110'];
    protected $fillable = ['group_id', 'goods', 'title', 'short_name', 'remains_cashless', 'reserve_cashless', 'remains_cash',
        'reserve_cash', 'p101', 'p102', 'p103', 'p104', 'p105', 'p106', 'p107', 'p108', 'p109', 'p110'];
}