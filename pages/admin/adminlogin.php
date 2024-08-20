<?php
include '../../includes/header.php';
include '../../includes/connection/connection.php';
include '../../includes/connection/admincontrol.php';

$errorMessage = "";

if (isset($_POST['login'])) {

  $query = $conn->prepare("SELECT * FROM admin WHERE admin_name = ? AND nip = ? AND password = ?");
  $query->execute([$_POST['username'], $_POST['nip'], $_POST['password']]);

  if ($query->rowCount() > 0) {
    session_start();
    $userData = $query->fetch(PDO::FETCH_ASSOC);

    $_SESSION['current_user'] = $userData['admin_name'];
    $_SESSION['userID'] = $userData['id_admin'];
    $_SESSION['role'] = $userData['role'];
    $_SESSION['nip'] = $userData['nip'];
    $_SESSION['gender'] = $userData['gender'];

    $_SESSION['role'] == 'admin' ? header("Location: ./admin.php") : header("Location: ../employee/employee.php");
  } else {
    $errorMessage = "Username, NIP, atau Password salah !";
  }
}

?>

<body class="w-full px-6 flex flex-col justify-center bg-slate-50 ">
  <section class=" flex space-x-10 h-screen ">
    <div class=" w-[60%] h flex flex-col justify-center items-center rounded-md bg-cover bg-bottom">
      <div class=" w-[70%] bg-cover bg-center">
        <img src="../../assets/lohin.png" alt="logo-tiara" class=" w-full object-cover">
      </div>
    </div>
    <div class=" w-[40%] px-6 mx-auto flex flex-col items-center ">
      <div class=" w-full py-3 mt-8 border-b-[1.5px] border-b-slate-500">
        <h1 class=" py-5 text-4xl text-slate-800 font-bold">Login</h1>
      </div>
      <form action="adminlogin.php" method="post" class=" w-full my-8 flex flex-col">
        <input type="text" name="username" id="inputUsername" placeholder="Username" class="rounded-md px-4 py-2 mb-4 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-amber-400">
        <input type="text" name="nip" id="inputNip" placeholder="NIP/NIM" class="rounded-md px-4 py-2 mb-4 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-amber-400">
        <input type="password" name="password" id="inputPassword" placeholder="Password" class="rounded-md px-4 py-2 mb-2 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-amber-400">

        <section class=" flex px-2 mb-2">
          <input type="checkbox" name="" id="" class="">
          <p class=" ml-3 text-sm text-amber-500 font-normal ">I agree to the terms & conditions</p>
        </section>
        <p class=" text-center text-sm text-red-600 py-2"><?= $errorMessage ?></p>
        <button type="submit" name="login" class="bg-blue-800 hover:bg-blue-900 text-white text-lg font-semibold px-8 py-3 rounded-md transition-all duration-300">
          Login
        </button>
      </form>
      <section class=" w-full grid grid-cols-3 gap-4 items-center mb-4">
        <div class=" ">
          <hr class=" border-black">
        </div>
        <div class=" text-center">Or login with</div>
        <div class=" ">
          <hr class=" border-black">
        </div>
      </section>
      <section class=" w-full grid grid-cols-2 gap-2 ">
        <div class=" py-3 flex items-center justify-center rounded-md text-slate-700 border border-slate-400 hover:cursor-pointer hover:bg-slate-100">
          <div class="h-[30px] w-[30px] mr-2 bg-cover bg-center">
            <img src="../../assets/iconGoogle.png" alt="" class=" w-full object-cover">
          </div>
          Google
        </div>
        <div class=" text-center">
          <div class=" py-3 flex items-center justify-center rounded-md text-slate-700 border border-slate-400 hover:cursor-pointer hover:bg-slate-100">
            <div class="h-[30px] w-[30px] mr-2 bg-cover bg-center">
              <img src="../../assets/iconApple.png" alt="" class=" w-full object-cover">
            </div>
            Apple
          </div>
        </div>
      </section>
    </div>
  </section>
</body>