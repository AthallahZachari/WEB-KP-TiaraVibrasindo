<?php
session_start();
include '../../includes/connection/connection.php';
include '../../includes/header.php';

if (!isset($_SESSION['current_user']) && !isset($_SESSION['role']) && !isset($_SESSION['gender'])) {
  header("Location: ../../index.php");
  exit();
}
?>

<body>
  <?php include '../component/navbar.php'; ?>
  <div class=" px-6">
    <h1 class="text-3xl text-slate-800 font-bold my-3">Welcome back, <?= $_SESSION['current_user']?> !</h1>
    <section class=" flex space-x-2">
      <div class=" w-[300px] px-4 py-3 rounded-md shadow-md">
        <a href="" class=" text-2xl text-slate-800 font-bold ">Lihat Kelas <i class=" fa-solid fa-arrow-right-long ml-2 hover:translate-x-1 "></i></a>
        <p class=" text-slate-600">Cek daftar kelas yang tersedia untukmu</p>
      </div>
      <div class=" w-[300px] px-4 py-3 rounded-md shadow-md">
        <a href="" class=" text-2xl text-slate-800 font-bold ">Daftar Murid <i class=" fa-solid fa-arrow-right-long ml-2 hover:translate-x-1 "></i></a>
        <p class=" text-slate-600">Cek daftar murid yang mengikuti kelas</p>
      </div>
    </section>
  </div>
</body>