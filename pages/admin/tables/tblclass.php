<div class=" w-auto mb-3 flex justify-between">
  <form action="" method="GET" class=" flex items-center">
    <input type="text" name="searchbox" placeholder="Search..." class=" rounded-tl-md rounded-bl-md px-4 py-1 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-amber-400">
    <button type="submitSearch" class=" px-4 py-[4.7px] bg-blue-800 text-slate-100 rounded-tr-md rounded-br-md">
      <i class="fa-solid fa-magnifying-glass"></i>
    </button>
  </form>
  <button id="btnAddClass" class=" px-4 py-[4.7px] text-white font-semibold rounded-md bg-amber-400 hover:bg-amber-500"><i class="fa-solid fa-plus mr-2"></i>New</button>
</div>
<table class="text-sm overflow-x-auto table-auto w-full">
  <thead>
    <tr class="border-y-[1.5px] border-y-slate-300 text-slate-800">
      <th class=" text-left px-2 py-3">ID</th>
      <th class=" text-left px-2 py-3">Nama</th>
      <th class=" text-left px-2 py-3">Materi</th>
      <th class=" text-left px-2 py-3">Ruangan</th>
      <th class=" text-left px-2 py-3">Pengajar</th>
      <th class=" text-left px-2 py-3">Durasi</th>
      <th class=" text-left px-2 py-3">Tanggal</th>
      <th class=" text-center px-2 py-3 w-[50px]"></th>
    </tr>
  </thead>
  <tbody>
    <?php if ($queryClass->rowCount() > 0) : ?>
      <?php foreach ($rowClass as $row) : ?>
        <?php $row['pengajar'] == 7 ? $bgColor = "bg-red-600 text-slate-200" : ''; ?>
        <tr class=" text-slate-600">
          <td class="px-2 py-2"><?= $row['id_class'] ?></td>
          <td class="px-2 py-2"><?= $row['nama_kelas'] ?></td>
          <td class="px-2 py-2"><?= $row['nama_materi'] ?></td>
          <td class="px-2 py-2"><?= $row['ruangan'] ?></td>
          <td class=" my-2 ">
            <p class="<?= $bgColor ?> py-2 px-2 rounded-md"><?= $row['admin_name'] ?></p>
          </td>
          <td class="px-2 py-2"><?= $row['durasi'] ?> menit</td>
          <td class="px-2 py-2"><?= $row['tanggal'] ?></td>
          <td class="text-center ">
            <button id="action-<?= $row['id_class'] ?>" class="action-button px-2 py-[5px] rounded-md hover:bg-slate-200"><i class="fa-solid fa-ellipsis"></i></button>
            <div id="dropdown-<?= $row['id_class'] ?>" class="dropdown-content hidden absolute mt-1 text-left bg-white border-2 border-white  rounded-md shadow-lg">
              <button
                href="#"
                onclick="toggleEditForm('<?= $row['id_class'] ?>')"
                class="block w-full px-4 py-2 text-sm text-left text-gray-700 rounded-md hover:bg-gray-100">
                Edit
              </button>
              <form action="class.php" method="POST">
                <input type="hidden" name="deleteRow" value="<?= $row['id_class'] ?>">
                <button type="submit" name="btnDeleteRow" class="px-4 py-2 text-sm text-left text-red-700 rounded-md hover:bg-red-100">Hapus</button>
              </form>
            </div>

            <section id="formEditClass-<?= $row['id_class'] ?>" class="fixed inset-0 flex z-30 items-center justify-center bg-black bg-opacity-50 text-left hidden">
              <div class="bg-white rounded-lg px-5 w-[40%]">
                <div class="py-3 mb-2 border-b-[2px] border-b-slate-400">
                  <div class=" mt-2 py-2 flex justify-between">
                    <h2 class="text-2xl text-slate-800 font-semibold"><?= $row['nama_kelas'] ?></h2>
                    <p class=" text-slate-700 mt-2 font-semibold"><i class="fa-solid fa-user mr-2"></i><?= $row['admin_name'] ?></p>
                  </div>
                </div>
                <form action="" method="POST" id="formEditClass" class=" grid grid-cols-3 gap-2 py-5">
                  <input type="hidden" name="edit_id_class" id="edit_id_class" value="<?= $row['id_class'] ?>">

                  <label for="edit_class" class=" mb-2 block text-sm font-medium text-gray-700">Nama Kelas</label>
                  <input type="text" name="edit_class" id="edit_class" class=" col-span-2 rounded-md px-4 py-2 mb-4 border border-slate-400 focus:outline-none focus:ring-1 focus:ring-amber-300">

                  <label for="edit_ruangan" class=" mb-2 block text-sm font-medium text-gray-700">Ruangan</label>
                  <input type="text" name="edit_ruangan" id="edit_ruangan" class=" col-span-2 rounded-md px-4 py-2 mb-4 border border-slate-400 focus:outline-none focus:ring-1 focus:ring-amber-300">


                  <label for="edit_pengajar_tanggal" class=" mb-2 block text-sm font-medium text-gray-700">Pengajar & Materi</label>
                  <div class=" w-full relative inline-block col-start-2 col-end-3 mb-3">
                    <button type="button" id="dropdownPengajar" class=" w-full px-3 py-2 flex justify-between items-center col-start-2 col-end-3 border border-slate-400  rounded-md">Pengajar<i class="fa-solid fa-chevron-down ml-2"></i></button>
                    <ul id="listMentor" class=" text-left text-sm hidden absolute left-0 mt-2 border-2 border-white bg-white shadow-md rounded-md">
                      <?php foreach ($rowMentor as $mentor) : ?>
                        <?php if ($mentor['id_admin'] != 1) : ?>
                          <li class="p-2 rounded-md hover:cursor-pointer hover:bg-slate-200" data-value="<?= htmlspecialchars($mentor['id_admin']); ?>">
                            <?= htmlspecialchars($mentor['admin_name']); ?>
                          </li>
                        <?php endif; ?>
                      <?php endforeach; ?>
                    </ul>
                  </div>
                  <div class=" w-full relative inline-block col-start-3 col-end-4">
                    <button type="button" id="dropdownMateri" class=" w-full px-3 py-2 flex justify-between items-center col-start-2 col-end-3 bg-amber-400 rounded-md">Materi<i class="fa-solid fa-chevron-down ml-2"></i></button>
                    <ul id="listMateri" class=" text-left text-sm hidden absolute left-0 mt-2 border-2 border-white bg-white shadow-md rounded-md">
                      <?php foreach ($rowMateri as $materi) : ?>
                        <li class="p-2 rounded-md hover:cursor-pointer hover:bg-slate-200" data-value="<?= htmlspecialchars($materi['id_materi']); ?>">
                          <?= htmlspecialchars($materi['nama_materi']); ?>
                        </li>
                      <?php endforeach; ?>
                    </ul>
                  </div>

                  <label for="edit_durasi" class=" mb-2 block text-sm font-medium text-gray-700">Durasi</label>
                  <input type="number" name="edit_durasi" id="edit_durasi" class=" col-span-2 rounded-md px-4 py-2 mb-4 border border-slate-400 focus:outline-none focus:ring-1 focus:ring-amber-300">

                  <button
                    type="button"
                    class=" px-4 py-3 mr-3 col-start-1 col-end-2 border border-gray-300 rounded-md text-slate-600 hover:bg-gray-100"
                    onclick="toggleEditForm('<?= $row['id_class'] ?>')">
                    Cancel
                  </button>
                  <button
                    type="submit"
                    name="submitEditMateri"
                    class=" px-4 py-3 col-start-2 col-end-4 bg-blue-700 text-white rounded-md hover:bg-blue-800">
                    Save
                  </button>

                </form>
              </div>
            </section>
          </td>
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr>
        <td colspan="12" class="py-2 px-4 text-center text-gray-700">Table Kosong</td>
      </tr>
    <?php endif; ?>
  </tbody>
</table>
<div class=" border-b-[1.5px] border-b-slate-300"></div>

<section id="formAddClass" class="hidden fixed inset-0 z-20 flex items-center justify-center bg-black bg-opacity-50">
  <div class="rounded-md w-[40%]">
    <div class="bg-white px-6 py-5 rounded-md">
      <div class="flex items-center border-b-[1.5px] border-b-slate-500 py-3 mb-5">
        <div class="w-[60px] h-[60px] mr-4 border border-slate-800 rounded-[50%] flex justify-center items-center">
          <i class="fa-solid fa-school text-2xl"></i>
        </div>
        <div class="py-3">
          <h1 class="text-3xl text-slate-800 font-semibold">Tambah Kelas Baru</h1>
        </div>
      </div>
      <form action="" method="POST" class="grid grid-cols-3 gap-2">
        <input type="hidden" name="resetID" value="<?= $_SESSION['userID'] ?>">

        <label for="nama_kelas" class="px-1 text-sm font-medium text-slate-800">Nama Kelas</label>
        <input type="text" name="nama_kelas" placeholder="Nama..." class="col-span-2 rounded-md px-4 py-2 mb-3 border border-slate-400 focus:outline-none focus:ring-1 focus:ring-amber-400">

        <label for="ruangan" class="px-1 text-sm font-medium text-slate-800">Ruangan</label>
        <input type="text" name="ruangan" placeholder="Ruangan..." class="col-span-2 rounded-md px-4 py-2 mb-3 border border-slate-400 focus:outline-none focus:ring-1 focus:ring-amber-400">

        <label for="dropdown" class=" px-1 text-sm font-medium text-slate-800">Pengajar & Materi</label>
        <div class="w-full relative inline-block col-start-2 col-end-3 mb-3">
          <button type="button" id="newDropdownPengajar" class="w-full px-3 py-2 flex justify-between items-center border border-slate-400 rounded-md">Pengajar<i class="fa-solid fa-chevron-down ml-2"></i></button>
          <ul id="newListMentor" class="text-left text-sm hidden absolute left-0 mt-2 border-2 border-white bg-white shadow-md rounded-md">
            <?php foreach ($rowMentor as $mentor) : ?>
              <?php if ($mentor['id_admin'] != 1) : ?>
                <li class="p-2 rounded-md hover:cursor-pointer hover:bg-slate-200" data-value="<?= htmlspecialchars($mentor['id_admin']); ?>">
                  <?= htmlspecialchars($mentor['admin_name']); ?>
                </li>
              <?php endif; ?>
            <?php endforeach; ?>
          </ul>
        </div>

        <div class="w-full relative inline-block col-start-3 col-end-4">
          <button type="button" id="newDropdownMateri" class="w-full px-3 py-2 flex justify-between items-center bg-amber-400 rounded-md">Materi<i class="fa-solid fa-chevron-down ml-2"></i></button>
          <ul id="newListMateri" class="text-left text-sm hidden absolute left-0 mt-2 border-2 border-white bg-white shadow-md rounded-md">
            <?php foreach ($rowMateri as $materi) : ?>
              <li class="p-2 rounded-md hover:cursor-pointer hover:bg-slate-200" data-value="<?= htmlspecialchars($materi['id_materi']); ?>">
                <?= htmlspecialchars($materi['nama_materi']); ?>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>

        <!-- Hidden inputs to store selected values -->
        <input type="hidden" name="selected_pengajar" id="selectedPengajar">
        <input type="hidden" name="selected_materi" id="selectedMateri">

        <label for="durasi" class="px-1 text-sm font-medium text-slate-800">Durasi (menit)</label>
        <input type="number" name="durasi" placeholder="Durasi..." class="col-span-2 rounded-md px-4 py-2 mb-3 border border-slate-400 focus:outline-none focus:ring-1 focus:ring-amber-400">

        <label for="tanggal" class="px-1 text-sm font-medium text-slate-800">Tanggal</label>
        <input type="date" name="tanggal" class="col-start-3 rounded-md px-4 py-2 mb-3 border border-slate-400 focus:outline-none focus:ring-1 focus:ring-amber-400">

        <button type="button" id="btnCancel" class="px-3 py-3 my-3 col-start-1 col-end-2 border border-slate-400 rounded-md hover:bg-slate-200">Cancel</button>
        <button type="submit" name="submitNewClass" class="px-3 py-3 my-3 col-start-2 col-end-4 text-slate-100 bg-blue-700 hover:bg-blue-800 rounded-md">Tambah</button>
      </form>
    </div>
  </div>
</section>

<!-- PAGINATION -->
<section class=" mt-2 py-2 flex justify-between items-center ">
  <p class="text-slate-600 text-sm">Showing : <?= $end_row ?> of <?= $total_rows; ?> rows</p>
  <p class="text-slate-600 text-sm">Page <?= $page; ?> of <?= $total_pages; ?> pages</p>
  <div>
    <a href="class.php?page=<?= max(1, $page - 1); ?>" class="hover:bg-slate-200 text-blue-800 font-semibold border border-slate-400 px-4 py-[7px] mr-3 rounded-md transition-all duration-300">
      <i class="fa-solid fa-chevron-left mr-3"></i>Prev
    </a>
    <?php if ($page > 3) : ?>
      <a href="class.php?page=1" class="px-3 py-[7px] font-semibold rounded-md border border-slate-400 hover:bg-gray-200 transition-all duration-300">1</a>
      <?php if ($page > 4) : ?>
        <span class="px-3 py-2 font-semibold">...</span>
      <?php endif; ?>
    <?php endif; ?>

    <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++) : ?>
      <a href="class.php?page=<?= $i; ?>" class="px-3 py-[7px] font-semibold rounded-md border border-slate-400 hover:bg-opacity-90 <?= $i == $page ? 'bg-amber-500 text-slate-100' : '' ?>"><?= $i; ?></a>
    <?php endfor; ?>

    <?php if ($page < $total_pages - 2) : ?>
      <?php if ($page < $total_pages - 3) : ?>
        <span class="px-3 py-2 font-semibold">...</span>
      <?php endif; ?>
      <a href="class.php?page=<?= $total_pages; ?>" class="px-3 py-[7px] font-semibold rounded-md border border-slate-400 hover:bg-gray-200 transition-all duration-300"><?= $total_pages; ?></a>
    <?php endif; ?>

    <a href="class.php?page=<?= min($total_pages, $page + 1); ?>" class="bg-blue-700 hover:bg-blue-800 text-slate-100 font-semibold px-4 py-[7px] ml-3 rounded-md">
      Next<i class="fa-solid fa-chevron-right ml-3"></i>
    </a>
  </div>
</section>
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