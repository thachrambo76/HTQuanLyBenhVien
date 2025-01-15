<?php
require_once("../config/config.php");

// Get the ID from the URL query parameter
$id = isset($_GET['id']) ? $_GET['id'] : 0;

// Fetch employee data from the database
$sql = "SELECT maNhanVien, tenNhanVien, vaiTro, email FROM nhanvien WHERE maNhanVien = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $employee = $result->fetch_assoc();
} else {
    echo "<p>Không tìm thấy thông tin nhân viên.</p>";
    exit();
}
?>

<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4>Chi Tiết Nhân Viên</h4>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-sm-3 font-weight-bold">ID:</div>
                <div class="col-sm-9"><?php echo htmlspecialchars($employee['maNhanVien']); ?></div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-3 font-weight-bold">Tên:</div>
                <div class="col-sm-9"><?php echo htmlspecialchars($employee['tenNhanVien']); ?></div>
            </div>
            <!-- <div class="row mb-3">
                <div class="col-sm-3 font-weight-bold">Ngày Sinh:</div>
                <div class="col-sm-9"><?php echo htmlspecialchars($employee['ngaySinh']); ?></div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-3 font-weight-bold">Nơi Ở:</div>
                <div class="col-sm-9"><?php echo htmlspecialchars($employee['noiO']); ?></div>
            </div> -->
            <div class="row mb-3">
                <div class="col-sm-3 font-weight-bold">Chức Vụ:</div>
                <div class="col-sm-9"><?php echo htmlspecialchars($employee['vaiTro']); ?></div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-3 font-weight-bold">Email:</div>
                <div class="col-sm-9"><?php echo htmlspecialchars($employee['email']); ?></div>
            </div>
        </div>
        <div class="card-footer text-right">
        <a href="index.php?quanli=danh-sach-nhan-vien" class="btn btn-secondary">Quay lại</a>
        </div>
    </div>
</div>

<?php
$conn->close();
?>
