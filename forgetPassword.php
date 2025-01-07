<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/forgetPass.css">
    <title>Forget Password</title>
</head>

<body>
    <?php
    require "functions/connect.php";
    require "functions/db_class.php";
    $db = new Database();
    $db->connect($db_host, $db_user, $db_pass, $db_name);
    ?>
    <main>
        <div class="form-container">
            <div class="lock-icon">
                <img src="images/lock.png" alt="Lock Icon">
            </div>
            <h4>Please Enter Your Email Address</h4>
            <form method="POST" action="./functions/check_if_user_exists.php">
                <div class="form-group">
                    <label for="exampleInputEmail1">Email Address</label>
                    <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                    <?php $error = isset($errors['name']) ? $errors['name'] : '';
                    echo $error; ?>
                </div>
                <button type="submit" class="btn edit">Submit</button>
            </form>
        </div>
    </main>
</body>

</html>