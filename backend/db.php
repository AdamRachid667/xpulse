<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");

$pdo = new PDO(
    "mysql:host=localhost;dbname=xpulse;charset=utf8",
    "root",
    ""
);

?>