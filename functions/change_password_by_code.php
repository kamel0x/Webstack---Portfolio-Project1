<?php

require "connect.php";
require "db_class.php";
require "./forget_password.php";

$db = new Database();
$db->connect($db_host, $db_user, $db_pass, $db_name);

$db->changePasswordByID($_POST['random_number'], $_POST['new_password']);
