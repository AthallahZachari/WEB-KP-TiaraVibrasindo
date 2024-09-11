<div class="bg-white rounded-lg px-5 w-[40%]">
  <div class="py-3 mb-2 border-b-[2px] border-b-slate-400">
    <div class=" mt-2 py-2 flex justify-between">
      <h2 class="text-2xl text-slate-800 font-semibold">#<?= $row['nip'] ?></h2>
      <p class=" text-slate-700 mt-2 font-semibold"><i class="fa-solid fa-user mr-2"></i><?= $row['admin_name'] ?></p>
    </div>
  </div>
  <form action="" method="POST" id="formEditEmployee" class=" grid grid-cols-3 gap-2 py-5">
    <input type="hidden" name="id_admin" id="id_admin" value="<?= $row['id_admin'] ?>">

    <label for="edit_name" class=" mb-2 block text-sm font-medium text-gray-700">Nama</label>
    <input type="text" name="edit_name" id="edit_name" value="<?= $row['admin_name']?>" class=" col-span-2 rounded-md px-4 py-2 mb-4 border border-slate-400 focus:outline-none focus:ring-1 focus:ring-amber-300">

    <label for="edit_nip" class=" mb-2 block text-sm font-medium text-gray-700">NIP / NIM</label>
    <input type="text" name="edit_nip" id="edit_nip" value="<?= $row['nip']?>" class=" col-span-2 rounded-md px-4 py-2 mb-4 border border-slate-400 focus:outline-none focus:ring-1 focus:ring-amber-300">


    <label for="edit_gender" class=" mb-2 block text-sm font-medium text-gray-700">Gender & Role</label>
    <select name="edit_gender" id="edit_gender" class=" col-start-2 col-end-3 rounded-md px-3 py-2 mb-3 border border-slate-400 focus:outline-none focus:ring-1 focus:ring-amber-400 hover:cursor-pointer">
      <option value="" disabled selected>Gender</option>
      <option value="pria">Pria</option>
      <option value="wanita">Wanita</option>
    </select>

    <select name="edit_role" id="edit_role" class=" col-start-3 col-end-4 rounded-md px-3 py-2 mb-3 border border-slate-400 focus:outline-none focus:ring-1 focus:ring-amber-400 hover:cursor-pointer">
      <option value="" disabled selected>Role</option>
      <option value="admin">Admin</option>
      <option value="employee">Employee</option>
      <option value="student">Student</option>
    </select>

    <label for="edit_password" class=" mb-2 block text-sm font-medium text-gray-700">Password</label>
    <input type="text" name="edit_password" id="edit_password" value="<?= $row['password']?>" class=" col-span-2 rounded-md px-4 py-2 mb-4 border border-slate-400 focus:outline-none focus:ring-1 focus:ring-amber-300">

    <button
      type="button"
      class=" px-4 py-3 mr-3 col-start-1 col-end-2 border border-gray-300 rounded-md text-slate-600 hover:bg-gray-100"
      onclick="toggleEditForm('<?= $row['id_admin'] ?>')">
      Cancel
    </button>
    <button
      type="submit"
      name="submitEditUser"
      class=" px-4 py-3 col-start-2 col-end-4 bg-blue-700 text-white rounded-md hover:bg-blue-800">
      Save
    </button>

  </form>
</div>