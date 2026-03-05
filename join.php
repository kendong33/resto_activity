<?php
require 'config.php';

$sql = "SELECT c.customer_id, c.first_name, c.last_name, c.phone_number, 
        -- m.item_id, m.dish_name, m.price, m.catagory,
        o.order_id, o.order_date, o.quantity
        FROM customers c
        INNER JOIN orders o ON c.customer_id = o.customer_id 
        ORDER BY c.customer_id";

$stmt = $resto->prepare($sql);
$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($results as $row) {
    echo "Customer ID: {$row['customer_id']} - First Name: {$row['first_name']} 
    - Last Name: {$row['last_name']} - Phone Number: {$row['phone_number']}<br>";
    echo "Order ID: {$row['order_id']} - Order Date: {$row['order_date']} - Quantity: {$row['quantity']}<br><br>";
}



?>