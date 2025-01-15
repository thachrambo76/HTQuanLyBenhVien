<?php
// Kết nối cơ sở dữ liệu
require_once("../config/config.php");

// Lấy mã lịch hẹn từ URL
$maLichHen = isset($_GET['maLichHen']) ? $_GET['maLichHen'] : null;
$lichHen = null;

if ($maLichHen) {
    // Truy vấn lấy thông tin chi tiết lịch hẹn bao gồm mô tả sức khỏe
    $sql = "SELECT lhk.maLichHen, lhk.maBenhNhan, bn.tenBenhNhan, lhk.ngayKham, lhk.moTa            FROM lichhenkham lhk
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
} else {
    die("Không có mã lịch hẹn được truyền vào.");
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết lịch hẹn</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Chi tiết lịch hẹn</h1>

        <?php if ($lichHen): ?>
            <table class="table table-bordered">
                <tr>
                    <th>Mã lịch hẹn</th>
                    <td><?php echo htmlspecialchars($lichHen['maLichHen']); ?></td>
                </tr>
                <tr>
                    <th>Mã bệnh nhân</th>
                    <td><?php echo htmlspecialchars($lichHen['maBenhNhan']); ?></td>
                </tr>
                <tr>
                    <th>Tên bệnh nhân</th>
                    <td><?php echo htmlspecialchars($lichHen['tenBenhNhan']); ?></td>
                </tr>
                <tr>
                    <th>Ngày khám</th>
                    <td><?php echo htmlspecialchars($lichHen['ngayKham']); ?></td>
                </tr>
                <tr>
                    <th>Mô tả sức khỏe</th>
                    <td><?php echo htmlspecialchars($lichHen['moTa']); ?></td>
                </tr>
            </table>
            <a href="?quanli=quan-ly-lich-kham" class="btn btn-secondary">Quay lại</a>
        <?php else: ?>
            <p class="text-danger">Không tìm thấy lịch hẹn!</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
