<?php
namespace Admin;

class SystemConfig
{
    public static function get( $key, $default = null )
    {
        $opt = \LaravelSysConf::where('key', '=', $key)->first();
        //$opt = \ConfigOption::where( 'key', '=', $key )->first();
        return $opt ? $opt->value : $default;
    }

    public static function set( $key, $value )
    {
        if( !$opt = \LaravelSysConf::where('key', '=', $key)->first() )
        //if ( !$opt = \ConfigOption::where( 'key', '=', $key )->first() )
        {
            return \LaravelSysConf::create([
            //return \ConfigOption::create( [
                'key' => $key,
                'value' => $value
            ] );
        }
        else
        {
            $opt->value = $value;
            return $opt->save();
        }
    }
}