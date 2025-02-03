<?php
session_start();
include '../../includes/connection/connection.php';
include '../../includes/model.php';
include '../component/utils.php';
include '../component/pagination.php';

if (!isset($_SESSION['role']) && !isset($_SESSION['current_user'])) {
  header("Location: ../../index.php");
  exit();
}

// [ PARAMS ] get id for class info
$classID = isset($_GET['id']) ? $_GET['id'] : null;

// [ GET ] DETAIL KELAS
$query = $conn->prepare("
  SELECT
    listed_class.*, 
    class.*,
    admin.*,
    materi.*  
  FROM listed_class 
  INNER JOIN class ON class.id_class = listed_class.id_kelas
  INNER JOIN admin ON admin.id_admin = class.pengajar
  INNER JOIN materi ON materi.id_materi = class.materi
  WHERE class.id_class = ?  
");
$query->execute([$classID]);
$rowDetail = $query->fetch(PDO::FETCH_ASSOC);

// [ GET ] ATTENDANCE DETAIL
$attendanceList = $conn->prepare("
  SELECT * FROM attendance WHERE student_id = ? AND class_id = ?
");
$attendanceList->execute([$_SESSION['userID'], $classID]);
$attendanceRow = $attendanceList->fetch(PDO::FETCH_ASSOC);

$classDetail = new detailClass($rowDetail);
$attendanceDetail = new detailAttendance($attendanceRow);

// [ GET ] CLASS DETAIL
$_SESSION['classDetail'] = [
  'IDkelas' => $classDetail->ID,
  'kelas' => $classDetail->nama,
  'pengajar' => $classDetail->pengajar,
  'materi' => $classDetail->materi,
  'durasi' => $classDetail->durasi,
  'ruangan' => $classDetail->ruangan,
  'mulai' => $classDetail->mulai
];

$_SESSION['attendanceDetail'] = [
  'attendanceID' => $attendanceDetail->IDkelas,
  'status' => $attendanceDetail->status,
];
// [ SET ] status background 
$_SESSION['attendanceDetail']['status'] == NULL ? $_SESSION['attendanceDetail']['status'] = 'absent' : $_SESSION['attendanceDetail']['status'];  

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnCheckAttendance'])) {
  $userID = $_POST['userID'] ?? null;
  $classID = $_POST['classID'] ?? null;

  if (!$userID || !$classID) {
    die("Error: Data tidak valid.");
  }

  // Cek apakah peserta sudah absen
  $checkAttendance = $conn->prepare("
      SELECT attendance_id FROM attendance WHERE student_id = ? AND class_id = ?
  ");
  $checkAttendance->execute([$userID, $classID]);
  $attendanceRow = $checkAttendance->fetch(PDO::FETCH_ASSOC);

  if ($attendanceRow) {
    // Jika sudah ada, update status
    $updateAttendance = $conn->prepare("
          UPDATE attendance SET status = 'present', time = CURRENT_TIMESTAMP WHERE attendance_id = ?
      ");
    $updateAttendance->execute([$attendanceRow['attendance_id']]);
  } else {
    // Jika belum, insert data baru
    $insertAttendance = $conn->prepare("
          INSERT INTO attendance (student_id, class_id, status, time, created_at) 
          VALUES (?, ?, 'present', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)
      ");
    $insertAttendance->execute([$userID, $classID]);
  }

  // Redirect kembali ke halaman kelas
  header("Location: class.php?id=" . urlencode($classID));
  exit();
}


?>

<body class=" w-full">
  <?php include '../component/navbar.php'; ?>
  <div class=" px-6 h-[100vh]">
    <h1 class=" my-3 text-3xl text-slate-800 font-bold">Welcome back, <?= $_SESSION['current_user'] ?>!</h1>
    <section class=" flex justify-center items-center w-full h-3/4">
      <div class=" w-[60%] p-3 bg-slate-50 rounded-lg shadow-lg">
        <div class=" flex justify-between">
          <h1 class=" text-3xl text-blue-800 font-bold hover:underline"><?= $_SESSION['classDetail']['kelas'] ?></h1>
          <section class=" flex flex-col items-end">
            <h2 class=" font-bold"><i class="fa-solid fa-user text-sm mr-2"></i><?= $_SESSION['classDetail']['pengajar'] ?></h2>
            <p class=" text-amber-500"><i class="fa-regular fa-clock mr-2"></i><?= $_SESSION['classDetail']['durasi'] ?> menit</p>
          </section>
        </div>
        <h1 class=" mt-5 mb-2 font-semibold text-slate-500">Attendance</h1>
        <table class="text-sm overflow-x-auto table-auto w-full">
          <thead>
            <tr class="border-y-[1.5px] border-y-slate-300 text-slate-800 text-left">
              <th class=" py-2 px-2">Ruangan</th>
              <th class=" py-2 px-2">Durasi</th>
              <th class=" py-2 px-2 w-[150px]">Waktu Mulai</th>
              <th class=" py-2 px-2">Status</th>
              <th class=" py-2 px-2 w-[50px] text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr class=" text-gray-700">
              <td class=" p-2"><?= $_SESSION['classDetail']['ruangan'] ?></td>
              <td class=" p-2"><?= $_SESSION['classDetail']['durasi'] ?> menit</td>
              <td class=" p-2 "><?= $_SESSION['classDetail']['mulai'] ?></td>
              <td>
                <p class=" p-2 rounded-lg <?= Utils::bgAttendance($_SESSION['attendanceDetail']['status']) ?>">
                  <?= $_SESSION['attendanceDetail']['status'] ?>
                </p>
              </td>
              <td class=" px-2 pt-3 text-right">
                <form action="class.php" method="post">
                  <input type="hidden" name="userID" value="<?= $_SESSION['userID'] ?>">
                  <input type="hidden" name="classID" value="<?= $_SESSION['classDetail']['IDkelas'] ?>">
                  <button type="submit" name="btnCheckAttendance" class=" bg-green-600 px-3 py-2 rounded-lg text-slate-100 font-semibold shadow-lg hover:bg-green-700 transition-all duration-300">Check</button>
                </form>
              </td>
            </tr>
          </tbody>
        </table>
        <div class=" border-b-[1.5px] border-b-slate-300  mb-3"></div>
        <section>
          <a href="./student.php">
            <button class=" px-3 py-2 rounded-lg bg-blue-800 text-amber-400 font-semibold shadow-lg hover:bg-blue-900 transition-all duration-300">
              <i class="fa-solid fa-chevron-left mr-3"></i>Kembali
            </button>
          </a>
        </section>
      </div>
    </section>
  </div>
</body>
<div class=" w-full">
  <?php include '../../includes/footer.php'; ?>
</div>