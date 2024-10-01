<div class=" w-auto mb-2 flex justify-between">
  <form action="" method="GET" class=" flex items-center">
    <input type="text" name="searchbox" placeholder="Search..." class=" rounded-tl-md rounded-bl-md px-4 py-1 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-amber-400">
    <button type="submitSearch" class=" px-4 py-[8.7px] bg-blue-800 text-slate-100 rounded-tr-md rounded-br-md">
      <i class="fa-solid fa-magnifying-glass"></i>
    </button>
  </form>
  <div>
    <h1 class=" font-bold text-slate-600">Daftar Semua Siswa</h1>
  </div>
</div>
<table class="text-sm overflow-x-auto table-auto w-full">
  <thead>
    <tr class="border-y-[1.5px] border-y-slate-300 text-slate-800">
      <th class=" text-left px-2 py-3">Nama</th>
      <th class=" text-left px-2 py-3">NIM</th>
      <th class=" text-left px-2 py-3">Jenis Kelamin</th>
      <th class=" text-center px-2 py-3 w-[50px]"></th>
    </tr>
  </thead>
  <tbody>
    <?php if ($queryStudent->rowCount() > 0) : ?>
      <?php foreach ($rowStudent as $row) : ?>
        <tr class=" text-slate-600">
          <td class="px-2 py-2"><?= $row['admin_name'] ?></td>
          <td class="px-2 py-2"><?= $row['nip'] ?></td>
          <td class="px-2 py-2"><?= $row['gender'] ?></td>
          <td class="text-center ">

            <button id="action-<?= $row['id_admin'] ?>" class="action-button px-2 py-[5px] rounded-md hover:bg-slate-200"><i class="fa-solid fa-ellipsis"></i></button>
            <div id="dropdown-<?= $row['id_admin'] ?>" class="dropdown-content hidden absolute mt-1 text-left bg-white border-2 border-white  rounded-md shadow-lg">
              <form action=" " method="POST">
                <input type="hidden" name="idClass" value="<?= $_SESSION['idClass'] ?>">
                <input type="hidden" name="student" value="<?= $row['id_admin'] ?>">
                <button type="submit" name="submitStudent" class="px-4 py-2 text-slate-800 rounded-md hover:bg-slate-200">Tambah</button>
              </form>
            </div>

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

<!-- PAGINATION -->
<?php
echo pagination($page, $total_pages, 'classDetail.php?id='.$id_class, $start_row, $end_row);
?>


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