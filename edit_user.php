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
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

// استلام معرف المستخدم من الرابط
$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!$user_id) {
    die("معرف المستخدم غير صالح.");
}

// جلب بيانات المستخدم
$sql = "SELECT * FROM users_tb WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("المستخدم غير موجود.");
}

$user = $result->fetch_assoc();

$error_message = [];
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $user_level = $_POST['user_level'];
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    // التحقق من اسم المستخدم
    if (empty($username)) {
        $error_message[] = "اسم المستخدم مطلوب.";
    }

    // التحقق من مستوى المستخدم
    if (!in_array($user_level, ['admin', 'editor', 'viewer'])) {
        $error_message[] = "مستوى المستخدم غير صحيح.";
    }

    // التحقق من كلمة المرور إذا تم إدخالها
    if (!empty($new_password) && $new_password !== $confirm_password) {
        $error_message[] = "كلمتا المرور غير متطابقتين.";
    }

    if (empty($error_message)) {
        // تحديث البيانات
        if (!empty($new_password)) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $sql_update = "UPDATE users_tb SET username = ?, password = ?, user_level = ? WHERE user_id = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("sssi", $username, $hashed_password, $user_level, $user_id);
        } else {
            $sql_update = "UPDATE users_tb SET username = ?, user_level = ? WHERE user_id = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("ssi", $username, $user_level, $user_id);
        }

        if ($stmt_update->execute()) {
            $success_message = "تم تحديث بيانات المستخدم بنجاح.";
            header("Location: users_view.php?updated=1");
            exit();
        } else {
            $error_message[] = "حدث خطأ أثناء تحديث البيانات: " . $stmt_update->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل المستخدم - نظام رقيب العهدة</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> 
    <style>
        /* يمكنك لصق التنسيقات الكاملة هنا -->
        <?php include 'style.css'; ?>
        /* ولكن لأننا نريد كل شيء في ملف واحد، سألصق التنسيقات مباشرة أدناه */
    </style>
</head>
<body>

<!-- التنسيقات المحترفة مباشرة -->
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', 'Tahoma', Geneva, Verdana, sans-serif;
    }
    :root {
        --primary: #1a2a6c;
        --primary-dark: #0d1a4d;
        --secondary: #b21f1f;
        --accent: #fdbb2d;
        --light: #f8f9fa;
        --dark: #343a40;
        --success: #28a745;
        --warning: #ffc107;
        --danger: #dc3545;
        --gray: #6c757d;
        --light-gray: #e9ecef;
        --shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        --card-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    body {
        background: linear-gradient(135deg, #1a2a6c, #b21f1f, #fdbb2d);
        background-attachment: fixed;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
        color: var(--dark);
    }
    .container {
        width: 100%;
        max-width: 800px;
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        box-shadow: var(--shadow);
        overflow: hidden;
        padding: 30px;
        animation: fadeIn 0.8s ease-out;
    }
    .header {
        text-align: center;
        margin-bottom: 30px;
        position: relative;
    }
    .header h1 {
        font-size: 36px;
        color: var(--primary);
        margin-bottom: 15px;
        background: linear-gradient(to right, var(--primary), var(--secondary));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        position: relative;
        display: inline-block;
    }
    .header h1::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 120px;
        height: 4px;
        background: linear-gradient(to right, var(--primary), var(--secondary));
        border-radius: 2px;
    }
    .user-info {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 20px;
        margin-top: 20px;
        flex-wrap: wrap;
    }
    .user-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: white;
        font-size: 32px;
    }
    .user-details {
        text-align: center;
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
    .user-level {
        font-size: 18px;
        padding: 5px 15px;
        border-radius: 20px;
        margin-top: 5px;
        display: inline-block;
    }
    .level-admin {
        background: rgba(40, 167, 69, 0.15);
        color: var(--success);
    }
    .level-editor {
        background: rgba(255, 193, 7, 0.15);
        color: var(--warning);
    }
    .level-viewer {
        background: rgba(220, 53, 69, 0.15);
        color: var(--danger);
    }
    .message-container {
        margin-bottom: 30px;
    }
    .error-message {
        background-color: #f8d7da;
        color: #721c24;
        padding: 20px;
        border-radius: 10px;
        border: 1px solid #f5c6cb;
        text-align: right;
    }
    .error-message ul {
        list-style: none;
        margin-top: 15px;
        text-align: right;
    }
    .error-message li {
        margin-bottom: 8px;
        position: relative;
        padding-right: 20px;
    }
    .error-message li:before {
        content: "•";
        position: absolute;
        right: 0;
        color: #dc3545;
    }
    .edit-form {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: var(--card-shadow);
    }
    .form-group {
        margin-bottom: 25px;
    }
    .form-group label {
        display: block;
        margin-bottom: 10px;
        font-weight: 600;
        color: var(--dark);
        font-size: 18px;
    }
    .form-control {
        width: 100%;
        padding: 15px;
        border: 2px solid var(--light-gray);
        border-radius: 10px;
        font-size: 16px;
        transition: all 0.3s;
    }
    .form-control:focus {
        border-color: var(--primary);
        outline: none;
        box-shadow: 0 0 0 3px rgba(26, 42, 108, 0.2);
    }
    .password-info {
        color: var(--gray);
        font-size: 14px;
        margin-top: 8px;
    }
    .form-actions {
        display: flex;
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
        text-decoration: none;
        border: none;
        cursor: pointer;
        box-shadow: var(--card-shadow);
        flex: 1;
        text-align: center;
        justify-content: center;
    }
    .btn-primary {
        background: linear-gradient(to right, var(--primary), var(--primary-dark));
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
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @media (max-width: 768px) {
        .container { padding: 20px; }
        .form-actions {
            flex-direction: column;
        }
    }
</style>

<div class="container">
    <div class="header">
        <h1>تعديل بيانات المستخدم</h1>
        <div class="user-info">
            <div class="user-avatar"><?= substr($user['username'], 0, 1) ?></div>
            <div class="user-details">
                <div class="user-id">رقم المستخدم: #<?= $user['user_id'] ?></div>
                <div class="user-name"><?= htmlspecialchars($user['username']) ?></div>
                <div class="user-level 
                    <?= $user['user_level'] === 'admin' ? 'level-admin' :
                        ($user['user_level'] === 'editor' ? 'level-editor' : 'level-viewer') ?>">
                    <?= $user['user_level'] === 'admin' ? 'مدير النظام' :
                        ($user['user_level'] === 'editor' ? 'محرر' : 'مستخدم عادي') ?>
                </div>
            </div>
        </div>
    </div>

    <!-- رسائل الخطأ أو النجاح -->
    <?php if (!empty($error_message)): ?>
        <div class="message-container">
            <div class="error-message">
                <ul>
                    <?php foreach ($error_message as $msg): ?>
                        <li><?= $msg ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>

    <div class="edit-form">
        <form method="POST">
            <div class="form-group">
                <label for="username">اسم المستخدم</label>
                <input type="text" id="username" name="username" class="form-control"
                       value="<?= htmlspecialchars($user['username']) ?>" required>
            </div>
            <div class="form-group">
                <label for="user_level">مستوى المستخدم</label>
                <select id="user_level" name="user_level" class="form-control" required>
                    <option value="admin" <?= $user['user_level'] === 'admin' ? 'selected' : '' ?>>مدير النظام</option>
                    <option value="editor" <?= $user['user_level'] === 'editor' ? 'selected' : '' ?>>محرر</option>
                    <option value="viewer" <?= $user['user_level'] === 'viewer' ? 'selected' : '' ?>>مستخدم عادي</option>
                </select>
            </div>
            <div class="form-group">
                <label for="new_password">كلمة المرور الجديدة (اختياري)</label>
                <input type="password" id="new_password" name="new_password" class="form-control">
                <p class="password-info">اترك هذا الحقل فارغاً إذا كنت لا تريد تغيير كلمة المرور</p>
            </div>
            <div class="form-group">
                <label for="confirm_password">تأكيد كلمة المرور الجديدة</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control">
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> حفظ التغييرات
                </button>
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

<script>
    document.querySelector('form').addEventListener('submit', function(e) {
        const newPassword = document.getElementById('new_password').value;
        const confirmPassword = document.getElementById('confirm_password').value;
        if (newPassword && newPassword !== confirmPassword) {
            e.preventDefault();
            alert('كلمتا المرور غير متطابقتين.');
            document.getElementById('new_password').focus();
        }
    });
</script>

</body>
</html>
<?php $conn->close(); ?>