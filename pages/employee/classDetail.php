<?php
session_start();
include '../../includes/connection/connection.php';
include '../component/pagination.php';

if (!isset($_SESSION['role']) && !isset($_SESSION['current_user'])) {
  header("Location: ../../index.php");
  exit();
}

// [ PARAMS ] get params for class ID
$_SESSION['current_class'] = isset($_GET['id']) ? $_GET['id'] : null;
$id_class = $_SESSION['current_class'];


// [ GET ] Data detail class 
$queryDetail = $conn->prepare("SELECT class.*, materi.nama_materi FROM class JOIN materi ON class.materi = materi.id_materi WHERE id_class = ?");
$queryDetail->execute([$id_class]);
$rowDetail = $queryDetail->fetch(PDO::FETCH_ASSOC);

$_SESSION['className'] = $rowDetail['nama_kelas'];
$_SESSION['materiName'] = $rowDetail['nama_materi'];
$_SESSION['idClass'] = $rowDetail['id_class'];
$currentID = $_SESSION['idClass'];

// [ GET ] list murid
$queryStudent = $conn->prepare("SELECT * FROM admin WHERE `role` = ?");
$queryStudent->execute(['student']);
$rowStudent = $queryStudent->fetchAll(PDO::FETCH_ASSOC);

if($_SERVER['REQUEST_METHOD'] === 'POST'){
  // [ POST ] Daftarkan murid ke kelas tertentu
  if(isset($_POST['submitStudent'])){
    $class = $_POST['idClass'];
    $student = $_POST['student'];

    $queryMember = $conn->prepare("INSERT INTO listed_class (id_kelas, id_murid) VALUES(?, ?)");
    $queryMember->execute([$class, $student]);

    header("Location: ./classDetail.php?id=$currentID");
  }
}

// [ PAGINATION ] 
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page > 1) ? ($page * $limit) - $limit : 0;

$sqlCount = $conn->prepare("SELECT COUNT(*) as total_rows FROM admin WHERE `role` = ?");
$sqlCount->execute(['student']);
$total_rows = $sqlCount->fetchColumn();

$total_pages = ceil($total_rows / $limit);

$start_row = $start + 1;
$end_row = min($start + $limit, $total_rows);


?>

<body class=" w-full">
  <?php include '../component/navbar.php'; ?>
  <div class=" px-6 h-[100vh]">
    <section class=" w-full">
      <section class=" my-3 text-sm text-blue-800 font-light">
        <p>dashboard / kelas</p>
      </section>
      <section class=" text-3xl text-slate-700 font-bold flex justify-between">
        <h1 class="  text-slate-800 font-bold"><?=$_SESSION['className']?></h1>
        <h1 class=" text-2xl">Welcome back, <?= $_SESSION['current_user'] ?> !</h1>
      </section>
      <section class=" mb-3 text-xl text-slate-600 font-bold ">
        <h1 class="font-bold"><?=$_SESSION['materiName']?></h1>
        <h1 class=" text-sm font-bold"><?=$_SESSION['idClass']?></h1>
      </section>

      <!-- [ TABLE ] -->
      <div class=" w-[80%] px-3 py-3 rounded-md shadow-lg">
        <?php include './tables/tblClassDetail.php'; ?>
      </div>

    </section>
  </div>
</body>