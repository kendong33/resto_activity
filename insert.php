<?php
require 'config.php';

if(isset($_POST['add'])){
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $phone_number = trim($_POST['phone_number']);

    $stmt = $resto->prepare("INSERT INTO customers (first_name, last_name, phone_number)
    VALUES(?, ?, ?)");
    $stmt->execute([$first_name, $last_name, $phone_number]);

    // Redirect to refresh the page and show updated data
    header("Location: resto.php?tab=customers");
    exit();
}

if(isset($_POST['add_order'])){
    $customer_id = $_POST['customer'];
    $item_id = $_POST['menu_item'];
    $quantity = (int)$_POST['qty'];
    $order_date = date('Y-m-d H:i:s');

    if (!empty($customer_id) && !empty($item_id) && $quantity > 0) {
        $stmt = $resto->prepare("INSERT INTO orders (customer_id, item_id, quantity, order_date)
        VALUES(?, ?, ?, ?)");
        $stmt->execute([$customer_id, $item_id, $quantity, $order_date]);

        // Redirect to refresh the page and show updated data
        header("Location: resto.php?tab=orders");
        exit();
    } else {
        $_SESSION['error'] = "Please select a customer, menu item, and enter a quantity";
        header("Location: resto.php?tab=orders");
        exit();
    }
}

if(isset($_POST['add_menu'])){
    $dish_name = trim($_POST['dish_name']);
    $price = (float)trim($_POST['price']);
    $category = trim($_POST['category']);

    if ($price > 20000) {
        $_SESSION['error'] = "Price cannot exceed 20000";
        header("Location: resto.php?tab=menu");
        exit();
    }

    $stmt = $resto->prepare("INSERT INTO menuitems (dish_name, price, category)
    VALUES(?, ?, ?)");
    $stmt->execute([$dish_name, $price, $category]);

    // Redirect to refresh the page and show updated data
    header("Location: resto.php?tab=menu");
    exit();
}
