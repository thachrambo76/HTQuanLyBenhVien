<?php
// Kết nối cơ sở dữ liệu
require_once("../config/config.php");
$maLichHen = isset($_GET['maLichHen']) ? $_GET['maLichHen'] : null;
$lichHen = null;

// Lấy thông tin lịch hẹn theo mã
if ($maLichHen) {
    $sql = "SELECT lhk.maLichHen, lhk.maBenhNhan, bn.tenBenhNhan, lhk.ngayKham
            FROM lichhenkham lhk
            JOIN benhnhan bn ON lhk.maBenhNhan = bn.maBenhNhan
            WHERE lhk.maLichHen = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $maLichHen);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $lichHen = $result->fetch_assoc();
    } else {
        die("Không tìm thấy lịch hẹn.");
    }
}

if(isset($_POST['update'])){
    $maBenhNhan = $_POST['maBenhNhan'];
    $maLichHen = $_POST['maLichHen'];
    $dichVuKham = $_POST['dichVuKham'];

    $sql_dichvu = "INSERT INTO dichvu_benhnhan(maBenhNhan,maLichHen,maDichVu) 
    VALUES ('$maBenhNhan', '$maLichHen', '$dichVuKham');";

    $ketqua = mysqli_query($conn,$sql_dichvu);
}

// Xử lý cập nhật ngày khám
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $ngayKham = $_POST['ngayKham'];

    $sql = "UPDATE lichhenkham SET ngayKham = ? WHERE maLichHen = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $ngayKham, $maLichHen);

    if ($stmt->execute()) {
        echo "<p style='color: green;'>Cập nhật thành công!</p>";
    } else {
        echo "<p style='color: red;'>Cập nhật thất bại!</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa ngày khám</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Chỉnh sửa ngày khám</h1>

        <?php if ($lichHen): ?>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Mã lịch hẹn</label>
                    <input type="text" class="form-control" name="maLichHen" value="<?php echo htmlspecialchars($lichHen['maLichHen']); ?>" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mã bệnh nhân</label>
                    <input type="text" class="form-control" name="maBenhNhan" value="<?php echo htmlspecialchars($lichHen['maBenhNhan']); ?>" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tên bệnh nhân</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($lichHen['tenBenhNhan']); ?>" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Ngày khám</label>
                    <input type="date" name="ngayKham" class="form-control" value="<?php echo htmlspecialchars($lichHen['ngayKham']); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Dịch vụ khám</label>
                    <select name="dichVuKham" id="dichVuKham">
                    <option>Chọn dịch vụ khám</option>
                    <?php 
                        $sql_str = "select*from dichvu";
                        $res = mysqli_query($conn,$sql_str);
                        while($row = mysqli_fetch_assoc($res)){

                        ?> 
                            <option value="<?=$row['maDichVu']?>"><?=$row['tenDichVu']?></option>
                            <?php }?>
                        </select>
                </div>
                <button type="submit" name="update" class="btn btn-success">Cập nhật</button>
                <a href="?quanli=quan-ly-lich-kham" class="btn btn-secondary">Quay lại</a>
            </form>
        <?php else: ?>
            <p class="text-danger">Không tìm thấy lịch hẹn!</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
