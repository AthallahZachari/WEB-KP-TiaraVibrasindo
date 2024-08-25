<?php
session_start();
include '../../includes/connection/connection.php';
include '../../includes/header.php';

if (!isset($_SESSION['role']) && !isset($_SESSION['current_user'])) {
  header("Location: ../../index.php");
  exit();
}


// [ PAGINATION ]
$limit = 10; // Jumlah data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Halaman saat ini
$start = ($page > 1) ? ($page * $limit) - $limit : 0; // Hitung offset

$popupMessage = '';
$searchClass = '';

// [ GET ] all kelas
$sqlClass = "SELECT class.*, materi.nama_materi, admin.admin_name 
            FROM class JOIN materi ON class.materi = materi.id_materi 
            JOIN admin ON class.pengajar = admin.id_admin ";

// [ GET ] get kelas dari searchbox (jika ada)
if (isset($_GET['searchbox']) && !empty($_GET['searchbox'])) {
  $searchClass = '%' . $_GET['searchbox'] . '%';
  $sqlClass .= "WHERE class.nama_kelas LIKE :searchbox ";
}

$sqlClass .= " LIMIT :limit OFFSET :offset";

$queryClass = $conn->prepare($sqlClass);

if (!empty($searchClass)) {
  $queryClass->bindParam(':searchbox', $searchClass, PDO::PARAM_STR);
}

$queryClass->bindParam(':limit', $limit, PDO::PARAM_INT);
$queryClass->bindParam(':offset', $start, PDO::PARAM_INT);

$queryClass->execute();
$rowClass = $queryClass->fetchAll(PDO::FETCH_ASSOC);

// [GET] Hitung total data untuk pagination
$sqlCount = "SELECT COUNT(*) as total FROM class";
if (!empty($searchClass)) {
  $sqlCount .= " WHERE class.nama_kelas LIKE :searchbox";
}

$queryCount = $conn->prepare($sqlCount);

if (!empty($searchClass)) {
  $queryCount->bindParam(':searchbox', $searchClass);
}

$queryCount->execute();
$total_rows = $queryCount->fetchColumn();

$total_pages = ceil($total_rows / $limit);

// [GET] Mulai dan akhir baris yang ditampilkan
$start_row = $start + 1;
$end_row = min($start + $limit, $total_rows);

$sqlMateri = "SELECT * FROM materi";
$queryMateri = $conn->prepare($sqlMateri);
$queryMateri->execute();
$rowMateri = $queryMateri->fetchAll(PDO::FETCH_ASSOC);

$sqlMentor = "SELECT * FROM admin WHERE role = 'employee'";
$queryMentor = $conn->prepare($sqlMentor);
$queryMentor->execute();
$rowMentor = $queryMentor->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['submitNewClass'])) {
    $insertClass = $conn->prepare("INSERT INTO `class` (`nama_kelas`, `pengajar`, `materi`, `ruangan`, `durasi`, `tanggal`) VALUES (?, ?, ?, ?, ?, ?)");
    $insertClass->execute([$_POST['nama_kelas'], $_POST['selected_pengajar'], $_POST['selected_materi'], $_POST['ruangan'], $_POST['durasi'], $_POST['tanggal']]);

    if ($insertClass->rowCount() > 0) {
      $_SESSION['popupMessage'] = "Berhasil Menambahkan Kelas !";
      header('Location: ./class.php');
      exit();
    }
  }
}


?>

<body class=" w-full ">
  <?php include '../component/navbar.php'; ?>
  <div class=" px-6 flex h-[100vh]">
    <section class=" w-full">
      <section class=" mt-3 text-sm text-blue-800 font-light">
        <p>dashboard / inputKelas</p>
      </section>
      <section class=" mb-3 text-3xl text-slate-700 font-bold flex justify-between">
        <h1 class="  text-slate-800 font-bold">Dashboard</h1>
        <h1 class=" text-2xl">Welcome back, <?= $_SESSION['current_user'] ?> !</h1>
      </section>
      
      <!-- [ TABLE ] -->
      <div class=" w-full px-3 py-3 rounded-md shadow-lg">
        <?php include './tables/tblclass.php'; ?>
      </div>  
    </section>

    <!-- [ FORM ] Add kelas baru -->
    <section id="formAddClass" class="hidden fixed inset-0 z-20 flex items-center justify-center bg-black bg-opacity-50">
      <?php include './forms/addclass.php';?>
    </section>

  </div>
</body>
<div class=" w-full">
  <?php include '../../includes/footer.php'; ?>
</div>
<script>
  document.addEventListener('DOMContentLoaded', function() {

    // Get all toggle buttons
    const toggleButtons = document.querySelectorAll('[id^="toggleListPengajar-"]');
    const btnAddClass = document.getElementById('btnAddClass');
    const formNewClass = document.getElementById('formAddClass');
    const listMentorNew = document.getElementById('newListMentor');
    const listMateriNew = document.getElementById('newListMateri');
    const listMentor = document.getElementById('listMentor');
    const listMateri = document.getElementById('listMateri');
    const btnCloseForm = document.getElementById('btnCancel');

    const btnShowPengajar = document.getElementById('dropdownPengajar');
    const btnShowMateri = document.getElementById('dropdownMateri');
    const btnShowPengajarNew = document.getElementById('newDropdownPengajar');
    const btnShowMateriNew = document.getElementById('newDropdownMateri');

    const selectedPengajarInput = document.getElementById('selectedPengajar');
    const selectedMateriInput = document.getElementById('selectedMateri');

    btnAddClass.addEventListener('click', function() {
      formNewClass.classList.toggle('hidden');
    })

    btnCloseForm.addEventListener('click', function() {
      formNewClass.classList.toggle('hidden');
    })

    btnShowPengajar.addEventListener('click', function() {
      listMentor.classList.toggle('hidden');
    })

    btnShowPengajarNew.addEventListener('click', function() {
      listMentorNew.classList.toggle('hidden');
    })

    btnShowMateri.addEventListener('click', function() {
      listMateri.classList.toggle('hidden');
    })

    btnShowMateriNew.addEventListener('click', function() {
      listMateriNew.classList.toggle('hidden');
    })

    // Handle selection of a pengajar
    listMentorNew.addEventListener('click', function(event) {
      const item = event.target;
      if (item.tagName.toLowerCase() === 'li') {
        const pengajarId = item.getAttribute('data-value');
        selectedPengajarInput.value = pengajarId;
        btnShowPengajarNew.innerHTML = item.innerText + ' <i class="fa-solid fa-chevron-down ml-2"></i>';
        listMentorNew.classList.add('hidden');
      }
    });

    // Handle selection of a materi
    listMateriNew.addEventListener('click', function(event) {
      const item = event.target;
      if (item.tagName.toLowerCase() === 'li') {
        const materiId = item.getAttribute('data-value');
        selectedMateriInput.value = materiId;
        btnShowMateriNew.innerHTML = item.innerText + ' <i class="fa-solid fa-chevron-down ml-2"></i>';
        listMateriNew.classList.add('hidden');
      }
    });

    toggleButtons.forEach(button => {
      button.addEventListener('click', function() {
        const id = this.id.split('-')[1];
        const dropdown = document.getElementById(`dropdownListPengajar-${id}`);
        dropdown.classList.toggle('hidden');
      });
    });

  });

  document.querySelectorAll('.action-button').forEach(button => {
    button.addEventListener('click', function(event) {
      // Mendapatkan ID materi
      const classId = this.id.split('-')[1];
      // Menampilkan atau menyembunyikan dropdown terkait
      const dropdown = document.getElementById(`dropdown-${classId}`);
      dropdown.classList.toggle('hidden');
    });
  });

  // 
  function toggleEditForm(id) {
    const formEditClass = document.getElementById(`formEditClass-${id}`);

    if (formEditClass) {
      formEditClass.classList.toggle('hidden');
    }
  }
</script>