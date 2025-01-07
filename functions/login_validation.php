<?php
require_once 'connect.php'; 
require_once 'db_class.php'; 

$errors = [];
$prev_data = [];

if (empty($_POST['email'])) {
    $errors['email'] = "Email is required";
} else {
    $prev_data['email'] = $_POST['email'];
}

if (empty($_POST['password'])) {
    $errors['password'] = "Password is required";
}

if ($errors) {
    $errors = json_encode($errors);
    $url = "Location: ../login.php?errors={$errors}";
    if ($prev_data) {
        $prev_data = json_encode($prev_data);
        $url .= "&prev_data={$prev_data}";
    }
    header($url);
    exit();
} else {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $db = new Database();
    $db->connect($db_host, $db_user, $db_pass, $db_name);

    $user = $db->getRow('users', 'email',$email);

    if ($user) {
        if ($password == $user['password']) {
            session_start();
            $_SESSION['id'] = $user['id'];
            $_SESSION['login'] = true;
            header("Location: ../home.php");
            exit();
        } else {
            $errors['password'] = "Invalid Password";
        }
    } else {
        $errors['email'] = "Invalid Email";
    }

    $prev_data['email'] = $_POST['email'];
    $prev_data = json_encode($prev_data);
    $errors = json_encode($errors);
    $url = "Location: ../login.php?errors={$errors}&prev_data={$prev_data}";
    header($url);
    exit();
}
?>