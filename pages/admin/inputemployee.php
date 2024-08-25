<?php
include '../../includes/connection/connection.php';
include '../../includes/header.php';
include '../../includes/connection/admincontrol.php';

if (!isset($_SESSION['current_user'])) {
  header("Location: ../../index.php");
  exit();
}

// [ PAGINATION ] 
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Halaman saat ini
$start = ($page > 1) ? ($page * $limit) - $limit : 0; // Hitung offset

$sqlEmployee = "SELECT * FROM admin";
$queryEmployee = $conn->prepare($sqlEmployee);
$queryEmployee->execute();
$rowsEmployee = $queryEmployee->fetchAll(PDO::FETCH_ASSOC);

// [ GET ] Total rows (pagination)
$sqlCount = "SELECT COUNT(*) as total FROM admin";

$queryCount = $conn->prepare($sqlCount);
$queryCount->execute();
$total_rows = $queryCount->fetchColumn();

$total_pages = ceil($total_rows / $limit);

$start_row = $start + 1;
$end_row = min($start + $limit, $total_rows);

?>

<body class="min-h-screen w-full">
  <?php include '../component/navbar.php'; ?>
  <div class=" px-6">
    <section class=" mt-3 text-sm text-blue-800 font-light">
      <p>dashboard / inputUser</p>
    </section>
    <section class=" mb-3 text-3xl text-slate-700 font-bold flex justify-between">
      <h1 class="  text-slate-800 font-bold">Dashboard</h1>
      <h1 class=" text-2xl">Welcome back, <?= $_SESSION['current_user'] ?> !</h1>
    </section>
  </div>
  <div class=" w-full flex px-6 mb-5">
    <?php include './tables/tblemployee.php';?>

    <section id="formAddEmployee" class="w-[40%] rounded-md ">
      <div class="w-full px-5 py-2 shadow-xl rounded-md ">
        <div class="py-3 border-b-[1.5px] border-b-slate-800">
          <h1 class="text-3xl text-slate-800 font-bold">Input Nama Baru</h1>
        </div>
        <form action="inputmateri.php" method="post" class="my-5 flex flex-col">
          <input type="text" name="nama_employee" id="inputNamaEmployee" placeholder="Nama..." class="rounded-md px-4 py-2 mb-4 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-amber-400">
          <input type="text" name="nip" id="inputNIP" placeholder="NIP..." class="rounded-md px-4 py-2 mb-4 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-amber-400">

          <section class="flex justify-between">
            <a href="" class="w-[45%] text-center text-lg font-semibold px-8 py-3 border border-slate-300 rounded-md hover:bg-slate-100 transition-all duration-300">
              Cancel
            </a>
            <button type="submit" name="submitNama" class="w-[45%] bg-blue-800 hover:bg-blue-900 text-white text-lg font-semibold px-8 py-3 rounded-md transition-all duration-300">
              Submit
            </button>
          </section>
        </form>
      </div>
    </section>
  </div>

</body>
<div class=" w-full">
  <?php include '../../includes/footer.php'; ?>
</div>