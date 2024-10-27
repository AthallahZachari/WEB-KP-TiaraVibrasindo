<div class="w-auto mb-2 flex justify-between">
  <form action="" method="GET" class="flex items-center">
    <input type="text" name="searchbox" placeholder="Search..." class=" rounded-tl-md rounded-bl-md px-4 py-1 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-amber-400">
    <button type="submitSearch" class=" px-4 py-[8.7px] bg-blue-800 text-slate-100 rounded-tr-md rounded-br-md">
      <i class="fa-solid fa-magnifying-glass"></i>
    </button>
  </form>
  <div>
    <h1 class=" font-bold text-slate-600">Attendance</h1>
  </div>
</div>
<table class="text-sm overflow-x-auto table-auto w-full">
  <thead>
    <tr class="border-y-[1.5px] border-y-slate-300 text-slate-800">
      <th class=" text-left px-2 py-3">Nama</th>
      <th class=" text-left px-2 py-3">Status</th>
      <th class=" text-left px-2 py-3">Waktu</th>
      <th class=" text-center px-2 py-3 w-[50px]"></th>
    </tr>
  </thead>
  <tbody>
    <?php if ($attendanceList->rowCount() > 0) : ?>
      <?php foreach ($rowAttendance as $list) : ?>
        <tr>
          <td class=" p-2">
            <div class=" flex items-center">
              <div class=" px-3 py-2 mr-3 rounded-[50%] bg-slate-200 text-center">
                <i class="fa-solid fa-user"></i>
              </div>
              <div class="">
                <p class=" font-bold text-slate-800"><?= $list['admin_name'] ?></p>
                <p class=" text-slate-400"><?= $list['nip'] ?></p>
              </div>
            </div>
          </td>
          <td class=" p-2"><p class=" p-2 <?= Utils::bgAttendance($list['status']) ?> rounded-md"><?= $list['status'] ?></p></td>
          <td class=" p-2"><p class=" text-amber-600"><i class="fa-regular fa-clock mr-1"></i><?=Utils::readTime($list['time'])?></p></td>
          <td class=" p-2">
            <button id="" class="action-button px-2 py-[5px] rounded-md hover:bg-slate-200"><i class="fa-solid fa-ellipsis"></i></button>
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