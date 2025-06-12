<?php
// إعدادات الاتصال بقاعدة البيانات
$servername = "localhost";
$username = "root";
$password = "778838336";
$dbname = "Custody_sergeant";

// إنشاء الاتصال
$conn = new mysqli($servername, $username, $password, $dbname);

// التحقق من وجود خطأ في الاتصال
if ($conn->connect_error) {
    die("<div class='container'><div class='error-message'>فشل الاتصال بقاعدة البيانات: {$conn->connect_error}</div></div>");
}

// استلام معرف المستخدم من الرابط
$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!$user_id) {
    die("<div class='container'><div class='error-message'>معرف المستخدم غير صالح.</div></div>");
}

// جلب بيانات المستخدم قبل الحذف (لعرض تأكيد)
$sql = "SELECT * FROM users_tb WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("<div class='container'><div class='error-message'>المستخدم غير موجود.</div></div>");
}

$user = $result->fetch_assoc();

// التأكد من أن المستخدم يريد الحذف
if (!isset($_GET['confirm'])) {
    ?>
    <!DOCTYPE html>
    <html lang="ar" dir="rtl">
    <head>
        <meta charset="UTF-8">
        <title>حذف المستخدم - نظام رقيب العهدة</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> 
        <style>
            /* التنسيقات الكاملة هنا */
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }
            :root {
                --primary: #1a2a6c;
                --danger: #dc3545;
                --light-gray: #e9ecef;
                --card-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
                --success: #28a745;
                --gray: #6c757d;
            }

            body {
                background: linear-gradient(135deg, #1a2a6c, #b21f1f, #fdbb2d);
                min-height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 20px;
                color: #343a40;
            }

            .container {
                width: 100%;
                max-width: 600px;
                background: white;
                border-radius: 20px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
                overflow: hidden;
                padding: 30px;
                text-align: center;
                animation: fadeIn 0.6s ease-out;
            }

            .header h1 {
                font-size: 36px;
                color: var(--danger);
                margin-bottom: 20px;
                background: linear-gradient(to right, var(--danger), #b52d3a);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }

            .user-avatar {
                width: 80px;
                height: 80px;
                border-radius: 50%;
                background: linear-gradient(135deg, var(--primary), #b21f1f);
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: bold;
                color: white;
                font-size: 32px;
                margin: 0 auto 20px;
            }

            .user-details {
                margin-bottom: 20px;
            }

            .user-id {
                font-size: 18px;
                color: var(--gray);
            }

            .user-name {
                font-size: 24px;
                font-weight: 700;
                color: var(--dark);
            }

            .form-actions {
                display: flex;
                justify-content: center;
                gap: 15px;
                margin-top: 30px;
                flex-wrap: wrap;
            }

            .btn {
                padding: 15px 30px;
                border-radius: 10px;
                font-weight: 600;
                font-size: 18px;
                display: inline-flex;
                align-items: center;
                gap: 10px;
                transition: all 0.3s;
                border: none;
                cursor: pointer;
                text-decoration: none;
                box-shadow: var(--card-shadow);
            }

            .btn-danger {
                background: linear-gradient(to right, var(--danger), #b52d3a);
                color: white;
            }

            .btn-cancel {
                background: linear-gradient(to right, #6c757d, #5a6268);
                color: white;
            }

            .btn:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            }

            .footer {
                margin-top: 40px;
                text-align: center;
                color: var(--gray);
                font-size: 15px;
                padding-top: 20px;
                border-top: 1px solid var(--light-gray);
            }

            .error-message {
                background-color: #f8d7da;
                color: #721c24;
                padding: 20px;
                border-radius: 10px;
                margin-bottom: 20px;
                border: 1px solid #f5c6cb;
                text-align: center;
            }

            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }

            @media (max-width: 768px) {
                .btn {
                    width: 100%;
                    justify-content: center;
                }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>حذف المستخدم</h1>
                <div class="user-info">
                    <div class="user-avatar"><?= substr($user['username'], 0, 1) ?></div>
                    <div class="user-details">
                        <div class="user-id">رقم المستخدم: #<?= $user['user_id'] ?></div>
                        <div class="user-name"><?= htmlspecialchars($user['username']) ?></div>
                    </div>
                </div>
            </div>

            <div class="edit-form">
                <form method="GET">
                    <input type="hidden" name="id" value="<?= $user['user_id'] ?>">
                    <p style="text-align: center; font-size: 18px; color: #343a40; margin-bottom: 20px;">
                        هل أنت متأكد من رغبتك في حذف المستخدم "<strong><?= htmlspecialchars($user['username']) ?></strong>"؟<br>
                        لا يمكن التراجع عن هذا الإجراء!
                    </p>
                    <div class="form-actions">
                        <a href="?id=<?= $user['user_id'] ?>&confirm=1" class="btn btn-danger">
                            <i class="fas fa-trash"></i> نعم، احذف المستخدم
                        </a>
                        <a href="users_view.php" class="btn btn-cancel">
                            <i class="fas fa-times"></i> إلغاء
                        </a>
                    </div>
                </form>
            </div>

            <div class="footer">
                <p>جميع الحقوق محفوظة &copy; 2025 نظام رقيب العهدة | الإصدار 2.2</p>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit();
}

// إذا تم تأكيد الحذف
$sql_delete = "DELETE FROM users_tb WHERE user_id = ?";
$stmt_delete = $conn->prepare($sql_delete);
$stmt_delete->bind_param("i", $user_id);

if ($stmt_delete->execute()) {
    // إعادة التوجيه بعد الحذف بنجاح
    header("Location: users_view.php?deleted=1");
    exit();
} else {
    echo "<div class='container'>
            <div class='error-message'>
                <h2><i class='fas fa-exclamation-triangle'></i> خطأ في الحذف</h2>
                <p>حدث خطأ أثناء حذف المستخدم: {$stmt_delete->error}</p>
            </div>
          </div>";
}
?>