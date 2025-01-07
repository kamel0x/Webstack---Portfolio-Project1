<?php

require "connect.php";
require "db_class.php";
require "./forget_password.php";

$db = new Database();
$db->connect($db_host, $db_user, $db_pass, $db_name);

$user_exists = $db->checkIfUserExists("users", $_POST['email']);
if ($user_exists !== null) {
    $randomNumber = rand(1000, 9999);
    sendEmail($_POST['email'], $randomNumber);
    $user_id = $user_exists['id'];
    $db->insert('forget_password', "`user_id` , `random_number`", "'$user_id' , '$randomNumber'");
    $cookie_name = "user_id";
    $cookie_value = $user_exists['id'];
    $expire_time = time() + 4 * 3600; // 1 hour from now

    setcookie($cookie_name, $cookie_value, $expire_time, "/");
    header('Location: ../changePassword.php');
} else {
    echo "
    <div style='
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: #FFFBF2;
        font-family: Arial, sans-serif;
    '>
        <div style='
            background-color: #FFFBF2;
            color: #33211D;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px #33211D;
            text-align: center;
            max-width: 500px;
            width: 100%;
        '>
            <h2 style='
                color: #DA9F5B;
                margin-bottom: 20px;
            '>Error</h2>
            <p style='color: #33211D;'>There's no account saved in our database with this email address.</p>
            <a href='../forgetPassword.php' style='
                display: inline-block;
                margin-top: 20px;
                padding: 12px 20px;
                background-color: #DA9F5B;
                color: #33211D;
                text-decoration: none;
                border-radius: 4px;
                font-size: 16px;
                transition: background-color 0.3s ease;
            '>Try Again</a>
        </div>
    </div>
    ";
}
