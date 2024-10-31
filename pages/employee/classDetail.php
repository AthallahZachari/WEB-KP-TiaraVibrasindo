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

// [ PARAMS ] get params for class ID
$_SESSION['current_class'] = isset($_GET['id']) ? $_GET['id'] : null;
$id_class = $_SESSION['current_class'];


// [ GET ] Data detail class 
$queryDetail = $conn->prepare("SELECT class.*, materi.nama_materi FROM class JOIN materi ON class.materi = materi.id_materi WHERE id_class = ?");
$queryDetail->execute([$id_class]);
$rowDetail = $queryDetail->fetch(PDO::FETCH_ASSOC);

$_SESSION['idClass'] = $rowDetail['id_class'];
$_SESSION['className'] = $rowDetail['nama_kelas'];
$_SESSION['materiName'] = $rowDetail['nama_materi'];
$currentID = $_SESSION['idClass'];

// [ PAGINATION ] Semua murid tblClassDetail
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page > 1) ? ($page * $limit) - $limit : 0;

$sqlCount = $conn->prepare("SELECT COUNT(*) as total_rows FROM admin WHERE `role` = ?");
$sqlCount->execute(['student']);
$total_rows = $sqlCount->fetchColumn();

$total_pages = ceil($total_rows / $limit);

$start_row = $start + 1;
$end_row = min($start + $limit, $total_rows);

// [ GET ] list semua murid
$queryStudent = $conn->prepare("SELECT * FROM admin WHERE `role` = :role LIMIT :limit OFFSET :offset");
$queryStudent->bindValue(':role', 'student', PDO::PARAM_INT);
$queryStudent->bindValue(':limit', $limit, PDO::PARAM_INT);
$queryStudent->bindValue(':offset', $start, PDO::PARAM_INT);
$queryStudent->execute();
$rowStudent = $queryStudent->fetchAll(PDO::FETCH_ASSOC);


// [ PAGINATION ] Siswa Kelas Ini
$this_limit = 5;
$this_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$this_start = ($this_page > 1) ? ($this_page * $this_limit) - $this_limit : 0;

$sqlCountListed = $conn->prepare("SELECT COUNT(*) as total_listed FROM listed_class WHERE id_kelas = ?");
$sqlCountListed->execute([$currentID]);
$totalListed = $sqlCountListed->fetchColumn();

$this_total_pages = ceil($totalListed / $this_limit);

$this_start_row = $this_start + 1;
$this_end_row = min($this_start + $this_limit, $totalListed);

// [ GET ] Siswa Kelas Ini
$listedStudent = $conn->prepare("SELECT listed_class.*, `admin`.* FROM listed_class JOIN `admin` ON listed_class.id_murid = admin.id_admin WHERE listed_class.id_kelas = :kelasID LIMIT :limit OFFSET :offset");
$listedStudent->bindValue(':kelasID', $currentID, PDO::PARAM_INT);
$listedStudent->bindValue(':limit', $this_limit, PDO::PARAM_INT);
$listedStudent->bindValue(':offset', $this_start, PDO::PARAM_INT);
$listedStudent->execute();
$rowListed = $listedStudent->fetchAll(PDO::FETCH_ASSOC);


// [ PAGINATION ] Absen Kelas Ini
$att_limit = 3;
$att_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$att_start = ($att_page > 1) ? ($att_page * $att_limit) - $att_limit : 0;

$attCount = $conn->prepare("SELECT COUNT(*) as total_attendance FROM attendance WHERE class_id = ?");
$attCount->execute([$currentID]);
$attListed = $attCount->fetchColumn(); // Mengambil jumlah attendance yang benar

$att_total_pages = ceil($attListed / $att_limit);
$att_start_row = $att_start + 1;
$att_end_row = min($att_start + $att_limit, $attListed);

// [ GET ] list absen murid
$attendanceList = $conn->prepare(
  "SELECT admin.*, attendance.*,
  COALESCE(attendance.status, 'absent') as status 
  FROM listed_class 
  JOIN admin ON admin.id_admin = listed_class.id_murid 
  LEFT JOIN attendance ON attendance.student_id = admin.id_admin 
  AND attendance.class_id = listed_class.id_kelas 
  WHERE listed_class.id_kelas = :idkelas
  LIMIT :limit OFFSET :offset"
);
$attendanceList->bindValue(':idkelas', $currentID, PDO::PARAM_INT);
$attendanceList->bindValue(':limit', $att_limit, PDO::PARAM_INT);
$attendanceList->bindValue(':offset', $att_start, PDO::PARAM_INT);
$attendanceList->execute();
$rowAttendance = $attendanceList->fetchAll(PDO::FETCH_ASSOC);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // [ POST ] Daftarkan murid ke kelas tertentu
  if (isset($_POST['submitStudent'])) {
    $class = $_POST['idClass'];
    $student = $_POST['student'];

    $queryMember = $conn->prepare("INSERT INTO listed_class (id_kelas, id_murid) VALUES(?, ?)");
    $queryMember->execute([$class, $student]);

    header("Location: ./classDetail.php?id=$currentID");
  }
}

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

      <!-- [ TABLE ] -->
      <div id="tableClassDetail" class=" w-[80%] px-3 py-3 rounded-md shadow-lg hidden">
        <?php include './tables/tblClassDetail.php'; ?>
      </div>

      <!-- [ TABLE ] -->
      <div id="tableAllStudents" class=" w-[80%] px-3 py-3 rounded-md shadow-lg hidden">
        <?php include './tables/tblAllStudent.php'; ?>
      </div>

      <!-- [ TABLE ] -->
      <div id="tableAttendance" class=" w-[60%] px-3 py-3 mb-5 rounded-md shadow-lg hidden">
        <?php include './tables/tblAttendance.php'; ?>
      </div>

    </section>
  </div>
  <script>
    // // Get buttons and tables
    // const btnClassDetail = document.getElementById('btnClassDetail');
    // const btnAllStudents = document.getElementById('btnAllStudents');
    // const btnAttendance = document.getElementById('btnAttendance');
    // const tableClassDetail = document.getElementById('tableClassDetail');
    // const tableAllStudents = document.getElementById('tableAllStudents');
    // const tableClassAttendance = document.getElementById('tableAtttendance');

    // // Function to remove 'border-b-2' class from all buttons
    // function removeActiveClasses() {
    //   btnClassDetail.classList.remove('border-b-2', 'active-btn');
    //   btnAllStudents.classList.remove('border-b-2', 'active-btn');
    //   btnAttendance.classList.remove('border-b-2', 'active-btn');
    // }

    // // Show table based on URL parameter
    // function showTableFromURL() {
    //   const urlParams = new URLSearchParams(window.location.search);
    //   const tableParam = urlParams.get('table');

    //   if (tableParam === '1') {
    //     btnClassDetail.click();
    //   } else if (tableParam === '2') {
    //     btnAllStudents.click();
    //   } else if (tableParam === '3') {
    //     btnAttendance.click();
    //   } else {
    //     // Default to table 1 if no parameter is set
    //     btnClassDetail.click();
    //   }
    // }

    // // Add event listeners to buttons to update URL and show respective table
    // btnClassDetail.addEventListener('click', () => {
    //   window.history.pushState({}, '', '?table=1');
    //   tableClassDetail.classList.remove('hidden');
    //   tableAllStudents.classList.add('hidden');
    //   tableClassAttendance.classList.add('hidden');
    //   removeActiveClasses();
    //   btnClassDetail.classList.add('border-b-2', 'active-btn');
    // });

    // btnAllStudents.addEventListener('click', () => {
    //   window.history.pushState({}, '', '?table=2');
    //   tableAllStudents.classList.remove('hidden');
    //   tableClassDetail.classList.add('hidden');
    //   tableClassAttendance.classList.add('hidden');
    //   removeActiveClasses();
    //   btnAllStudents.classList.add('border-b-2', 'active-btn');
    // });

    // btnAttendance.addEventListener('click', () => {
    //   window.history.pushState({}, '', '?table=3');
    //   tableClassAttendance.classList.remove('hidden');
    //   tableAllStudents.classList.add('hidden');
    //   tableClassDetail.classList.add('hidden');
    //   removeActiveClasses();
    //   btnAttendance.classList.add('border-b-2', 'active-btn');
    // });

    // // Show the table based on URL on page load
    // showTableFromURL();

    // // Get buttons and tables
    // const btnClassDetail = document.getElementById('btnClassDetail');
    // const btnAllStudents = document.getElementById('btnAllStudents');
    // const btnAttendance = document.getElementById('btnAttendance');
    // const tableClassDetail = document.getElementById('tableClassDetail');
    // const tableAllStudents = document.getElementById('tableAllStudents');
    // const tableClassAttendance = document.getElementById('tableAtttendance');

    // // Function to remove 'border-b-2' class from both buttons
    // function removeActiveClasses() {
    //   btnClassDetail.classList.remove('border-b-2', 'active-btn');
    //   btnAllStudents.classList.remove('border-b-2', 'active-btn');
    //   btnAttendance.classList.remove('border-b-2', 'active-btn');
    // }

    // // Function to update URL with current table and maintain id
    // function updateURL(currentTable) {
    //   const url = new URL(window.location.href);
    //   url.searchParams.set('table', currentTable);
    //   window.history.pushState({}, '', url);
    // }

    // // Event listener for "Semua Siswa" button
    // btnClassDetail.addEventListener('click', () => {
    //   tableClassDetail.classList.remove('hidden');
    //   tableAllStudents.classList.add('hidden');
    //   tableClassAttendance.classList.add('hidden');
    //   removeActiveClasses();
    //   btnClassDetail.classList.add('border-b-2', 'active-btn');
    //   updateURL(1); // Set table parameter to 1
    // });

    // // Event listener for "Siswa" button
    // btnAllStudents.addEventListener('click', () => {
    //   tableAllStudents.classList.remove('hidden');
    //   tableClassDetail.classList.add('hidden');
    //   tableClassAttendance.classList.add('hidden');
    //   removeActiveClasses();
    //   btnAllStudents.classList.add('border-b-2', 'active-btn');
    //   updateURL(2); // Set table parameter to 2
    // });

    // // Event listener for "Attendance" button
    // btnAttendance.addEventListener('click', () => {
    //   tableClassAttendance.classList.remove('hidden');
    //   tableAllStudents.classList.add('hidden');
    //   tableClassDetail.classList.add('hidden');
    //   removeActiveClasses();
    //   btnAttendance.classList.add('border-b-2', 'active-btn');
    //   updateURL(3); // Set table parameter to 3
    // });

    // ========================================
    // Event listener untuk tombol
    // btnClassDetail.addEventListener('click', () => {
    //   tableClassDetail.classList.remove('hidden');
    //   tableAllStudents.classList.add('hidden');
    //   tableAttendance.classList.add('hidden');
    //   removeActiveClasses();
    //   btnClassDetail.classList.add('border-b-2', 'active-btn');
    // });

    // btnAllStudents.addEventListener('click', () => {
    //   tableAllStudents.classList.remove('hidden');
    //   tableClassDetail.classList.add('hidden');
    //   tableAttendance.classList.add('hidden');
    //   removeActiveClasses();
    //   btnAllStudents.classList.add('border-b-2', 'active-btn');
    // });

    // btnAttendance.addEventListener('click', () => {
    //   tableAttendance.classList.remove('hidden');
    //   tableAllStudents.classList.add('hidden');
    //   tableClassDetail.classList.add('hidden');
    //   removeActiveClasses();
    //   btnAttendance.classList.add('border-b-2', 'active-btn');
    // });

    // // JavaScript untuk menangani tampilan tabel saat halaman dimuat
    // window.onload = function() {
    //   // Mendapatkan parameter dari URL
    //   const urlParams = new URLSearchParams(window.location.search);
    //   const tableParam = urlParams.get('table');

    //   // Menampilkan tabel yang sesuai berdasarkan parameter URL
    //   if (tableParam === '2') {
    //     tableAllStudents.classList.remove('hidden');
    //     tableClassDetail.classList.add('hidden');
    //     tableAttendance.classList.add('hidden');
    //     btnAllStudents.classList.add('border-b-2', 'active-btn');
    //   } else if (tableParam === '3') {
    //     tableAttendance.classList.remove('hidden');
    //     tableAllStudents.classList.add('hidden');
    //     tableClassDetail.classList.add('hidden');
    //     btnAttendance.classList.add('border-b-2', 'active-btn');
    //   } else {
    //     // Default ke tableClassDetail jika tidak ada parameter
    //     tableClassDetail.classList.remove('hidden');
    //     tableAllStudents.classList.add('hidden');
    //     tableAttendance.classList.add('hidden');
    //     btnClassDetail.classList.add('border-b-2', 'active-btn');
    //   }
    // };

    // ==================================
    // Mendapatkan elemen tombol dan tabel
    const btnClassDetail = document.getElementById('btnClassDetail');
    const btnAllStudents = document.getElementById('btnAllStudents');
    const btnAttendance = document.getElementById('btnAttendance');
    const tableClassDetail = document.getElementById('tableClassDetail');
    const tableAllStudents = document.getElementById('tableAllStudents');
    const tableClassAttendance = document.getElementById('tableAttendance');

    // Fungsi untuk menghapus kelas aktif dari semua tombol
    function removeActiveClasses() {
      btnClassDetail.classList.remove('border-b-2', 'active-btn');
      btnAllStudents.classList.remove('border-b-2', 'active-btn');
      btnAttendance.classList.remove('border-b-2', 'active-btn');
    }

    // Fungsi untuk menampilkan tabel sesuai dengan parameter
    function showTable(param) {
      // Menghapus kelas aktif dari semua tombol
      removeActiveClasses();

      if (param === '2') {
        tableAllStudents.classList.remove('hidden');
        tableClassDetail.classList.add('hidden');
        tableClassAttendance.classList.add('hidden');
        btnAllStudents.classList.add('border-b-2', 'active-btn'); // Menambahkan border aktif
      } else if (param === '3') {
        tableClassAttendance.classList.remove('hidden');
        tableAllStudents.classList.add('hidden');
        tableClassDetail.classList.add('hidden');
        btnAttendance.classList.add('border-b-2', 'active-btn'); // Menambahkan border aktif
      } else {
        // Default ke tableClassDetail
        tableClassDetail.classList.remove('hidden');
        tableAllStudents.classList.add('hidden');
        tableClassAttendance.classList.add('hidden');
        btnClassDetail.classList.add('border-b-2', 'active-btn'); // Menambahkan border aktif
      }
    }

    // Event listener untuk tombol
    btnClassDetail.addEventListener('click', () => {
      showTable('1'); // '1' untuk tabel detail kelas
    });

    btnAllStudents.addEventListener('click', () => {
      showTable('2'); // '2' untuk tabel semua siswa
    });

    btnAttendance.addEventListener('click', () => {
      showTable('3'); // '3' untuk tabel attendance
    });

    // Menampilkan tabel yang sesuai berdasarkan parameter URL saat halaman dimuat
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