<?php 

?>

<section class="px-5 py-6 w-full rounded-lg shadow-xl">
  <div class=" w-auto mb-3 flex justify-between">
    <form action="" method="GET" class=" flex items-center">
      <input type="text" name="searchbox" placeholder="Search..." class=" rounded-tl-md rounded-bl-md px-4 py-1 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-amber-400">
      <button type="submit" class=" px-4 py-[4.7px] bg-blue-800 text-slate-100 rounded-tr-md rounded-br-md">
        <i class="fa-solid fa-magnifying-glass"></i>
      </button>
    </form>
    <button id="btnTambahEmployee" class=" px-3 py-[4.7px] text-sm text-white font-semibold rounded-md bg-amber-400 hover:bg-amber-500"><i class="fa-solid fa-plus mr-2"></i>Add User</button>
  </div>
  <table class="text-sm overflow-x-auto table-auto w-full">
    <thead>
      <tr class="border-y-[1.5px] border-y-slate-300">
        <th class=" text-left px-2 py-3">ID</th>
        <th class=" text-left px-2 py-3">Nama</th>
        <th class=" text-left px-2 py-3">Gender</th>
        <th class=" text-left px-2 py-3">Password</th>
        <th class=" text-left px-2 py-3">Role</th>
        <th class=" text-left px-2 py-3"></th>
      </tr>
    </thead>
    <tbody>
      <?php if ($queryEmployee->rowCount() > 0) : ?>
        <?php foreach ($rowsEmployee as $row) : ?>
          <tr class=" text-slate-600">
            <td class="px-2 py-2"><?= $row['nip'] ?></td>
            <td class="px-2 py-2"><?= $row['admin_name'] ?></td>
            <td class="px-2 py-2"><?= $row['gender'] ?></td>
            <td class="px-2 py-2 font-bold"><?= $row['password'] ?></td>
            <td class="px-2"><p class=" mt-[2px] px-2 py-2 <?= Utils::bgSetter($row['role']) ?> rounded-md"><?= $row['role'] ?></p></td>
            <td class="text-center ">
              <button id="action-<?= $row['id_admin'] ?>" class="action-button px-2 py-[5px] rounded-md hover:bg-slate-200"><i class="fa-solid fa-ellipsis"></i></button>
              <div id="dropdown-<?= $row['id_admin'] ?>" class="dropdown-content hidden absolute mt-1 text-left bg-white border-2 border-white  rounded-md shadow-lg">
                <button
                  href="#"
                  onclick="toggleEditForm('<?= $row['id_admin'] ?>')"
                  class="block w-full px-4 py-2 text-sm text-left text-gray-700 rounded-md hover:bg-gray-100">
                  Edit
                </button>
                <form action="class.php" method="POST">
                  <input type="hidden" name="deleteRow" value="<?= $row['id_admin'] ?>">
                  <button type="submit" name="btnDeleteRow" class="px-4 py-2 text-sm text-left text-red-700 rounded-md hover:bg-red-100">Hapus</button>
                </form>
              </div>

            </td>
          </tr>
        <?php endforeach; ?>
      <?php else : ?>
        <tr>
          <td colspan="12" class="py-2 px-4 text-center text-gray-700">Table Kosong</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
  <div class=" border-b-[1.5px] border-b-slate-300"></div>

  <!-- PAGINATION -->
  <section class=" mt-2 py-2 flex justify-between items-center ">
    <p class="text-slate-600 text-sm">Showing : <?= $end_row ?> of <?= $total_rows; ?> rows</p>
    <p class="text-slate-600 text-sm">Page <?= $page; ?> of <?= $total_pages; ?> pages</p>
    <div>
      <a href="inputemployee.php?page=<?= max(1, $page - 1); ?>" class="hover:bg-slate-200 text-blue-800 font-semibold border border-slate-400 px-4 py-[7px] mr-3 rounded-md transition-all duration-300">
        <i class="fa-solid fa-chevron-left mr-3"></i>Prev
      </a>
      <?php if ($page > 3) : ?>
        <a href="inputemployee.php?page=1" class="px-3 py-[7px] font-semibold rounded-md border border-slate-400 hover:bg-gray-200 transition-all duration-300">1</a>
        <?php if ($page > 4) : ?>
          <span class="px-3 py-2 font-semibold">...</span>
        <?php endif; ?>
      <?php endif; ?>

      <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++) : ?>
        <a href="inputemployee.php?page=<?= $i; ?>" class="px-3 py-[7px] font-semibold rounded-md border border-slate-400 hover:bg-opacity-90 <?= $i == $page ? 'bg-amber-500 text-slate-100' : '' ?>"><?= $i; ?></a>
      <?php endfor; ?>

      <?php if ($page < $total_pages - 2) : ?>
        <?php if ($page < $total_pages - 3) : ?>
          <span class="px-3 py-2 font-semibold">...</span>
        <?php endif; ?>
        <a href="inputemployee.php?page=<?= $total_pages; ?>" class="px-3 py-[7px] font-semibold rounded-md border border-slate-400 hover:bg-gray-200 transition-all duration-300"><?= $total_pages; ?></a>
      <?php endif; ?>

      <a href="inputemployee.php?page=<?= min($total_pages, $page + 1); ?>" class="bg-blue-700 hover:bg-blue-800 text-slate-100 font-semibold px-4 py-[7px] ml-3 rounded-md">
        Next<i class="fa-solid fa-chevron-right ml-3"></i>
      </a>
    </div>
  </section>
</section>