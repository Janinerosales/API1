<?php

include 'Books.php';

header("Content-Type: application/json; charset=utf-8");


$book = new Books();

$book->createTable();
echo $book->update($_POST);
