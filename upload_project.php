<?php
session_start();
include("db_config.php");

$loggedIn = false;

// ฟังก์ชันดึง student_id จากฐานข้อมูล
function getStudentId($conn, $studentCode) {
    $stmt = $conn->prepare("SELECT student_id FROM students WHERE student_id = ?");
    $stmt->bind_param("i", $studentCode);
    $stmt->execute();
    $stmt->bind_result($id);
    if ($stmt->fetch()) {
        return $id;
    }
    return false;
}

// Login
if (isset($_POST['login'])) {
    $studentCode = $_POST['student_id'];
    $password = $_POST['password']; // ยังไม่ใช้จริง (mock)

    // สมมุติว่าใช้ student_id เป็นรหัสผ่านแบบง่าย
    if ($studentCode === $password) {
        $student_id = getStudentId($conn, $studentCode);
        if ($student_id) {
            $_SESSION['student_id'] = $student_id;
            $loggedIn = true;
        } else {
            $error = "ไม่พบรหัสนักศึกษาในระบบ";
        }
    } else {
        $error = "รหัสผ่านไม่ถูกต้อง";
    }
}

if (isset($_SESSION['student_id'])) {
    $loggedIn = true;
    $student_id = $_SESSION['student_id'];
}

// Upload Project
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
        $project_id = $stmt->insert_id;

        // เชื่อมโยงกับ student ใน project_students
        $stmt2 = $conn->prepare("INSERT INTO project_students (project_id, student_id) VALUES (?, ?)");
        $stmt2->bind_param("ii", $project_id, $student_id);
        $stmt2->execute();

        $success = "อัปโหลดโครงงานสำเร็จแล้ว!";
    } else {
        $uploadError = "เกิดข้อผิดพลาดในการบันทึกข้อมูล";
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: upload_project.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>อัปโหลดโครงงานนักศึกษา</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            padding: 30px;
            background-color: #f0f2f5;
        }
        .container {
            max-width: 700px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mb-4">ระบบอัปโหลดโครงงานนักศึกษา</h2>

    <?php if (!$loggedIn): ?>
        <!-- ฟอร์มเข้าสู่ระบบ -->
        <form method="POST" class="border p-4 bg-white shadow-sm rounded">
            <h5>เข้าสู่ระบบนักศึกษา</h5>
            <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
            <div class="mb-3">
                <label>รหัสนักศึกษา</label>
                <input type="text" name="student_id" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>รหัสผ่าน</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button name="login" type="submit" class="btn btn-primary">เข้าสู่ระบบ</button>
        </form>

    <?php else: ?>
        <!-- ฟอร์มอัปโหลดโครงงาน -->
        <form method="POST" enctype="multipart/form-data" class="border p-4 bg-white shadow-sm rounded">
            <h5>อัปโหลดโครงงานของคุณ</h5>
            <?php if (isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
            <?php if (isset($uploadError)) echo "<div class='alert alert-danger'>$uploadError</div>"; ?>

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
            <a href="?logout=true" class="btn btn-secondary">ออกจากระบบ</a>
        </form>
    <?php endif; ?>
</div>

</body>
</html>
