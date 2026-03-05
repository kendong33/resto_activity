<?php
require 'config.php';

$stmt = $resto->query("SELECT c.*, o.order_date, o.quantity FROM customers c LEFT JOIN orders o ON c.customer_id = o.customer_id");
$customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt_menuitems = $resto->query("SELECT * FROM menuitems");
$menuitems = $stmt_menuitems->fetchAll(PDO::FETCH_ASSOC);

$stmt_orders = $resto->query("SELECT o.order_id, c.first_name, c.last_name, m.dish_name, m.price, o.quantity, o.order_date FROM orders o INNER JOIN customers c ON o.customer_id = c.customer_id INNER JOIN menuitems m ON o.item_id = m.item_id ORDER BY o.order_date DESC");
$orders = $stmt_orders->fetchAll(PDO::FETCH_ASSOC);