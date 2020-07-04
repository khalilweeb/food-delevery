<?php

require 'core/init.php';

$user = DB::getInstance()->query("SELECT username FROM users");

if($user->error()) {
    echo "ezriofrezoifo";
} else {
    echo 'OK!';
}
