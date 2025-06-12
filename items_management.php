<?php
include 'db.php';
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>كشف العهدة - نظام رقيب العهدة</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">     
    <style>
        :root {
            --primary: #1a2a6c;
            --primary-dark: #121f4d;
            --secondary: #d9232d;
            --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Tajawal', sans-serif;
        }
        body {
            background-color: #f4f6f9;
            color: #333;
            line-height: 1.6;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 24px;
            color: #1a2a6c;
        }
        .action-buttons {
            display: flex;
            justify-content: flex-start;
            gap: 10px;
            margin-bottom: 20px;
        }
        .action-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 8px;
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
            box-shadow: var(--card-shadow);
        }
        .action-btn.primary {
            background: linear-gradient(to right, var(--primary), var(--primary-dark));
            color: white;
        }
        .action-btn.secondary {
            background: linear-gradient(to right, var(--secondary), #8c1919);
            color: white;
        }
        .action-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        .items-table-container {
            background: white;
            border-radius: 15px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
        }
        .toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            border-bottom: 1px solid #ddd;
        }
        .search-box {
            display: flex;
            align-items: center;
            gap: 10px;
            position: relative;
        }
        .search-box input {
            width: 250px;
            padding: 8px 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        .table-actions {
            display: flex;
            gap: 10px;
        }
        .table-btn {
            padding: 8px 12px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 14px;
            background: #e0e0e0;
            color: #333;
        }
        .export-dropdown {
            position: relative;
            display: inline-block;
        }
        .export-options {
            display: none;
            position: absolute;
            top: 40px;
            right: 0;
            background: white;
            min-width: 180px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            z-index: 10;
            border-radius: 8px;
            overflow: hidden;
            animation: fadeIn 0.3s ease-out;
        }
        .export-options.show {
            display: block;
        }
        .export-option {
            padding: 12px 16px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #333;
            font-weight: 500;
            transition: all 0.2s;
            border-bottom: 1px solid #eee;
        }
        .export-option:last-child {
            border-bottom: none;
        }
        .export-option:hover {
            background: #f0f0f0;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(5px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .table-responsive {
            overflow-x: auto;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
        }
        .items-table thead tr {
            background: #f0f0f0;
        }
        .items-table th,
        .items-table td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        .item-icon {
            width: 36px;
            height: 36px;
            background: #eef2ff;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
        }
        .status-badge {
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 13px;
        }
        .status-ready {
            background: #d4edda;
            color: #155724;
        }
        .status-maintenance {
            background: #fff3cd;
            color: #856404;
        }
        .status-damaged {
            background: #f8d7da;
            color: #721c24;
        }
        .action-cell {
            white-space: nowrap;
        }
        .action-btn-small {
            padding: 6px 10px;
            font-size: 13px;
            margin-right: 5px;
            border-radius: 6px;
            display: inline-block;
        }
        .action-btn-small.view {
            background: #007bff;
            color: white;
        }
        .action-btn-small.edit {
            background: #28a745;
            color: white;
        }
        .action-btn-small.delete {
            background: #dc3545;
            color: white;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 14px;
            color: #666;
        }

        /* رسائل الإشعارات */
        .notification {
            position: fixed;
            bottom: 20px;
            left: 20px;
            background: #333;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            animation: fadeIn 0.3s forwards;
            z-index: 9999;
        }
        .notification.success {
            background: #28a745;
        }
        .notification.error {
            background: #dc3545;
        }
        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(20px);}
            to {opacity: 1; transform: translateY(0);}
        }
        @keyframes fadeOut {
            from {opacity: 1; transform: translateY(0);}
            to {opacity: 0; transform: translateY(20px);}
        }

        /* أنماط المودال */
        .modal {
            display: none;
            position: fixed;
            z-index: 99999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }
        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border-radius: 10px;
            width: 90%;
            max-width: 400px;
            box-shadow: var(--card-shadow);
            position: relative;
            animation: fadeIn 0.3s ease-out;
        }
        .close-btn {
            position: absolute;
            top: 10px;
            left: 15px;
            font-size: 24px;
            cursor: pointer;
            color: #999;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* رسالة تم الحذف */
        .success-message {
            display: none;
            position: fixed;
            bottom: 20px;
            left: 20px;
            background: #28a745;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 99999;
            animation: slideInUp 0.4s ease-out;
            font-size: 15px;
            font-weight: bold;
        }
        .success-message i {
            margin-left: 8px;
        }
        @keyframes slideInUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        @keyframes slideOutDown {
            from { transform: translateY(0); opacity: 1; }
            to { transform: translateY(20px); opacity: 0; }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>كشف العهدة التفصيلي</h1>
        <p>قائمة كاملة بجميع عناصر العهدة المسجلة في نظام رقيب العهدة مع تفاصيل الحالة والمسؤولية</p>
    </div>
    <div class="action-buttons">
        <a href="add_item.php" class="action-btn primary">
            <i class="fas fa-plus-circle"></i> إضافة عهدة جديدة
        </a>
        <a href="dashboard.php" class="action-btn secondary">
            <i class="fas fa-home"></i> العودة للرئيسية
        </a>
    </div>

    <!-- جدول كشف العهدة -->
    <div class="items-table-container">
        <div class="toolbar">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="ابحث في كشف العهدة...">
            </div>
            <div class="table-actions">
                <button class="table-btn refresh" id="refreshBtn">
                    <i class="fas fa-sync-alt"></i> تحديث
                </button>
                <div class="export-dropdown" id="exportDropdown">
                    <button class="table-btn export" id="exportBtn">
                        <i class="fas fa-file-export"></i> تصدير البيانات
                    </button>
                    <div class="export-options" id="exportOptions">
                        <a href="#" class="export-option" id="exportExcel">
                            <i class="fas fa-file-excel"></i> تصدير إلى Excel
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="items-table" id="itemsTable">
                <thead>
                    <tr>
                        <th style="width: 60px;"></th>
                        <th>ID</th>
                        <th>الصنف</th>
                        <th>وحدة القياس</th>
                        <th>عدد الجاهز</th>
                        <th>عدد يحتاج صيانة</th>
                        <th>عدد تالف</th>
                        <th>مكان وجود العهدة</th>
                        <th>الجهة التابعة</th>
                        <th>تاريخ الإدخال</th>
                        <th>مسؤول العهدة</th>
                        <th>مسؤول القسم</th>
                        <th style="width: 200px;">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM kashf ORDER BY `id` ASC";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td><div class='item-icon'><i class='fas fa-box'></i></div></td>";
                            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['الصنف']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['وحدة_القياس']) . "</td>";
                            echo "<td><span class='status-badge status-ready'>" . htmlspecialchars($row['عدد_الجاهز']) . "</span></td>";
                            echo "<td><span class='status-badge status-maintenance'>" . htmlspecialchars($row['عدد_يحتاج_صيانة']) . "</span></td>";
                            echo "<td><span class='status-badge status-damaged'>" . htmlspecialchars($row['عدد_تالف']) . "</span></td>";
                            echo "<td>" . htmlspecialchars($row['مكان_وجود_العهدة']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['الجهة_التي_تتبعها_العهدة']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['تأربخ_الادخال']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['اسم_الشخص_المسؤول_عن_العهدة']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['اسم_الشخص_المسؤول_على_القسم']) . "</td>";
                            echo "<td class='action-cell'>
                                    <a href='view_item.php?id=" . $row['id'] . "' class='action-btn-small view' title='عرض التفاصيل'><i class='fas fa-eye'></i> عرض</a>
                                    <a href='edit_item.php?id=" . $row['id'] . "' class='action-btn-small edit' title='تعديل العهدة'><i class='fas fa-edit'></i> تعديل</a>
                                    <a href='delete_item.php?id=" . $row['id'] . "' class='action-btn-small delete delete-link' title='حذف العهدة'>حذف</a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='13'>لا توجد بيانات متاحة</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="footer">
        <?php
        $sql_count = "SELECT COUNT(*) AS total_items FROM kashf";
        $result_count = $conn->query($sql_count);
        $row_count = $result_count->fetch_assoc();
        echo "<p>إجمالي أصناف العهدة: " . $row_count['total_items'] . " أصناف</p>";
        echo "<p>جميع الحقوق محفوظة &copy; " . date('Y') . " نظام رقيب العهدة | الإصدار 2.0</p>";
        $conn->close();
        ?>
    </div>
</div>

<!-- مودال تأكيد الحذف -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <span class="close-btn">&times;</span>
        <h2 id="modalTitle">تأكيد الحذف</h2>
        <p id="modalMessage">هل أنت متأكد من رغبتك في حذف هذه العهدة؟<br>لا يمكن التراجع عن هذا الإجراء.</p>
        <div style="text-align: left; margin-top: 20px;" id="modalButtons">
            <button id="confirmDeleteBtn" class="action-btn-small delete" style="padding: 8px 16px;">نعم، احذف</button>
            <button id="cancelDeleteBtn" class="action-btn-small" style="padding: 8px 16px; background: #6c757d; color: white;">إلغاء</button>
        </div>
    </div>
</div>

<!-- رسالة تم الحذف -->
<div id="deleteSuccessMessage" class="success-message">
    <i class="fas fa-trash"></i> تم حذف العهدة بنجاح!
</div>

<script>
    function showDeleteSuccessMessage() {
        const msg = document.getElementById('deleteSuccessMessage');
        msg.style.display = 'flex';
        setTimeout(() => {
            msg.style.animation = 'slideOutDown 0.4s ease-in';
            setTimeout(() => {
                msg.style.display = 'none';
            }, 400);
        }, 2500);
    }

    // مودال الحذف
    let deleteLink = null;

    document.addEventListener('click', function(e) {
        if (e.target.closest('.delete-link')) {
            e.preventDefault();
            deleteLink = e.target.closest('.delete-link').href;
            document.getElementById('modalTitle').textContent = 'تأكيد الحذف';
            document.getElementById('modalMessage').innerHTML = 'هل أنت متأكد من رغبتك في حذف هذه العهدة؟<br>لا يمكن التراجع عن هذا الإجراء.';
            document.getElementById('modalButtons').style.display = 'block';
            document.getElementById('deleteModal').style.display = 'block';
        }
    });

    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        if (deleteLink) {
            document.getElementById('modalTitle').textContent = 'جارٍ الحذف';
            document.getElementById('modalMessage').innerHTML = 'جاري حذف العهدة... الرجاء الانتظار.';
            document.getElementById('modalButtons').style.display = 'none';

            setTimeout(() => {
                window.location.href = deleteLink;
            }, 1000);
        }
    });

    document.getElementById('cancelDeleteBtn').addEventListener('click', function() {
        document.getElementById('deleteModal').style.display = 'none';
    });

    document.querySelector('.close-btn')?.addEventListener('click', function() {
        document.getElementById('deleteModal').style.display = 'none';
    });

    // إظهار رسالة الحذف الناجح إذا كانت موجودة
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('deleted')) {
        showDeleteSuccessMessage();
    }
</script>
</body>
</html>