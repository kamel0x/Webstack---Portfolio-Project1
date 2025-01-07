<?php

// session_start();
// if($_SESSION['login']){
//     header("location:home.php");
// }else{
//     session_destroy();
// }
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="icon" href="images/cafeteria.png" type="image/png">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
</head>
<style>
    body {
        padding-top: 80px;
        height: auto;
    }
</style>

<body>
    <?php
    require "design/header.php";
    if ($data['perm_id'] == 1) {
        header("Location: home.php");
      };
    $id = $_GET['id'];
    $table = 'users';
    $field = 'id';
    $data = $db->getRow($table, $field, $id);

    ?>
    <div class="add-user-container">
        <div class="login-box">
            <form class="login-form" method="post" action="functions/update_user.php" enctype="multipart/form-data">
                <h1>Edit User</h1>
                <input type="number" name="id" value="<?php echo $data['id'] ?>" hidden>

                <div class="input-box">
                    <label class="form-label" for="name"> Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Your first name" value="<?php echo $data['name'] ?>">
                    <span class="text-danger">
                        <?php $error = isset($errors['name']) ? $errors['name'] : '';
                        echo $error; ?>
                    </span>
                </div>

                <div class="input-box">
                    <label class="form-label" for="email"> Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter Your email" value="<?php echo $data['email'] ?>">
                    <span class="text-danger">
                        <?php $error = isset($errors['email']) ? $errors['email'] : '';
                        echo $error; ?>
                    </span>
                </div>


                <div class="input-box">
                    <label class="form-label" for="room">Room No.</label>
                    <select name="room" id="room">
                        <option value="0">Choose Your Room</option>
                        <?php
                        $rooms = $db->select('rooms');
                        $user_room = $db->getRow('rooms', 'id', $data['room_id']);
                        foreach ($rooms as $room) {
                            echo '<option value="' . $room['id'] . '"';
                            if (isset($user_room) && $user_room['id'] == $room['id']) {
                                echo ' selected';
                            }
                            echo '>' . $room['name'] . '</option>';
                        }
                        ?>

                    </select>

                    <div class="input-box">
                        <label class="form-label" for="ext">Ext</label>
                        <input type="text" class="form-control" id="ext" name="ext" placeholder="Ext" value="<?php echo $data['ext'] ?>">
                        <span class="text-danger">
                            <?php $error = isset($errors['ext']) ? $errors['ext'] : '';
                            echo $error; ?>
                        </span>
                    </div>



                    <div class="input-box">
                        <label class="form-label" for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" value="<?php echo $data['password'] ?>">
                        <span class="text-danger">
                            <?php $error = isset($errors['password']) ? $errors['password'] : '';
                            echo $error; ?>
                        </span>
                    </div>
                    <div class="input-box">
                        <label class="form-label" for="confirm">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm" name="confirm" placeholder="Re-type Password" value="<?php echo $data['password'] ?>">
                        <span class="text-danger">
                            <?php $error = isset($errors['confirm']) ? $errors['confirm'] : '';
                            echo $error; ?>
                        </span>
                    </div>

                    <div class="input-box">
                    <label class="form-label" for="permission">permission </label>
                    <select name="permission" id="permission">
                        <option value="0">Choose The permission</option>
                        <?php
                        $permissions = $db->select('permissions');
                        $user_permission = $db->getRow('permissions', 'id', $data['perm_id']);
                        foreach ($permissions as $permission) {
                            echo '<option value="' . $permission['id'] . '"';
                            if (isset($user_permission) && $user_permission['id'] == $permission['id']) {
                                echo ' selected';
                            }
                            echo '>' . $permission['name'] . '</option>';
                        }
                        ?>


                    <div class="input-box">
                        <label class="form-label" for="img">Profile Picture</label>
                        <input type="file" class="form-control" id="img" name="img">
                        <span class="text-danger">
                            <?php $error = isset($errors['img']) ? $errors['img'] : '';
                            echo $error; ?>
                        </span>
                    </div>
                    <div class="button-box">
                        <button class="btn edit" type="submit">Submit</button>
                        <button class="btn" type="reset">Reset</button>
                    </div>



            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>