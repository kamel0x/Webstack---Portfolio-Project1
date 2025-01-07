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

if (empty($_POST['price'])) {
    $errors['price'] = "price is required";
} else {
    $prev_data['price'] = $_POST['price'];
}


if (empty($_POST['category'])) {
    $errors['category'] = "category is required";
} else {
    $prev_data['category'] = $_POST['category'];
}

if (empty($_POST['status'])) {
    $errors['status'] = "status is required";
} else {
    $prev_data['status'] = $_POST['status'];
}


if (!empty($_FILES['img']['name'])) {

    $img_ext= pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
    if( ! in_array($img_ext, ["jpg", "jpeg", "png"])){
        $errors['img'] = " Your extension is not allowed ,Only JPG, JPEG, PNG files are allowed";
    }
}



if ($errors) {
    $errors = json_encode($errors);
    $url = "Location:../edit_product.php?id={$id}&errors={$errors}";
    if ($prev_data) {
        $prev_data = json_encode($prev_data);
        $url .= "&prev_data={$prev_data}";
    }
    header($url);
    exit();
}else{
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $status = $_POST['status'];

    if (!empty($_FILES['img']['name'])) {
        $tmp = $_FILES['img']['tmp_name'];
        $image_name = $_FILES['img']['name'];
        $image_path = "../images/$image_name";
        move_uploaded_file($tmp, $image_path);
        $image = "images/$image_name";
    } else {
        $id = $_POST['id'];
        $table = 'products';
        $field = 'id';
        $product = $db->getRow($table, $field, $id);
        $image = $product['image'];
    }
    $data = "name = '$name', price = '$price', categ_id = '$category', image = '$image', status = '$status'";
    $table ='products';
    $db->update($table, $data, $id);

    header('Location: ../allProducts.php');
    exit();
}
?>
