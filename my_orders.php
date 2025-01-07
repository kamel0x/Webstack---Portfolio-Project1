
<?php

/////////////////////////
include 'design/header.php';
$user_id = $_SESSION['id'];

// Check if the date range is set
$date_from = isset($_GET['date_from']) ? $_GET['date_from'] : null;
$date_to = isset($_GET['date_to']) ? $_GET['date_to'] : null;

if ($date_from && $date_to) {
    // Fetch orders within the date range
    $query = "SELECT * FROM orders WHERE user_id = ? AND date >= ? AND date <= ?";
    $orders = $db->getRows($query, [$user_id, $date_from, $date_to]);
} else {
    // Fetch  orders if no date range is selected
    $orders = $db->getAll('orders', 'user_id', $user_id);
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link rel="stylesheet" href="css/myorders.css">
    <link rel="icon" href="images/cafeteria.png" type="image/png">
    <script src="js/my_orders_items.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
</head>
<body>

    <div class="container">
        <main>
            <h1>My Orders</h1>

            <div class="filter-section">
                <form method="GET" action="" id="filter-form">
                    <div class="date-picker">
                        <label for="date-from">Date from</label>
                        <input type="date" id="date-from" name="date_from" value="<?php echo htmlspecialchars($date_from); ?>">
                    </div>
                    <div class="date-picker">
                        <label for="date-to">Date to</label>
                        <input type="date" id="date-to" name="date_to" value="<?php echo htmlspecialchars($date_to); ?>">
                    </div>
                </form>
            </div>

            <table class="order-table">
                <thead>
                    <tr>
                        <th>Order Date</th>
                        <th>Status</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="order-list">
                    <?php if (!empty($orders)) :
                        foreach ($orders as $order) {
                            $status_name = $db->getRow('order_status', 'id', $order['status']);
                            ?>

                            <tr class="order-row" data-order-id="<?php echo $order['id']; ?>" data-total="<?php echo $order['total']; ?>">
                                <td><?php echo $order['date']; ?></td>
                                <td><?php echo $status_name['name']; ?></td>
                                <td><?php echo $order['total']; ?> EGP</td>
                                <td>
                                    <?php if ($order['status'] == '1') : ?>
                                        <button class="cancel-btn" data-order-id="<?php echo $order['id']; ?>">Cancel</button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="4">No orders found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Container for displaying order items -->
            <div id="order-items-container">
                <!-- Order items will be displayed here via JavaScript -->
            </div>

            <div class="total">
                <span>Total</span>
                <span id="total-price">EGP 0</span>
            </div>

            <div class="pagination mt-4">
                <button class="prev-page">&lt;</button>
                <span class="page-number">1</span>
                <button class="next-page">&gt;</button>
            </div>
        </main>
    </div>

    <?php
    require "design/footer.php";
    ?>

    <script>
        // JavaScript to automatically submit the form when date inputs change
        document.getElementById('date-from').addEventListener('change', function() {
            document.getElementById('filter-form').submit();
        });

        document.getElementById('date-to').addEventListener('change', function() {
            document.getElementById('filter-form').submit();
        });

        // JavaScript to update the total price when an order row is clicked
        document.querySelectorAll('.order-row').forEach(row => {
            row.addEventListener('click', function() {
                // Get the total price from the data-total attribute
                var totalPrice = this.getAttribute('data-total');

                // Update the total price display
                document.getElementById('total-price').innerText = 'EGP ' + totalPrice;
            });
        });
    </script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
