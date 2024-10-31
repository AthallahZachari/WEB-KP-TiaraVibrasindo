<?php
include '../../includes/connection/connection.php';
include '../../includes/header.php';
session_start();

if (!isset($_SESSION['current_user']) && $_SESSION['role'] != 'admin') {
  header("Location: ../../index.php");
  exit();
}

// [ PAGINATION ]
$limit = 10; // Jumlah data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Halaman saat ini
$start = ($page > 1) ? ($page * $limit) - $limit : 0; // Hitung offset

$searchMateri = '';
$popupMessage = '';

// [ GET ] get semua materi
$sqlMateri = "SELECT * FROM materi";

// [ GET ] get materi dengan filter (jika ada)
if (isset($_GET['searchbox']) && !empty($_GET['searchbox'])) {
  $searchMateri = '%' . $_GET['searchbox'] . '%';
  $sqlMateri .= " WHERE nama_materi LIKE :searchbox";
}

// [ GET ] get materi order by descending/ascending (jika ada)
if (isset($_GET['sortAscending']) && !empty($_GET['sortAscending'])) {
  $sortMateri = '%' . $_GET['sortAscending'] . '%';
  $sqlMateri .= " ORDER BY `nama_materi` ASC";
}

// [ LIMIT & OFFSET ] untuk pagination
$sqlMateri .= " LIMIT :limit OFFSET :offset";

$queryMateri = $conn->prepare($sqlMateri);

if (!empty($searchMateri)) {
  $queryMateri->bindParam(':searchbox', $searchMateri);
}

$queryMateri->bindParam(':limit', $limit, PDO::PARAM_INT);
$queryMateri->bindParam(':offset', $start, PDO::PARAM_INT);

$queryMateri->execute();
$rowsMateri = $queryMateri->fetchAll(PDO::FETCH_ASSOC);

// [GET] Hitung total data untuk pagination
$sqlCount = "SELECT COUNT(*) as total FROM materi";
if (!empty($searchMateri)) {
  $sqlCount .= " WHERE nama_materi LIKE :searchbox";
}

$queryCount = $conn->prepare($sqlCount);

if (!empty($searchMateri)) {
  $queryCount->bindParam(':searchbox', $searchMateri);
}

$queryCount->execute();
$total_rows = $queryCount->fetchColumn();

$total_pages = ceil($total_rows / $limit);

// [GET] Mulai dan akhir baris yang ditampilkan
$start_row = $start + 1;
$end_row = min($start + $limit, $total_rows);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // [ POST ] Create Materi Baru
  if (isset($_POST['submitMateri'])) {
    $insertMateri = $conn->prepare("INSERT INTO materi (nama_materi, deskripsi_materi) VALUES (?, ?)");
    $insertMateri->execute([$_POST['nama_materi'], $_POST['deskripsi_materi']]);

    if ($insertMateri->rowCount() > 0) {
      $_SESSION['popupMessage'] = "Berhasil Menambahkan Materi !";
      header('Location: ./inputmateri.php');
      exit();
    }
  }

  // [ POST ] Create Nama baru
  if (isset($_POST['submitNama'])) {
    function generateRandomString($length)
    {
      return substr(bin2hex(random_bytes($length)), 0, $length);
    }
    $password = generateRandomString(8);

    $insertNama = $conn->prepare("INSERT INTO admin (`admin_name`, `nip`, `password`) VALUES (?, ?, ?)");
    $insertNama->execute([$_POST['nama_employee'], $_POST['nip'], $password]);

    if ($insertNama->rowCount() > 0) {
      $_SESSION['popupMessage'] = "Berhasil Menambahkan Nama !";
      header('Location: ./inputmateri.php');
      exit();
    }
  }

  // [ UPDATE ] Edit Materi
  if (isset($_POST['submitEditMateri'])) {
    $updateMateri = $conn->prepare("UPDATE `materi` SET `nama_materi` = ?, `deskripsi_materi` = ? WHERE id_materi = ?");
    $updateMateri->execute([$_POST['edit_materi'], $_POST['edit_deskripsi'], $_POST['edit_id_materi']]);

    if ($updateMateri->rowCount() > 0) {
      $_SESSION['popupMessage'] = "Berhasil Mengupdate Materi !";
      header('Location: ./inputmateri.php');
      exit();
    }
  }

  if (isset($_POST['btnDeleteRow'])) {
    $deleteRow = $conn->prepare("DELETE FROM `materi` WHERE `id_materi` = ?");
    $deleteRow->execute([$_POST['deleteRow']]);

    if ($deleteRow->rowCount() > 0) {
      $_SESSION['popupMessage'] = "Berhasil menghapus materi !";
      header("Location: ./inputmateri.php");
      exit();
    }
  }
}

$popupMessage = isset($_SESSION['popupMessage']) ? $_SESSION['popupMessage'] : '';

?>

<?php include '../component/navbar.php'; ?>

<body class=" w-full">
  <section class=" min-h-screen">
    <section class=" w-full">
      <div class="  px-6">
        <section class=" mt-3 text-sm text-blue-800 font-light">
          <p>dashboard / inputMateri</p>
        </section>
        <section class=" mb-3 text-3xl text-slate-700 font-bold flex justify-between">
          <h1 class="  text-slate-800 font-bold">Dashboard</h1>
          <h1 class=" text-2xl">Welcome back, <?= $_SESSION['current_user'] ?> !</h1>
        </section>
        <!-- TABLE & FORM MATERI -->
        <div class=" w-full flex my-5">
          <section id="table-container" class="px-5 py-6 mr-5 w-[80%] rounded-lg shadow-xl">
            <div id="control-button" class=" w-auto mb-3 flex justify-between">
              <form action="./inputmateri.php" method="GET" class=" flex items-center">
                <input type="text" name="searchbox" placeholder="Search..." class=" rounded-tl-md rounded-bl-md px-4 py-1 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-amber-400">
                <button type="submit" class=" px-4 py-[4.7px] bg-blue-800 text-slate-100 rounded-tr-md rounded-br-md">
                  <i class="fa-solid fa-magnifying-glass"></i>
                </button>
              </form>
              <div class="flex space-x-2">
                <form action="" method="GET">
                  <button type="sortAscending" class=" px-[10px] py-[3.8px] text-md font-semibold rounded-md border text-slate-800 border-slate-400 hover:bg-slate-200"><i class="fa-solid fa-arrow-down-wide-short"></i></button>
                </form>
                <button id="btnTambahMateri" class=" px-3 py-[6px] text-sm text-white font-semibold rounded-md bg-amber-400 hover:bg-amber-500"><i class="fa-solid fa-plus mr-1"></i>New</button>
              </div>
            </div>
            <table class="text-sm overflow-x-auto table-auto w-full">
              <thead>
                <tr class="border-y-[1.5px] border-y-slate-300">
                  <th class=" text-left px-2 py-3">ID</th>
                  <th class=" text-left px-2 py-3">Materi</th>
                  <th class=" text-left px-2 py-3">Deskripsi</th>
                  <th class=" text-left px-2 py-3 w-[50px] "></th>
                </tr>
              </thead>
              <tbody>
                <?php if ($queryMateri->rowCount() > 0) : ?>
                  <?php foreach ($rowsMateri as $row) : ?>
                    <tr class=" text-slate-600">
                      <td class="px-2 py-2"><?= $row['id_materi'] ?></td>
                      <td class="px-2 py-2"><?= $row['nama_materi'] ?></td>
                      <td class="px-2 py-2"><?= $row['deskripsi_materi'] ?></td>
                      <td class=" text-center">
                        <button id="action-<?= $row['id_materi'] ?>" class="action-button px-2 py-[5px] rounded-md hover:bg-slate-200"><i class="fa-solid fa-ellipsis"></i></button>
                        <div id="dropdown-<?= $row['id_materi'] ?>" class="dropdown-content hidden absolute mt-1 text-left bg-white border-2 border-white  rounded-md shadow-lg">
                          <button
                            href="#"
                            onclick="toggleEditForm('<?= $row['id_materi'] ?>')"
                            class="block w-full px-4 py-2 text-sm text-left text-gray-700 rounded-md hover:bg-gray-100">
                            Edit
                          </button>
                          <form action="inputmateri.php" method="POST">
                            <input type="hidden" name="deleteRow" value="<?= $row['id_materi'] ?>">
                            <button type="submit" name="btnDeleteRow" class="px-4 py-2 text-sm text-left text-red-700 rounded-md hover:bg-red-100">Hapus</button>
                          </form>
                        </div>

                        <section id="formEditMateri-<?= $row['id_materi'] ?>" class="fixed inset-0 flex z-30 items-center justify-center bg-black bg-opacity-50 text-left hidden">
                          <div class="bg-white rounded-lg px-5 w-[40%]">
                            <div class="py-5 mb-4 border-b-[2px] border-b-slate-400">
                              <div class=" flex items-center justify-between">
                                <h2 class="text-2xl text-slate-700 font-semibold"><?= $row['nama_materi'] ?></h2>
                                <p class=" text-2xl text-slate-700 font-semibold">#<?= $row['id_materi'] ?></p>
                              </div>
                              <p class=" text-slate-600 mt-2"><?= $row['deskripsi_materi'] ?></p>
                            </div>
                            <form action="" method="POST" id="formEditMateri" class=" grid grid-cols-3">
                              <input type="hidden" name="edit_id_materi" id="edit_id_materi" value="<?= $row['id_materi'] ?>">
                              <label for="edit_materi" class=" mb-2 block text-sm font-medium text-gray-700">Nama Materi</label>
                              <input type="text" name="edit_materi" id="edit_materi" class=" col-span-2 rounded-md px-4 py-2 mb-4 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-amber-300">
                              <label for="edit_deskripsi" class=" mb-2 block text-sm font-medium text-gray-700">Deskripsi</label>
                              <input type="text" name="edit_deskripsi" id="edit_deskripsi" class=" col-span-2 rounded-md px-4 py-2 mb-4 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-amber-300">
                              <div class=" col-start-2 grid grid-cols-2 col-end-4 mb-5">
                                <button
                                  type="button"
                                  class=" px-4 py-2 mr-3 border border-gray-300 rounded-md text-slate-600 hover:bg-gray-100"
                                  onclick="toggleEditForm('<?= $row['id_materi'] ?>')">
                                  Cancel
                                </button>
                                <button
                                  type="submit"
                                  name="submitEditMateri"
                                  class=" px-4 py-2 bg-blue-700 text-white rounded-md hover:bg-blue-800">
                                  Save
                                </button>
                              </div>
                            </form>
                          </div>
                        </section>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else : ?>
                  <tr>
                    <td colspan="12" class="py-2 px-4 text-center text-gray-700">Table Kosong/Tidak ada data dengan pencarian terkait</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
            <div class=" border-b-[1.5px] border-b-slate-300"></div>

            <!-- PAGINATION -->
            <section class=" mt-5 flex justify-between items-center ">
              <p class="text-slate-600 text-sm">Showing : <?= ($end_row + 1) - $start_row ?> of <?= $total_rows; ?> rows</p>
              <p class="text-slate-600 text-sm">Page <?= $page; ?> of <?= $total_pages; ?> pages</p>
              <div>
                <a href="inputmateri.php?page=<?= max(1, $page - 1); ?>" class="hover:bg-slate-200 text-blue-800 font-semibold border border-slate-400 px-4 py-[7px] mr-3 rounded-md transition-all duration-300">
                  <i class="fa-solid fa-chevron-left mr-3"></i>Prev
                </a>
                <?php if ($page > 3) : ?>
                  <a href="inputmateri.php?page=1" class="px-3 py-[7px] font-semibold rounded-md border border-slate-400 hover:bg-gray-200 transition-all duration-300">1</a>
                  <?php if ($page > 4) : ?>
                    <span class="px-3 py-2 font-semibold">...</span>
                  <?php endif; ?>
                <?php endif; ?>

                <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++) : ?>
                  <a href="inputmateri.php?page=<?= $i; ?>" class="px-3 py-[7px] font-semibold rounded-md border border-slate-400 hover:bg-opacity-90 <?= $i == $page ? 'bg-amber-500 text-slate-100' : '' ?>"><?= $i; ?></a>
                <?php endfor; ?>

                <?php if ($page < $total_pages - 2) : ?>
                  <?php if ($page < $total_pages - 3) : ?>
                    <span class="px-3 py-2 font-semibold">...</span>
                  <?php endif; ?>
                  <a href="inputmateri.php?page=<?= $total_pages; ?>" class="px-3 py-[7px] font-semibold rounded-md border border-slate-400 hover:bg-gray-200 transition-all duration-300"><?= $total_pages; ?></a>
                <?php endif; ?>

                <a href="inputmateri.php?page=<?= min($total_pages, $page + 1); ?>" class="bg-blue-700 hover:bg-blue-800 text-slate-100 font-semibold px-4 py-[7px] ml-3 rounded-md">
                  Next<i class="fa-solid fa-chevron-right ml-3"></i>
                </a>
              </div>
            </section>

          </section>

          <section id="formAddMateri" class="w-[40%] rounded-md hidden">
            <div class="w-full px-5 py-2 shadow-xl rounded-md ">
              <div class="py-3 border-b-[1.5px] border-b-slate-800">
                <h1 class="text-3xl text-slate-800 font-bold">Input Materi Baru</h1>
              </div>
              <form action="inputmateri.php" method="post" class="my-5 flex flex-col">
                <input type="text" name="nama_materi" id="inputNamaMateri" placeholder="Materi..." class="rounded-md px-4 py-2 mb-4 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-amber-400">
                <input type="text" name="deskripsi_materi" id="inputDeskripsiMateri" placeholder="Deksripsi..." class="rounded-md px-4 py-2 mb-4 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-amber-400">

                <section class="flex justify-between">
                  <a href="" class="w-[45%] text-center text-lg font-semibold px-8 py-3 border border-slate-300 rounded-md hover:bg-slate-100 transition-all duration-300">
                    Cancel
                  </a>
                  <button type="submit" name="submitMateri" class="w-[45%] bg-blue-800 hover:bg-blue-900 text-white text-lg font-semibold px-8 py-3 rounded-md transition-all duration-300">
                    Submit
                  </button>
                </section>
              </form>
            </div>
          </section>
        </div>
      </div>

      <!-- Toast Popup -->
      <?php if (!empty($popupMessage)) : ?>
        <div id="toaster" class=" fixed flex items-center bottom-4 right-4 px-4 py-3 bg-slate-700 rounded-md shadow-md border-l-[15px] border-l-green-500">
          <p class=" text-slate-100 font-semibold">
            <i class="fa-solid fa-circle-exclamation text-2xl text-green-500 mr-3"></i>
            <?= $popupMessage ?>
          </p>
        </div>
        <?php unset($_SESSION['popupMessage']); ?>
      <?php endif; ?>

      <script>
        document.addEventListener("DOMContentLoaded", function() {
          const toastPopup = document.getElementById('toaster');
          if (toastPopup) {
            setTimeout(() => {
              toastPopup.classList.add('opacity-0');
              setTimeout(() => {
                toastPopup.remove();
              }, 1000); // Tunggu sampai transisi selesai sebelum menghapus elemen
            }, 3000); // Popup akan hilang setelah 3 detik
          }

          const btnTambahMateri = document.getElementById('btnTambahMateri');
          const btnTambahEmployee = document.getElementById('btnTambahEmployee');
          const formAddMateri = document.getElementById('formAddMateri');
          const formAddEmployee = document.getElementById('formAddEmployee');
          const tableContainer = document.getElementById('table-container');

          btnTambahMateri.addEventListener('click', function() {
            formAddMateri.classList.toggle('hidden');
            tableContainer.classList.toggle('w-[65%]');
          });

        });

        document.querySelectorAll('.action-button').forEach(button => {
          button.addEventListener('click', function(event) {
            // Mendapatkan ID materi
            const materiId = this.id.split('-')[1];
            // Menampilkan atau menyembunyikan dropdown terkait
            const dropdown = document.getElementById(`dropdown-${materiId}`);
            dropdown.classList.toggle('hidden');
          });
        });

        // 
        function toggleEditForm(id) {
          const formEditMateri = document.getElementById(`formEditMateri-${id}`);

          if (formEditMateri) {
            formEditMateri.classList.toggle('hidden');
          }
        }
      </script>
    </section>
</body>
<?php include '../../includes/footer.php'; ?>