<?php
require 'config.php';

if(isset($_GET['delete'])){
    $customer_id = $_GET['delete'];

    $stmt = $resto->prepare("DELETE FROM customers WHERE customer_id = ?");
    $stmt->execute([$customer_id]);
    
    // Redirect to customers tab after deletion
    header("Location: resto.php?tab=customers");
    exit();
}

if(isset($_GET['delete_order'])){
    $order_id = $_GET['delete_order'];

    $stmt = $resto->prepare("DELETE FROM orders WHERE order_id = ?");
    $stmt->execute([$order_id]);
    
    // Redirect to orders tab after deletion
    header("Location: resto.php?tab=orders");
    exit();
}

if(isset($_GET['delete_menu'])){
    $item_id = $_GET['delete_menu'];

    $stmt = $resto->prepare("DELETE FROM menuitems WHERE item_id = ?");
    $stmt->execute([$item_id]);
    
    header("Location: resto.php?tab=menu");
    exit();
}
?>