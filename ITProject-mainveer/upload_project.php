<?php
include("conn.php");

// ✅ Upload Project
if (isset($_POST['upload'])) {
    $title = $_POST['title'];
    $abstract = $_POST['description'];
    $year = $_POST['year'];
    $category = $_POST['category'];
    $file_pdf_path = null;
    $file_zip_path = null;

    // อัปโหลด PDF
    if ($_FILES["file_pdf"]["error"] == 0) {
        $pdf_name = basename($_FILES["file_pdf"]["name"]);
        $file_pdf_path = "uploads/pdf/" . time() . "_" . $pdf_name;
        move_uploaded_file($_FILES["file_pdf"]["tmp_name"], $file_pdf_path);
    }

    // อัปโหลด ZIP
    if ($_FILES["file_zip"]["error"] == 0) {
        $zip_name = basename($_FILES["file_zip"]["name"]);
        $file_zip_path = "uploads/zip/" . time() . "_" . $zip_name;
        move_uploaded_file($_FILES["file_zip"]["tmp_name"], $file_zip_path);
    }

    // เพิ่มข้อมูลลง projects
    $stmt = $conn->prepare("INSERT INTO projects (title, abstract, year, category, file_pdf, file_zip) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisss", $title, $abstract, $year, $category, $file_pdf_path, $file_zip_path);

    if ($stmt->execute()) {
        $success = "✅ อัปโหลดโครงงานสำเร็จแล้ว!";
    } else {
        $uploadError = "❌ เกิดข้อผิดพลาดในการบันทึกข้อมูล";
    }
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>อัปโหลดโครงงานนักศึกษา</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;600&display=swap" rel="stylesheet">
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

        .card-form {
            border-radius: 20px;
            border: none;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(6px);
            color: #fff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            padding: 30px;
        }

        .btn {
            border-radius: 50px;
        }

        .section-title {
            text-align: center;
            margin: 100px 0 30px;
            font-weight: bold;
            font-size: 1.8rem;
            color: #00ffe7;
        }

        footer {
            background: rgba(0, 0, 0, 0.9);
            color: #ccc;
            padding: 25px;
            margin-top: 80px;
            text-align: center;
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
                    <li class="nav-item"><a class="nav-link active" href="upload_project.php">อัปโหลดไฟล์</a></li>
                    <li class="nav-item"><a class="nav-link" href="Dowload.php">ดาวน์โหลดไฟล์</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">ออกจากระบบ</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <h2 class="section-title">ระบบอัปโหลดโครงงานนักศึกษา</h2>

        <!-- ฟอร์มอัปโหลดโครงงาน -->
        <form method="POST" enctype="multipart/form-data" class="card-form">
            <h5 class="mb-3">อัปโหลดโครงงานของคุณ</h5>
            <?php if (isset($success))
                echo "<div class='alert alert-success'>$success</div>"; ?>
            <?php if (isset($uploadError))
                echo "<div class='alert alert-danger'>$uploadError</div>"; ?>

            <div class="mb-3">
                <label>ชื่อโครงงาน</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>บทคัดย่อ (Abstract)</label>
                <textarea name="description" class="form-control" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label>ปีการศึกษา</label>
                <select name="year" class="form-select" required>
                    <option value="">-- เลือกปี --</option>
                    <option value="2566">2566</option>
                    <option value="2567">2567</option>
                    <option value="2568">2568</option>
                </select>
            </div>
            <div class="mb-3">
                <label>หมวดหมู่</label>
                <input type="text" name="category" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>แนบไฟล์รายงาน (PDF)</label>
                <input type="file" name="file_pdf" accept=".pdf" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>แนบไฟล์ซอร์สโค้ด (ZIP)</label>
                <input type="file" name="file_zip" accept=".zip" class="form-control" required>
            </div>
            <button name="upload" type="submit" class="btn btn-success">อัปโหลด</button>
        </form>
    </div>

    <!-- Footer -->
    <footer>
        <p>© 2025 แผนกเทคโนโลยีสารสนเทศ - Sisaket Vocational College</p>
        <p>S-ICE Smart College</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>