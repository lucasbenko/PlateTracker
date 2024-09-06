<?php
include('config.php');
session_start();

$mysqli = mysqli_connect("$db_host", "$db_username", "$db_password", "$db_database");

$fname = ucfirst(strtolower(filter_input(INPUT_POST, 'first_name')));
$lname = ucfirst(strtolower(filter_input(INPUT_POST, 'last_name')));
$email = filter_input(INPUT_POST, 'email');
$password = filter_input(INPUT_POST, 'password');
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$check_duplicate_query = "SELECT COUNT(*) AS count FROM users WHERE email = ?";
$stmt = $mysqli->prepare($check_duplicate_query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row['count'] > 0) {
    $_SESSION['error_message'] = "Email address is already associated with an account.";
    header("Location: createaccount");
    exit;
}

$sql = "INSERT INTO users (first_name, last_name, email, password) 
        VALUES (?, ?, ?, ?)";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ssss", $fname, $lname, $email, $hashed_password);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    $_SESSION['account_created_message'] = "Account created successfully. You can now log in.";
    header("Location: loginform");
    exit;
} else {
    echo "Error: " . $stmt->error;
    header("Location: createaccount");
    exit;
}