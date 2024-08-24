<?php
session_start();
include_once './Database.php';

$database = new Database();
$db = $database->getConnection();

function createUser($email, $password)
{
    global $db;

    // Check if the email already exists
    $stmt = $db->prepare("SELECT COUNT(*) FROM data_admin WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $emailExists = $stmt->fetchColumn();

    if ($emailExists) {
        $_SESSION["message"] = "Email already exists!";
        header("Location: ../admin/login.php");
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $db->prepare("INSERT INTO data_admin (email, password) VALUES (:email, :password)");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashed_password);

    if ($stmt->execute()) {
        $_SESSION["message"] = "Sukses create Admin!";
        header("Location: ../admin/login.php");
    } else {
        $_SESSION["message"] = "Gagal create Admin!";
        header("Location: ../admin/login.php");
    }
}

$email = 'admin@gmail.com';
$password = 'admin123';

// Create the user
createUser($email, $password);
?>