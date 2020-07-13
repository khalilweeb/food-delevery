<?php

require 'core/init.php';

$user = DB::getInstance()->update('users' , 4 ,array(

    'username'  => 'kluas',



));
/* 
if(!$user->count()) {
    echo "NO user!";
} else {
    foreach($user->results() as $user) {

        echo 'name : ' , $user->username , '<br>';
        echo 'password : ' , $user->password , '<br>';
        echo 'salt : ' , $user->salt , '<br>';

        echo '<hr>';

    }
} */
