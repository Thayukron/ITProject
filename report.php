<?php
// การเชื่อมต่อฐานข้อมูล
$host = "localhost";
$user = "root";      // เปลี่ยนตาม username ของคุณ
$pass = "";          // เปลี่ยนตามรหัสผ่านของคุณ
$db = "project_db";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ดึงข้อมูลโครงงาน + นักศึกษา + อาจารย์
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
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #0f172a, #1e3a8a);
            color: #333;
        }

        .container {
            max-width: 1400px;
            margin: 50px auto;
            padding: 0 20px;
        }

        h1 {
            text-align: center;
            color: #fff;
            margin-bottom: 50px;
            font-size: 3rem;
            text-shadow: 3px 3px 10px rgba(0, 0, 0, 0.4);
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 40px;
        }

        .card {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            transition: transform 0.4s, box-shadow 0.4s;
        }

        .card:hover {
            transform: translateY(-15px) scale(1.03);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.35);
        }

        .card-header {
            position: relative;
            color: #fff;
            padding: 0;
            text-align: center;
        }

        .card-header img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            display: block;
        }

        .card-header h2 {
            position: absolute;
            bottom: 10px;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 1.5rem;
            font-weight: 700;
            text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.7);
        }

        .card-body {
            padding: 25px;
        }

        .card-body p {
            margin: 10px 0;
        }

        .label {
            font-weight: 700;
            color: #1e3a8a;
        }

        .download-btn,
        .video-btn {
            display: inline-block;
            margin-top: 12px;
            padding: 12px 25px;
            background: #1e40af;
            color: #fff;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 500;
            transition: background 0.3s, transform 0.3s;
            margin-right: 10px;
        }

        .download-btn:hover,
        .video-btn:hover {
            background: #2563eb;
            transform: scale(1.05);
        }

        @media(max-width:768px) {
            h1 {
                font-size: 2.2rem;
            }

            .card-header img {
                height: 180px;
            }
        }
    </style>
</head>

<body>
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
                            <p><span class="label">อาจารย์ที่ปรึกษา:</span> <?php echo htmlspecialchars($row['teachers']); ?>
                            </p>
                            <p><span class="label">ปีการศึกษา:</span> <?php echo htmlspecialchars($row['year']); ?></p>
                            <p><span class="label">หมวดหมู่:</span> <?php echo htmlspecialchars($row['category']); ?></p>
                            <p><span class="label">รายละเอียด:</span> <?php echo nl2br(htmlspecialchars($row['abstract'])); ?>
                            </p>
                            <?php if (!empty($row['file_pdf'])): ?>
                                <a class="download-btn" href="<?php echo htmlspecialchars($row['file_pdf']); ?>" download>ดาวน์โหลด
                                    PDF</a>
                            <?php endif; ?>
                            <?php if (!empty($row['video_link'])): ?>
                                <a class="video-btn" href="<?php echo htmlspecialchars($row['video_link']); ?>"
                                    target="_blank">ดูวิดีโอ</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p style="color:#fff; text-align:center; font-size:1.2rem;">ไม่มีโครงงานในระบบ</p>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>

<?php $conn->close(); ?>