<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center">📝 Đăng ký tài khoản</h2>
    <p class="text-center">Vui lòng điền đầy đủ thông tin bên dưới.</p>

    <?php
    include 'config.php';
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
                $check = mysqli_query($conn, "SELECT * FROM SinhVien WHERE MaSV='$maSV'");
                if (mysqli_num_rows($check) > 0) {
                    echo "<div class='alert alert-danger'>⚠️ Mã sinh viên đã tồn tại!</div>";
                } else {
                    $sql = "INSERT INTO SinhVien(MaSV, HoTen, GioiTinh, NgaySinh, Hinh, MaNganh) 
                            VALUES('$maSV', '$hoTen', '$gioiTinh', '$ngaySinh', '$hinh', '$maNganh')";
                    if (mysqli_query($conn, $sql)) {
                        echo "<div class='alert alert-success'>✅ Đăng ký thành công! <a href='login.php'>Đăng nhập ngay</a></div>";
                    } else {
                        echo "<div class='alert alert-danger'>❌ Lỗi: " . mysqli_error($conn) . "</div>";
                    }
                }
            } else {
                echo "<div class='alert alert-warning'>⚠️ Lỗi khi tải ảnh lên! Kiểm tra thư mục <b>Content/images/</b></div>";
            }
        } else {
            echo "<div class='alert alert-warning'>⚠️ Lỗi upload file: " . $_FILES['Hinh']['error'] . "</div>";
        }
    }
    ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">📌 Mã SV:</label>
            <input type="text" name="MaSV" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">👤 Họ tên:</label>
            <input type="text" name="HoTen" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">⚤ Giới tính:</label>
            <select name="GioiTinh" class="form-control" required>
                <option value="Nam">Nam</option>
                <option value="Nữ">Nữ</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">📅 Ngày sinh:</label>
            <input type="date" name="NgaySinh" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">🖼 Hình ảnh:</label>
            <input type="file" name="Hinh" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">🏫 Mã ngành:</label>
            <input type="text" name="MaNganh" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">📥 Đăng ký</button>
    </form>

    <div class="text-center mt-3">
        <a href="login.php" class="btn btn-link">🔑 Đăng nhập ngay</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
