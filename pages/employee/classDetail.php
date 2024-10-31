<?php
session_start();
include '../../includes/connection/connection.php';
include '../../includes/header.php';
include '../component/utils.php';
include '../component/pagination.php';

if (!isset($_SESSION['role']) && !isset($_SESSION['current_user'])) {
  header("Location: ../../index.php");
  exit();
}

include '../../includes/connection/employeeControl.php';

// // [ PARAMS ] get params for class ID
// $_SESSION['current_class'] = isset($_GET['id']) ? $_GET['id'] : null;
// $id_class = $_SESSION['current_class'];


// // [ GET ] Data detail class 
// $queryDetail = $conn->prepare("SELECT class.*, materi.nama_materi FROM class JOIN materi ON class.materi = materi.id_materi WHERE id_class = ?");
// $queryDetail->execute([$id_class]);
// $rowDetail = $queryDetail->fetch(PDO::FETCH_ASSOC);

// $_SESSION['idClass'] = $rowDetail['id_class'];
// $_SESSION['className'] = $rowDetail['nama_kelas'];
// $_SESSION['materiName'] = $rowDetail['nama_materi'];
// $currentID = $_SESSION['idClass'];

// // [ PAGINATION ] Semua murid tblClassDetail
// $limit = 5;
// $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
// $start = ($page > 1) ? ($page * $limit) - $limit : 0;

// $sqlCount = $conn->prepare("SELECT COUNT(*) as total_rows FROM admin WHERE `role` = ?");
// $sqlCount->execute(['student']);
// $total_rows = $sqlCount->fetchColumn();

// $total_pages = ceil($total_rows / $limit);

// $start_row = $start + 1;
// $end_row = min($start + $limit, $total_rows);

// // [ GET ] list semua murid
// $queryStudent = $conn->prepare("SELECT * FROM admin WHERE `role` = :role LIMIT :limit OFFSET :offset");
// $queryStudent->bindValue(':role', 'student', PDO::PARAM_INT);
// $queryStudent->bindValue(':limit', $limit, PDO::PARAM_INT);
// $queryStudent->bindValue(':offset', $start, PDO::PARAM_INT);
// $queryStudent->execute();
// $rowStudent = $queryStudent->fetchAll(PDO::FETCH_ASSOC);


// // [ PAGINATION ] Siswa Kelas Ini
// $this_limit = 5;
// $this_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
// $this_start = ($this_page > 1) ? ($this_page * $this_limit) - $this_limit : 0;

// $sqlCountListed = $conn->prepare("SELECT COUNT(*) as total_listed FROM listed_class WHERE id_kelas = ?");
// $sqlCountListed->execute([$currentID]);
// $totalListed = $sqlCountListed->fetchColumn();

// $this_total_pages = ceil($totalListed / $this_limit);

// $this_start_row = $this_start + 1;
// $this_end_row = min($this_start + $this_limit, $totalListed);

// // [ GET ] Siswa Kelas Ini
// $listedStudent = $conn->prepare("SELECT listed_class.*, `admin`.* FROM listed_class JOIN `admin` ON listed_class.id_murid = admin.id_admin WHERE listed_class.id_kelas = :kelasID LIMIT :limit OFFSET :offset");
// $listedStudent->bindValue(':kelasID', $currentID, PDO::PARAM_INT);
// $listedStudent->bindValue(':limit', $this_limit, PDO::PARAM_INT);
// $listedStudent->bindValue(':offset', $this_start, PDO::PARAM_INT);
// $listedStudent->execute();
// $rowListed = $listedStudent->fetchAll(PDO::FETCH_ASSOC);


// // [ PAGINATION ] Absen Kelas Ini
// $att_limit = 3;
// $att_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
// $att_start = ($att_page > 1) ? ($att_page * $att_limit) - $att_limit : 0;

// $attCount = $conn->prepare("SELECT COUNT(*) as total_attendance FROM attendance WHERE class_id = ?");
// $attCount->execute([$currentID]);
// $attListed = $attCount->fetchColumn(); // Mengambil jumlah attendance yang benar

// $att_total_pages = ceil($attListed / $att_limit);
// $att_start_row = $att_start + 1;
// $att_end_row = min($att_start + $att_limit, $attListed);

// // [ GET ] list absen murid
// $attendanceList = $conn->prepare(
//   "SELECT admin.*, attendance.*,
//   COALESCE(attendance.status, 'absent') as status 
//   FROM listed_class 
//   JOIN admin ON admin.id_admin = listed_class.id_murid 
//   LEFT JOIN attendance ON attendance.student_id = admin.id_admin 
//   AND attendance.class_id = listed_class.id_kelas 
//   WHERE listed_class.id_kelas = :idkelas
//   LIMIT :limit OFFSET :offset"
// );
// $attendanceList->bindValue(':idkelas', $currentID, PDO::PARAM_INT);
// $attendanceList->bindValue(':limit', $att_limit, PDO::PARAM_INT);
// $attendanceList->bindValue(':offset', $att_start, PDO::PARAM_INT);
// $attendanceList->execute();
// $rowAttendance = $attendanceList->fetchAll(PDO::FETCH_ASSOC);


// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//   // [ POST ] Daftarkan murid ke kelas tertentu
//   if (isset($_POST['submitStudent'])) {
//     $class = $_POST['idClass'];
//     $student = $_POST['student'];

//     $queryMember = $conn->prepare("INSERT INTO listed_class (id_kelas, id_murid) VALUES(?, ?)");
//     $queryMember->execute([$class, $student]);

//     header("Location: ./classDetail.php?id=$currentID");
//   }
// }

?>

<body class=" w-full">
  <?php include '../component/navbar.php'; ?>
  <div class=" px-6 min-h-[100vh]">
    <section class=" w-full">
      <section class=" my-3 text-sm text-blue-800 font-light">
        <p>dashboard / kelas</p>
      </section>

      <section class=" text-3xl text-slate-700 font-bold flex justify-between">
        <h1 class="  text-slate-800 font-bold"><?= $_SESSION['className'] ?></h1>
        <h1 class=" text-2xl">Welcome back, <?= $_SESSION['current_user'] ?> !</h1>
      </section>
      <section class=" mb-5 text-xl text-slate-600 font-semibold ">
        <h1 class="font-bold"><?= $_SESSION['materiName'] ?></h1>
        <p class=" text-sm text-amber-500">
          <i class="fa-regular fa-clock mr-2"></i><?= $rowDetail['durasi'] ?> menit
        </p>
        <p class=" text-sm">
          <i class="fa-regular fa-calendar mr-2"></i><?= $rowDetail['tanggal'] ?>
        </p>
      </section>

      <section class=" w-[25%] mt-7 mb-3 grid grid-cols-6 font-semibold text-slate-800">
        <button id="btnClassDetail" class=" border-b-2 border-amber-400 col-span-2 py-3 hover:bg-slate-200 transition duration-100 active-button">Semua Siswa</button>
        <button id="btnAllStudents" class="  border-amber-400 col-span-2 hover:bg-slate-200 transition duration-100"> Siswa</button>
        <button id="btnAttendance" class="  border-amber-400 col-span-2 hover:bg-slate-200 transition duration-100"> Attendance</button>
      </section>

      <!-- [ TABLE ] Daftar semua siswa -->
      <div id="tableClassDetail" class=" w-[80%] px-3 py-3 rounded-md shadow-lg hidden">
        <?php include './tables/tblClassDetail.php'; ?>
      </div>

      <!-- [ TABLE ] Daftar siswa kelas ini -->
      <div id="tableAllStudents" class=" w-[80%] px-3 py-3 rounded-md shadow-lg hidden">
        <?php include './tables/tblAllStudent.php'; ?>
      </div>

      <!-- [ TABLE ] Daftar presensi -->
      <div id="tableAttendance" class=" w-[60%] px-3 py-3 mb-5 rounded-md shadow-lg hidden">
        <?php include './tables/tblAttendance.php'; ?>
      </div>

    </section>
  </div>
  <script>

    // [ SET ] All Button
    const btnClassDetail = document.getElementById('btnClassDetail');
    const btnAllStudents = document.getElementById('btnAllStudents');
    const btnAttendance = document.getElementById('btnAttendance');
    const tableClassDetail = document.getElementById('tableClassDetail');
    const tableAllStudents = document.getElementById('tableAllStudents');
    const tableClassAttendance = document.getElementById('tableAttendance');

    // [ REMOVE ] Active-Button effect
    function removeActiveClasses() {
      btnClassDetail.classList.remove('border-b-2', 'active-btn');
      btnAllStudents.classList.remove('border-b-2', 'active-btn');
      btnAttendance.classList.remove('border-b-2', 'active-btn');
    }

    // [ SHOW ] Table sesuai button
    function showTable(param) {
      removeActiveClasses();

      if (param === '2') {
        tableAllStudents.classList.remove('hidden');
        tableClassDetail.classList.add('hidden');
        tableClassAttendance.classList.add('hidden');
        btnAllStudents.classList.add('border-b-2', 'active-btn'); // [ ADD ] Active-Table effect
      } else if (param === '3') {
        tableClassAttendance.classList.remove('hidden');
        tableAllStudents.classList.add('hidden');
        tableClassDetail.classList.add('hidden');
        btnAttendance.classList.add('border-b-2', 'active-btn'); // [ ADD ] Active-Table effect
      } else {
        // [ SET ] Default display ke tableClassDetail
        tableClassDetail.classList.remove('hidden');
        tableAllStudents.classList.add('hidden');
        tableClassAttendance.classList.add('hidden');
        btnClassDetail.classList.add('border-b-2', 'active-btn'); // [ ADD ] Active-Table effect
      }
    }

    // Event listener button
    btnClassDetail.addEventListener('click', () => {
      showTable('1'); // '1' untuk tabel detail kelas
    });

    btnAllStudents.addEventListener('click', () => {
      showTable('2'); // '2' untuk tabel semua siswa
    });

    btnAttendance.addEventListener('click', () => {
      showTable('3'); // '3' untuk tabel attendance
    });

    // [ GET ] parameter table yang sesuai
    window.onload = function() {
      const urlParams = new URLSearchParams(window.location.search);
      const tableParam = urlParams.get('table');
      showTable(tableParam || '1'); // Jika tidak ada parameter, default ke '1'
    };
  </script>
</body>
<div class=" w-full">
  <?php include '../../includes/footer.php'; ?>
</div>