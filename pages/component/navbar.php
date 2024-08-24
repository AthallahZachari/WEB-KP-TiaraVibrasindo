<?php
include '../../includes/header.php';

$path = "";

if (!isset($_SESSION['current_user']) && !isset($_SESSION['role'])) {
  header("Location: ../../index.php");
  exit();
}

// $_SESSION['role'] == 'admin' ? $path = "admin" : $path = "employee" ;

if ($_SESSION['role'] == 'admin') {
  $path = "admin";
} elseif ($_SESSION['role'] == 'employee') {
  $path = "employee";
} else {
  $path = "student";
}

?>
<section class=" w-full h-200px text-slate-800 sticky top-0 m-auto bg-glass-bg backdrop-blur-lg shadow-lg">
  <nav class=" px-6 py-2 flex justify-between items-center">
    <div class=" flex items-center">
      <div class=" w-[80px] h-[47px] mr-3 bg-cover bg-center">
        <img src="../../assets/Logo.jpg" alt="logo-tiara" class=" w-full object-cover">
      </div>
      <h1 class=" text-2xl font-bold">TIARA VIBRASINDO</h1>
    </div>
    <ul class=" w-[20%] flex justify-between ">
      <li>
        <a href="../<?= $_SESSION['role']?>/<?=$_SESSION['role']?>.php" class=" hover:font-semibold">Home</a>
      </li>
      <li>
        <a href="../<?= $_SESSION['role']?>/class.php" class=" hover:font-semibold">Class</a>
      </li>
      <li>
        <a href="../<?=$_SESSION['role']?>/profile.php" class=" hover:font-semibold">Profile</a>
      </li>
      <li>
        <a href="../../includes/connection/logout.php" class=" px-3 py-2 border border-slate-400 rounded-md hover:bg-slate-100">
          <i class="fa-solid fa-arrow-right-from-bracket"></i>
        </a>
      </li>
    </ul>
  </nav>
</section>