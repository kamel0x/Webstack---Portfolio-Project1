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

    ?>
    <div class="add-user-container">
        <div class="login-box">
            <form class="login-form" method="post" action="functions/user_add.php" enctype="multipart/form-data">
                <h1>Add User</h1>

                <div class="input-box">
                    <label class="form-label" for="name"> Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Your first name" value="<?php $val = isset($prev_data['name']) ? $prev_data['name'] : "";
                                                                                                                                echo $val; ?>">
                    <span class="text-danger">
                        <?php $error = isset($errors['name']) ? $errors['name'] : '';
                        echo $error; ?>
                    </span>
                </div>

                <div class="input-box">
                    <label class="form-label" for="email"> Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter Your email" value="<?php $val = isset($prev_data['email']) ? $prev_data['email'] : "";
                                                                                                                            echo $val; ?>">
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
                        foreach ($rooms as $room) {
                            echo '<option value="' . $room['id'] . '"';
                            if (isset($prev_data['room']) && $prev_data['room'] == $room['id']) {
                                echo ' selected';
                            }
                            echo '>' . $room['name'] . '</option>';
                        }
                        ?>

                    </select>
                    <span class="text-danger">
                        <?php $error = isset($errors['room']) ? $errors['room'] : '';
                        echo $error; ?>
                    </span>
                </div>

                <div class="input-box">
                    <label class="form-label" for="ext">Ext</label>
                    <input type="text" class="form-control" id="ext" name="ext" placeholder="Ext" value="<?php $val = isset($prev_data['ext']) ? $prev_data['ext'] : "";
                                                                                                            echo $val; ?>">
                    <span class="text-danger">
                        <?php $error = isset($errors['ext']) ? $errors['ext'] : '';
                        echo $error; ?>
                    </span>
                </div>



                <div class="input-box">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                    <span class="text-danger">
                        <?php $error = isset($errors['password']) ? $errors['password'] : '';
                        echo $error; ?>
                    </span>
                </div>
                <div class="input-box">
                    <label class="form-label" for="confirm">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm" name="confirm" placeholder="Re-type Password">
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
                        foreach ($permissions as $permission) {
                            echo '<option value="' . $permission['id'] . '"';
                            if (isset($prev_data['permission']) && $prev_data['permission'] == $permission['id']) {
                                echo ' selected';
                            }
                            echo '>' . $permission['name'] . '</option>';
                        }
                        ?>

                    </select>
                    <span class="text-danger">
                        <?php $error = isset($errors['permission']) ? $errors['permission'] : '';
                        echo $error; ?>
                    </span>
                </div>


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
                    <button class="btn btn-danger" type="reset">Reset</button>
                </div>



            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>