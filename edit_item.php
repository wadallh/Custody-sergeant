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
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل العهدة</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">    
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            direction: rtl;
            background-color: #f4f6f9;
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

        .back-btn {
            display: inline-block;
            text-align: center;
            padding: 10px;
            background: #6c757d;
            color: white;
            border-radius: 6px;
            text-decoration: none;
            font-size: 16px;
            margin-bottom: 15px;
            transition: background 0.3s ease;
        }

        .back-btn:hover {
            background: #5a6268;
        }

        form {
            display: grid;
            gap: 15px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        textarea {
            width: 100%;
            height: 100px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        button {
            padding: 10px;
            background: linear-gradient(to right, #1a2a6c, #121f4d);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background: #0f153d;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- زر الرجوع -->
    <a href="javascript:history.back()" class="back-btn">
        <i class="fas fa-arrow-right"></i> رجوع
    </a>

    <!-- نموذج تعديل العهدة -->
    <h2>تعديل العهدة</h2>
    <form action="update_item.php" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($item['id']) ?>">

        <div class="form-group">
            <label for="الصنف">الصنف</label>
            <input type="text" id="الصنف" name="الصنف" value="<?= htmlspecialchars($item['الصنف']) ?>" required>
        </div>

        <div class="form-group">
            <label for="وحدة_القياس">وحدة القياس</label>
            <input type="text" id="وحدة_القياس" name="وحدة_القياس" value="<?= htmlspecialchars($item['وحدة_القياس']) ?>" required>
        </div>

        <div class="form-group">
            <label for="عدد_الجاهز">عدد الجاهز</label>
            <input type="number" id="عدد_الجاهز" name="عدد_الجاهز" value="<?= htmlspecialchars($item['عدد_الجاهز']) ?>" required>
        </div>

        <div class="form-group">
            <label for="عدد_يحتاج_صيانة">عدد يحتاج صيانة</label>
            <input type="number" id="عدد_يحتاج_صيانة" name="عدد_يحتاج_صيانة" value="<?= htmlspecialchars($item['عدد_يحتاج_صيانة']) ?>" required>
        </div>

        <div class="form-group">
            <label for="عدد_تالف">عدد تالف</label>
            <input type="number" id="عدد_تالف" name="عدد_تالف" value="<?= htmlspecialchars($item['عدد_تالف']) ?>" required>
        </div>

        <div class="form-group">
            <label for="مكان_وجود_العهدة">مكان وجود العهدة</label>
            <input type="text" id="مكان_وجود_العهدة" name="مكان_وجود_العهدة" value="<?= htmlspecialchars($item['مكان_وجود_العهدة']) ?>" required>
        </div>

        <div class="form-group">
            <label for="الجهة_التي_تتبعها_العهدة">الجهة التابعة</label>
            <input type="text" id="الجهة_التي_تتبعها_العهدة" name="الجهة_التي_تتبعها_العهدة" value="<?= htmlspecialchars($item['الجهة_التي_تتبعها_العهدة']) ?>" required>
        </div>

        <div class="form-group">
            <label for="تأربخ_الادخال">تاريخ الإدخال</label>
            <input type="date" id="تأربخ_الادخال" name="تأربخ_الادخال" value="<?= htmlspecialchars($item['تأربخ_الادخال']) ?>" required>
        </div>

        <div class="form-group">
            <label for="اسم_الشخص_المسؤول_عن_العهدة">مسؤول العهدة</label>
            <input type="text" id="اسم_الشخص_المسؤول_عن_العهدة" name="اسم_الشخص_المسؤول_عن_العهدة" value="<?= htmlspecialchars($item['اسم_الشخص_المسؤول_عن_العهدة']) ?>" required>
        </div>

        <div class="form-group">
            <label for="اسم_الشخص_المسؤول_على_القسم">مسؤول القسم</label>
            <input type="text" id="اسم_الشخص_المسؤول_على_القسم" name="اسم_الشخص_المسؤول_على_القسم" value="<?= htmlspecialchars($item['اسم_الشخص_المسؤول_على_القسم']) ?>" required>
        </div>

        <button type="submit">تحديث العهدة</button>
    </form>
</div>

</body>
</html>