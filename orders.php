<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <link rel="stylesheet" href="css/myorders.css">
    <link rel="icon" href="images/cafeteria.png" type="image/png">
    <link rel="stylesheet" href="css/orders.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
</head>

<body>

    <?php
    include 'design/header.php';

    $user_id = $_SESSION['id'];
    

    $orders = $db->getUserOrders($user_id);

    $userOrders = [];
    foreach ($orders as $order) {
        $userOrders[$order['id']][] = $order;
    }
    ?>

    <div class="container">
            <h1>Orders</h1>

            <?php foreach ($userOrders as $orderId => $orderItems) : ?>
                <div class="con" >
                    <table class=" table order-table">
                        <thead>
                            <tr>
                                <th>User Name</th>
                                <th>Order Date</th>
                                <th>Room</th>
                                <th>Ext</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="order-list">
                            <tr>
                                <td><?= $orderItems[0]['user_name'] ?></td>
                                <td><?= $orderItems[0]['date'] ?></td>
                                <td><?= $orderItems[0]['room'] ?></td>
                                <td><?= $orderItems[0]['ext'] ?></td>
                                <td><?= $orderItems[0]['total'] ?> Egp</td>
                                <td><a class="deliver-btn btn btn-primary" href="update_order_status.php?id=<?php echo $orderItems[0]['id']?>" >Deliver</a></td>

                            </tr>
                        </tbody>
                    </table>

                    <div class="items-container">
                        <?php
                        $total = 0;
                        foreach ($orderItems as $order) :
                            $total += $order['price'] * $order['quantity'];
                        ?>
                            <div class="item">
                                <div class="item-image">
                                    <img src="<?= $order['image'] ?>" alt="<?= $order['product_name'] ?>">
                                    <div class="item-price"><?= $order['price'] ?> LE</div>
                                </div>
                                <div class="item-info">
                                    <span><?= $order['product_name'] ?> x</span>
                                    <span><?= $order['quantity'] ?></span>
                                </div>
                            </div>

                        <?php endforeach; ?>

                    </div>
                </div>

            <?php endforeach; ?>

        <nav class="d-flex justify-content-center">
            <div class="pagination mt-4">
                <button class="prev-page">&lt;</button>
                <span class="page-number">1</span>
                <button class="next-page">&gt;</button>
            </div>
        </nav>
    </div>



<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>    <script>
        let currentPage = 1;
        const itemsPerPage = 1; // Number of items per page
        const rows = document.querySelectorAll('.con'); // Select all table rows
        const totalPages = Math.ceil(rows.length / itemsPerPage);

        function showPage(page) {
            rows.forEach((row, index) => {
                row.style.display = (index >= (page - 1) * itemsPerPage && index < page * itemsPerPage) ? 'block' : 'none';
            });
            document.querySelector('.page-number').textContent = page;
        }

        document.querySelector('.prev-page').addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                showPage(currentPage);
            }
        });

        document.querySelector('.next-page').addEventListener('click', () => {
            if (currentPage < totalPages) {
                currentPage++;
                showPage(currentPage);
            }
        });

        // Show the first page on load
        showPage(currentPage);
    </script>


</body>

</html>