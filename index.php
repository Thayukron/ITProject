<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ระบบจัดการโครงงาน แผนก IT</title>
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;600&display=swap" rel="stylesheet">
  <!-- ===========================
        Navbar Section
=========================== -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow">
  <div class="container">
    <a class="navbar-brand fw-bold text-white" href="index.html">
      <img src="img/14-removebg-preview.png" 
           alt="Logo" 
           style="height:50px; width:auto; margin-right:10px; vertical-align:middle;">
      IT Project
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
            data-bs-target="#navbarNav" aria-controls="navbarNav" 
            aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link active" href="index.html">หน้าแรก</a></li>
        <li class="nav-item"><a class="nav-link" href="#">เกี่ยวกับโครงงาน</a></li>
        <li class="nav-item"><a class="nav-link" href="#">สมาชิก</a></li>
        <li class="nav-item"><a class="nav-link" href="report.php">ผลงาน</a></li>
        <li class="nav-item"><a class="nav-link" href="#">อัปโหลดไฟล์</a></li>
        <li class="nav-item"><a class="nav-link" href="#">ติดต่อ</a></li>
      </ul>
    </div>
  </div>
</nav>
<!-- ===========================
        End Navbar Section
=========================== -->

  <style>
    body {
      font-family: 'Kanit', sans-serif;
      color: #fff;
      background: #111;
      overflow-x: hidden;
    }

    /* ==== Background IT Effect ==== */
    .background {
      position: fixed;
      width: 100%;
      height: 100%;
      background: linear-gradient(-45deg, #696565, #1a1a1a, #222, #696565);
      background-size: 400% 400%;
      animation: gradientBG 18s ease infinite;
      z-index: -3;
    }
    @keyframes gradientBG {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    /* Circles */
    .circle {
      position: absolute;
      border-radius: 50%;
      background: rgba(11, 178, 255, 0.08);
      animation: float 20s infinite ease-in-out;
      z-index: -2;
    }
    .circle:nth-child(1) {
      width: 350px; height: 350px;
      top: 10%; left: 15%;
      animation-duration: 25s;
    }
    .circle:nth-child(2) {
      width: 200px; height: 200px;
      bottom: 20%; right: 20%;
      animation-duration: 18s;
    }
    .circle:nth-child(3) {
      width: 150px; height: 150px;
      bottom: 10%; left: 30%;
      animation-duration: 15s;
    }
    @keyframes float {
      0%   { transform: translateY(0px) rotate(0deg); }
      50%  { transform: translateY(-40px) rotate(180deg); }
      100% { transform: translateY(0px) rotate(360deg); }
    }

    
.navbar {
  background: rgba(0, 0, 0, 0.5);  /* สีดำโปร่ง 50% */
  padding: 15px 0;
  backdrop-filter: blur(8px);      /* เบลอพื้นหลังด้านหลัง navbar */
  -webkit-backdrop-filter: blur(8px); /* สำหรับ Safari */
}
    .navbar .nav-link {
      color: #ddd !important;
      font-weight: 500;
      transition: 0.3s;
    }
    .navbar .nav-link:hover {
      color: #00ffe7 !important;
    }

    /* Hero */
    .hero {
      padding: 120px 20px;
      text-align: center;
      position: relative;
    }
    .hero h1 {
      font-weight: 600;
      font-size: 2.7rem;
      text-shadow: 0 0 15px rgba(0,255,200,0.5);
    }
    .hero p {
      font-size: 1.2rem;
      opacity: 0.9;
      color: #ccc;
    }

    /* Section Title */
    .section-title {
      text-align: center;
      margin: 60px 0 30px;
      font-weight: bold;
      font-size: 1.8rem;
      color: #00ffe7;
      position: relative;
    }
    .section-title::after {
      content: '';
      display: block;
      width: 60px;
      height: 3px;
      background: #00ffe7;
      margin: 10px auto 0;
      border-radius: 2px;
    }

    /* Cards */
    .card {
      border-radius: 20px;
      border: none;
      background: rgba(255,255,255,0.05);
      backdrop-filter: blur(6px);
      color: #fff;
      box-shadow: 0 4px 20px rgba(0,0,0,0.2);
      transition: transform 0.3s, box-shadow 0.3s;
    }
    .card:hover {
      transform: translateY(-8px);
      box-shadow: 0 6px 25px rgba(0,255,200,0.3);
    }
    .btn {
      border-radius: 50px;
    }

    /* Footer */
    footer {
      background: rgba(0,0,0,0.9);
      color: #ccc;
      padding: 25px;
      margin-top: 80px;
      text-align: center;
    }
    /* ===========================
        Navbar Style
=========================== */
.navbar {
  background: rgba(0, 0, 0, 0.5);
  padding: 15px 0;
  backdrop-filter: blur(8px);
  -webkit-backdrop-filter: blur(8px);
}
.navbar .nav-link {
  color: #ddd !important;
  font-weight: 500;
  transition: 0.3s;
}
.navbar .nav-link:hover {
  color: #00ffe7 !important;
}

  </style>
</head>
<body>

<div class="background"></div>
<div class="circle"></div>
<div class="circle"></div>
<div class="circle"></div>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow">
  <div class="container">
<a class="navbar-brand fw-bold text-white" href="index.html">
    <img src="img/14-removebg-preview.png" 
         alt="Logo" 
         style="height:50px; width:auto; margin-right:10px; vertical-align:middle;">
    IT Project
</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
            data-bs-target="#navbarNav" aria-controls="navbarNav" 
            aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="index.php">หน้าแรก</a></li>
        <li class="nav-item"><a class="nav-link" href="#">เกี่ยวกับโครงงาน</a></li>
        <li class="nav-item"><a class="nav-link" href="register.php">สมาชิก</a></li>
        <li class="nav-item"><a class="nav-link" href="report.php">ผลงาน</a></li>
        <li class="nav-item"><a class="nav-link" href="upload_project.php">อัปโหลดไฟล์</a></li>
        <li class="nav-item"><a class="nav-link" href="#">ติดต่อ</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Hero -->
<section class="hero">
  <div class="container">
    <h1>ระบบจัดการโครงงาน แผนกเทคโนโลยีสารสนเทศ</h1>
    <p class="mt-3">Sisaket Vocational College</p>
    <hr class="my-4 bg-light w-50 mx-auto">
    <p><strong>ชื่อโครงงาน:</strong> ระบบจัดการไฟล์และผลงานของนักศึกษาแผนก IT</p>
    <p><strong>อาจารย์ที่ปรึกษา:</strong> นายคณิศร บัวจันทร์</p>
  </div>
</section>


<div class="container">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<h2 class="section-title">
  <i class="fas fa-folder-open" style="margin-right:10px; color:#00ffe7;"></i>
  ฟังก์ชันการใช้งาน
</h2>

  <div class="row g-4">
    <div class="col-md-4">
      <div class="card p-4 text-center">
        <h4> ผลงานโครงงาน</h4>
        <p>รวบรวมไฟล์และผลลัพธ์โครงงานทั้งหมด</p>
 <a href="#" class="btn btn-info">ดูผลงาน</a>
      </div>
    </div>
    
    <div class="col-md-4">
      <div class="card p-4 text-center">
       <h4>
  <img src="img/hard-disc-drive-97581_1920.png" alt="upload" style="width:24px; height:24px; vertical-align:middle; margin-right:8px;">
  อัปโหลดไฟล์
</h4>
        <form>
          <input class="form-control mb-2" type="file" name="fileToUpload">
          <button class="btn btn-success w-100" type="button">อัปโหลด</button>
        </form>
      </div>
    </div>
    
    <div class="col-md-4">
    <div class="card p-4 text-center">
    <h4>
  <img src="img/47.png" alt="upload" style="width:70px; height:40px; vertical-align:middle; margin-right:8px;">
  สถิติและความคืบหน้า
</h4>
        <p>แสดงจำนวนไฟล์ที่อัปโหลด ความคืบหน้าโครงการ</p>
        <a href="#" class="btn btn-info">ดูสถิติ</a>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<footer>
  <p>© 2025 แผนกเทคโนโลยีสารสนเทศ - Sisaket Vocational College</p>
    <p>S-ICE Smart College</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
