<?php
include '../../includes/connection/connection.php';
include '../../includes/header.php';
include '../component/utils.php';
include '../component/pagination.php';
session_start();

if (!isset($_SESSION['current_user'])) {
  header("Location: ../../index.php");
  exit();
}

// [ PAGINATION ] 
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Halaman saat ini
$start = ($page > 1) ? ($page * $limit) - $limit : 0; // Hitung offset

$searchbox = isset($_GET['searchbox']) ? $_GET['searchbox'] : '';

// [ GET ] All User List
$sqlEmployee = "SELECT * FROM admin WHERE admin_name LIKE :searchbox LIMIT :limit OFFSET :offset ";
$queryEmployee = $conn->prepare($sqlEmployee);
$queryEmployee->bindValue(':searchbox', '%' . $searchbox . '%', PDO::PARAM_STR);
$queryEmployee->bindValue(':limit', $limit, PDO::PARAM_INT);
$queryEmployee->bindValue(':offset', $start, PDO::PARAM_INT);
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


if($_SERVER['REQUEST_METHOD'] === 'POST'){
  // [ POST ] New Employee/User
  if(isset($_POST['submitNewClass'])){
    $insertEmployee = $conn->prepare("INSERT INTO `admin` (`admin_name`, `nip`, `password`, `gender`, `role`) VALUES (?, ?, ?, ?, ?)");
    $insertEmployee->execute([$_POST['nama'], $_POST['nip'], $_POST['password'], $_POST['jenis_kelamin'], $_POST['role']]);
    
    if($insertEmployee->rowCount() > 0){
      $_SESSION['popupMessage'] = "Berhasil Menambahkan Pengguna !";
      header("Location: ./inputemployee.php");
      exit();
    }
  }

  // [ UPDATE ] Edit Data User
  if(isset($_POST['submitEditUser'])){
    $editEmployee = $conn->prepare(("UPDATE `admin` SET `admin_name` = ?, `nip` = ?, `password` = ?, `gender` = ?, `role` = ? WHERE id_admin = ?"));
    $editEmployee->execute([
      $_POST['edit_name'],
      $_POST['edit_nip'],
      $_POST['edit_password'],
      $_POST['edit_gender'],
      $_POST['edit_role'],
      $_POST['id_admin']
    ]);

    if($editEmployee->rowCount() > 0){
      $_SESSION['popupMessage'] = "Berhasil Mengupdate Data Pengguna !";
      header('Location: ./inputemployee.php');
      exit();
    }
  }
}

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

  <!-- [ TABLE ] data table user -->
  <div class=" w-[90%] flex px-6 mb-5">
    <?php include './tables/tblemployee.php'; ?>
  </div>

  <!-- [ FORM ] Add User baru -->
  <section id="formAddEmployee" class="hidden fixed inset-0 z-20 flex items-center justify-center bg-black bg-opacity-50">
    <?php include './forms/addEmployee.php'; ?>
  </section>

</body>

<div class=" w-full">
  <?php include '../../includes/footer.php'; ?>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    
    // [ BUTTONS ] button group
    const btnAddNew = document.getElementById('btnTambahEmployee');
    const btnCancel = document.getElementById('btnCancel');

    // [ TARGET ] target object
    const formAddNew = document.getElementById('formAddEmployee');

    btnAddNew.addEventListener('click', function() {
      formAddNew.classList.toggle('hidden');
    })

    btnCancel.addEventListener('click', function() {
      formAddNew.classList.toggle('hidden');
    })
  })
</script>