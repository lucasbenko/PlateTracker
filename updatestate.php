<?php
session_start();
include('config.php');

$mysqli = mysqli_connect("$db_host", "$db_username", "$db_password", "$db_database");

if (!$mysqli) {
    die("Connection failed: " . mysqli_connect_error());
}

$state = isset($_POST['state']) ? $_POST['state'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$action = isset($_POST['action']) ? $_POST['action'] : '';
$id = isset($_COOKIE['id']) ? $_COOKIE['id'] : '';

if (!$email || !$state || !$action || !$id) {
    echo "Invalid parameters.";
    exit;
}

if ($action === 'insert') {
    $stmt = $mysqli->prepare("SELECT * FROM state_visits WHERE id = ? AND email = ? AND state = ?");
    $stmt->bind_param("sss", $id, $email, $state);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        $stmt = $mysqli->prepare("INSERT INTO state_visits (id, email, state, visit_time) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("sss", $id, $email, $state);
        if ($stmt->execute()) {
            echo "State inserted successfully.";
        } else {
            echo "Error inserting state: " . $stmt->error;
        }
    } else {
        echo "State already exists.";
    }
} elseif ($action === 'delete') {
    $stmt = $mysqli->prepare("DELETE FROM state_visits WHERE id = ? AND email = ? AND state = ?");
    $stmt->bind_param("sss", $id, $email, $state);
    if ($stmt->execute()) {
        echo "State deleted successfully.";
    } else {
        echo "Error deleting state: " . $stmt->error;
    }
} else {
    echo "Invalid action.";
}

$stmt->close();
$mysqli->close();
?>
