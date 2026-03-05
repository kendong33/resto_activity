<?php
session_start();
require 'insert.php';
require 'select.php';
require 'update.php';
require 'delete.php';
?>
<?php
$editCustomer = null;

if (isset($_GET['edit'])) {
    $customer_id = $_GET['edit'];
    $stmt = $resto->prepare("SELECT c.*, o.order_date, o.quantity FROM customers c LEFT JOIN orders o ON c.customer_id = o.customer_id WHERE c.customer_id = ? LIMIT 1");
    $stmt->execute([$customer_id]);
    $editCustomer = $stmt->fetch(PDO::FETCH_ASSOC);
}

$editMenuItem = null;

if (isset($_GET['edit_menu'])) {
    $item_id = $_GET['edit_menu'];
    $stmt = $resto->prepare("SELECT * FROM menuitems WHERE item_id = ?");
    $stmt->execute([$item_id]);
    $editMenuItem = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <title>Restaurant</title>
    <style>
        .dropdown {
            width: 100%;
            max-width: 300px;
            padding: 8px 12px;


            font-size: 14px;
            color: #444;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 4px;


            cursor: pointer;
            outline: none;
        }

        .custom-thead {
            --bs-table-bg: #e3f2fd;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-white pb-0 border-0 mt-3">
                        <h1>Bistro Manager Pro</h1>
                        <ul class="nav nav-underline" id="bistroTabs" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active" id="orders-tab" data-bs-toggle="tab"
                                    data-bs-target="#orders" type="button" role="tab" aria-controls="orders"
                                    aria-selected="true">Order</button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" id="customers-tab" data-bs-toggle="tab"
                                    data-bs-target="#customers" type="button" role="tab" aria-controls="customers"
                                    aria-selected="false">Customer</button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" id="menu-tab" data-bs-toggle="tab" data-bs-target="#menu"
                                    type="button" role="tab" aria-controls="menu" aria-selected="false">Menu
                                    Item</button>
                            </li>
                        </ul>

                        <div class="card-body">
                            <div class="tab-content" id="bistroTabsContent">

                                <div class="tab-pane fade show active" id="orders" role="tabpanel"
                                    aria-labelledby="orders-tab">
                                    <div class="p-3">
                                        <h3>Place New Order</h3>
                                        <?php if (isset($_SESSION['error'])): ?>
                                            <div class="alert alert-danger" role="alert">
                                                <?= htmlspecialchars($_SESSION['error']) ?>
                                            </div>
                                            <?php unset($_SESSION['error']); ?>
                                        <?php endif; ?>
                                        <form method="POST">
                                            <div class="card-body row row-cols-1 row-cols-md-4 g-3 align-items-end">

                                                <div class="col">
                                                    <p class="mb-1">Customer</p>
                                                    <select name="customer" id="customer" class="form-select" required>
                                                        <option value="">Select a Customer</option>
                                                        <?php foreach ($customers as $customer): ?>
                                                            <option value="<?= htmlspecialchars($customer['customer_id']) ?>">
                                                                <?= htmlspecialchars($customer['first_name'] . ' ' . $customer['last_name']) ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    <p class="mb-1">Menu Item</p>
                                                    <select name="menu_item" id="menu_item" class="form-select" required>
                                                        <option value="">Select a Menu Item</option>
                                                        <?php foreach ($menuitems as $item): ?>
                                                            <option value="<?= htmlspecialchars($item['item_id']) ?>">
                                                                <?= htmlspecialchars($item['dish_name']) ?> - $<?= htmlspecialchars($item['price']) ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    <p class="mb-1">Qty</p>
                                                    <input type="number" name="qty" class="form-control" placeholder="0"
                                                        min="1" required>
                                                </div>
                                                <div class="col">
                                                    <button type="submit" name="add_order" class="btn btn-primary w-100">Add Order</button>
                                                </div>
                                            </div>
                                        </form>
                                        <div>
                                            <table class="table">
                                                <thead class="custom-thead">
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Customer</th>
                                                        <th>Dish</th>
                                                        <th>Qty</th>
                                                        <th>Total</th>
                                                        <th>Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($orders as $order): ?>
                                                        <tr>
                                                            <td><?= htmlspecialchars($order['order_id']) ?></td>
                                                            <td><?= htmlspecialchars($order['first_name'] . ' ' . $order['last_name']) ?></td>
                                                            <td><?= htmlspecialchars($order['dish_name']) ?></td>
                                                            <td><?= htmlspecialchars($order['quantity']) ?></td>
                                                            <td>$<?= htmlspecialchars(number_format($order['price'] * $order['quantity'], 2)) ?></td>
                                                            <td><?= htmlspecialchars(date('M d, Y h:i A', strtotime($order['order_date']))) ?></td>
                                                            <td>
                                                                <a href="?delete_order=<?= htmlspecialchars($order['order_id']) ?>&tab=orders" class="btn btn-sm btn-outline-danger">✕</a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="customers" role="tabpanel"
                                    aria-labelledby="customers-tab">
                                    <div class="p-3">
                                        <h3 class="mb-3">Customer Directory</h3>
                                        <form method="POST">
                                            <div class="row g-3 align-items-end">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-1">First Name</label>

                                                    <input type="text" name="first_name"
                                                        value="<?= !empty($editCustomer) ? htmlspecialchars($editCustomer['first_name']) : '' ?>"
                                                        class="form-control form-control-sm" required>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label mb-1">Last Name</label>

                                                    <input type="text" name="last_name"
                                                        value="<?= !empty($editCustomer) ? htmlspecialchars($editCustomer['last_name']) : '' ?>"
                                                        class="form-control form-control-sm" required>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label mb-1">Phone Number</label>

                                                    <input type="text" name="phone_number"
                                                        value="<?= !empty($editCustomer) ? htmlspecialchars($editCustomer['phone_number']) : '' ?>"
                                                        class="form-control form-control-sm">
                                                </div>
                                                <div class="col-md-3">
                                                    <?php if (!empty($editCustomer)): ?>
                                                        <input type="hidden" name="customer_id" value="<?= htmlspecialchars($editCustomer['customer_id']) ?>">
                                                        <button class="btn btn-warning w-100" type="submit" name="update">Update Customer</button>
                                                    <?php else: ?>
                                                        <button class="btn btn-success w-100" type="submit" name="add">Add Customer</button>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <table border="1" cellpadding="10" class="table">
                                        <thead class="table-secondary">
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Product</th>

                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <?php foreach ($customers as $customers): ?>
                                            <tbody>
                                                <tr>
                                                    <td><?= htmlspecialchars($customers['customer_id']) ?></td>
                                                    <td><?= htmlspecialchars($customers['first_name']) ?></td>
                                                    <td><?= htmlspecialchars($customers['last_name']) ?></td>
                                                    <td><?= htmlspecialchars($customers['phone_number'] ?? '') ?></td>

                                                    <td>
                                                        <a href="?edit=<?= htmlspecialchars($customers['customer_id']) ?>&tab=customers"
                                                            class="btn btn-outline-primary">Edit</a>
                                                        <a href="?delete=<?= htmlspecialchars($customers['customer_id']) ?>&tab=customers"
                                                            class="btn btn-outline-danger">Delete</a>

                                                    </td>
                                                </tr>
                                            </tbody>
                                        <?php endforeach; ?>

                                    </table>
                                </div>

                                <div class="tab-pane fade" id="menu" role="tabpanel" aria-labelledby="menu-tab">
                                    <div class="p-3">
                                        <h3 class="mb-3">Menu Items</h3>
                                        <?php if (isset($_SESSION['error'])): ?>
                                            <div class="alert alert-danger" role="alert">
                                                <?= htmlspecialchars($_SESSION['error']) ?>
                                            </div>
                                            <?php unset($_SESSION['error']); ?>
                                        <?php endif; ?>
                                        <form method="POST">
                                            <div class="row g-3 align-items-end">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-1">Dish Name</label>
                                                    <input type="text" name="dish_name" 
                                                        value="<?= !empty($editMenuItem) ? htmlspecialchars($editMenuItem['dish_name']) : '' ?>"
                                                        class="form-control form-control-sm" required>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label mb-1">Price</label>
                                                    <input type="number" name="price" 
                                                        value="<?= !empty($editMenuItem) ? htmlspecialchars($editMenuItem['price']) : '' ?>"
                                                        class="form-control form-control-sm" step="0.01" max="20000" required>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label mb-1">Category</label>
                                                    <input type="text" name="category" 
                                                        value="<?= !empty($editMenuItem) ? htmlspecialchars($editMenuItem['category']) : '' ?>"
                                                        class="form-control form-control-sm" required>
                                                </div>
                                                <div class="col-md-3">
                                                    <?php if (!empty($editMenuItem)): ?>
                                                        <input type="hidden" name="item_id" value="<?= htmlspecialchars($editMenuItem['item_id']) ?>">
                                                        <button class="btn btn-warning w-100" type="submit" name="update_menu">Update Menu Item</button>
                                                    <?php else: ?>
                                                        <button class="btn btn-success w-100" type="submit" name="add_menu">Add Menu Item</button>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <table border="1" cellpadding="10" class="table">
                                        <thead class="table-secondary">
                                            <tr>
                                                <th>ID</th>
                                                <th>Dish Name</th>
                                                <th>Price</th>
                                                <th>Category</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <?php foreach ($menuitems as $item): ?>
                                            <tbody>
                                                <tr>
                                                    <td><?= htmlspecialchars($item['item_id']) ?></td>
                                                    <td><?= htmlspecialchars($item['dish_name']) ?></td>
                                                    <td>$<?= htmlspecialchars($item['price']) ?></td>
                                                    <td><?= htmlspecialchars($item['category']) ?></td>
                                                    <td>
                                                        <a href="?edit_menu=<?= htmlspecialchars($item['item_id']) ?>&tab=menu" class="btn btn-outline-primary">Edit</a>
                                                        <a href="?delete_menu=<?= htmlspecialchars($item['item_id']) ?>&tab=menu" class="btn btn-outline-danger">Delete</a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        <?php endforeach; ?>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>

        const tabButtons = document.querySelectorAll('[role="tab"]');


        function showTab(tabId) {
            const tabButton = document.getElementById(tabId + '-tab');
            if (tabButton) {
                const tab = new bootstrap.Tab(tabButton);
                tab.show();
            }
        }


        function initializeTab() {

            const urlParams = new URLSearchParams(window.location.search);
            let tabId = urlParams.get('tab');


            if (!tabId) {
                tabId = window.location.hash.slice(1);
            }


            if (!tabId) {
                tabId = 'orders';
            }


            showTab(tabId);


            window.location.hash = tabId;


            if (urlParams.has('tab')) {
                window.history.replaceState(null, '', window.location.pathname + '#' + tabId);
            }
        }


        initializeTab();

        tabButtons.forEach(button => {
            button.addEventListener('click', function () {
                const tabId = this.id.replace('-tab', '');
                window.location.hash = tabId;
            });
        });

        window.addEventListener('hashchange', function () {
            const tabId = window.location.hash.slice(1);
            if (tabId) {
                showTab(tabId);
            }
        });
    </script>