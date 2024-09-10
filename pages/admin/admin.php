<?php
session_start();
include '../../includes/connection/connection.php';
include '../../includes/header.php';

if (!isset($_SESSION['current_user']) && $_SESSION['role'] != 'admin') {
  header("Location: ../../index.php");
  exit();
}

?>

<body class=" w-full ">
  <?php include '../component/navbar.php'; ?>
  <div class=" px-6 min-h-screen">
    <section class=" mt-3 text-sm text-blue-800 font-light">
      <p>dashboard /</p>
    </section>
    <section class=" text-3xl text-slate-700 font-bold flex justify-between">
      <h1 class="  text-slate-800 font-bold">Dashboard</h1>
      <h1 class=" text-2xl">Welcome back, <?= $_SESSION['current_user'] ?> !</h1>
    </section>
    <section class=" flex py-3">
      <div class=" px-5 py-3 w-[300px] mr-3 border border-slate-300 rounded-md hover:bg-slate-100 hover:cursor-pointer">
        <a href="./inputmateri.php" class=" text-2xl font-semibold mb-2">Daftar Materi <i class=" fa-solid fa-arrow-right-long ml-2 hover:translate-x-1 "></i></a>
        <p class=" text-slate-600">Input Materi kursus</p>
      </div>
      <div class=" px-5 py-3 w-[300px] mr-3 border border-slate-300 rounded-md hover:bg-slate-100 hover:cursor-pointer">
        <a href="./inputemployee.php" class=" text-2xl font-semibold mb-2">Daftar Pengguna<i class=" fa-solid fa-arrow-right-long ml-2 hover:translate-x-1 "></i></a>
        <p class=" text-slate-600">Input Karyawan dan Trainee</p>
      </div>
      <div class=" px-5 py-3 w-[300px] mr-3 border border-slate-300 rounded-md hover:bg-slate-100 hover:cursor-pointer">
        <h3 class=" text-2xl font-semibold mb-2">Input Materi <i class=" fa-solid fa-arrow-right-long ml-2 hover:translate-x-1 "></i></h3>
        <p class=" text-slate-600">Input Materi ini deksripsi dari ini materi input</p>
      </div>
    </section>
  </div>
</body>
<section>
  <?php include '../../includes/footer.php';?>
</section>