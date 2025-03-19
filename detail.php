<?php
session_start();
include 'config.php';
if (!isset($_SESSION['MaSV'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM SinhVien WHERE MaSV='$id'");
$row = mysqli_fetch_assoc($result);

echo "Thông tin chi tiết sinh viên<br><br>";
echo "Mã SV: " . $row['MaSV'] . "<br>";
echo "Họ tên: " . $row['HoTen'] . "<br>";
echo "Giới tính: " . $row['GioiTinh'] . "<br>";
echo "Ngày sinh: " . $row['NgaySinh'] . "<br>";
echo "Hình: ";
if ($row['Hinh'] && file_exists($row['Hinh'])) {
    echo "<img src='" . $row['Hinh'] . "' width='150'>";
} else {
    echo "Không có hình";
}
echo "<br>";
echo "Mã ngành: " . $row['MaNganh'] . "<br>";
echo "<a href='index.php'>Quay lại</a>";
?>