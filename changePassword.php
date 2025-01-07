<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/forgetPass.css">
   
    <title>Change Password</title>
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
        <h4>Please change your password</h4>
        <form method="POST" action="./functions/change_password_by_code.php">
            <div class="form-group mb-4">
                <label class="mb-1" for="code">Your Code</label>
                <input name="random_number" type="text" class="form-control" id="code" aria-describedby="emailHelp" placeholder="Enter code">

            </div>

            <div class="form-group">
                <label class="mb-1" for="newPassword">New Password</label>
                <input name="new_password" type="text" class="form-control" id="newPassword" aria-describedby="emailHelp" placeholder="Enter password">

            </div>

            <button type="submit" class="btn btn-primary mt-4">Submit</button>
        </form>
    </div>
    </main>


</body>

</html>