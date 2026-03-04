<?php
$host = "localhost";
$db = "resto_db";
$username = "root";
$password = "";

try {
    $resto = new RESTO("mysql:host=$host;dbname=$dbname", $username, $password);
    $resto-> setAttribute(RESTO::ATTR_ERRMODE, RESTO::ERRMODE_EXCEPTION);
} catch(RESTOException $e){
    die("Connection failed: " . $e->getMessage());
}
?>