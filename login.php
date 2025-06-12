<?php
session_start();

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

// معالجة بيانات النموذج عند إرساله
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // الحصول على بيانات المدخلات
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // حماية ضد حقن SQL
    $username = mysqli_real_escape_string($conn, $username);
    
    // استعلام للبحث عن المستخدم
    $sql = "SELECT user_id, username, password FROM users_tb WHERE username = '$username'";
    $result = $conn->query($sql);
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        
        // التحقق من صحة كلمة المرور (افتراض أن كلمات المرور مخزنة باستخدام password_hash)
        if (password_verify($password, $row['password'])) {
            // تسجيل الدخول ناجح - تخزين بيانات الجلسة
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['loggedin'] = true;
            
            // توجيه المستخدم إلى الصفحة الرئيسية
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "كلمة المرور غير صحيحة";
        }
    } else {
        $error = "اسم المستخدم غير موجود";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 450px;
            padding: 40px;
            text-align: center;
        }
        
        h2 {
            color: #2c3e50;
            font-size: 28px;
            margin-bottom: 30px;
            position: relative;
            padding-bottom: 15px;
        }
        
        h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(to right, #1a2a6c, #b21f1f);
            border-radius: 2px;
        }
        
        .form-group {
            margin-bottom: 25px;
            text-align: right;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: 600;
            font-size: 16px;
        }
        
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 14px 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        
        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #1a2a6c;
            outline: none;
            box-shadow: 0 0 0 3px rgba(26, 42, 108, 0.2);
        }
        
        .btn {
            background: linear-gradient(to right, #1a2a6c, #b21f1f);
            color: white;
            border: none;
            padding: 14px 25px;
            font-size: 18px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s ease;
            margin-top: 10px;
        }
        
        .btn:hover {
            background: linear-gradient(to right, #233380, #c72a2a);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .links {
            margin-top: 25px;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        
        .links a {
            color: #1a2a6c;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease;
            margin: 5px 0;
        }
        
        .links a:hover {
            color: #b21f1f;
            text-decoration: underline;
        }
        
        .logo {
            margin-bottom: 25px;
        }
        
        .logo h1 {
            color: #1a2a6c;
            font-size: 32px;
            background: linear-gradient(to right, #1a2a6c, #b21f1f);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .footer {
            margin-top: 30px;
            color: #7f8c8d;
            font-size: 14px;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }
        
        .error {
            background-color: #ffdddd;
            color: #d32f2f;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 500;
            border: 1px solid #ff9999;
        }
        
        @media (max-width: 480px) {
            .container {
                padding: 25px;
            }
            
            h2 {
                font-size: 24px;
            }
            
            .links {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <h1>نظام المستخدمين</h1>
        </div>
        
        <h2>تسجيل الدخول إلى حسابك</h2>
        
        <?php if(isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form action="login.php" method="post">
            <div class="form-group">
                <label for="username">اسم المستخدم:</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">كلمة المرور:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn">تسجيل الدخول</button>
        </form>
        
        <div class="links">
            <a href="#">هل نسيت كلمة المرور؟</a>
            <a href="register.php">تسجيل حساب جديد</a>
            <a href="#">مساعدة</a>
        </div>
        
        <div class="footer">
            &copy; <?php echo date('Y'); ?> نظام المستخدمين. جميع الحقوق محفوظة.
        </div>
    </div>
</body>
</html>