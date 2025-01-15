<?php
require_once("../config/config.php");

// Lấy mã đơn thuốc từ URL
if (isset($_GET['id'])) {
    $maDonThuoc = $_GET['id'];

    // Truy vấn lấy thông tin đơn thuốc và tên bệnh nhân
    $sql = "SELECT 
                phieukham.*, 
                benhnhan.tenBenhNhan 
            FROM phieukham 
            INNER JOIN benhnhan ON phieukham.maBenhNhan = benhnhan.maBenhNhan 
            WHERE phieukham.maDonThuoc = '$maDonThuoc'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $donThuoc = $result->fetch_assoc();
    } else {
        die("Không tìm thấy đơn thuốc.");
    }
}

// Xử lý cập nhật thông tin đơn thuốc
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $maDonThuoc = $_POST['maDonThuoc'];  // Lấy mã đơn thuốc từ POST
    $keHoachDieuTri = $_POST['keHoachDieuTri'];
    $ghiChu = $_POST['ghiChu'];

    // Cập nhật thông tin đơn thuốc
    $sql = "UPDATE phieukham SET 
                keHoachDieuTri = '$keHoachDieuTri',
                ghiChu = '$ghiChu'
            WHERE maDonThuoc = '$maDonThuoc'";

    if ($conn->query($sql) === TRUE) {
        // Hiển thị thông báo cập nhật thành công
        echo "<div class='alert alert-success' role='alert'>Cập nhật thành công!</div>";
        echo "<a href='index.php?quanli=don-thuoc' class='btn btn-primary'>Quay lại danh sách đơn thuốc</a>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>Lỗi: " . $conn->error . "</div>";
    }
}

$conn->close();
?>

<div class="container mt-5">
    <h2 class="text-center">Chỉnh Sửa Đơn Thuốc</h2>
    <form action="index.php?quanli=edit-dt&id=<?php echo $donThuoc['maDonThuoc']; ?>" method="POST">
        <!-- Input ẩn cho maDonThuoc -->
        <input type="hidden" name="maDonThuoc" value="<?php echo $donThuoc['maDonThuoc']; ?>">

        <div class="form-group">
            <label for="tenBenhNhan">Tên Bệnh Nhân</label>
            <input type="text" class="form-control" id="tenBenhNhan" name="tenBenhNhan" value="<?php echo $donThuoc['tenBenhNhan']; ?>" readonly>
        </div>

        <div class="form-group">
            <label for="keHoachDieuTri">Kế Hoạch Điều Trị</label>
            <input type="text" class="form-control" id="keHoachDieuTri" name="keHoachDieuTri" value="<?php echo $donThuoc['keHoachDieuTri']; ?>" required>
        </div>

        <div class="form-group">
            <label for="ghiChu">Ghi Chú</label>
            <textarea class="form-control" id="ghiChu" name="ghiChu" rows="3" required><?php echo $donThuoc['ghiChu']; ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Cập Nhật</button>
        <a href="index.php" class="btn btn-secondary">Hủy</a>
    </form>
</div>
