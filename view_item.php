<?php
include 'db.php';

$id = $_GET['id'];
$sql = "SELECT * FROM kashf WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("السجل غير موجود.");
}

$item = $result->fetch_assoc();
$conn->close();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض تفاصيل العهدة</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> 
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Tajawal', sans-serif;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #1a2a6c;
            margin-bottom: 20px;
        }

        .details {
            display: grid;
            gap: 15px;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            background: #f9f9f9;
            border-radius: 6px;
        }

        .detail-label {
            font-weight: bold;
            color: #333;
        }

        .detail-value {
            color: #555;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #1a2a6c;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>تفاصيل العهدة</h2>
    <div class="details">
        <div class="detail-item">
            <span class="detail-label">الصنف:</span>
            <span class="detail-value"><?= htmlspecialchars($item['الصنف']) ?></span>
        </div>
        <div class="detail-item">
            <span class="detail-label">وحدة القياس:</span>
            <span class="detail-value"><?= htmlspecialchars($item['وحدة_القياس']) ?></span>
        </div>
        <div class="detail-item">
            <span class="detail-label">عدد الجاهز:</span>
            <span class="detail-value"><?= htmlspecialchars($item['عدد_الجاهز']) ?></span>
        </div>
        <div class="detail-item">
            <span class="detail-label">عدد يحتاج صيانة:</span>
            <span class="detail-value"><?= htmlspecialchars($item['عدد_يحتاج_صيانة']) ?></span>
        </div>
        <div class="detail-item">
            <span class="detail-label">عدد تالف:</span>
            <span class="detail-value"><?= htmlspecialchars($item['عدد_تالف']) ?></span>
        </div>
        <div class="detail-item">
            <span class="detail-label">مكان وجود العهدة:</span>
            <span class="detail-value"><?= htmlspecialchars($item['مكان_وجود_العهدة']) ?></span>
        </div>
        <div class="detail-item">
            <span class="detail-label">الجهة التابعة:</span>
            <span class="detail-value"><?= htmlspecialchars($item['الجهة_التي_تتبعها_العهدة']) ?></span>
        </div>
        <div class="detail-item">
            <span class="detail-label">تاريخ الإدخال:</span>
            <span class="detail-value"><?= htmlspecialchars($item['تأربخ_الادخال']) ?></span>
        </div>
        <div class="detail-item">
            <span class="detail-label">مسؤول العهدة:</span>
            <span class="detail-value"><?= htmlspecialchars($item['اسم_الشخص_المسؤول_عن_العهدة']) ?></span>
        </div>
        <div class="detail-item">
            <span class="detail-label">مسؤول القسم:</span>
            <span class="detail-value"><?= htmlspecialchars($item['اسم_الشخص_المسؤول_على_القسم']) ?></span>
        </div>
    </div>
    <a href="items_management.php"><i class="fas fa-arrow-left"></i> العودة إلى كشف العهدة</a>
</div>

</body>
</html>