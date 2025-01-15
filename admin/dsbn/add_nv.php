<?php
require_once("../config/config.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $maNhanVien = $_POST['maNhanVien'];
    $tenNhanVien = $_POST['tenNhanVien'];
    $email = $_POST['email'];
    $sdt = $_POST['sdt'];
    $vaiTro = $_POST['vaiTro'];

    $sql = "INSERT INTO nhanvien (maNhanVien, tenNhanVien, email, sdt, vaiTro) 
            VALUES ('$maNhanVien', '$tenNhanVien', '$email', '$sdt', '$vaiTro')";

    if ($conn->query($sql) === TRUE) {
        echo "thêm nhân thành công";
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Thêm Nhân Viên</h2>
    <form action="index.php?quanli=add-nv" method="POST">
        <div class="form-group">
            <label for="maNhanVien">Mã Nhân Viên</label>
            <input type="text" class="form-control" id="maNhanVien" name="maNhanVien" placeholder="Nhập mã nhân viên" required>
        </div>
        <div class="form-group">
            <label for="tenNhanVien">Tên Nhân Viên</label>
            <input type="text" class="form-control" id="tenNhanVien" name="tenNhanVien" placeholder="Nhập tên nhân viên" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email" required>
        </div>
        <div class="form-group">
            <label for="sdt">Số Điện Thoại</label>
            <input type="text" class="form-control" id="sdt" name="sdt" placeholder="Nhập số điện thoại" required>
        </div>
        <div class="form-group">
            <label for="vaiTro">Chức Vụ</label>
            <input type="text" class="form-control" id="vaiTro" name="vaiTro" placeholder="Nhập chức vụ" required>
        </div>
        <button type="submit" class="btn btn-primary">Thêm Nhân Viên</button>
        <a href="index.php" class="btn btn-secondary">Quay lại</a>
    </form>
</div>

</body>
</html>