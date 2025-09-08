<?php
include 'conn.php';

$sql = "SELECT p.project_id, p.title, p.abstract, p.year, p.category, p.cover_image, p.file_pdf, p.video_link,
        GROUP_CONCAT(DISTINCT s.name SEPARATOR ', ') AS students,
        GROUP_CONCAT(DISTINCT t.name SEPARATOR ', ') AS teachers
        FROM projects p
        LEFT JOIN project_students ps ON p.project_id = ps.project_id
        LEFT JOIN students s ON ps.student_id = s.student_id
        LEFT JOIN project_teachers pt ON p.project_id = pt.project_id
        LEFT JOIN teachers t ON pt.teacher_id = t.teacher_id
        GROUP BY p.project_id
        ORDER BY p.year DESC";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>รายงานโครงงาน IT</title>
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Kanit', sans-serif;
      color: #fff;
      background: #111;
      overflow-x: hidden;
    }

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

    .circle {
      position: absolute;
      border-radius: 50%;
      background: rgba(11, 178, 255, 0.08);
      animation: float 20s infinite ease-in-out;
      z-index: -2;
    }
    .circle:nth-child(1) { width: 350px; height: 350px; top: 10%; left: 15%; animation-duration: 25s; }
    .circle:nth-child(2) { width: 200px; height: 200px; bottom: 20%; right: 20%; animation-duration: 18s; }
    .circle:nth-child(3) { width: 150px; height: 150px; bottom: 10%; left: 30%; animation-duration: 15s; }
    @keyframes float {
      0% { transform: translateY(0px) rotate(0deg); }
      50% { transform: translateY(-40px) rotate(180deg); }
      100% { transform: translateY(0px) rotate(360deg); }
    }

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

    h1 {
      text-align: center;
      color: #fff;
      font-size: 3rem;
      margin: 120px 0 60px;
      text-shadow: 3px 3px 12px rgba(0, 0, 0, 0.5);
    }

    .container {
      max-width: 1400px;
      margin: auto;
      padding: 0 20px;
    }

    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
      gap: 40px;
    }

    .card {
      background: rgba(255,255,255,0.05);
      color: #fff;
      border-radius: 20px;
      border: none;
      backdrop-filter: blur(6px);
      box-shadow: 0 4px 20px rgba(0,0,0,0.2);
      transition: transform 0.3s, box-shadow 0.3s;
    }

    .card:hover {
      transform: translateY(-8px);
      box-shadow: 0 6px 25px rgba(0,255,200,0.3);
    }

    .card-header img {
      width: 100%;
      height: 220px;
      object-fit: cover;
    }

    .card-header h2 {
      text-align: center;
      font-size: 1.5rem;
      font-weight: bold;
      margin-top: 15px;
    }

    .card-body {
      padding: 20px 25px;
    }

    .label {
      font-weight: 700;
      color: #00ffe7;
    }

    .download-btn,
    .video-btn {
      display: inline-block;
      margin-top: 15px;
      padding: 12px 24px;
      background: linear-gradient(135deg, #00ffe7, #1bc3c3);
      color: #000;
      border-radius: 30px;
      text-decoration: none;
      font-weight: bold;
      box-shadow: 0 5px 15px rgba(0, 255, 231, 0.3);
      transition: 0.3s ease;
      margin-right: 10px;
    }

    .download-btn:hover,
    .video-btn:hover {
      background: linear-gradient(135deg, #0ff, #0cf);
      color: #111;
      transform: scale(1.05);
    }

    footer {
      background: rgba(0,0,0,0.9);
      color: #ccc;
      padding: 25px;
      margin-top: 80px;
      text-align: center;
    }

    @media(max-width:768px) {
      h1 {
        font-size: 2rem;
        margin-top: 100px;
      }
      .card-header h2 {
        font-size: 1.2rem;
      }
    }
  </style>
</head>

<body>

<!-- Background Effects -->
<div class="background"></div>
<div class="circle"></div>
<div class="circle"></div>
<div class="circle"></div>

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
        <li class="nav-item"><a class="nav-link" href="index.php">หน้าแรก</a></li>
        <li class="nav-item"><a class="nav-link" href="#">เกี่ยวกับโครงงาน</a></li>
        <li class="nav-item"><a class="nav-link" href="register.php">สมาชิก</a></li>
        <li class="nav-item"><a class="nav-link active" href="report.php">ผลงาน</a></li>
        <li class="nav-item"><a class="nav-link" href="upload_project.php">อัปโหลดไฟล์</a></li>
        <li class="nav-item"><a class="nav-link" href="#">ติดต่อ</a></li>
      </ul>
    </div>
  </div>
</nav>
<!-- ===========================
        End Navbar Section
=========================== -->

<div class="container">
  <h1>รายงานโครงงาน IT</h1>
  <div class="grid">
    <?php if ($result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="card">
          <div class="card-header">
            <?php if (!empty($row['cover_image'])): ?>
              <img src="<?php echo htmlspecialchars($row['cover_image']); ?>" alt="Cover Image">
            <?php else: ?>
              <img src="default-cover.jpg" alt="Cover Image">
            <?php endif; ?>
            <h2><?php echo htmlspecialchars($row['title']); ?></h2>
          </div>
          <div class="card-body">
            <p><span class="label">ผู้จัดทำ:</span> <?php echo htmlspecialchars($row['students']); ?></p>
            <p><span class="label">อาจารย์ที่ปรึกษา:</span> <?php echo htmlspecialchars($row['teachers']); ?></p>
            <p><span class="label">ปีการศึกษา:</span> <?php echo htmlspecialchars($row['year']); ?></p>
            <p><span class="label">หมวดหมู่:</span> <?php echo htmlspecialchars($row['category']); ?></p>
            <p><span class="label">รายละเอียด:</span> <?php echo nl2br(htmlspecialchars($row['abstract'])); ?></p>
            <?php if (!empty($row['file_pdf'])): ?>
              <a class="download-btn" href="<?php echo htmlspecialchars($row['file_pdf']); ?>" download>ดาวน์โหลด PDF</a>
            <?php endif; ?>
            <?php if (!empty($row['video_link'])): ?>
              <a class="video-btn" href="<?php echo htmlspecialchars($row['video_link']); ?>" target="_blank">ดูวิดีโอ</a>
            <?php endif; ?>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p style="color:#fff; text-align:center; font-size:1.2rem;">ไม่มีโครงงานในระบบ</p>
    <?php endif; ?>
  </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>
