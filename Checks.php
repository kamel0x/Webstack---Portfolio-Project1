<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/myorders.css">
    <link rel="icon" href="images/cafeteria.png" type="image/png">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/footer.css">
    <style>
        .myBtn {
            background-color: #4b3723 !important;
            color: white;
            transition: all 0.3s;
        }

        .myBtn:hover {
            color: white !important;
            background-color: #4b3723 !important;
        }

        .myInput:focus {
            border-color: #4f3131 !important;
            box-shadow: 0 0 0 0.25rem rgba(79, 49, 49, 0.15);
        }

        .success-btn {
            transition: background-color 0.1s;
            border: 1px solid grey;
        }

        .success-btn:hover {
            background-color: #4b3723;
            color: white;
        }

        .pg-link {
            color: #4b3723 !important;
        }

        .pg-link:focus {
            box-shadow: 0 0 0 0.25rem rgba(79, 49, 49, 0.15);
            background-color: white;
        }

        .clickable-row {
            cursor: pointer;
        }
    </style>

    <title>Checks</title>
</head>

<body>
    <?php 
        include 'design/header.php';
        if ($data['perm_id'] == 1) {
            header("Location: home.php");
            exit();
        }
    ?>

    <main class="container p-4">
        <h1 class="mb-3"><span style="background-color: #4f3131; padding: 0px 10px; border-radius: 16px; color:white">C</span>hecks</h1>

        <div style="max-width: 550px;" class="row">
            <div class="col-12 col-md-6">
                <label for="fromDate" class="form-label">From</label>
                <input id="fromDate" class="form-control myInput" type="date">
            </div>

            <div class="col-12 col-md-6 mb-3">
                <label for="toDate" class="form-label">To</label>
                <input id="toDate" class="form-control myInput" type="date">
            </div>

            <div class="col-12">
                <label for="userSelect" class="form-label">User</label>
                <?php $users = $db->select('users'); ?>
                <select id="userSelect" name="user_id" class="form-select myInput">
                    <option value="">Select a user</option>
                    <?php foreach ($users as $user): ?>
                        <option value="<?= $user['id'] ?>"><?= htmlspecialchars($user['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <!-- Users and amount table -->
        <table class="table mt-3 table-bordered">
            <thead>
                <tr>
                    <th style="background-color: #4f3131; color: white" scope="col">Name</th>
                    <th style="background-color: #4f3131; color: white" scope="col">Total Amount</th>
                </tr>
            </thead>
            <tbody id="users_table_body">
            <?php
                $stmt = $db->getUserTotals();
                foreach ($stmt as $order) {
                    $users = $db->getRow('users', 'id', $order['user_id']);
                    ?>
                    <tr class="clickable-row" data-user-id="<?php echo $users['id']; ?>">
                        <td><?php echo $users['name']; ?></td>
                        <td><?php echo $order['total_amount']; ?></td>
                    </tr>
                    <?php } ?>
            </tbody>
        </table>

        <!-- Orders table -->
        <div id="orders_table" style="padding: 0 32px; display:none;" class="p-6">
            <table class="table table-bordered mt-3" id="ordersTable">
                <thead>
                    <tr>
                        <th style="background-color: #4f3131; color: white" scope="col">Order Date</th>
                        <th style="background-color: #4f3131; color: white" scope="col">Amount</th>
                    </tr>
                </thead>
                <tbody id="orders_table_body">

                </tbody>
            </table>
        </div>

        <div id="order-items-container">
            <!-- Order items will be displayed here via JavaScript -->
        </div>

        <nav class="d-flex justify-content-center">
            <div class="pagination mt-4">
                <button class="prev-page">&lt;</button>
                <span class="page-number">1</span>
                <button class="next-page">&gt;</button>
            </div>
        </nav>
    </main>

    <?php 
        require "design/footer.php";
    ?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="./js/jquery.js"></script>
 <script>
    $(document).ready(function() {
        // Click event for user rows
        $('#users_table_body').on('click', '.clickable-row', function() {
            let user_id = $(this).data('user-id');
            $('#userSelect').val(user_id);
            fetchOrders();
        });

        // When the user selects a specific user
        $('#userSelect').change(function() {
            fetchOrders();
        });

        // When the user changes the date range
        $('#fromDate, #toDate').change(function() {
            fetchOrders();
        });

        // Fetch orders based on user and date range
        function fetchOrders() {
            let user_id = $('#userSelect').val();
            let from_date = $('#fromDate').val();
            let to_date = $('#toDate').val();

            // Ensure user_id is selected
            if (user_id) {
                $.ajax({
                    url: 'fetch_data.php', // Your PHP file to fetch data
                    type: 'POST',
                    data: {
                        user: user_id,
                        from_date: from_date,
                        to_date: to_date
                    },
                    dataType: 'json',
                    success: function(response) {
                        // Update the orders table
                        let ordersHtml = '';
                        if (response.orders && response.orders.length > 0) {
                            response.orders.forEach(function(order) {
                                ordersHtml += order;
                            });
                        } else {
                            ordersHtml = '<tr><td colspan="2">No orders found for the selected criteria.</td></tr>';
                        }
                        $('#ordersTable tbody').html(ordersHtml);
                        $('#orders_table').show(); // Show the orders table if there are results
                    },
                    error: function() {
                        alert('An error occurred while fetching orders.');
                    }
                });
            } else {
                $('#ordersTable tbody').html('<tr><td colspan="2">Please select a user.</td></tr>');
                $('#orders_table').hide(); // Hide the orders table if no user is selected
            }
        }

        // Click event for orders
        $('#ordersTable').on('click', 'tr', function() {
            let order_id = $(this).find('td[data-order-id]').data('order-id');
            if (order_id) {
                fetchOrderDetails(order_id);
            }
        });

        // Fetch order details based on order ID
        function fetchOrderDetails(order_id) {
            $.ajax({
                url: 'fetch_data.php', // Your PHP file to fetch data
                type: 'POST',
                data: {
                    order_id: order_id
                },
                dataType: 'json',
                success: function(response) {
                    let orderDetailsHtml = '';
                    if (response.order_details && response.order_details.length > 0) {
                        response.order_details.forEach(function(item) {
                            orderDetailsHtml += `<div class="order-item">
                                <img src="${item.image}" alt="${item.name}" style="width: 50px; height: 50px;">
                                <p>Name: ${item.name}</p>
                                <p>Quantity: ${item.quantity}</p>
                                <p>Price: ${item.price}</p>
                            </div>`;
                        });
                    } else {
                        orderDetailsHtml = '<p>No details available for this order.</p>';
                    }
                    $('#orderDetails').html(orderDetailsHtml);
                    $('#orderDetailsContainer').show(); // Show the order details section
                },
                error: function() {
                    alert('An error occurred while fetching order details.');
                }
            });
        }

        $("#orders_table_body").on("click", "tr", function() {
        const orderId = $(this).find("#o_id").data("order-id");

        $.ajax({
            url: "fetch_data.php",
            method: "POST",
            data: {
                order_id: orderId
            },
            dataType: 'json',
            success: function(response) {
                if (response.order_details && response.order_details.length > 0) {
                    const orderItemsHTML = response.order_details.map(item => `
                        <div class="item-card">
                            <div class="item-image">
                                <img src="${item.image}" alt="${item.name}">
                                <div class="item-price">${item.price} LE</div>
                            </div>
                            <div class="item-info">
                                <span>${item.name}</span>
                                <span>${item.quantity}</span>
                            </div>
                        </div>
                    `).join('');
                    $("#order-items-container").html(orderItemsHTML);
                } else {
                    $("#order-items-container").html('<p>No items found for this order.</p>');
                }
            },
            error: function() {
                console.error("Error fetching order details.");
            }
        });
    });
    });
</script>
</body>

</html>