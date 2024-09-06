<?php
include('config.php');
session_start();

if ((!filter_input(INPUT_POST, 'email')) || (!filter_input(INPUT_POST, 'password'))) {
    header("Location: loginform");
    exit;
}

$mysqli = mysqli_connect("$db_host", "$db_username", "$db_password", "$db_database");

$targetemail = filter_input(INPUT_POST, 'email');
$targetpasswd = filter_input(INPUT_POST, 'password');

$sql = "SELECT id, first_name, last_name, password FROM users WHERE email = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $targetemail);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {

    while ($info = $result->fetch_assoc()) {
        $id = $info['id'];
        $f_name = $info['first_name'];
        $l_name = $info['last_name'];
        $storedPassword = $info['password'];
    }

    if (password_verify($targetpasswd, $storedPassword)) {
        setcookie("auth", session_id(), time() + 60 * 30, "/", "", 0);
        setcookie("id", $id, time() + 60 * 30, "/", "", 0);
        setcookie("first_name", $f_name, time() + 60 * 30, "/", "", 0);
        setcookie("last_name", $l_name, time() + 60 * 30, "/", "", 0);
        setcookie("email", $targetemail, time() + 60 * 30, "/", "", 0);
        header("Location: index");
        exit;
    } else {
        header("Location: loginform");
        exit;
    }
} else {
    header("Location: loginform");
    exit;
}
