<?php

session_start();
if (isset($_SESSION['login'])) {
    header("location:home.php");
} else {
    session_destroy();
}
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
    <title>Login Page</title>

    <link rel="stylesheet" href="css/styles.css">
    <link rel="icon" href="images/cafeteria.png" type="image/png">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

</head>

<body>

    <div class="login-container">
        <div class="login-box">
            <form class="login-form" method="post" action="functions/login_validation.php">
                <div class="avatar">
                    <img src="images/cafeteria.png" alt="Logo">
                </div>

                <label for="exampleInputEmail1" class="form-label">Username</label>
                <div class="input-box">
                    <input type="email" name="email" placeholder="email" value="<?php $val = isset($prev_data['email']) ? $prev_data['email'] : "";
                                                                                echo $val; ?>">
                    <span class="text-danger">
                        <?php $error = isset($errors['email']) ? $errors['email'] : '';
                        echo $error; ?>
                    </span>
                </div>


                <label class="form-label">Password</label>
                <div class="input-box">
                    <input type="password" name="password" placeholder="Password">
                    <span class="text-danger">
                        <?php $error = isset($errors['password']) ? $errors['password'] : '';
                        echo $error; ?>
                    </span>
                </div>


                <div class="button-box">
                    <button class=" btn text-light br" type="submit">Login</button>
                </div>

                <div class="links">
                    <a href="forgetPassword.php">Forgot Username / Password?</a>
                </div>
            </form>
        </div>
    </div>
    <script src="bootstrap/js/bootstrap.bundle.js"></script>

</body>

</html>