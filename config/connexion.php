<?php
$host = "db.3wa.io";
$port = "3306";
$dbname = "adangilbert_phpj15";
$connexionString = "mysql:host=$host;port=$port;dbname=$dbname";

$user = "adangilbert";
$password = "dfdea6b0f73368f1dd0954ba9bbcca30";

$db = new PDO(
    $connexionString,
    $user,
    $password
);

