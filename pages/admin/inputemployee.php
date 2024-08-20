<?php
include '../../includes/connection/connection.php';
include '../../includes/header.php';
include '../../includes/connection/admincontrol.php';

if (!isset($_SESSION['current_user'])) {
  header("Location: ../../index.php");
  exit();
}

$sqlEmployee = "SELECT * FROM admin";
$queryEmployee = $conn->prepare($sqlEmployee);
$queryEmployee->execute();
$rowsEmployee = $queryEmployee->fetchAll(PDO::FETCH_ASSOC);
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
    <section class="px-5 py-6 mr-5 w-[80%] rounded-lg shadow-xl">
      <div class=" w-auto mb-3 flex justify-between">
        <form action="" method="GET" class=" flex items-center">
          <input type="text" name="searchbox" placeholder="Search..." class=" rounded-tl-md rounded-bl-md px-4 py-1 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-amber-400">
          <button type="submit" class=" px-4 py-[4.7px] bg-blue-800 text-slate-100 rounded-tr-md rounded-br-md">
            <i class="fa-solid fa-magnifying-glass"></i>
          </button>
        </form>
        <button id="btnTambahEmployee" class=" px-3 py-[4.7px] text-sm text-white font-semibold rounded-md bg-amber-400 hover:bg-amber-500"><i class="fa-solid fa-plus mr-2"></i>Add User</button>
      </div>
      <table class="text-sm overflow-x-auto table-auto w-full">
        <thead>
          <tr class="border-y-[1.5px] border-y-slate-300">
            <th class=" text-left px-2 py-3">ID</th>
            <th class=" text-left px-2 py-3">Nama</th>
            <th class=" text-left px-2 py-3">Gender</th>
            <th class=" text-left px-2 py-3">Role</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($queryEmployee->rowCount() > 0) : ?>
            <?php foreach ($rowsEmployee as $row) : ?>
              <tr class=" text-slate-600">
                <td class="px-2 py-2"><?= $row['nip'] ?></td>
                <td class="px-2 py-2"><?= $row['admin_name'] ?></td>
                <td class="px-2 py-2"><?= $row['gender'] ?></td>
                <td class="px-2 py-2"><?= $row['role'] ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else : ?>
            <tr>
              <td colspan="12" class="py-2 px-4 text-center text-gray-700">Table Kosong</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
      <div class=" border-b-[1.5px] border-b-slate-300"></div>
    </section>

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