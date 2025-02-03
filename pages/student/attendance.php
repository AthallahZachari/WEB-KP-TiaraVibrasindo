<?php
session_start();
include '../../includes/connection/connection.php';
include '../../includes/header.php';
include './model.php';

if (!isset($_SESSION['current_user']) && !isset($_SESSION['role']) && !isset($_SESSION['gender'])) {
    header("Location: ../../index.php");
    exit();
}

?>

<body>
    <h1>HEELLLLO</h1>
</body>