<?php
session_start();
include 'config.php';

$error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $maSV = trim($_POST['MaSV']); // Xóa khoảng trắng
    $result = mysqli_query($conn, "SELECT * FROM SinhVien WHERE MaSV='$maSV'");

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['MaSV'] = $maSV;
        header("Location: index.php");
        exit();
    } else {
        $error = "❌ Mã sinh viên không tồn tại!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-container {
            width: 380px;
            margin: 100px auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>🔑 Đăng nhập</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger text-center"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">📌 Mã Sinh Viên</label>
            <input type="text" name="MaSV" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">🚀 Đăng nhập</button>
    </form>

    <div class="mt-3 text-center">
        <a href="register.php" class="btn btn-link">👉 Đăng ký ngay</a> |
        <a href="home.php" class="btn btn-link">🏠 Trở về trang chủ</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
