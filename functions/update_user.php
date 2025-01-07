<?php
require "connect.php";
require "db_class.php";

$db = new Database();
$db->connect($db_host, $db_user, $db_pass, $db_name);

$errors = [];
$prev_data = [];
$id = $_POST['id'];

if (empty($_POST['name'])) {
    $errors['name'] = "name is required";
} else {
    $prev_data['name'] = $_POST['name'];
}

if (empty($_POST['ext'])) {
    $errors['ext'] = "ext is required";
} else {
    $prev_data['ext'] = $_POST['ext'];
}

if (empty($_POST['email'])) {
    $errors['email'] = "email is required";
} else {
    $prev_data['email'] = $_POST['email'];
}

if (empty($_POST['password'])) {
    $errors['password'] = "password is required";
}else {
    if (strlen($_POST['password']) != 8) {
        $errors['password'] = "Password have to be 8 characters ";
    } elseif (!preg_match('/^[a-z0-9_]+$/', $_POST['password'])) {
        $errors['password'] = "Password only allows lowercase letters, numbers, and underscores";
    }
}

if (empty($_POST['confirm'])) {
    $errors['confirm'] = "confirm is required";
} elseif($_POST['password'] != $_POST['confirm']){
    $errors['confirm'] = "Password does not match";
}

if ($_POST['room'] == 0) {
    $errors['room'] = "room is required";
} else {
    $prev_data['room'] = $_POST['room'];
}

if ($_POST['permission'] == 0) {
    $errors['permission'] = "permission is required";
} else {
    $prev_data['permission'] = $_POST['permission'];
}

if (!empty($_FILES['img']['name'])) {

    $img_ext= pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
    if( ! in_array($img_ext, ["jpg", "jpeg", "png"])){
        $errors['img'] = " Your extension is not allowed ,Only JPG, JPEG, PNG files are allowed";
    }
}



if ($errors) {
    $errors = json_encode($errors);
    $url = "Location:../home.php?errors={$errors}";
    if ($prev_data) {
        $prev_data = json_encode($prev_data);
        $url .= "&prev_data={$prev_data}";
    }
    header($url);
    exit();
}else{
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $room = $_POST['room'];
    $permission = $_POST['permission'];
    $password = $_POST['password'];
    $ext = $_POST['ext'];

    if (!empty($_FILES['img']['name'])) {
        $tmp = $_FILES['img']['tmp_name'];
        $image_name = $_FILES['img']['name'];
        $image_path = "../images/$image_name";
        move_uploaded_file($tmp, $image_path);
        $image = "images/$image_name";
    } else {
        $table = 'users';
        $field = 'id';
        $user = $db->getRow($table, $field, $id);
        $image = $user['image'];
    }
    $data = "name = '$name', email = '$email', password = '$password', room_id = '$room', ext = '$ext', image = '$image', perm_id = '$permission'";
    
    $db->update("users", $data, $id);

    header('Location: ../allUsers.php');
    exit();
}
?>
