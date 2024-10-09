<?php
session_start();
include '../../includes/connection/connection.php';
include '../../includes/header.php';

if (!isset($_SESSION['current_user']) && !isset($_SESSION['role']) && !isset($_SESSION['gender'])) {
  header("Location: ../../index.php");
  exit();
}

$classList = $conn->prepare("
  SELECT
    listed_class.*, 
    class.*,
    admin.*,
    materi.*  
  FROM listed_class 
  INNER JOIN class ON class.id_class = listed_class.id_kelas
  INNER JOIN admin ON admin.id_admin = class.pengajar
  INNER JOIN materi ON materi.id_materi = class.materi
  WHERE listed_class.id_murid = ?");
$classList->execute([$_SESSION['userID']]);


?>

<body class=" bg-[url('../../assets/background.jpg')] bg-cover bg-center">
  <?php include '../component/navbar.php'; ?>
  <div class=" h-[90vh] px-6">
    <section class="text-3xl text-slate-800 font-bold">
      <h1 class=" my-3">Welcome back, <?= $_SESSION['current_user'] ?> !</h1>
      <h1 class=" text-2xl mb-2 underline">Daftar Kelas</h1>
    </section>

    <section class=" flex flex-wrap gap-x-4 gap-y-4">
      <?php foreach ($classList as $index => $list): ?>
        <div class=" min-w-[300px] px-4 py-3 bg-white rounded-md shadow-md">
          <a href="./class.php?id=<?=$list['id_class']?>" class=" text-2xl text-blue-800 font-bold hover:underline">
            <?= $list['nama_kelas'] ?>
          </a>
          <h1><?= $list['nama_materi']?></h1>
          <section class=" flex justify-between mt-3">
            <h2 class=" font-bold"><i class="fa-solid fa-user mr-2"></i><?= $list['admin_name']?></h2>
            <p class=" text-amber-500"><i class="fa-regular fa-clock mr-2"></i><?= $list['durasi'] ?> menit</p>
          </section>
        </div>
      <?php endforeach; ?>
    </section>

  </div>
</body>
<div class=" w-full">
  <?php include '../../includes/footer.php'; ?>
</div>