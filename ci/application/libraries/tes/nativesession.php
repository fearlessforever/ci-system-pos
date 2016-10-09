<?php if ( ! defined('BASEPATH') ) exit( 'No direct script access allowed' );

class Nativesession
{
    public function __construct()
    {
        // @session_name('jouningakure');
		// ini_set('session.save_path',realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/../session')); // SET save session path
		// ini_set('session.save_path',getcwd(). '/tmp');
		session_start(); 
    }

    public function set( $key, $value )
    {
        $_SESSION[$key] = $value;
    }

    public function get( $key )
    {
        return isset( $_SESSION[$key] ) ? $_SESSION[$key] : null;
    }

    public function regenerateId( $delOld = false )
    {
        session_regenerate_id( $delOld );
    }

    public function delete( $key )
    {
        unset( $_SESSION[$key] );
    }
}