<?php
session_start();
include '../../includes/connection/connection.php';
include '../../includes/header.php';

if (!isset($_SESSION['current_user']) && !isset($_SESSION['role']) && !isset($_SESSION['gender'])) {
  header("Location: ../../index.php");
  exit();
}

$classList = $conn->prepare("SELECT class.*, materi.nama_materi FROM class JOIN materi ON class.materi = materi.id_materi WHERE pengajar = ?");
$classList->execute([$_SESSION['userID']]);
$rowClass = $classList->fetchAll(PDO::FETCH_ASSOC);
?>

<body>
  <?php include '../component/navbar.php'; ?>
  <div class=" px-6">
    <h1 class="text-3xl text-slate-800 font-bold my-3">Welcome back, <?= $_SESSION['current_user'] ?> !</h1>
    <section class=" flex space-x-3">

      <?php foreach ($rowClass as $row): ?>
        <div class=" w-[350px] px-4 py-3 rounded-md shadow-md ">
          <a href="./classDetail.php?id=<?=$row['id_class']?>" class="block text-2xl text-blue-800 font-bold hover:cursor-pointer hover:underline transition duration-200">
            <?=$row['nama_kelas']?>
          </a>
          <p class=" text-slate-600"><?=$row['nama_materi']?></p>
          <section class=" flex justify-between items-end h-[50px]">
            <p class=" font-semibold"><?= $_SESSION['current_user']?></p>
            <p class=" text-amber-500"><i class="fa-regular fa-clock mr-2"></i><?=$row['durasi']?> menit</p>
          </section>
        </div>
      <?php endforeach; ?>

    </section>
  </div>
</body>