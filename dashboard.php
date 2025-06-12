<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - نظام رقيب العهدة</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">     
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', 'Tahoma', Geneva, Verdana, sans-serif;
        }
        
        :root {
            --primary: #1a2a6c;
            --secondary: #b21f1f;
            --accent: #fdbb2d;
            --light: #f8f9fa;
            --dark: #343a40;
            --gray: #6c757d;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
        
        body {
            background: linear-gradient(135deg, #1a2a6c, #b21f1f, #fdbb2d);
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            position: relative;
        }

        .logout-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            color: var(--dark);
            padding: 10px 20px;
            border-radius: 30px;
            font-size: 16px;
            text-decoration: none;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background-color: var(--secondary);
            color: white;
            transform: scale(1.05);
        }
        
        .container {
            max-width: 800px;
            width: 100%;
            text-align: center;
        }
        
        .header {
            margin-bottom: 50px;
            animation: fadeInDown 1s ease;
        }
        
        .logo {
            display: inline-flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .logo i {
            font-size: 48px;
            color: var(--accent);
            text-shadow: 0 0 15px rgba(253, 187, 45, 0.5);
        }
        
        .logo h1 {
            font-size: 42px;
            color: white;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }
        
        .welcome-text {
            font-size: 22px;
            color: rgba(255, 255, 255, 0.9);
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }
        
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 35px;
            margin-top: 50px;
        }
        
        .dashboard-btn {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 40px 30px;
            text-decoration: none;
            box-shadow: var(--shadow);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            transform: translateY(0);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 300px;
        }
        
        .dashboard-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 8px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
        }
        
        .dashboard-btn:hover {
            transform: translateY(-15px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }
        
        .dashboard-btn.users-btn:hover {
            background: linear-gradient(to bottom right, rgba(255, 255, 255, 0.95), rgba(26, 42, 108, 0.1));
        }
        
        .dashboard-btn.items-btn:hover {
            background: linear-gradient(to bottom right, rgba(255, 255, 255, 0.95), rgba(178, 31, 31, 0.1));
        }
        
        .btn-icon {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
            font-size: 50px;
            color: white;
            transition: all 0.4s ease;
        }
        
        .users-btn .btn-icon {
            background: linear-gradient(135deg, var(--primary), #233380);
            box-shadow: 0 8px 20px rgba(26, 42, 108, 0.4);
        }
        
        .items-btn .btn-icon {
            background: linear-gradient(135deg, var(--secondary), #c72a2a);
            box-shadow: 0 8px 20px rgba(178, 31, 31, 0.4);
        }
        
        .dashboard-btn:hover .btn-icon {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.3);
        }
        
        .btn-title {
            font-size: 32px;
            color: var(--dark);
            margin-bottom: 15px;
            font-weight: 700;
        }
        
        .btn-desc {
            font-size: 18px;
            color: var(--gray);
            line-height: 1.6;
            max-width: 280px;
        }
        
        .footer {
            margin-top: 70px;
            color: rgba(255, 255, 255, 0.7);
            font-size: 16px;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
        }
        
        /* الرسوم المتحركة */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-15px);
            }
        }
        
        .float-animation {
            animation: float 4s ease-in-out infinite;
        }
        
        .delay-1 {
            animation-delay: 0.2s;
        }
        
        /* التصميم المتجاوب */
        @media (max-width: 768px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
                max-width: 500px;
                margin: 50px auto 0;
            }
            
            .logo h1 {
                font-size: 36px;
            }
            
            .welcome-text {
                font-size: 18px;
            }
        }
        
        @media (max-width: 480px) {
            .logo h1 {
                font-size: 28px;
            }
            
            .btn-title {
                font-size: 28px;
            }
            
            .btn-icon {
                width: 80px;
                height: 80px;
                font-size: 40px;
            }
            
            .dashboard-btn {
                min-height: 250px;
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <!-- زر تسجيل الخروج -->
    <a href="logout.php" class="logout-btn">
        <i class="fas fa-sign-out-alt"></i> تسجيل الخروج
    </a>

    <!-- محتوى الصفحة -->
    <div class="container">
        <div class="header">
            <div class="logo float-animation">
                <i class="fas fa-shield-alt"></i>
                <h1>نظام رقيب العهدة</h1>
            </div>
            <p class="welcome-text">
                لوحة التحكم الرئيسية لنظام إدارة المستخدمين والعهدة. اختر الوحدة التي ترغب في إدارتها:
            </p>
        </div>
        
        <div class="dashboard-grid">
            <a href="users_management.php" class="dashboard-btn users-btn">
                <div class="btn-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h2 class="btn-title">إدارة المستخدمين</h2>
                <p class="btn-desc">إضافة، تعديل، حذف المستخدمين وإدارة صلاحياتهم</p>
            </a>
            
            <a href="items_management.php" class="dashboard-btn items-btn delay-1">
                <div class="btn-icon">
                    <i class="fas fa-boxes"></i>
                </div>
                <h2 class="btn-title">إدارة العهدة</h2>
                <p class="btn-desc">تسجيل، تتبع، وإدارة جميع عناصر العهدة والمستودعات</p>
            </a>
        </div>
        
        <div class="footer">
            <p>جميع الحقوق محفوظة &copy; 2023 نظام رقيب العهدة | الإصدار 2.0</p>
        </div>
    </div>
    
    <script>
        // إضافة تأثيرات تفاعلية بسيطة
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.dashboard-btn');
            
            buttons.forEach(btn => {
                btn.addEventListener('mouseenter', function() {
                    this.classList.add('float');
                });
                
                btn.addEventListener('mouseleave', function() {
                    this.classList.remove('float');
                });
            });
            
            // رسالة ترحيب عند الدخول
            setTimeout(() => {
                console.log('مرحبًا بك في نظام رقيب العهدة!');
            }, 1000);
        });
    </script>
</body>
</html>