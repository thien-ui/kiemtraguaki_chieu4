<?php
session_start();
include 'config.php';

if (!isset($_SESSION['MaSV'])) {
    header("Location: login.php");
    exit();
}

// Kiểm tra quyền admin
if ($_SESSION['MaSV'] !== '999999999') {
    header("Location: index.php");
    exit();
}

$error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $maSV = $_POST['MaSV'];
    $hoTen = $_POST['HoTen'];
    $gioiTinh = $_POST['GioiTinh'];
    $ngaySinh = $_POST['NgaySinh'];
    $maNganh = $_POST['MaNganh'];

    $hinh = '';
    if ($_FILES['Hinh']['error'] === UPLOAD_ERR_OK) {
        $targetDir = './Content/images/';
        $hinh = $targetDir . basename($_FILES['Hinh']['name']);
        if (move_uploaded_file($_FILES['Hinh']['tmp_name'], $hinh)) {
            $sql = "INSERT INTO SinhVien(MaSV, HoTen, GioiTinh, NgaySinh, Hinh, MaNganh) 
                    VALUES('$maSV', '$hoTen', '$gioiTinh', '$ngaySinh', '$hinh', '$maNganh')";
            if (mysqli_query($conn, $sql)) {
                header("Location: index.php");
                exit();
            } else {
                $error = "❌ Lỗi: " . mysqli_error($conn);
            }
        } else {
            $error = "❌ Lỗi khi di chuyển file ảnh!";
        }
    } else {
        $error = "❌ Lỗi upload file: " . $_FILES['Hinh']['error'];
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Sinh Viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .form-container {
            width: 500px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .preview-img {
            max-width: 100px;
            max-height: 100px;
            display: none;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2 class="text-center">📌 Thêm Sinh Viên</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger text-center"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">🔢 Mã Sinh Viên</label>
            <input type="text" name="MaSV" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">📛 Họ Tên</label>
            <input type="text" name="HoTen" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">🚻 Giới Tính</label>
            <select name="GioiTinh" class="form-select" required>
                <option value="Nam">Nam</option>
                <option value="Nữ">Nữ</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">📅 Ngày Sinh</label>
            <input type="date" name="NgaySinh" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">🖼️ Hình Ảnh</label>
            <input type="file" name="Hinh" class="form-control" accept="image/*" onchange="previewImage(event)">
            <img id="preview" class="preview-img">
        </div>
        <div class="mb-3">
            <label class="form-label">🏫 Mã Ngành</label>
            <input type="text" name="MaNganh" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success w-100">✅ Thêm Sinh Viên</button>
    </form>

    <div class="mt-3 text-center">
        <a href="index.php" class="btn btn-link">🔙 Quay lại</a>
    </div>
</div>

<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('preview');
            output.src = reader.result;
            output.style.display = 'block';
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
