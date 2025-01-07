<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cafeteria Users</title>
  <link rel="stylesheet" href="css/myorders.css">
  <link rel="icon" href="images/cafeteria.png" type="image/png">
  <link rel="stylesheet" href="css/CafeteriaUsers.css">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/footer.css">
</head>

<body>
  <?php
  require "design/header.php";
  if($data['perm_id'] == 1){header("Location: home.php");};

  ?>
  <div class="container">
    <h2>All Users</h2>
    <div class="add-user">
      <a class="btn edit" href="AddUser.php">Add user</a>
    </div>
    <table class="table table-striped table-hover">
  <thead>
    <tr>
      <th>Name</th>
      <th>Room</th>
      <th>Image</th>
      <th>Ext</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $table = 'users';
    $stmt = $db->select($table);
    foreach ($stmt as $user) {
      $rooms = $db->getRow('rooms', 'id', $user['room_id']);
    ?>
      <tr>
        <td><?php echo $user['name']; ?></td>
        <td><?php echo $rooms['name']; ?></td>
        <td><img class="user-image" src="<?php echo $user['image']; ?>" alt="Image"></td>
        <td><?php echo $user['ext']; ?></td>
        <td>
          <a class="edit btn" href="edit_user.php?id=<?php echo $user['id'] ?>">Edit</a>
          <a href="#deleteModal<?php echo $user['id']; ?>" class="btn delete" data-bs-toggle="modal">Delete</a>
        </td>
      </tr>

      <!-- Modal for Delete Confirmation -->
      <div class="modal fade" id="deleteModal<?php echo $user['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?php echo $user['id']; ?>" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="deleteModalLabel<?php echo $user['id']; ?>">Confirm Deletion</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Are you sure you want to delete the user <?php echo $user['name']; ?>?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <a href="functions/delete_user.php?id=<?php echo $user['id']; ?>" class="btn btn-danger">Delete</a>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>

  </tbody>
</table>


    <nav class="d-flex justify-content-center">


      <div class="pagination mt-4">
        <button class="prev-page">&lt;</button>
        <span class="page-number">1</span>

        <button class="next-page">&gt;</button>
      </div>
    </nav>
  </div>

  <?php
  require "design/footer.php";
  ?>

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