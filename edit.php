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
$result = mysqli_query($conn, "SELECT * FROM SinhVien WHERE MaSV='$id'");
$row = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hoTen = $_POST['HoTen'];
    $gioiTinh = $_POST['GioiTinh'];
    $ngaySinh = $_POST['NgaySinh'];
    $maNganh = $_POST['MaNganh'];
    $hinh = $row['Hinh'];

    if ($_FILES['Hinh']['name']) {
        $targetDir = './Content/images/';
        $hinh = $targetDir . basename($_FILES['Hinh']['name']);
        if ($_FILES['Hinh']['error'] === UPLOAD_ERR_OK) {
            if (move_uploaded_file($_FILES['Hinh']['tmp_name'], $hinh)) {
                $sql = "UPDATE SinhVien SET HoTen='$hoTen', GioiTinh='$gioiTinh', NgaySinh='$ngaySinh', Hinh='$hinh', MaNganh='$maNganh' WHERE MaSV='$id'";
                if (mysqli_query($conn, $sql)) {
                    header("Location: index.php");
                } else {
                    echo "Lỗi: " . mysqli_error($conn);
                }
            } else {
                echo "Lỗi khi di chuyển file ảnh!";
            }
        } else {
            echo "Lỗi upload file: " . $_FILES['Hinh']['error'];
        }
    } else {
        $sql = "UPDATE SinhVien SET HoTen='$hoTen', GioiTinh='$gioiTinh', NgaySinh='$ngaySinh', MaNganh='$maNganh' WHERE MaSV='$id'";
        if (mysqli_query($conn, $sql)) {
            header("Location: index.php");
        } else {
            echo "Lỗi: " . mysqli_error($conn);
        }
    }
}

echo "Sửa thông tin sinh viên<br><br>";
echo "<form method='POST' enctype='multipart/form-data'>";
echo "Mã SV: " . $row['MaSV'] . " (không thể sửa)<br>";
echo "Họ tên: <input type='text' name='HoTen' value='" . $row['HoTen'] . "' required><br>";
echo "Giới tính: <input type='text' name='GioiTinh' value='" . $row['GioiTinh'] . "' required><br>";
echo "Ngày sinh: <input type='date' name='NgaySinh' value='" . $row['NgaySinh'] . "' required><br>";
echo "Hình: <input type='file' name='Hinh'><br>";
if ($row['Hinh'] && file_exists($row['Hinh'])) {
    echo "Hình hiện tại: <img src='" . $row['Hinh'] . "' width='100'><br>";
}
echo "Mã ngành: <input type='text' name='MaNganh' value='" . $row['MaNganh'] . "' required><br>";
echo "<input type='submit' value='Lưu'> ";
echo "<a href='index.php'>Quay lại</a>";
echo "</form>";
?>