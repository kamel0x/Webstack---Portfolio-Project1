<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cafeteria Products</title>
  <link rel="stylesheet" href="css/myorders.css">
    <link rel="icon" href="images/cafeteria.png" type="image/png">
  <link rel="stylesheet" href="css/CafeteriaProducts.css">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/footer.css">
</head>

<body>
  <?php include 'design/header.php' ;
    if($data['perm_id'] == 1){header("Location: home.php");};
  
  ?>
  <div class="container">
    <h2>All Products</h2>
    <div class="add-product">
      <a class="btn edit" href="AddProduct.php">Add product</a>
    </div>

    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>Product</th>
          <th>Price</th>
          <th>Image</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $table = 'products';
        $stmt = $db->select($table);
        foreach ($stmt as $row) {
        ?>
          <tr>
            <td> <?php echo $row['name'] ?> </td>
            <td><?php echo $row['price'] ?> EGP</td>
            <td><img class="product-image" src="<?php echo $row['image'] ?>" alt=""></td>
            <td><?php
                $old_status = $row['status'];
                $status = $db->getRow('product_status', 'id', $old_status);
                echo $status['name'];
                ?> </td>
            <td>
              <div class="actions">
                <a class="edit btn " href="edit_product.php?id=<?php echo $row['id']; ?>">Edit</a>
                <a href="#deleteModal<?php echo $row['id']; ?>" class="btn btn-danger" data-bs-toggle="modal">Delete</a>
              </div>
            </td>
          </tr>
          <div class="modal fade" id="deleteModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="deleteModalLabel<?php echo $row['id']; ?>">Confirm Deletion</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  Are you sure you want to delete the product <?php echo $row['name']; ?>?
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <a href="functions/delete_product.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      </tbody>
    </table>

    <nav class="d-flex justify-content-center">
     

      <div class="pagination mt-4" >
        <button class="prev-page">&lt;</button>
        <span class="page-number">1</span>

        <button class="next-page">&gt;</button>
    </div>
    </nav>
  </div>

  <?php require "design/footer.php" ?>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> 
<script src="bootstrap/js/bootstrap.bundle.js"></script>

 <script>
  let currentPage = 1;
const itemsPerPage = 3; // Number of items per page
const rows = document.querySelectorAll('tbody tr'); // Select all table rows
const totalPages = Math.ceil(rows.length / itemsPerPage);

function showPage(page) {
  rows.forEach((row, index) => {
    row.style.display = (index >= (page - 1) * itemsPerPage && index < page * itemsPerPage) ? 'table-row' : 'none';
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