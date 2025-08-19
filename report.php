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
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* -------------------- พื้นฐาน -------------------- */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(160deg, #0f172a, #1e3a8a);
            color: #333;
        }

        .container {
            max-width: 1400px;
            margin: 60px auto;
            padding: 0 20px;
        }

        h1 {
            text-align: center;
            color: #fff;
            font-size: 3rem;
            margin-bottom: 60px;
            text-shadow: 3px 3px 12px rgba(0, 0, 0, 0.5);
        }

        /* -------------------- Grid Card -------------------- */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 40px;
        }

        /* -------------------- Card -------------------- */
        .card {
            background: #fff;
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            transition: transform 0.4s, box-shadow 0.4s;
        }

        .card:hover {
            transform: translateY(-20px) scale(1.05);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.35);
        }

        /* -------------------- Card Header -------------------- */
        .card-header {
            position: relative;
            text-align: center;
        }

        .card-header img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            transition: transform 0.5s;
        }

        .card-header:hover img {
            transform: scale(1.1);
        }

        .card-header h2 {
            position: absolute;
            bottom: 15px;
            left: 0;
            width: 100%;
            font-size: 1.6rem;
            font-weight: 700;
            color: #fff;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.7);
        }

        /* -------------------- Card Body -------------------- */
        .card-body {
            padding: 30px 25px;
        }

        .card-body p {
            margin: 10px 0;
            font-size: 1rem;
            line-height: 1.6;
        }

        .label {
            font-weight: 700;
            color: #1e3a8a;
        }

        /* -------------------- Buttons -------------------- */
        .download-btn,
        .video-btn {
            display: inline-block;
            margin-top: 15px;
            padding: 14px 28px;
            background: linear-gradient(135deg, #3b82f6, #60a5fa);
            color: #fff;
            border-radius: 15px;
            text-decoration: none;
            font-weight: 600;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            margin-right: 12px;
        }

        .download-btn:hover,
        .video-btn:hover {
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        /* -------------------- Responsive -------------------- */
        @media(max-width:768px) {
            h1 {
                font-size: 2.4rem;
                margin-bottom: 40px;
            }

            .card-header img {
                height: 180px;
            }

            .card-body {
                padding: 20px;
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