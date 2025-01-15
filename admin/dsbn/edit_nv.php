<?php
require_once("../config/config.php");

// Check if ID is passed for editing
if (isset($_GET['id'])) {
    $maNhanVien = $_GET['id'];

    // Fetch employee details based on ID
    $sql = "SELECT * FROM nhanvien WHERE maNhanVien = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $maNhanVien);
    $stmt->execute();
    $result = $stmt->get_result();
    $nhanvien = $result->fetch_assoc();

    // Check if the employee data is found
    if (!$nhanvien) {
        echo "Nhân viên không tồn tại!";
        exit();
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Không có ID nhân viên nào được cung cấp.";
    exit();
}

// Handle form submission to update employee data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $maNhanVien = $_POST['maNhanVien'];
    $tenNhanVien = $_POST['tenNhanVien'];
    $email = $_POST['email'];
    $sdt = $_POST['sdt'];
    $vaiTro = $_POST['vaiTro'];

    // Update query to modify employee details
    $sql = "UPDATE nhanvien SET tenNhanVien = ?, email = ?, sdt = ?, vaiTro = ? WHERE maNhanVien = ?";

    // Prepare and bind the parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssii", $tenNhanVien, $email, $sdt, $vaiTro, $maNhanVien);

    // Execute the query and check if it was successful
    if ($stmt->execute()) {
        $successMessage = "Cập nhật thành công!";
    } else {
        $errorMessage = "Cập nhật thất bại: " . $conn->error;
    }

    // Close the statement
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh Sửa Nhân Viên</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Chỉnh Sửa Thông Tin Nhân Viên</h2>

    <?php if (isset($successMessage)): ?>
        <div class="alert alert-success"><?php echo $successMessage; ?></div>
    <?php elseif (isset($errorMessage)): ?>
        <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
    <?php endif; ?>

    <form action="" method="post">
        <input type="hidden" name="maNhanVien" value="<?php echo $nhanvien['maNhanVien']; ?>">
        <div class="form-group">
            <label>Tên Nhân Viên</label>
            <input type="text" name="tenNhanVien" class="form-control" value="<?php echo $nhanvien['tenNhanVien']; ?>" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo $nhanvien['email']; ?>" required>
        </div>
        <div class="form-group">
            <label>Số Điện Thoại</label>
            <input type="text" name="sdt" class="form-control" value="<?php echo $nhanvien['sdt']; ?>" required>
        </div>
        <div class="form-group">
            <label>Vai Trò</label>
            <input type="number" name="vaiTro" class="form-control" value="<?php echo $nhanvien['vaiTro']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Lưu</button>
        <a href="index.php?quanli=danh-sach-nhan-vien" class="btn btn-secondary">Hủy</a>
    </form>
</div>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
