<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MSL | @yield('tittle')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/YOUR_KIT_CODE.js" crossorigin="anonymous"></script>
</head>
<body class="bg-gray-100 font-[Poppins]">
    <nav class="bg-[#00a86b] p-4 px-10 flex justify-between items-center shadow-lg text-white fixed top-0 left-0 w-full z-50">
            <div>
              <img src="/img/logo.png" alt="Logo" class="h-10 w-auto">
            </div>
            <button id="menu-toggle" class="md:hidden text-white focus:outline-none">
                ☰
            </button>
            <ul id="menu" class="hidden md:flex space-x-4 font-bold">
                <li><a href="#" class="hover:underline">Home</a></li>
                <li><a href="/schedule" class="hover:underline">Schedule</a></li>
                <li><a href="#" class="hover:underline">Dashboard</a></li>
                <li><a href="#" class="hover:underline">Contact</a></li>
            </ul>
    </nav>
    

    @yield('content')


    {{-- <section id="FOOTER "> 
    <div class="ft-2  bg-black text-white p-5">
      <hr class="color-white">
      <div class="row justify-content-center p-5">
        <div class="col-md-6 p-5">
          <h3 class="fw-bold ">HARVEST HUB</h3>
          <p> E-Commerce dan  layanan konsultasi <br>di bidang Pertanian dan Peternakan.</p>
            
        </div>
        <div class="col-md-6 row justify-content-between text-start p-5 ">
          <div class="col-md-4">
            <h6>Contact</h6><br> 
              <ul>
                <li><h6>Email</h6></li>
                <li>Facebook</li>
                <li>Instagram</li>
              </ul>
          </div>
          <div class="col-md-4">
            <h6>About</h6><br>
            <ul>
              <li>Team</li>
              <li>Shipping</li>
              <li>Affiliate</li>
            </ul>
          </div>
          <div class="col-md-4">
            <h6>Info</h6><br>
            <ul>
              <li>Privacy Policies</li>
              <li>Terms & Conditions</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    
  </section> --}}

  <script>
        document.getElementById('menu-toggle').addEventListener('click', function() {
            document.getElementById('menu').classList.toggle('hidden');
        });
   </script>

    
</body>
</html>