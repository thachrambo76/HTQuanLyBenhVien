<?php
require_once("../config/config.php");
// Kiểm tra nếu mã nhân viên được truyền vào
if (isset($_GET['maNhanVien'])) {
    $maNhanVien = $_GET['maNhanVien'];

    // Lấy dữ liệu ngày làm việc, tên nhân viên và ca làm việc
    $sql = "SELECT nhanVien.maNhanVien, nhanVien.tenNhanVien, lichLamViec.ngayLam, lichLamViec.caLamViec 
            FROM lichLamViec 
            INNER JOIN nhanVien ON lichLamViec.maNhanVien = nhanVien.maNhanVien 
            WHERE lichLamViec.maNhanVien = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $maNhanVien);
    $stmt->execute();
    $result = $stmt->get_result();

    // Lấy dữ liệu từ kết quả truy vấn
    $row = $result->fetch_assoc();

    if (!$row) {
        echo "Không tìm thấy nhân viên.";
        exit;
    }
} else {
    echo "Mã nhân viên không hợp lệ.";
    exit;
}

// Xử lý khi form được gửi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ngayLamMoi = $_POST['ngayLam'];
    $caLamMoi = $_POST['caLamViec'];

    // Cập nhật ngày làm và ca làm
    $sql = "UPDATE lichLamViec SET ngayLam = ?, caLamViec = ? WHERE maNhanVien = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $ngayLamMoi, $caLamMoi, $maNhanVien);

    if ($stmt->execute()) {
        // Hiển thị thông báo thành công
        $successMessage = "Cập nhật thông tin làm việc thành công!";
    } else {
        $errorMessage = "Cập nhật thất bại: " . $conn->error;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa ngày làm việc</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }
        .container {
            width: 80%;
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
        }
        .btn {
            padding: 10px 15px;
            margin-top: 10px;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn-primary {
            background-color: #007bff;
            color: white;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
        .message {
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Chỉnh sửa thông tin làm việc</h2>

        <?php if (isset($successMessage)): ?>
            <div class="message success"><?php echo $successMessage; ?></div>
        <?php elseif (isset($errorMessage)): ?>
            <div class="message error"><?php echo $errorMessage; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="maNhanVien">Mã Nhân Viên:</label>
                <input type="text" id="maNhanVien" name="maNhanVien" value="<?php echo $row['maNhanVien']; ?>" readonly class="form-control">
            </div>
            <div class="form-group">
                <label for="tenNhanVien">Tên Nhân Viên:</label>
                <input type="text" id="tenNhanVien" name="tenNhanVien" value="<?php echo $row['tenNhanVien']; ?>" readonly class="form-control">
            </div>
            <div class="form-group">
                <label for="ngayLam">Ngày Làm:</label>
                <input type="date" id="ngayLam" name="ngayLam" value="<?php echo $row['ngayLam']; ?>" required class="form-control">
            </div>
            <div class="form-group">
                <label for="caLamViec">Ca Làm:</label>
                <input type="text" id="caLamViec" name="caLamViec" value="<?php echo $row['caLamViec']; ?>" required class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Lưu</button>
            <a href="index.php?quanli=quan-ly-lich-lam-viec" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
</body>
</html>