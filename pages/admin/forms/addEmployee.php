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
