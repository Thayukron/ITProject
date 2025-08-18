<?php
// เชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";   // เปลี่ยนเป็น user ของคุณ
$password = "";       // รหัสผ่านของคุณ
$dbname = "project_db";

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8mb4");

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ดึงข้อมูลโครงงานทั้งหมด
$sql = "SELECT * FROM projects ORDER BY year DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ดาวน์โหลดโครงงาน</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <h2 class="mb-4 text-center">📚 รายการโครงงาน</h2>
    <div class="row">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <?php if ($row['cover_image']): ?>
                            <img src="<?= htmlspecialchars($row['cover_image']); ?>" class="card-img-top" style="height:200px;object-fit:cover;">
                        <?php else: ?>
                            <img src="no_cover.jpg" class="card-img-top" style="height:200px;object-fit:cover;">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($row['title']); ?></h5>
                            <p class="card-text"><strong>ปี:</strong> <?= $row['year']; ?></p>
                            <p class="card-text"><strong>หมวดหมู่:</strong> <?= htmlspecialchars($row['category']); ?></p>
                            <p class="card-text"><?= mb_strimwidth(strip_tags($row['abstract']), 0, 100, "..."); ?></p>
                        </div>
                        <div class="card-footer text-center">
                            <?php if ($row['file_pdf']): ?>
                                <a href="<?= htmlspecialchars($row['file_pdf']); ?>" class="btn btn-sm btn-danger" target="_blank">📄 PDF</a>
                            <?php endif; ?>
                            <?php if ($row['file_zip']): ?>
                                <a href="<?= htmlspecialchars($row['file_zip']); ?>" class="btn btn-sm btn-primary" target="_blank">💾 Source Code</a>
                            <?php endif; ?>
                            <?php if ($row['video_link']): ?>
                                <a href="<?= htmlspecialchars($row['video_link']); ?>" class="btn btn-sm btn-warning" target="_blank">▶ วิดีโอ</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center">ยังไม่มีข้อมูลโครงงาน</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
<?php $conn->close(); ?>
