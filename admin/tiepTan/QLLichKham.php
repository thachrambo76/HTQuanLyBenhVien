<?php
// Kết nối cơ sở dữ liệu
require_once("../config/config.php");
// Tìm kiếm lịch hẹn
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $search = trim($_POST['search']); // Lấy dữ liệu tìm kiếm từ form

    if (!empty($search)) {
        // Truy vấn lọc lịch hẹn theo mã bệnh nhân
        $sql = "SELECT lhk.maLichHen, lhk.maBenhNhan, bn.tenBenhNhan, lhk.ngayKham
                FROM lichhenkham lhk
                JOIN benhnhan bn ON lhk.maBenhNhan = bn.maBenhNhan
                WHERE lhk.maBenhNhan LIKE ?";
        $stmt = $conn->prepare($sql);
        $searchParam = "%$search%";
        $stmt->bind_param("s", $searchParam);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        echo "<p style='color: red;'>Vui lòng nhập mã bệnh nhân!</p>";
    }
} else {
    // Truy vấn mặc định
    $sql = "SELECT lhk.maLichHen, lhk.maBenhNhan, bn.tenBenhNhan, lhk.ngayKham
            FROM lichhenkham lhk
            JOIN benhnhan bn ON lhk.maBenhNhan = bn.maBenhNhan";
    $result = $conn->query($sql);
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách lịch hẹn khám</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Danh sách lịch hẹn khám</h1>

        <!-- Form tìm kiếm -->
        <form method="POST" class="row mb-4">
            <div class="col-md-8">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Nhập mã bệnh nhân" value="<?php echo isset($_POST['search']) ? htmlspecialchars($_POST['search']) : ''; ?>">
                    <button type="submit" class="btn btn-primary">Tìm</button>
                </div>
            </div>
        </form>

        <!-- Hiển thị danh sách -->
        <table class="table table-bordered">
            <thead class="table" style="background-color: skyblue; ">
                <tr>
                    <th>Mã lịch hẹn</th>
                    <th>Mã bệnh nhân</th>
                    <th>Tên bệnh nhân</th>
                    <th>Ngày khám</th>
                    <th>Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['maLichHen']); ?></td>
                            <td><?php echo htmlspecialchars($row['maBenhNhan']); ?></td>
                            <td><?php echo htmlspecialchars($row['tenBenhNhan']); ?></td>
                            <td><?php echo htmlspecialchars($row['ngayKham']); ?></td>
                            <td>

                                <a href="index.php?quanli=edit-tt&maLichHen=<?php echo $row['maLichHen']; ?>" class="btn btn-warning btn-sm">Chỉnh sửa</a>
                                <a href="index.php?quanli=ct-tt&maLichHen=<?php echo $row['maLichHen']; ?>"  class="btn btn-info btn-sm">Xem chi tiết</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center text-danger">Không có dữ liệu!</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>