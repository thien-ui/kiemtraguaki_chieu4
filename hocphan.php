<?php
session_start();
include 'config.php';
if (!isset($_SESSION['MaSV'])) {
    header("Location: login.php");
    exit();
}
$result = mysqli_query($conn, "SELECT * FROM HocPhan");

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_GET['add'])) {
    $maHP = $_GET['add'];
    if (!in_array($maHP, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $maHP;
    }
    header("Location: hocphan.php");
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký học phần</title>
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
        .btn-primary {
            background: #007bff;
            border: none;
            transition: 0.3s;
        }
        .btn-primary:hover {
            background: #0056b3;
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
        <h2 class="text-center mb-4">📚 Đăng ký học phần</h2>
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
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['MaHP']; ?></td>
                    <td><?php echo $row['TenHP']; ?></td>
                    <td><?php echo $row['SoTinChi']; ?></td>
                    <td>
                        <a href="hocphan.php?add=<?php echo $row['MaHP']; ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-cart-plus"></i> Thêm
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="d-flex justify-content-between mt-3">
            <a href="cart.php" class="btn btn-primary">
                <i class="fas fa-shopping-cart"></i> Xem giỏ hàng
            </a>
            <a href="index.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
