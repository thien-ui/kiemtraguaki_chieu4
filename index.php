<?php
session_start();
include 'config.php';
if (!isset($_SESSION['MaSV'])) {
    header("Location: login.php");
    exit();
}

// Kiểm tra quyền admin
$isAdmin = ($_SESSION['MaSV'] === '999999999');

$result = mysqli_query($conn, "SELECT * FROM SinhVien");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sinh viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-4">
        <h1 class="text-center">Danh sách sinh viên</h1>
        <div class="d-flex justify-content-between mb-3">
            <a href='logout.php' class="btn btn-danger">Đăng xuất</a>
            <?php if ($isAdmin) { ?>
                <a href='create.php' class="btn btn-success">Thêm sinh viên</a>
            <?php } ?>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center bg-white">
                <thead class="table-dark">
                    <tr>
                        <th>Mã SV</th>
                        <th>Họ tên</th>
                        <th>Giới tính</th>
                        <th>Ngày sinh</th>
                        <th>Hình</th>
                        <th>Mã ngành</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $row['MaSV']; ?></td>
                            <td><?php echo $row['HoTen']; ?></td>
                            <td><?php echo $row['GioiTinh']; ?></td>
                            <td><?php echo $row['NgaySinh']; ?></td>
                            <td>
                                <?php if ($row['Hinh'] && file_exists($row['Hinh'])) { ?>
                                    <img src="<?php echo $row['Hinh']; ?>" width="40" height="40" class="rounded-circle">
                                <?php } else { echo "Không có hình"; } ?>
                            </td>
                            <td><?php echo $row['MaNganh']; ?></td>
                            <td>
                                <a href='detail.php?id=<?php echo $row['MaSV']; ?>' class="btn btn-primary btn-sm">Chi tiết</a>
                                <?php if ($isAdmin) { ?>
                                    <a href='edit.php?id=<?php echo $row['MaSV']; ?>' class="btn btn-warning btn-sm">Sửa</a>
                                    <a href='delete.php?id=<?php echo $row['MaSV']; ?>' class="btn btn-danger btn-sm" onclick="return confirm('Xóa sinh viên này?')">Xóa</a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
