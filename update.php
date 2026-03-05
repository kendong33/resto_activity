<?php
require 'config.php';

if (isset($_POST['update'])){
    $customer_id = $_POST['customer_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone_number = $_POST['phone_number'];

    $stmt = $resto->prepare("UPDATE customers SET first_name = ?, last_name = ?, phone_number = ? WHERE customer_id = ?");
    $stmt->execute([$first_name, $last_name, $phone_number, $customer_id]);
    
    header("Location: resto.php?tab=customers");
    exit();
}

if (isset($_POST['update_menu'])){
    $item_id = $_POST['item_id'];
    $dish_name = $_POST['dish_name'];
    $price = (float)$_POST['price'];
    $category = $_POST['category'];

    if ($price > 20000) {
        $_SESSION['error'] = "Price cannot exceed 20000";
        header("Location: resto.php?tab=menu");
        exit();
    }

    $stmt = $resto->prepare("UPDATE menuitems SET dish_name = ?, price = ?, category = ? WHERE item_id = ?");
    $stmt->execute([$dish_name, $price, $category, $item_id]);

    header("Location: resto.php?tab=menu");
    exit();
}