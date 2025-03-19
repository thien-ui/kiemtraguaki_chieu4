<?php
session_start();
include 'config.php';
if (!isset($_SESSION['MaSV'])) {
    header("Location: login.php");
    exit();
}

if (isset($_SESSION['MaSV']) && !empty($_SESSION['cart'])) {
    $maSV = $_SESSION['MaSV'];
    $ngayDK = date('Y-m-d');
    $sql = "INSERT INTO DangKy(NgayDK, MaSV) VALUES('$ngayDK', '$maSV')";
    if (mysqli_query($conn, $sql)) {
        $maDK = mysqli_insert_id($conn);
        foreach ($_SESSION['cart'] as $maHP) {
            mysqli_query($conn, "INSERT INTO ChiTietDangKy(MaDK, MaHP) VALUES('$maDK', '$maHP')");
        }
        $_SESSION['cart'] = [];
        $message = "Đăng ký thành công!";
    } else {
        $message = "Lỗi: " . mysqli_error($conn);
    }
} else {
    $message = "Vui lòng đăng nhập và chọn học phần!";
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lưu đăng ký</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Arial', sans-serif;
        }
        .alert {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            border-radius: 15px;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            color: #fff;
            padding: 20px;
            max-width: 500px;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="alert <?php echo strpos($message, 'Lỗi') === false ? 'alert-success' : 'alert-danger'; ?>" role="alert">
        <?php echo $message; ?>
        <a href="hocphan.php" class="btn btn-primary mt-3"><i class="fas fa-arrow-left"></i> Quay lại</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>