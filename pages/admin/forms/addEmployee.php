<?php
require_once '../../pages/component/utils.php';

$password = Utils::randPassword(8);
?>

<div class="rounded-md w-[40%]">
  <div class="bg-white px-6 py-5 rounded-md">
    <div class="flex items-center border-b-[1.5px] border-b-slate-500 py-3 mb-5">
      <div class="w-[60px] h-[60px] mr-4 border border-slate-800 rounded-[50%] flex justify-center items-center">
        <i class="fa-solid fa-users text-2xl "></i>
      </div>
      <div class="py-3">
        <h1 class="text-3xl text-slate-800 font-semibold">Daftar Pengguna Baru</h1>
      </div>
    </div>
    <form action="" method="POST" class="grid grid-cols-3 gap-2">
      <input type="hidden" name="resetID" value="<?= $_SESSION['userID'] ?>">

      <label for="nama" class="px-1 text-sm font-medium text-slate-800">Nama </label>
      <input type="text" name="nama" placeholder="Nama..." class="col-span-2 rounded-md px-4 py-2 mb-3 border border-slate-400 focus:outline-none focus:ring-1 focus:ring-amber-400">

      <label for="nip" class="px-1 text-sm font-medium text-slate-800">NIP</label>
      <input type="text" name="nip" placeholder="Ruangan..." class="col-span-2 rounded-md px-4 py-2 mb-3 border border-slate-400 focus:outline-none focus:ring-1 focus:ring-amber-400">

      <input type="hidden" name="password" value="<?= $password?>">

      <label for="jenis_kelamin" class="px-1 text-sm font-medium text-slate-800">Jenis Kelamin & Status</label>
      <select name="jenis_kelamin" id="jenis_kelamin" class=" col-start-2 col-end-3 rounded-md px-3 py-2 mb-3 border border-slate-400 focus:outline-none focus:ring-1 focus:ring-amber-400">
        <option value="" disabled selected>Gender</option>
        <option value="pria">Pria</option>
        <option value="wanita">Wanita</option>
      </select>

      <select name="role" id="role" class=" col-start-3 col-end-4 rounded-md px-3 py-2 mb-3 bg-amber-400 focus:outline-none focus:ring-1 focus:ring-amber-400">
        <option value="" class=" bg-white" disabled selected>Role</option>
        <option value="admin" class=" bg-white">Admin</option>
        <option value="employee" class=" bg-white">Employee</option>
        <option value="student" class=" bg-white">Student</option>
      </select>

      <button type="button" id="btnCancel" class="px-3 py-3 my-3 col-start-1 col-end-2 border border-slate-400 rounded-md hover:bg-slate-200">Cancel</button>
      <button type="submit" name="submitNewClass" class="px-3 py-3 my-3 col-start-2 col-end-4 text-slate-100 bg-blue-700 hover:bg-blue-800 rounded-md">Tambah</button>
    </form>
  </div>
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