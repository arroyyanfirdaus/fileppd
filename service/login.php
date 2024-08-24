<?php
session_start();
include_once './Database.php';

$database = new Database();
$db = $database->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $_SESSION["message"] = "All fields are required!";
        header("Location: ../admin/login.php");
        exit();
    }

    $stmt = $db->prepare("SELECT id, password FROM data_admin WHERE email = :email");
    $stmt->bindParam(':email', $email);

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $email;

            header("Location: ../admin/index.php");
        } else {
            $_SESSION["message"] = "Incorrect password!";
            header("Location: ../admin/login.php");
        }
    } else {
        $_SESSION["message"] = "No account found with that email!";
        header("Location: ../admin/login.php");
    }
} else {
    header("Location: ../admin/login.php");
}
?>