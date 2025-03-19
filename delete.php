<?php
session_start();
include 'config.php';
if (!isset($_SESSION['MaSV'])) {
    header("Location: login.php");
    exit();
}

// Kiểm tra quyền: chỉ user có MaSV = 999999999 được truy cập
if ($_SESSION['MaSV'] !== '999999999') {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];
if (mysqli_query($conn, "DELETE FROM SinhVien WHERE MaSV='$id'")) {
    header("Location: index.php");
} else {
    echo "Lỗi khi xóa sinh viên: " . mysqli_error($conn);
}
?>