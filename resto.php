<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Restaurant</title>
</head>
<body> 
    <div class="container mt-5">
        <div class="row">
             <div class="col-lg-12 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-white pb-0 border-0 mt-3">
                        <h1>Bistro Manager Pro</h1> 
                            <ul class="nav nav-tabs" id="bistroTabs" role="tablist">
                                <li class="nav-item">
                                    <button class="nav-link active" id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders" type="button">Orders</button>
                                </li>
                                
  
                                <li class="nav-item">
                                    <button class="nav-link" id="customers-tab" data-bs-toggle="tab" data-bs-target="#customers" type="button">Customers</button>
                                </li>
                                
                                <li class="nav-item">
                                    <button class="nav-link" id="menu-tab" data-bs-toggle="tab" data-bs-target="#menu" type="button">Menu Items</button>
                                </li>
                            </ul>

                            <div class="card-body">
                                <div class="tab-content" id="bistroTabsContent">
                                
                            <!-- Orders Page -->
                                <div class="tab-pane fade show active" id="orders" role="tabpanel">
                                    <h3>Order Management</h3>
                                 <?php ?>
                                </div>

                            <!-- Customers Page -->
                                <div class="tab-pane fade" id="customers" role="tabpanel">
                                    <h3>Customer Directory</h3>
                                    <?php?>
                                </div>

                            <!-- Menu Items Page -->
                                <div class="tab-pane fade" id="menu" role="tabpanel">
                                    <h3>Menu Settings</h3>
                                    <?php?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>               
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net"></script>
</body>
</html>