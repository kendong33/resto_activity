<?php
$host = "localhost";
$dbname = "resto_db";
$username = "root";
$password = "";

try {
    $resto = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $resto->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Fix price column size automatically
    try {
        $resto->exec("ALTER TABLE menuitems MODIFY price decimal(7,2) NOT NULL");
    } catch(PDOException $e) {
        // Column already modified or table doesn't exist yet, ignore
    }
} catch(PDOException $e){
    die("Connection failed: " . $e->getMessage());
}