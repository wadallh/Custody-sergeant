<?php
// معلومات الاتصال بقاعدة البيانات
$servername = "localhost";
$username = "root";
$password = "778838336";
$dbname = "Custody_sergeant";

// إنشاء اتصال بقاعدة البيانات
$conn = new mysqli($servername, $username, $password, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

// تعيين الترميز إلى UTF-8 لدعم اللغة العربية
$conn->set_charset("utf8");

// تهيئة المتغيرات ورسائل الأخطاء
$success = false;
$errors = [];
$user_data = [];

// معالجة البيانات المرسلة من النموذج
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // جمع البيانات من النموذج
    $user_data = [
        'username' => trim($_POST['username']),
        'password' => $_POST['password'],
        'confirm_password' => $_POST['confirm_password'],
        'Date_Added' => $_POST['Date_Added'],
        'user_level' => $_POST['user_level']
    ];
    
    // التحقق من صحة البيانات
    if (empty($user_data['username'])) {
        $errors[] = "يرجى إدخال اسم المستخدم";
    }
    
    if (empty($user_data['password'])) {
        $errors[] = "يرجى إدخال كلمة المرور";
    } elseif (strlen($user_data['password']) < 8) {
        $errors[] = "كلمة المرور يجب أن تكون 8 أحرف على الأقل";
    }
    
    if ($user_data['password'] !== $user_data['confirm_password']) {
        $errors[] = "كلمتا المرور غير متطابقتين";
    }
    
    if (empty($user_data['Date_Added'])) {
        $errors[] = "يرجى إدخال تاريخ التسجيل";
    }
    
    // إذا لم توجد أخطاء، قم بإدخال البيانات
    if (empty($errors)) {
        // تنظيف البيانات
        $clean_username = $conn->real_escape_string($user_data['username']);
        $clean_date = $conn->real_escape_string($user_data['Date_Added']);
        $clean_level = $conn->real_escape_string($user_data['user_level']);
        
        // تشفير كلمة المرور
        $hashed_password = password_hash($user_data['password'], PASSWORD_DEFAULT);
        
        // استعلام الإدراج
        $sql = "INSERT INTO users_tb (username, password, Date_Added, user_level) 
                VALUES ('$clean_username', '$hashed_password', '$clean_date', '$clean_level')";
        
        if ($conn->query($sql) === TRUE) {
            $success = true;
            // تفريغ بيانات المستخدم بعد الإدخال الناجح
            $user_data = [];
        } else {
            $errors[] = "خطأ في إضافة المستخدم: " . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة مستخدم جديد</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', 'Tahoma', Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #1a2a6c, #b21f1f, #fdbb2d);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 600px;
            overflow: hidden;
            animation: fadeIn 0.5s ease-out;
        }
        
        .header {
            background: linear-gradient(to right, #1a2a6c, #233380);
            color: white;
            padding: 25px 30px;
            text-align: center;
            position: relative;
        }
        
        .header h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }
        
        .header i {
            position: absolute;
            top: 20px;
            left: 25px;
            font-size: 40px;
            opacity: 0.2;
        }
        
        .result-container {
            padding: 30px;
            text-align: center;
        }
        
        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 30px;
            border: 1px solid #c3e6cb;
        }
        
        .success-message i {
            font-size: 50px;
            margin-bottom: 20px;
            color: #28a745;
        }
        
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 20px;
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
        
        .actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            justify-content: center;
        }
        
        .btn {
            padding: 14px 25px;
            font-size: 18px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
            border: none;
        }
        
        .btn-primary {
            background: linear-gradient(to right, #1a2a6c, #b21f1f);
            color: white;
        }
        
        .btn-secondary {
            background: linear-gradient(to right, #6c757d, #5a6268);
            color: white;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .btn-primary:hover {
            background: linear-gradient(to right, #233380, #c72a2a);
        }
        
        .btn-secondary:hover {
            background: linear-gradient(to right, #5a6268, #4e555b);
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #6c757d;
            font-size: 14px;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {transform: translateY(0);}
            40% {transform: translateY(-20px);}
            60% {transform: translateY(-10px);}
        }
        
        .bounce {
            animation: bounce 1.5s;
        }
        
        @media (max-width: 480px) {
            .container {
                border-radius: 10px;
            }
            
            .header {
                padding: 20px;
            }
            
            .header h1 {
                font-size: 24px;
            }
            
            .actions {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <i class="fas fa-user-plus"></i>
            <h1>نتيجة إضافة المستخدم</h1>
        </div>
        
        <div class="result-container">
            <?php if ($success): ?>
                <div class="success-message">
                    <i class="fas fa-check-circle bounce"></i>
                    <h2>تمت العملية بنجاح!</h2>
                    <p>تم إضافة المستخدم <strong><?php echo htmlspecialchars($user_data['username'] ?? ''); ?></strong> إلى قاعدة البيانات بنجاح.</p>
                    <p>مستوى المستخدم: <strong>
                        <?php 
                        $level = $user_data['user_level'] ?? '';
                        if ($level === 'admin') echo 'مدير النظام';
                        elseif ($level === 'editor') echo 'محرر';
                        else echo 'مستخدم عادي';
                        ?>
                    </strong></p>
                </div>
                
                <div class="actions">
                    <a href="register.html" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i> إضافة مستخدم آخر
                    </a>
                    <a href="users_view.php" class="btn btn-secondary">
                        <i class="fas fa-list"></i> عرض قائمة المستخدمين
                    </a>
                </div>
            <?php else: ?>
                <?php if (!empty($errors)): ?>
                    <div class="error-message">
                        <h2><i class="fas fa-exclamation-triangle"></i> حدث خطأ أثناء الإضافة</h2>
                        <p>لم يتم إضافة المستخدم بسبب الأخطاء التالية:</p>
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                
                <div class="actions">
                    <a href="register.html" class="btn btn-primary">
                        <i class="fas fa-arrow-left"></i> العودة إلى النموذج
                    </a>
                    <a href="dashboard.php" class="btn btn-secondary">
                        <i class="fas fa-home"></i> الصفحة الرئيسية
                    </a>
                </div>
            <?php endif; ?>
            
            <div class="footer">
                <p>جميع الحقوق محفوظة &copy; <?php echo date('Y'); ?> | نظام رقيب العهدة</p>
            </div>
        </div>
    </div>
</body>
</html>