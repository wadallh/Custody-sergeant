<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "DELETE FROM kashf WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // إعادة التوجيه مع رسالة نجاح
        header("Location: items_management.php?deleted=1");
    } else {
        // إعادة التوجيه مع رسالة خطأ
        header("Location: items_management.php?deleted=0");
    }
    exit;
} else {
    // إذا لم يتم تمرير ID
    header("Location: items_management.php");
    exit;
}
?>