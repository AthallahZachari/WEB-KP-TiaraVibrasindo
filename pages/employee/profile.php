<?php
session_start();
include '../../includes/connection/connection.php';
include '../../includes/header.php';

if (!isset($_SESSION['current_user']) && !isset($_SESSION['role'])) {
  header("Location: ../../index.php");
  exit();
}


$sqlCount = "SELECT COUNT(*) as total FROM class WHERE pengajar = :userID";

$queryCount = $conn->prepare($sqlCount);
$queryCount->bindParam(":userID", $_SESSION['userID'], PDO::PARAM_INT);
$queryCount->execute();

$classCount = $queryCount->fetchColumn();

$_SESSION['gender'] == 'pria' ? $icon = "fa-mars text-blue-500" : $icon = "fa-venus text-pink-400";
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  if (isset($_POST['submitEditPassword'])) {

    $updatePassword = $conn->prepare("UPDATE admin SET `password` = ? WHERE `id_admin` = ?");
    $updatePassword->execute([$_POST['reEnterPassword'], $_SESSION['userID']]);

    $updatePassword->rowCount() > 0 ? $_SESSION['message'] = "Update berhasil!" : $_SESSION['message'] = "Update gagal!";;

    header('Location: ./profile.php');
    exit();
  }
}

if (isset($_SESSION['message'])) {
  $message = $_SESSION['message'];
  unset($_SESSION['message']);
}
?>

<body class=" bg-[url('../../assets/background.jpg')] bg-cover bg-center">
  <?php include '../component/navbar.php'; ?>
  <div class="min-h-[90vh] flex flex-col">
    <section class=" w-[50%] mx-auto mt-16 px-6 py-6 bg-white rounded-md shadow-md flex flex-col space-y-7 items-center">
      <section class="flex flex-col items-center">

        <div class=" bg-slate-200 w-16 h-16 mb-3 rounded-[50%] flex justify-center items-center">
          <i class="fa-solid fa-user text-3xl"></i>
        </div>
        <h1 class=" text-2xl font-semibold"><?= $_SESSION['current_user'] ?></h1>

        <div class="grid grid-cols-3 my-2">
          <div class=" text-center">
            <p class=" text-slate-700 "><?= $_SESSION['nip'] ?></p>
          </div>
          <div class=" px-5 text-center border-l-[2px] border-slate-600">
            <p><?= $_SESSION['role'] ?></p>
          </div>
          <div class=" px-5 border-l-[2px] border-slate-600">
            <p><i class="fa-solid <?= $icon ?> text-xl"></i></p>
          </div>
        </div>

        <div class=" mt-2">
          <button id="btnEditProfile" class=" px-4 py-2 bg-amber-400 hover:bg-amber-500 text-sm rounded-md "><i class="fa-solid fa-gear mr-3"></i>Edit</button>
        </div>

      </section>
      <section class=" w-full flex space-x-3">
        <div class=" px-3 py-3 w-1/3 h-[15vh] rounded-md border border-slate-300">
          <h1>Kelas Diampu</h1>
        </div>
        <div class=" px-3 py-3 w-1/3 rounded-md border border-slate-300">
          <h1>Kelas Jumlah</h1>
        </div>
        <div class=" px-3 py-3 w-1/3 rounded-md border border-slate-300">
          <h1>Kelas Diampu</h1>
        </div>

      </section>
    </section>

    <section id="formEditPassword" class=" hidden fixed inset-0 z-20 flex items-center justify-center bg-black bg-opacity-50">
      <div class=" bg-white rounded-md w-[40%] px-6 py-5">
        <div class=" flex items-center  border-b-[1.5px] border-b-slate-500 mb-5 ">
          <div class=" w-[60px] h-[60px] mr-4 border border-slate-800 bg-slate-200 rounded-[50%] flex justify-center items-center">
            <i class="fa-solid fa-user text-2xl"></i>
          </div>
          <div class="py-3">
            <h1 class="text-3xl text-slate-800 font-semibold"><?= $_SESSION['current_user'] ?><i class="fa-solid <?= $icon ?> text-2xl ml-3"></i></h1>
            <p class=" text-md"><?= $_SESSION['role'] ?></p>
          </div>
        </div>
        <form action="" method="POST" class="grid grid-cols-3 gap-2">
          <input type="hidden" name="resetID" value="<?= $_SESSION['userID'] ?>">
          <label for="Old Password" class=" px-1 text-sm font-medium text-slate-800">Old Password</label>
          <input type="text" name="currentPassword" id="" placeholder="Current Password..." class=" col-span-2 rounded-md px-4 py-2 mb-3 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-amber-400">

          <label for="New Password" class=" px-1 text-sm font-medium text-slate-800">New Password</label>
          <input type="text" name="newPassword" id="" placeholder="New Password..." class="col-span-2 rounded-md px-4 py-2 mb-3 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-amber-400">

          <label for="reEnterPassword" class=" px-1 text-sm font-medium text-slate-800">Re - enter Password</label>
          <input required type="text" name="reEnterPassword" id="" placeholder="Re - enter Password..." class="col-span-2 rounded-md px-4 py-2 mb-3 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-amber-400">

          <button type="button" id="btnCancelEdit" class="px-3 py-3 my-3 col-start-1 col-end-2 border border-slate-400 rounded-md hover:bg-slate-200">Cancel</button>
          <button type="submit" name="submitEditPassword" class="px-3 py-3 my-3 col-start-2 col-end-4 bg-blue-700 rounded-md ">Reset</button>
        </form>
      </div>
    </section>

  </div>
  <div id="toaster" class="hidden fixed flex items-center bottom-4 right-4 px-4 py-3 bg-slate-700 rounded-md shadow-md border-l-[15px] border-l-green-500">
    <h1 class=" text-2xl text-green-500 mr-3">
      <i class="fa-solid fa-circle-exclamation"></i>
    </h1>
    <p class=" text-slate-100 font-semibold">
      <?= $message ?>
    </p>
  </div>
</body>
<div class=" w-full">
  <?php include '../../includes/footer.php'; ?>
</div>
<script>
  document.getElementById('btnEditProfile').addEventListener('click', () => {
    document.getElementById('formEditPassword').classList.toggle('hidden');
  });

  document.getElementById('btnCancelEdit').addEventListener('click', () => {
    document.getElementById('formEditPassword').classList.toggle('hidden');
  });

  const message = "<?= $message ?>";
  if (message) {
    const toaster = document.getElementById('toaster');
    toaster.classList.remove('hidden');

    // Hide the toaster after 3 seconds
    setTimeout(function() {
      toaster.classList.add('hidden');
      message = "";
    }, 2500);
  }
</script>