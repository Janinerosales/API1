<?php

include 'user.php';

header("Content-Type: application/json; charset=utf-8");


$user = new Users();

$user->createTable();
echo $user->delete($_GET);