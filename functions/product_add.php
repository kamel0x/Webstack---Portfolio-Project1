<?php
require "connect.php";
require "db_class.php";

$db = new Database();
$db->connect($db_host, $db_user, $db_pass, $db_name);

$errors = [];
$prev_data = [];



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



if (empty($_FILES['img']['name'])) {
    $errors['img'] = "Image is required";
} else{
    $img_ext= pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
    if( ! in_array($img_ext, ["jpg", "jpeg", "png"])){
        $errors['img'] = " Your extension is not allowed ,Only JPG, JPEG, PNG files are allowed";
    }
}



if ($errors) {
    $errors = json_encode($errors);
    $url = "Location:../AddProduct.php?errors={$errors}";
    if ($prev_data) {
        $prev_data = json_encode($prev_data);
        $url .= "&prev_data={$prev_data}";
    }
    header($url);
    exit();
} else {


    $tmp = $_FILES['img']['tmp_name'];
    $image_name = $_FILES['img']['name'];
    $image_path="../images/$image_name";
    $img_moved=move_uploaded_file($tmp,$image_path);

    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $image = "images/$image_name";
    $status= 1;

    
    $table = "products";
    $columns = "`name`, `price`, `categ_id`, `image`,`status`";
    $values = "'$name', '$price', '$category', '$image', '$status' ";
    $db->insert($table, $columns, $values);


    header('Location: ../allProducts.php');
    exit();
}
?>
