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

// استعلام لجلب جميع المستخدمين
$sql = "SELECT user_id, username, Date_Added, user_level, created_at, last_updated FROM users_tb ORDER BY user_id ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض المستخدمين - نظام رقيب العهدة</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> 
    <!-- مكتبة SheetJS لتصدير Excel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script> 
    <!-- مكتبة jsPDF لتصدير PDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script> 
    <style>
        /* تم إدراج كل CSS من الملف الأصلي هنا */
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
        }
        .container {
            width: 100%;
            max-width: 1200px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: var(--shadow);
            overflow: hidden;
            padding: 30px;
            animation: fadeIn 0.8s ease-out;
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
            gap: 30px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }
        .action-btn {
            padding: 14px 30px;
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
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }
        /* جدول المستخدمين */
        .users-table-container {
            background: white;
            border-radius: 15px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            margin-top: 30px;
        }
        .toolbar {
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
            background: rgba(26, 42, 108, 0.05);
            border-bottom: 1px solid var(--light-gray);
        }
        .search-box {
            flex: 1;
            min-width: 300px;
            position: relative;
        }
        .search-box input {
            width: 100%;
            padding: 12px 20px 12px 45px;
            border: 2px solid var(--light-gray);
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s;
        }
        .search-box input:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(26, 42, 108, 0.2);
        }
        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
        }
        .table-actions {
            display: flex;
            gap: 10px;
        }
        .table-btn {
            padding: 10px 15px;
            border-radius: 8px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
            font-size: 15px;
            position: relative;
        }
        .table-btn.refresh {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success);
        }
        .table-btn.export {
            background: rgba(0, 123, 255, 0.1);
            color: #007bff;
        }
        .table-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        /* قائمة التصدير المنسدلة */
        .export-dropdown {
            position: relative;
            display: inline-block;
        }
        .export-options {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 180px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            z-index: 1;
            border-radius: 8px;
            overflow: hidden;
            top: 100%;
            left: 0;
            margin-top: 5px;
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
            color: var(--dark);
            font-weight: 500;
            transition: all 0.2s;
            border-bottom: 1px solid var(--light-gray);
        }
        .export-option:last-child {
            border-bottom: none;
        }
        .export-option:hover {
            background-color: rgba(26, 42, 108, 0.05);
            color: var(--primary);
        }
        .export-option i {
            font-size: 18px;
        }
        .table-responsive {
            overflow-x: auto;
            max-height: 500px;
            overflow-y: auto;
        }
        .users-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1000px;
        }
        .users-table th {
            background: rgba(26, 42, 108, 0.9);
            color: white;
            padding: 16px 20px;
            text-align: right;
            font-weight: 600;
            position: sticky;
            top: 0;
        }
        .users-table td {
            padding: 14px 20px;
            text-align: right;
            border-bottom: 1px solid var(--light-gray);
        }
        .users-table tr:nth-child(even) {
            background-color: rgba(26, 42, 108, 0.03);
        }
        .users-table tr:hover {
            background-color: rgba(26, 42, 108, 0.05);
        }
        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: white;
            font-size: 20px;
            margin: 0 auto;
        }
        .status {
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
            display: inline-block;
        }
        .status-active {
            background: rgba(40, 167, 69, 0.15);
            color: var(--success);
        }
        .status-inactive {
            background: rgba(220, 53, 69, 0.15);
            color: var(--danger);
        }
        .status-pending {
            background: rgba(255, 193, 7, 0.15);
            color: var(--warning);
        }
        .action-cell {
            display: flex;
            gap: 10px;
            justify-content: center;
        }
        .action-btn-small {
            padding: 8px 15px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 600;
            font-size: 14px;
            border: none;
            gap: 5px;
            text-decoration: none;
        }
        .action-btn-small.edit {
            background: rgba(40, 167, 69, 0.15);
            color: var(--success);
        }
        .action-btn-small.delete {
            background: rgba(220, 53, 69, 0.15);
            color: var(--danger);
        }
        .action-btn-small:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            color: var(--gray);
            font-size: 15px;
            padding-top: 20px;
            border-top: 1px solid var(--light-gray);
        }
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 25px;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            box-shadow: var(--shadow);
            z-index: 1000;
            animation: slideIn 0.3s, fadeOut 0.3s 2.5s forwards;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .notification.success {
            background: linear-gradient(to right, var(--success), #218838);
        }
        .notification.info {
            background: linear-gradient(to right, #17a2b8, #138496);
        }
        .notification.error {
            background: linear-gradient(to right, var(--danger), #bd2130);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInRow {
            from { opacity: 0; transform: translateX(20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; transform: translateY(-20px); }
        }
        .users-table tbody tr {
            animation: fadeInRow 0.5s ease-out;
            animation-fill-mode: both;
        }
        .users-table tbody tr:nth-child(1) { animation-delay: 0.1s; }
        .users-table tbody tr:nth-child(2) { animation-delay: 0.2s; }
        .users-table tbody tr:nth-child(3) { animation-delay: 0.3s; }
        .users-table tbody tr:nth-child(4) { animation-delay: 0.4s; }
        .users-table tbody tr:nth-child(5) { animation-delay: 0.5s; }
        .users-table tbody tr:nth-child(6) { animation-delay: 0.6s; }
        .users-table tbody tr:nth-child(7) { animation-delay: 0.7s; }
        @media (max-width: 768px) {
            .header h1 { font-size: 32px; }
            .action-buttons { flex-direction: column; align-items: center; }
            .action-btn { width: 100%; max-width: 350px; justify-content: center; }
            .toolbar { flex-direction: column; align-items: stretch; }
            .search-box { min-width: 100%; }
            .table-actions { width: 100%; justify-content: center; }
            .export-options { left: auto; right: 0; }
        }
        @media (max-width: 480px) {
            .container { padding: 20px; }
            .header h1 { font-size: 28px; }
            .action-btn { font-size: 16px; padding: 12px 20px; }
            .action-btn-small { padding: 6px 10px; font-size: 13px; }
            .users-table th, .users-table td { padding: 12px 15px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>عرض بيانات المستخدمين</h1>
            <p>قائمة كاملة بجميع المستخدمين المسجلين في نظام رقيب العهدة. يمكنك إدارة المستخدمين من خلال هذه الصفحة</p>
        </div>
        <div class="action-buttons">
            <a href="register.html" class="action-btn primary">
                <i class="fas fa-user-plus"></i> إضافة مستخدم جديد
            </a>
            <a href="dashboard.php" class="action-btn secondary">
                <i class="fas fa-home"></i> العودة للرئيسية
            </a>
        </div>
        <div class="users-table-container">
            <div class="toolbar">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="ابحث عن مستخدم...">
                </div>
                <div class="table-actions">
                    <button class="table-btn refresh" id="refreshBtn">
                        <i class="fas fa-sync-alt"></i> تحديث
                    </button>
                    <div class="export-dropdown">
                        <button class="table-btn export" id="exportBtn">
                            <i class="fas fa-file-export"></i> تصدير البيانات
                        </button>
                        <div class="export-options" id="exportOptions">
                            <a href="#" class="export-option" id="exportExcel">
                                <i class="fas fa-file-excel"></i> تصدير إلى Excel
                            </a>
                            <a href="#" class="export-option" id="exportPDF">
                                <i class="fas fa-file-pdf"></i> تصدير إلى PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="users-table" id="usersTable">
                    <thead>
                        <tr>
                            <th style="width: 60px;"></th>
                            <th>رقم المستخدم</th>
                            <th>اسم المستخدم</th>
                            <th>تاريخ التسجيل</th>
                            <th>مستوى المستخدم</th>
                            <th>تاريخ الإنشاء</th>
                            <th>آخر تحديث</th>
                            <th style="width: 200px;">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><div class="user-avatar"><?= substr($row['username'], 0, 1) ?></div></td>
                                    <td><?= $row['user_id'] ?></td>
                                    <td><?= htmlspecialchars($row['username']) ?></td>
                                    <td><?= $row['Date_Added'] ?></td>
                                    <td>
                                        <?php
                                            switch ($row['user_level']) {
                                                case 'admin':
                                                    echo '<span class="status status-active">مدير النظام</span>';
                                                    break;
                                                case 'editor':
                                                    echo '<span class="status status-pending">محرر</span>';
                                                    break;
                                                default:
                                                    echo '<span class="status status-inactive">مستخدم عادي</span>';
                                            }
                                        ?>
                                    </td>
                                    <td><?= $row['created_at'] ?></td>
                                    <td><?= $row['last_updated'] ?></td>
                                    <td class="action-cell">
                                        <a href="edit_user.php?id=<?= $row['user_id'] ?>" class="action-btn-small edit"><i class="fas fa-edit"></i> تعديل</a>
                                        <a href="delete_user.php?id=<?= $row['user_id'] ?>" class="action-btn-small delete" onclick="return confirmDelete()"><i class="fas fa-trash"></i> حذف</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" style="text-align:center;">لا يوجد مستخدمين حالياً</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="footer">
            <p>جميع الحقوق محفوظة &copy; 2025 نظام رقيب العهدة | الإصدار 2.1</p>
            <p>إجمالي المستخدمين: <?= $result->num_rows ?> مستخدم</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const exportBtn = document.getElementById('exportBtn');
            const exportOptions = document.getElementById('exportOptions');

            // البحث في الجدول
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const rows = document.querySelectorAll('.users-table tbody tr');
                rows.forEach(row => {
                    const userId = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                    const username = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                    if (userId.includes(searchTerm) || username.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });

            // زر التحديث
            document.getElementById('refreshBtn').addEventListener('click', function() {
                location.reload();
            });

            // عرض/إخفاء قائمة التصدير
            exportBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                exportOptions.classList.toggle('show');
            });

            // إغلاق القائمة عند النقر في أي مكان آخر
            document.addEventListener('click', function() {
                exportOptions.classList.remove('show');
            });

            // منع إغلاق القائمة عند النقر عليها
            exportOptions.addEventListener('click', function(e) {
                e.stopPropagation();
            });

            // تصدير إلى Excel
            document.getElementById('exportExcel').addEventListener('click', function(e) {
                e.preventDefault();
                exportOptions.classList.remove('show');
                exportToExcel();
            });

            // تصدير إلى PDF
            document.getElementById('exportPDF').addEventListener('click', function(e) {
                e.preventDefault();
                exportOptions.classList.remove('show');
                exportToPDF();
            });
        });

        // تأكيد الحذف
        function confirmDelete() {
            return confirm('هل أنت متأكد من رغبتك في حذف هذا المستخدم؟ لا يمكن التراجع عن هذا الإجراء.');
        }

        // عرض الإشعار
        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.innerHTML = `
                <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle'}"></i>
                ${message}
            `;
            document.body.appendChild(notification);
            setTimeout(() => {
                notification.style.animation = 'fadeOut 0.3s forwards';
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, 2500);
        }

        // تصدير إلى Excel
        function exportToExcel() {
            try {
                const table = document.getElementById('usersTable');
                const wb = XLSX.utils.book_new();
                const ws = XLSX.utils.table_to_sheet(table);
                XLSX.utils.book_append_sheet(wb, ws, "المستخدمين");
                XLSX.writeFile(wb, "المستخدمين_نظام_رقيب_العهدة.xlsx");
                showNotification('تم تصدير بيانات المستخدمين بنجاح إلى ملف Excel', 'success');
            } catch (error) {
                console.error('خطأ في تصدير Excel:', error);
                showNotification('حدث خطأ أثناء تصدير البيانات إلى Excel', 'error');
            }
        }

        // تصدير إلى PDF
        function exportToPDF() {
            try {
                const { jsPDF } = window.jspdf;
                const doc = new jsPDF({
                    orientation: 'landscape',
                    unit: 'mm',
                    format: 'a4'
                });
                doc.setFontSize(18);
                doc.setFont('helvetica', 'bold');
                doc.text('تقرير المستخدمين - نظام رقيب العهدة', 148, 15, { align: 'center' });
                const date = new Date().toLocaleDateString('ar-EG', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
                doc.setFontSize(12);
                doc.setFont('helvetica', 'normal');
                doc.text(`تاريخ التصدير: ${date}`, 280, 15, { align: 'left' });
                const table = document.getElementById('usersTable');
                const headers = [];
                const data = [];
                table.querySelectorAll('thead th').forEach((th, index) => {
                    if (index !== 7) {
                        headers.push(th.textContent.trim());
                    }
                });
                table.querySelectorAll('tbody tr').forEach(tr => {
                    const rowData = [];
                    tr.querySelectorAll('td').forEach((td, index) => {
                        if (index !== 7) {
                            if (index === 4) {
                                const statusSpan = td.querySelector('.status');
                                rowData.push(statusSpan ? statusSpan.textContent.trim() : td.textContent.trim());
                            } else {
                                rowData.push(td.textContent.trim());
                            }
                        }
                    });
                    data.push(rowData);
                });
                doc.autoTable({
                    head: [headers],
                    body: data,
                    startY: 25,
                    theme: 'grid',
                    styles: {
                        font: 'tahoma',
                        fontSize: 10,
                        cellPadding: 3,
                        textColor: [0, 0, 0],
                        halign: 'center'
                    },
                    headStyles: {
                        fillColor: [26, 42, 108],
                        textColor: [255, 255, 255],
                        fontStyle: 'bold'
                    },
                    alternateRowStyles: {
                        fillColor: [240, 240, 240]
                    },
                    margin: { top: 25 }
                });
                const pageCount = doc.internal.getNumberOfPages();
                for (let i = 1; i <= pageCount; i++) {
                    doc.setPage(i);
                    doc.setFontSize(10);
                    doc.text(`الصفحة ${i} من ${pageCount}`, doc.internal.pageSize.getWidth() - 15, doc.internal.pageSize.getHeight() - 10, { align: 'right' });
                }
                doc.save('المستخدمين_نظام_رقيب_العهدة.pdf');
                showNotification('تم تصدير بيانات المستخدمين بنجاح إلى ملف PDF', 'success');
            } catch (error) {
                console.error('خطأ في تصدير PDF:', error);
                showNotification('حدث خطأ أثناء تصدير البيانات إلى PDF', 'error');
            }
        }
    </script>
</body>
</html>
<?php $conn->close(); ?>