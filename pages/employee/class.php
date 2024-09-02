<?php
session_start();
include '../../includes/connection/connection.php';
include '../../includes/header.php';

if (!isset($_SESSION['role']) && !isset($_SESSION['current_user'])) {
  header("Location: ../../index.php");
  exit();
}

// [ PAGINATION ]
$limit = 10; // Jumlah data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Halaman saat ini
$start = ($page > 1) ? ($page * $limit) - $limit : 0; // Hitung offset

$queryClass = $conn->prepare("SELECT class.*, materi.nama_materi FROM class JOIN materi ON class.materi = materi.id_materi WHERE pengajar = ?");
$queryClass->execute([$_SESSION['userID']]);
$rowClass = $queryClass->fetchAll(PDO::FETCH_ASSOC);

$sqlCount = $conn->prepare("SELECT COUNT(*) as total FROM class WHERE pengajar = ?");
$sqlCount->execute([$_SESSION['userID']]);
$total_rows = $sqlCount->fetchColumn();

$total_pages = ceil($total_rows / $limit);

// [GET] Mulai dan akhir baris yang ditampilkan
$start_row = $start + 1;
$end_row = min($start + $limit, $total_rows);

?>

<body class=" w-full">
  <?php include '../component/navbar.php'; ?>
  <div class=" px-6 h-[100vh]">
    <section class=" w-full">
      <section class=" mt-3 text-sm text-blue-800 font-light">
        <p>dashboard / kelas</p>
      </section>
      <section class=" mb-3 text-3xl text-slate-700 font-bold flex justify-between">
        <h1 class="  text-slate-800 font-bold">Daftar Kelas</h1>
        <h1 class=" text-2xl">Welcome back, <?= $_SESSION['current_user'] ?> !</h1>
      </section>

      <!-- [ TABLE ] -->
      <div class=" w-full px-3 py-3 rounded-md shadow-lg">
        <?php include './tables/tblClass.php';?>
      </div>
      
    </section>
  </div>
</body>
<div class=" w-full">
  <?php include '../../includes/footer.php'; ?>
</div>