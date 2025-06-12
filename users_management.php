<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة المستخدمين - نظام رقيب العهدة</title>
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
            --primary-dark: #0d1a4d;
            --secondary: #b21f1f;
            --accent: #fdbb2d;
            --light: #f8f9fa;
            --dark: #343a40;
            --gray: #6c757d;
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
        }
        
        .container {
            width: 100%;
            max-width: 1000px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: var(--shadow);
            overflow: hidden;
            padding: 40px;
            animation: fadeIn 0.8s ease-out;
            text-align: center;
        }
        
        .header {
            text-align: center;
            margin-bottom: 40px;
            position: relative;
        }
        
        .header h1 {
            font-size: 42px;
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
        
        .header p {
            font-size: 18px;
            color: var(--gray);
            max-width: 700px;
            margin: 20px auto 0;
            line-height: 1.6;
        }
        
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 40px;
            margin: 60px 0;
            flex-wrap: wrap;
        }
        
        .action-btn {
            width: 300px;
            height: 180px;
            background: white;
            border-radius: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            box-shadow: var(--card-shadow);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            text-decoration: none;
        }
        
        .action-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 8px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
        }
        
        .action-btn:hover {
            transform: translateY(-15px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }
        
        .action-btn.users-btn:hover {
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0.95), rgba(26, 42, 108, 0.1));
        }
        
        .action-btn.view-btn:hover {
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0.95), rgba(178, 31, 31, 0.1));
        }
        
        .btn-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            font-size: 36px;
            color: white;
            transition: all 0.4s ease;
        }
        
        .users-btn .btn-icon {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            box-shadow: 0 10px 25px rgba(26, 42, 108, 0.4);
        }
        
        .view-btn .btn-icon {
            background: linear-gradient(135deg, var(--secondary), #8c1919);
            box-shadow: 0 10px 25px rgba(178, 31, 31, 0.4);
        }
        
        .action-btn:hover .btn-icon {
            transform: scale(1.1) rotate(10deg);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
        }
        
        .btn-title {
            font-size: 28px;
            color: var(--dark);
            font-weight: 700;
        }
        
        .btn-desc {
            font-size: 16px;
            color: var(--gray);
            margin-top: 10px;
            max-width: 250px;
        }
        
        .back-button {
            margin-top: 40px;
            text-align: right;
        }

        .btn-back {
            display: inline-block;
            padding: 12px 25px;
            background-color: var(--gray);
            color: white;
            border-radius: 10px;
            text-decoration: none;
            font-size: 16px;
            transition: background 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-back:hover {
            background-color: var(--dark);
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            color: var(--gray);
            font-size: 16px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
        
        /* الرسوم المتحركة */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
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
        
        /* التصميم المتجاوب */
        @media (max-width: 768px) {
            .header h1 {
                font-size: 32px;
            }
            
            .action-buttons {
                flex-direction: column;
                gap: 30px;
            }
            
            .action-btn {
                width: 100%;
                max-width: 350px;
                height: 160px;
            }
        }
        
        @media (max-width: 480px) {
            .container {
                padding: 25px;
            }
            
            .header h1 {
                font-size: 28px;
            }
            
            .btn-icon {
                width: 70px;
                height: 70px;
                font-size: 30px;
            }
            
            .btn-title {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>إدارة المستخدمين</h1>
            <p>لوحة التحكم المركزية لإدارة مستخدمي نظام رقيب العهدة. اختر الإجراء الذي ترغب في تنفيذه:</p>
        </div>
        
        <div class="action-buttons">
            <!-- زر إضافة مستخدم جديد -->
            <a href="register.html" class="action-btn users-btn float-animation">
                <div class="btn-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div class="btn-title">إضافة مستخدم جديد</div>
                <div class="btn-desc">تسجيل مستخدم جديد في النظام</div>
            </a>

            <!-- زر عرض المستخدمين -->
            <a href="users_view.php" class="action-btn view-btn float-animation" style="animation-delay: 0.2s;">
                <div class="btn-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="btn-title">عرض المستخدمين</div>
                <div class="btn-desc">عرض وتعديل وحذف المستخدمين الحاليين</div>
            </a>
        </div>

        <!-- زر الرجوع -->
        <div class="back-button">
            <a href="dashboard.php" class="btn-back">
                <i class="fas fa-arrow-right"></i> رجوع
            </a>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>جميع الحقوق محفوظة &copy; 2023 نظام رقيب العهدة | الإصدار 3.0</p>
        </div>
    </div>
</body>
</html>