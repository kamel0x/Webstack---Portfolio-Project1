<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Home Page</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/home.css">
</head>

<body>
    <?php
    include 'design/header.php';


    $user_id = $_SESSION['id'];
    $user = $db->getRow('users', 'id', $user_id);

    $users = $db->select('users');
    $products = $db->select('products');

    $isAdmin = $user['perm_id'] == 2;


    ?>
    <div class="container">
        <div class="row">
            <div class="search-select-container">
                <input type="text" id="search-input" class="form-control" placeholder="Search products...">
            </div>
        </div>

        <div class="row justify-content-between">
            <div class="col-xs-12 col-s-12 col-md-8 col-lg-8">

                <?php

                if ($isAdmin): ?>
                    <div>
                        <label for="user-select">Add to User</label>
                        <select id="user-select" name="user_id" class="form-control">
                            <option value="0">Select a user</option> <!-- Value is 0 for self -->
                            <?php foreach ($users as $user): ?>
                                <option value="<?= $user['id'] ?>"><?= $user['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php else: ?>
                    <h3 <?php

                        $latestProducts = $db->getLatestUserProducts($user_id);
                        if (empty($latestProducts)) {
                            echo "hidden";
                        }

                        ?> class="section-title">Latest Purchased</h3>
                    <div class="row justify-content-evenly mt-3 gx-4">
                        <?php
                        foreach ($latestProducts as $lp): ?>
                            <div class="product-item product-item-mini col-6 col-md-6 col-lg-4 text-center" style="width: fit-content;">
                                <div class="product-image-wrapper d-flex align-items-center">
                                    <img src="<?= $lp['image'] ?>" alt="<?= $lp['name'] ?>" class="img-fluid rounded-circle">
                                </div>
                                <div>
                                    <div class="drink-name">
                                        <span class="label">
                                            Drink Name :
                                        </span>
                                        <span class="value">
                                            <?= $lp['name'] ?>
                                        </span>
                                    </div>
                                    <div class="drink-price">
                                        <span class="label">
                                            Drink Price :
                                        </span>
                                        <span class="value">
                                            <?= $lp['price'] ?> <sub>EGP</sub>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <hr class="container">
                <h3 class="section-title">All Products </h3>

                <div class="row justify-content-evenly mt-3" id="products-container">
                    <?php foreach ($products as $product): ?>
                        <div class="product-item relative col-6 col-md-6 col-lg-4 text-center" style="width: fit-content;" data-product-name="<?= strtolower($product['name']) ?>">
                            <div class="product-image-wrapper d-flex align-items-center">
                                <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>" class="img-fluid">
                            </div>
                            <div>
                                <div class="drink-name">
                                    <span class="d-block label">
                                        Drink Name :
                                    </span>
                                    <span class="d-block value">
                                        <?= $product['name'] ?>
                                    </span>
                                </div>
                                <div class="drink-price">
                                    <span class="label">
                                        Drink Price :
                                    </span>
                                    <span class="value drink-price-highlight">
                                        <?= $product['price'] ?> <sub>EGP</sub>
                                    </span>
                                </div>
                            </div>
                            <button class="btn highlight add-product order-new-drink"
                                data-toggle="tooltip" data-placement="top" title="Order Drink"
                                data-product-id="<?= $product['id'] ?>"
                                data-product="<?= $product['name'] ?>"
                                data-price="<?= $product['price'] ?>">
                                <svg width="24" height="24" viewBox="-2 -1 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M18.5714 11.4266H11.4286V18.5694C11.4286 18.9483 11.2781 19.3117 11.0102 19.5796C10.7422 19.8475 10.3789 19.998 10 19.998C9.62112 19.998 9.25776 19.8475 8.98985 19.5796C8.72194 19.3117 8.57143 18.9483 8.57143 18.5694V11.4266H1.42857C1.04969 11.4266 0.686328 11.276 0.418419 11.0081C0.15051 10.7402 0 10.3769 0 9.99799C0 9.6191 0.15051 9.25574 0.418419 8.98783C0.686328 8.71992 1.04969 8.56941 1.42857 8.56941H8.57143V1.42656C8.57143 1.04768 8.72194 0.684313 8.98985 0.416404C9.25776 0.148495 9.62112 -0.00201416 10 -0.00201416C10.3789 -0.00201416 10.7422 0.148495 11.0102 0.416404C11.2781 0.684313 11.4286 1.04768 11.4286 1.42656V8.56941H18.5714C18.9503 8.56941 19.3137 8.71992 19.5816 8.98783C19.8495 9.25574 20 9.6191 20 9.99799C20 10.3769 19.8495 10.7402 19.5816 11.0081C19.3137 11.276 18.9503 11.4266 18.5714 11.4266Z" fill="#F5F5DC" />
                                </svg>
                            </button>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div id="no-products-message" class="text-center" style="display: none;">
                    <p>No products found.</p>
                </div>
            </div>
            <div class="col-12 col-s-12 col-md-4 col-lg-3 bill mt-4">
                <h3 class="text-center">Bill</h3>
                <form id="bill-form" action="functions/add_order.php" method="POST">
                    <input type="hidden" name="user_id" id="selected-user-id" value="0">

                    <div id="bill-items"></div>
                    <?php if (isset($_GET['error'])) {
                        echo "<span class='text-danger fw-bold'>" . $_GET['error'] . "</span>";
                    } ?>
                    <div class="form-group">
                        <label for="notes">Notes </label>
                        <textarea id="notes" name="notes" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="room">Room</label>
                        <br>
                        <span class="text-danger ">* if you are not in your room</span>
                        <select class="form-control" name="room" id="room">
                            <option value="0">Choose Your Room</option>
                            <?php
                            $rooms = $db->select('rooms');
                            foreach ($rooms as $room) {
                                echo '<option value="' . $room['id'] . '">' . $room['name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="ext">Ext</label>
                        <input type="text" id="ext" name="ext" class="form-control" placeholder="Ext Number">
                    </div>
                    <hr>
                    <h4>Total : <span class="value drink-price-highlight"> <span id="total-price">0</span> EGP </span></h4>
                    <input type="hidden" name="total" id="total-input">
                    <button type="submit" class="btn highlight btn-block">Confirm</button>
                </form>
            </div>
        </div>
    </div>
    <?php require 'design/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>

    $(document).ready(function() {
    // Function to update the total price
    function updateTotalPrice() {
        let totalPrice = 0;
        $('.bill-item').each(function() {
            const quantity = $(this).find('.quantity-controls span').text();
            const price = $(this).data('price');
            totalPrice += quantity * price;
        });
        $('#total-price').text(totalPrice);
        $('#total-input').val(totalPrice);
    }

    // Function to update an item in the bill
    function updateItem($item, newQuantity) {
        $item.find('.quantity-controls span').text(newQuantity);
        $item.find('.quantity-input').val(newQuantity);

        const itemTotal = newQuantity * $item.data('price');
        $item.find('.item-total').text(itemTotal);
        $item.find('.item-total-input').val(itemTotal);

        updateTotalPrice();
    }

    // Add product to bill
    $('.add-product').click(function() {
        const productId = $(this).data('product-id');
        const productName = $(this).data('product');
        const price = $(this).data('price');

        // Use backticks here to correctly reference the product ID
        let $item = $(`.bill-item[data-product-id="${productId}"]`);

        if ($item.length) {
            const newQuantity = parseInt($item.find('.quantity-controls span').text()) + 1;
            updateItem($item, newQuantity);
        } else {
            const billItem = `
                <div class="bill-item" data-product-id="${productId}" data-price="${price}">
                    <div class="d-flex justify-content-between">
                        <p>${productName}</p>
                        <div class="quantity-controls">
                            <button type="button" class="decrease">-</button>
                            <span>1</span>
                            <input type="hidden" name="products[${productId}][quantity]" value="1" class="quantity-input">
                            <button type="button" class="increase">+</button>
                        </div>
                        <p>EGP <span class="item-total">${price}</span></p>
                        <input type="hidden" name="products[${productId}][price]" value="${price}" class="item-total-input">
                    </div>
                </div>`;
            $('#bill-items').append(billItem);
        }
        updateTotalPrice();
    });

    // Increase quantity
    $('#bill-items').on('click', '.increase', function() {
        const $item = $(this).closest('.bill-item');
        const newQuantity = parseInt($item.find('.quantity-controls span').text()) + 1;
        updateItem($item, newQuantity);
    });

    // Decrease quantity
    $('#bill-items').on('click', '.decrease', function() {
        const $item = $(this).closest('.bill-item');
        const currentQuantity = parseInt($item.find('.quantity-controls span').text());

        if (currentQuantity > 1) {
            updateItem($item, currentQuantity - 1);
        } else {
            // Remove item from bill if quantity is less than 1
            $item.remove();
        }

        updateTotalPrice();
    });

    // Filter products based on search input
    $('#search-input').on('input', function() {
        const searchTerm = $(this).val().toLowerCase();
        filterProducts(searchTerm);
    });

    // Function to filter products
    function filterProducts(searchTerm) {
        const $productItems = $('#products-container .product-item');
        let foundAny = false;

        $productItems.each(function() {
            const productName = $(this).data('product-name');
            if (productName.includes(searchTerm)) {
                $(this).show();
                foundAny = true;
            } else {
                $(this).hide();
            }
        });

        $('#no-products-message').toggle(!foundAny);
    }

    // Update selected user ID when the dropdown changes
    $('#user-select').on('change', function() {
        var selectedUserId = $(this).val();
        $('#selected-user-id').val(selectedUserId);
    });
});
</script>
</body>

</html>