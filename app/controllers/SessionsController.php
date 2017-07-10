<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 12.10.14
 * Time: 21:21
 */
class SessionsController extends BaseController
{


    public function create()
    {
        if ( Auth::guest() )
        {
            return View::make( 'sessions.create' );
        }
        else
        {
            return Redirect::home();
        }
    }

    public function store()
    {
        if ( Auth::attempt( Input::only( 'username', 'password' ), true ) )
        {
            return View::make('default');
        }
        else
        {
            Flash::error( 'Увы и ах, явки и пароли не подходят.' );
            return Redirect::back()->withInput();
        }
    }

    public function destroy()
    {
        Auth::logout();
        return Redirect::route( 'sessions.create' );
    }
}