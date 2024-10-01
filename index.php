<?php
include './includes/header.php';

$currentDate = date('Y-m-d');
?>

<body>
  <section class=" w-full h-200px text-slate-800 sticky top-0 m-auto bg-blue-800">
    <nav class=" px-6 py-2 flex justify-between items-center">
      <div class=" flex items-center">
        <div class=" w-[80px] h-[47px] mr-3 bg-cover bg-center">
          <img src="./assets/Logo.jpg" alt="logo-tiara" class=" w-full object-cover">
        </div>
        <h1 class=" text-2xl text-slate-100 font-bold">TIARA VIBRASINDO</h1>
      </div>
      <ul class=" flex justify-between ">
        <li>
          <a href="./pages/admin/adminlogin.php" class=" px-5 py-3 text-slate-200 rounded-md bg-blue-600 hover:bg-blue-700">
            Login<i class="fa-solid fa-arrow-right-to-bracket ml-2"></i>
          </a>
        </li>
      </ul>
    </nav>
  </section>

  <section class="px-6 h-[90vh] grid grid-cols-2 gap-4">
    <div class=" w-full pt-10">
      <div class=" w-[50%] py-6">
        <h1 class=" text-5xl font-semibold m-0 p-0">Enhance Your Learning Experience</h1>
      </div>
      <h3 class="py-4 w-[80%]">Enhance your learning experience by exploring interactive learning platforms. You can unlock a myriad of opportunities to deepen your understanding, foster collaborative learning experiences, and cultivate essential skills.</h3>
      <section class="w-[70%] grid grid-cols-3 gap-3 font-semibold">
        <button class=" col-span-1 px-3 py-4 rounded-md border border-slate-400 hover:bg-slate-200">
          Get Started
        </button>
        <button class=" col-span-2 rounded-md bg-blue-700 text-amber-400 hover:bg-blue-800">
          Learning Information
        </button>
      </section>
    </div>
    <div class=" w-full flex flex-col justify-center">
      <div class=" w-full mr-3 bg-black bg-cover bg-center">
        <img src="./assets/hectorr.jpg" alt="logo-tiara" class=" w-full object-cover">
      </div>
    </div>
  </section>

</body>
<?php
include './includes/footer.php';
?>