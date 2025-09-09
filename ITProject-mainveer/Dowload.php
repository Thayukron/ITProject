<?php
session_start();

// ถ้าไม่ใช่นักศึกษาและไม่ใช่อาจารย์ → redirect ไป login.php
if (!isset($_SESSION['student_id']) && !isset($_SESSION['teacher_id'])) {
    header("Location: login.php");
    exit();
}

include 'conn.php';

// ดึงข้อมูลโครงงานทั้งหมด
$sql = "SELECT * FROM projects ORDER BY year DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ดาวน์โหลดโครงงาน IT</title>
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

        /* Background Gradient */
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
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* Floating circles */
        .circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(11, 178, 255, 0.08);
            animation: float 20s infinite ease-in-out;
            z-index: -2;
        }

        .circle:nth-child(1) {
            width: 350px;
            height: 350px;
            top: 10%;
            left: 15%;
            animation-duration: 25s;
        }

        .circle:nth-child(2) {
            width: 200px;
            height: 200px;
            bottom: 20%;
            right: 20%;
            animation-duration: 18s;
        }

        .circle:nth-child(3) {
            width: 150px;
            height: 150px;
            bottom: 10%;
            left: 30%;
            animation-duration: 15s;
        }

        @keyframes float {
            0% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-40px) rotate(180deg);
            }

            100% {
                transform: translateY(0px) rotate(360deg);
            }
        }

        /* Navbar */
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

        /* Hero Section */
        .hero {
            padding: 120px 20px;
            text-align: center;
            position: relative;
        }

        .hero h1 {
            font-weight: 600;
            font-size: 2.7rem;
            text-shadow: 0 0 15px rgba(0, 255, 200, 0.5);
        }

        .hero p {
            font-size: 1.2rem;
            opacity: 0.9;
            color: #ccc;
        }

        .hero hr {
            border-color: #00ffe7;
            width: 50%;
        }

        /* Grid cards */
        .container-grid {
            max-width: 1400px;
            margin: auto;
            padding: 20px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 40px;
        }

        .card {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            border-radius: 20px;
            border: none;
            backdrop-filter: blur(6px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 6px 25px rgba(0, 255, 200, 0.3);
        }

        .card-header img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
        }

        .card-body {
            padding: 20px 25px;
        }

        .card-body h5 {
            font-weight: bold;
        }

        .card-footer {
            text-align: center;
            background: transparent;
            border-top: none;
        }

        .download-btn {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 20px;
            background: linear-gradient(135deg, #00ffe7, #1bc3c3);
            color: #000;
            border-radius: 30px;
            text-decoration: none;
            font-weight: bold;
            box-shadow: 0 5px 15px rgba(0, 255, 231, 0.3);
            transition: 0.3s ease;
            margin-right: 10px;
        }

        .download-btn:hover {
            background: linear-gradient(135deg, #0ff, #0cf);
            color: #111;
            transform: scale(1.05);
        }

        footer {
            background: rgba(0, 0, 0, 0.9);
            color: #ccc;
            padding: 25px;
            margin-top: 80px;
            text-align: center;
        }

        @media(max-width:768px) {
            .hero h1 {
                font-size: 2rem;
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

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow">
        <div class="container">
            <a class="navbar-brand fw-bold text-white" href="index.php">
                <img src="https://img.freepik.com/premium-photo/robot-s-head-is-shown-with-brain-middle_886336-810.jpg"
                    alt="Logo" style="height:50px; width:auto; margin-right:10px; vertical-align:middle;">
                IT Project
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">หน้าแรก</a></li>
                    <li class="nav-item"><a class="nav-link" href="report.php">รายงาน</a></li>
                    <li class="nav-item"><a class="nav-link" href="upload_project.php">อัปโหลดไฟล์</a></li>
                    <li class="nav-item"><a class="nav-link active" href="Dowload.php">ดาวน์โหลดไฟล์</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">ออกจากระบบ</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <h1>ดาวน์โหลดโครงงาน IT</h1>
        <p>Sisaket Vocational College</p>
        <hr>
        <p><strong>ดาวน์โหลดไฟล์รายงานและซอร์สโค้ดของนักศึกษา</strong></p>
    </section>

    <!-- Grid of Projects -->
    <div class="container-grid">
        <div class="grid">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="card">
                        <div class="card-header">
                            <?php if (!empty($row['cover_image'])): ?>
                                <img src="<?= htmlspecialchars($row['cover_image']); ?>" alt="Cover Image">
                            <?php else: ?>
                                <img src="no_cover.jpg" alt="Cover Image">
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <h5><?= htmlspecialchars($row['title']); ?></h5>
                            <p><strong>ปี:</strong> <?= htmlspecialchars($row['year']); ?></p>
                            <p><strong>หมวดหมู่:</strong> <?= htmlspecialchars($row['category']); ?></p>
                            <p><?= mb_strimwidth(strip_tags($row['abstract']), 0, 100, "..."); ?></p>
                        </div>
                        <div class="card-footer">
                            <?php if (!empty($row['file_pdf'])): ?>
                                <a href="<?= htmlspecialchars($row['file_pdf']); ?>" class="download-btn" target="_blank">📄 PDF</a>
                            <?php endif; ?>
                            <?php if (!empty($row['file_zip'])): ?>
                                <a href="<?= htmlspecialchars($row['file_zip']); ?>" class="download-btn" target="_blank">💾 Source
                                    Code</a>
                            <?php endif; ?>
                            <?php if (!empty($row['video_link'])): ?>
                                <a href="<?= htmlspecialchars($row['video_link']); ?>" class="download-btn" target="_blank">▶
                                    วิดีโอ</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p style="color:#fff; text-align:center; font-size:1.2rem;">ยังไม่มีข้อมูลโครงงาน</p>
            <?php endif; ?>
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
<?php $conn->close(); ?>