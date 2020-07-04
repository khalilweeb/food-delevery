<?php 

session_start();

$GLOBALS['config'] = array (

    'mysql' => array(
        //db infos 
        'host' => 'localhost',
        'username' => 'root',
        'password' => 'root123',
        'db' => 'try'

    ),

    'remember' => array(
        'cookie_name' => 'hash',
        'cookie_expiry' => 604800 //cookie time (month)

    ),
    'session' => array(
        'session_name' => 'user'
    )



    );
  spl_autoload_register(function($class) {
           
      require_once 'classes/' . $class . '.php';
  });

  require_once 'functions/sanitize.php';