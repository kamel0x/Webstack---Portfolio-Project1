<?php

if (isset($_GET['errors'])) {
  $errors = json_decode($_GET['errors'], true);
}
if (isset($_GET['prev_data'])) {
  $prev_data = json_decode($_GET['prev_data'], true);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" href="css/styles.css" />
  <link rel="stylesheet" href="css/header.css">
  <title>Add Product</title>
  <style>
    body {
      padding-top: 80px;
      height: auto;
    }

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
   
  </style>
</head>


<body>
  <?php
  include 'design/header.php';
  if ($data['perm_id'] == 1) {
    header("Location: home.php");
  };
  ?>

  <main class="container p-4">
    <h1>Add Product</h1>
    <div class="row">
      <div class="col-12 col-lg-6">
        <form class="w-100 p-2" action="functions/product_add.php" method="post" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="product" class="form-label">Product Name</label>
            <input
              id="product_name"
              value="<?php $val = isset($prev_data['name']) ? $prev_data['name'] : "";
                      echo $val; ?>"
              name="name"
              type="text"
              class="form-control myInput"
              id="product"
              placeholder="Enter your product name" />
            <span class="text-danger">
              <?php $error = isset($errors['name']) ? $errors['name'] : '';
              echo $error; ?>
            </span>
          </div>

          <div class="mb-3">
            <label for="price" class="form-label">Product Price</label>
            <input
              id="product_price"
              value="<?php $val = isset($prev_data['price']) ? $prev_data['price'] : "";
                      echo $val; ?>"
              name="price"
              type="number"
              min="1"
              class="form-control myInput"
              id="price"
              placeholder="Enter your product price" />
            <span class="text-danger">
              <?php $error = isset($errors['price']) ? $errors['price'] : '';
              echo $error; ?>
            </span>
          </div>

          <div class="mb-3">
            <label for="category" class="form-label">Product Category</label>
            <select
              id="product_category"
              class="form-select myInput"
              id="category"
              name="category">
              <option>Choose your product category</option>
              <?php
              $table = 'categories';
              $data = $db->select($table);
              foreach ($data as $categ) {
              ?>
                <option <?php if (isset($prev_data['category'])) {
                          if ($prev_data['category'] == $categ['id']) {
                            echo "selected";
                          }
                        } ?> value="<?php echo $categ['id'] ?>"><?php echo $categ['name'] ?></option>
              <?php } ?>
            </select>
            <span class="text-danger">
              <?php $error = isset($errors['category']) ? $errors['category'] : '';
              echo $error; ?>
            </span>
          </div>

          <div class="mb-3">
            <label for="pic" class="form-label">Product Picture</label>
            <input
              id="product_pic"
              name="img"
              type="file"
              class="form-control myInput"
              id="pic"
              placeholder="Enter your product price" />
            <span class="text-danger">
              <?php $error = isset($errors['img']) ? $errors['img'] : '';
              echo $error; ?>
            </span>
          </div>

          <div class="my-2 d-lg-none">
            <img
              style="object-fit: fill; aspect-ratio: 16 / 9"
              id="product_img2"
              class="img-fluid"
              alt="" />
          </div>

          <div class="mb-3">
            <button class="btn edit">Save</button>
            <button type="reset" id="reset_button" class="btn btn-danger">
              Reset
            </button>
          </div>
        </form>
      </div>

      <div class="col-12 col-lg-6 d-none d-lg-flex justify-content-center">
        <img
        src="images/addproduct.png"
          style="object-fit: fill"
          id="product_img"
          class="img-fluid"
          alt="" />
      </div>
    </div>
  </main>


  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="js/jquery.js"></script>
</body>

</html>