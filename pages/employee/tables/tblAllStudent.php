<div class=" w-auto mb-2 flex justify-between">
	<form action="" method="GET" class=" flex items-center">
		<input type="text" name="searchbox" placeholder="Search..." class=" rounded-tl-md rounded-bl-md px-4 py-1 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-amber-400">
		<button type="submitSearch" class=" px-4 py-[8.7px] bg-blue-800 text-slate-100 rounded-tr-md rounded-br-md">
			<i class="fa-solid fa-magnifying-glass"></i>
		</button>
	</form>
	<div>
		<h1 class=" font-bold text-slate-600">Siswa Kelas Ini</h1>
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
		<?php if ($listedStudent->rowCount() > 0) : ?>
			<?php foreach ($rowListed as $list) : ?>
				<tr>
					<td class=" p-2"><?= $list['admin_name'] ?></td>
					<td class=" p-2"><?= $list['nip'] ?></td>
					<td class=" p-2"><?= $list['gender'] ?></td>
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