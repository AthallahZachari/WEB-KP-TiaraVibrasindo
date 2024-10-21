<?php
session_start();
include '../../includes/connection/connection.php';
include '../component/pagination.php';
include './model.php';
// require_once './model.php';

if (!isset($_SESSION['role']) && !isset($_SESSION['current_user'])) {
  header("Location: ../../index.php");
  exit();
}

// [ PARAMS ] get id for class info
$classID = isset($_GET['id']) ? $_GET['id'] : null;

$query = $conn->prepare("
  SELECT
    listed_class.*, 
    class.*,
    admin.*,
    materi.*  
  FROM listed_class 
  INNER JOIN class ON class.id_class = listed_class.id_kelas
  INNER JOIN admin ON admin.id_admin = class.pengajar
  INNER JOIN materi ON materi.id_materi = class.materi
  WHERE class.id_class = ?  
");
$query->execute([$classID]);
$rowDetail = $query->fetch(PDO::FETCH_ASSOC);

$classDetail = new detailClass($rowDetail);

$_SESSION['classDetail'] = [
  'IDkelas' => $classDetail->ID,
  'kelas' => $classDetail->nama,
  'materi' => $classDetail->materi,
  'durasi' => $classDetail->durasi,
]

?>

<body class=" w-full">
  <?php include '../component/navbar.php'; ?>
  <div class=" px-6 h-[100vh]">
    <h1>Selamat Datang di Kelas <?= $_SESSION['classDetail']['kelas']?></h1>
  </div>
</body>