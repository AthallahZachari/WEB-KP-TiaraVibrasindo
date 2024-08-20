<?php
include 'connection.php';
session_start();

// $errorMessage = "";

// if (isset($_POST['login'])) {

//     $query = $conn->prepare("SELECT * FROM admin WHERE admin_name = ? AND nip_admin = ? AND password = ?");
//     $query->execute([$_POST['username'], $_POST['nip'], $_POST['password']]);

//     if ($query->rowCount() > 0) {
//         $_SESSION['current_user'] = $_POST['username'];
//         header("Location: ./admindashboard.php");
//     } else {
//         $errorMessage = "Username, NIP, atau Password salah !";
//     }
// }

// $username = $_SESSION['current_user'];

?>
