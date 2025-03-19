<?php
session_start();
include 'config.php';
if (!isset($_SESSION['MaSV'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['remove'])) {
    $maHP = $_GET['remove'];
    $_SESSION['cart'] = array_diff($_SESSION['cart'], [$maHP]);
    header("Location: cart.php");
}

if (isset($_GET['clear'])) {
    $_SESSION['cart'] = [];
    header("Location: cart.php");
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng học phần</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1e1e1e, #121212);
            color: #fff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            max-width: 800px;
        }
        .card {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            border-radius: 15px;
            backdrop-filter: blur(15px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            padding: 20px;
        }
        .table {
            border-radius: 10px;
            overflow: hidden;
        }
        .table th {
            background: #4a4a4a;
            color: white;
        }
        .table td, .table th {
            text-align: center;
        }
        .btn-danger {
            background: #ff4b5c;
            border: none;
            transition: 0.3s;
        }
        .btn-danger:hover {
            background: #c72c3f;
        }
        .btn-success {
            background: #28a745;
            border: none;
            transition: 0.3s;
        }
        .btn-success:hover {
            background: #218838;
        }
        .btn-secondary {
            background: #6c757d;
            border: none;
            transition: 0.3s;
        }
        .btn-secondary:hover {
            background: #545b62;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card p-4">
        <h2 class="text-center mb-4">🛒 Giỏ hàng học phần</h2>
        <?php if (!empty($_SESSION['cart'])): 
            $cart = implode("','", $_SESSION['cart']);
            $result = mysqli_query($conn, "SELECT * FROM HocPhan WHERE MaHP IN ('$cart')");
        ?>
            <table class="table table-dark table-hover">
                <thead>
                    <tr>
                        <th>Mã HP</th>
                        <th>Tên HP</th>
                        <th>Số tín chỉ</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $row['MaHP'] ?></td>
                        <td><?= $row['TenHP'] ?></td>
                        <td><?= $row['SoTinChi'] ?></td>
                        <td>
                            <a href="cart.php?remove=<?= $row['MaHP'] ?>" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash-alt"></i> Xóa
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-center">Giỏ hàng trống 😞</p>
        <?php endif; ?>
        
        <div class="d-flex justify-content-between mt-3">
            <a href="cart.php?clear=1" class="btn btn-danger">
                <i class="fas fa-times-circle"></i> Xóa hết
            </a>
            <a href="save.php" class="btn btn-success">
                <i class="fas fa-save"></i> Lưu đăng ký
            </a>
            <a href="hocphan.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
