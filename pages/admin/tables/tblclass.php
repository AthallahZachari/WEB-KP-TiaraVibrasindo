<div class=" w-auto mb-3 flex justify-between">
  <form action="" method="GET" class=" flex items-center">
    <input type="text" name="searchbox" placeholder="Search..." class=" rounded-tl-md rounded-bl-md px-4 py-1 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-amber-400">
    <button type="submitSearch" class=" px-4 py-[4.7px] bg-blue-800 text-slate-100 rounded-tr-md rounded-br-md">
      <i class="fa-solid fa-magnifying-glass"></i>
    </button>
  </form>
  <button
    id="btnAddClass"
    class=" px-4 py-[4.7px] text-white font-semibold rounded-md bg-amber-400 hover:bg-amber-500">
    <i class="fa-solid fa-plus mr-2"></i>New
  </button>
</div>
<table class=" text-sm overflow-x-auto table-auto w-full">
  <thead>
    <tr class=" border-y-[1.5px] border-y-slate-300 text-slate-800">
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
        <tr class=" text-slate-600">
          <td class=" p-2"><?= $row['id_class'] ?></td>
          <td class=" p-2"><?= $row['nama_kelas'] ?></td>
          <td class=" p-2"><?= $row['nama_materi'] ?></td>
          <td class=" p-2"><?= $row['ruangan'] ?></td>
          <td class=" p-2"><?= $row['admin_name'] ?></td>
          <td class=" p-2"><?= $row['durasi'] ?></td>
          <td class=" p-2"><?= $row['tanggal'] ?></td>
          <td class=" text-center">

            <!-- [ BUTTON ] Show Option-->
            <button
              id="btnOption-<?= $row['id_class'] ?>"
              class="btnOption px-2 py-[5px] rounded-md hover:bg-slate-200">
              <i class="fa-solid fa-ellipsis"></i>
            </button>

            <!-- OPTION MENU -->
            <div id="menuOption-<?= $row['id_class'] ?>" class="hidden absolute mt-1 text-left bg-white border-2 border-white  rounded-md shadow-lg">
              <!-- [ BUTTON ] Edit Row-->
              <button
                id="btntoggleForm-<?= $row['id_class'] ?>"
                class="btntoggleForm block w-full px-4 py-2 text-sm text-left text-gray-700 rounded-md hover:bg-gray-100">
                Edit
              </button>

              <!-- [ BUTTON ] Delete Row-->
              <form action="class.php" method="POST">
                <input type="hidden" name="deleteRow" value="<?= $row['id_class'] ?>">
                <button
                  type="submit"
                  name="btnDelete"
                  class=" px-4 py-2 text-sm text-left text-red-700 rounded-md hover:bg-red-100">
                  Hapus
                </button>
              </form>

              <!-- [ FORM ] Edit Class -->
              <section id="toggleFormEdit-<?= $row['id_class'] ?>" class="hidden fixed inset-0 flex z-30 items-center justify-center bg-black bg-opacity-50 text-left">
                <div class=" bg-white rounded-lg px-5 w-[40%]">
                  <div class="py-3 mb-2 border-b-[2px] border-b-slate-400">
                    <div class=" mt-2 py-2 flex justify-between">
                      <h2 class="text-2xl text-slate-800 font-semibold"><?= $row['nama_kelas'] ?></h2>
                      <p class=" text-slate-700 mt-2 font-semibold"><i class="fa-solid fa-user mr-2"></i><?= $row['admin_name'] ?></p>
                    </div>
                  </div>
                  <form action="" method="POST" id="formEdit" class=" grid grid-cols-3 gap-2 py-5">
                    <input type="hidden" name="id" id="id" value="<?= $row['id_class'] ?>">

                    <label for="edit_class" class=" mb-2 block text-sm font-medium text-gray-700">Nama Kelas</label>
                    <input type="text" name="nama_class" id="nama_class" class=" col-span-2 rounded-md px-4 py-2 mb-4 border border-slate-400 focus:outline-none focus:ring-1 focus:ring-amber-300">

                    <label for="edit_ruangan" class=" mb-2 block text-sm font-medium text-gray-700">Ruangan</label>
                    <input type="text" name="edit_ruangan" id="edit_ruangan" class=" col-span-2 rounded-md px-4 py-2 mb-4 border border-slate-400 focus:outline-none focus:ring-1 focus:ring-amber-300">


                    <label for="edit_pengajar_tanggal" class=" mb-2 block text-sm font-medium text-gray-700">Pengajar & Materi</label>
                    <div class=" w-full relative inline-block col-start-2 col-end-3 mb-3">
                      <!-- [ BUTTON ] Dropdown Pengajar -->
                      <button
                        type="button"
                        id="dropPengajar-<?= $row['id_class'] ?>"
                        class="dropPengajar w-full px-3 py-2 flex justify-between items-center col-start-2 col-end-3 border border-slate-400  rounded-md">
                        Pengajar<i class="fa-solid fa-chevron-down ml-2"></i>
                      </button>
                      <ul id="listMentor-<?= $row['id_class'] ?>" class=" max-h-60 overflow-y-auto text-left text-sm hidden absolute left-0 mt-2 border-2 border-white bg-white shadow-md rounded-md">
                        <?php foreach ($rowMentor as $mentor) : ?>
                          <?php if ($mentor['id_admin'] != 1) : ?>
                            <li class="p-2 rounded-md hover:cursor-pointer hover:bg-slate-200" data-value="<?= htmlspecialchars($mentor['id_admin']); ?>">
                              <?= htmlspecialchars($mentor['admin_name']); ?>
                            </li>
                          <?php endif; ?>
                        <?php endforeach; ?>
                      </ul>
                      <!-- DROPDOWN Input Handler -->
                      <input type="hidden" name="selected_pengajar" id="selectedPengajar-<?= $row['id_class'] ?>">
                    </div>

                    <!-- [ BUTTON ] Dropdown Materi -->
                    <div class=" w-full relative inline-block col-start-3 col-end-4">
                      <button
                        type="button"
                        id="dropMateri-<?= $row['id_class'] ?>"
                        class="dropMateri w-full px-3 py-2 flex justify-between items-center col-start-2 col-end-3 bg-amber-400 rounded-md">
                        Materi<i class="fa-solid fa-chevron-down ml-2"></i>
                      </button>
                      <ul id="listMateri-<?= $row['id_class'] ?>" class=" max-h-60 overflow-y-auto text-left text-sm hidden absolute left-0 mt-2 border-2 border-white bg-white shadow-md rounded-md">
                        <?php foreach ($rowMateri as $materi) : ?>
                          <li class="p-2 rounded-md hover:cursor-pointer hover:bg-slate-200" data-value="<?= htmlspecialchars($materi['id_materi']); ?>">
                            <?= htmlspecialchars($materi['nama_materi']); ?>
                          </li>
                        <?php endforeach; ?>
                      </ul>
                      <!-- DROPDOWN Input Handler -->
                      <input type="hidden" name="selected_materi" id="selectedMateri-<?= $row['id_class'] ?>">
                    </div>

                    <label for="edit_durasi" class=" mb-2 block text-sm font-medium text-gray-700">Durasi</label>
                    <input type="number" name="edit_durasi" id="edit_durasi" class=" col-span-2 rounded-md px-4 py-2 mb-4 border border-slate-400 focus:outline-none focus:ring-1 focus:ring-amber-300">

                    <button
                      type="button"
                      id="btnCancel-<?= $row['id_class'] ?>"
                      class="btnCancel px-4 py-3 mr-3 col-start-1 col-end-2 border border-gray-300 rounded-md text-slate-600 hover:bg-gray-100">
                      Cancel
                    </button>
                    <button
                      type="submit"
                      name="submitEditClass"
                      class=" px-4 py-3 col-start-2 col-end-4 bg-blue-700 text-white rounded-md hover:bg-blue-800">
                      Save
                    </button>
                  </form>
                </div>
              </section>

            </div>
          </td>
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr>
        <td colspan="12" class=" py-2 px-4 text-center text-gray-700">Table Kosong</td>
      </tr>
    <?php endif; ?>
  </tbody>
</table>
<div class=" border-b-[1.5px] border-b-slate-300"></div>

<!-- [ FORM ] Add Class -->
<section id="toggleFormAdd" class="hidden fixed inset-0 flex z-30 items-center justify-center bg-black bg-opacity-50 text-left">
  <div class=" bg-white rounded-lg px-5 w-[40%]">
    <div class="py-3 mb-2 border-b-[2px] border-b-slate-400">
      <div class=" mt-2 py-2 flex justify-between">
        <h2 class="text-2xl text-slate-800 font-semibold">Input Kelas Baru</h2>
      </div>
    </div>
    <form action="" method="POST" id="formAdd" class=" grid grid-cols-3 gap-2 py-5">
      <label for="edit_class" class=" mb-2 block text-sm font-medium text-gray-700">Nama Kelas</label>
      <input type="text" name="class" id="class" class=" col-span-2 rounded-md px-4 py-2 mb-4 border border-slate-400 focus:outline-none focus:ring-1 focus:ring-amber-300">

      <label for="edit_ruangan" class=" mb-2 block text-sm font-medium text-gray-700">Ruangan</label>
      <input type="text" name="ruangan" id="ruangan" class=" col-span-2 rounded-md px-4 py-2 mb-4 border border-slate-400 focus:outline-none focus:ring-1 focus:ring-amber-300">


      <label for="edit_pengajar_tanggal" class=" mb-2 block text-sm font-medium text-gray-700">Pengajar & Materi</label>
      <div class=" w-full relative inline-block col-start-2 col-end-3 mb-3">
        <!-- [ BUTTON ] Dropdown Pengajar -->
        <button
          type="button"
          id="dropdownPengajar"
          class="w-full px-3 py-2 flex justify-between items-center col-start-2 col-end-3 border border-slate-400  rounded-md">
          Pengajar<i class="fa-solid fa-chevron-down ml-2"></i>
        </button>
        <ul id="listMentor" class=" max-h-60 overflow-y-auto text-left text-sm hidden absolute left-0 mt-2 border-2 border-white bg-white shadow-md rounded-md">
          <?php foreach ($rowMentor as $mentor) : ?>
            <?php if ($mentor['id_admin'] != 1) : ?>
              <li class="p-2 rounded-md hover:cursor-pointer hover:bg-slate-200" data-value="<?= htmlspecialchars($mentor['id_admin']); ?>">
                <?= htmlspecialchars($mentor['admin_name']); ?>
              </li>
            <?php endif; ?>
          <?php endforeach; ?>
        </ul>
        <!-- DROPDOWN Input Handler -->
        <input type="hidden" name="selectedPengajar" id="selectedPengajar" >
      </div>

      <!-- [ BUTTON ] Dropdown Materi -->
      <div class=" w-full relative inline-block col-start-3 col-end-4">
        <button
          type="button"
          id="dropdownMateri"
          class=" w-full px-3 py-2 flex justify-between items-center col-start-2 col-end-3 bg-amber-400 rounded-md">
          Materi<i class="fa-solid fa-chevron-down ml-2"></i>
        </button>
        <ul id="listMateri" class=" max-h-60 overflow-y-auto text-left text-sm hidden absolute left-0 mt-2 border-2 border-white bg-white shadow-md rounded-md">
          <?php foreach ($rowMateri as $materi) : ?>
            <li class="p-2 rounded-md hover:cursor-pointer hover:bg-slate-200" data-value="<?= htmlspecialchars($materi['id_materi']); ?>">
              <?= htmlspecialchars($materi['nama_materi']); ?>
            </li>
          <?php endforeach; ?>
        </ul>
        <!-- DROPDOWN Input Handler -->
        <input type="hidden" name="selectedMateri" id="selectedMateri">
      </div>

      <label for="durasi" class=" mb-2 block text-sm font-medium text-gray-700">Durasi</label>
      <input type="number" name="durasi" id="durasi" class=" rounded-md px-4 py-2 mb-4 border border-slate-400 focus:outline-none focus:ring-1 focus:ring-amber-300">
      <input type="date" name="tanggal" id="tanggal" class=" rounded-md px-4 py-2 mb-4 border border-slate-400 focus:outline-none focus:ring-1 focus:ring-amber-300">

      <button
        type="button"
        id="btnCancel"
        class="btnCancel px-4 py-3 mr-3 col-start-1 col-end-2 border border-gray-300 rounded-md text-slate-600 hover:bg-gray-100">
        Cancel
      </button>
      <button
        type="submit"
        name="submitNewClass"
        class=" px-4 py-3 col-start-2 col-end-4 bg-blue-700 text-white rounded-md hover:bg-blue-800">
        Save
      </button>
    </form>
  </div>
</section>

<script>
  document.querySelectorAll(`.btnOption`).forEach(button => {
    button.addEventListener('click', function(event) {
      const classID = this.id.split('-')[1];
      const dropdown = document.getElementById(`menuOption-${classID}`);
      dropdown.classList.toggle('hidden');
    })
  })


  // [ DROPDOWN ] pengajar
  document.querySelectorAll(`.dropPengajar`).forEach(button => {
    button.addEventListener('click', function(event) {
      const classID = this.id.split('-')[1];
      const dropdown = document.getElementById(`listMentor-${classID}`);
      dropdown.classList.toggle('hidden');

      //Handle selected input
      dropdown.querySelectorAll('li').forEach(item => {
        item.addEventListener('click', function() {
          const selectedValue = this.getAttribute('data-value');
          const selectedText = this.textContent;

          button.innerHTML = `${selectedText}<i class="fa-solid fa-chevron-down ml-2"></i>`;
          dropdown.classList.toggle('hidden');

          // Update input hidden dengan nilai pengajar yang dipilih
          document.getElementById(`selectedPengajar-${classID}`).value = selectedValue;
        })
      })
    })
  })

  // [ DROPDOWN ] materi
  document.querySelectorAll(`.dropMateri`).forEach(button => {
    button.addEventListener('click', function(event) {
      const classID = this.id.split('-')[1];
      const dropdown = document.getElementById(`listMateri-${classID}`)
      dropdown.classList.toggle('hidden');

      // Handle Selected Input
      dropdown.querySelectorAll('li').forEach(item => {
        item.addEventListener('click', function() {
          const selectedValue = this.getAttribute('data-value');
          const selectedText = this.textContent;

          button.innerHTML = `${selectedText}<i class="fa-solid fa-chevron-down ml-2"></i>`;
          dropdown.classList.toggle('hidden');

          document.getElementById(`selectedMateri-${classID}`).value = selectedValue;
        })
      })
    })
  })

  // [ TOGGLE ] Edit form
  document.querySelectorAll(`.btntoggleForm`).forEach(button => {
    button.addEventListener('click', function(event) {
      const classID = this.id.split('-')[1];
      const dropdown = document.getElementById(`toggleFormEdit-${classID}`);
      dropdown.classList.toggle('hidden');


    })
  })

  document.querySelectorAll(`.btnCancel`).forEach(button => {
    button.addEventListener('click', function(event) {
      const classID = this.id.split('-')[1];
      const dropdown = document.getElementById(`toggleFormEdit-${classID}`);
      dropdown.classList.toggle('hidden');
    })
  })

  // [ TOGGLE ] Add New Form
  document.addEventListener('DOMContentLoaded', function() {
    toggleAddForm('btnAddClass');
    toggleAddForm('btnCancel');
    toggleDropdown('dropdownMateri', 'listMateri', 'selectedMateri');
    toggleDropdown('dropdownPengajar', 'listMentor', 'selectedPengajar');
  });

  function toggleAddForm(id) {
    document.getElementById(`${id}`).addEventListener('click', () => {
      document.getElementById(`toggleFormAdd`).classList.toggle('hidden');
    })
  }

  function toggleDropdown(id, target, input) {
    const dropdown = document.getElementById(target);
    const button = document.getElementById(id);
    const selectedInput = document.getElementById(input);

    document.getElementById(`${id}`).addEventListener('click', () => {
      dropdown.classList.toggle('hidden');

      dropdown.querySelectorAll('li').forEach(item => {
        item.addEventListener('click', function() {
          const selectedValue = this.getAttribute('data-value');
          const selectedText = this.textContent;

          button.innerHTML = `${selectedText}<i class="fa-solid fa-chevron-down ml-2"></i>`;
          dropdown.classList.add('hidden');  

          selectedInput.value = selectedValue;
        })
      })
    })
  }
</script>