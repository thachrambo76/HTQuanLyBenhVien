<?php
require_once("../config/config.php");

// Khởi tạo biến kết quả
$result = "";

// Kiểm tra nếu form đã được submit
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Lấy các tham số từ form (dữ liệu gửi từ AJAX)
    $insurance_id = isset($_GET['insurance_id']) ? $_GET['insurance_id'] : '';
    $patient_id = isset($_GET['patient_id']) ? $_GET['patient_id'] : '';
    $patient_name = isset($_GET['patient_name']) ? $_GET['patient_name'] : '';
    $age = isset($_GET['age']) ? $_GET['age'] : '';

    // Tạo câu truy vấn SQL
    $sql = "SELECT benhnhan.tenBenhNhan, phieukham.maPhieuKham, donthuoc.maDonThuoc 
            FROM phieukham
            INNER JOIN benhnhan ON phieukham.maBenhNhan = benhnhan.maBenhNhan
            INNER JOIN donthuoc ON phieukham.maDonThuoc = donthuoc.maDonThuoc
            WHERE 1=1";

    // Thêm điều kiện vào câu truy vấn dựa trên input của người dùng
    if (!empty($insurance_id)) {
        $sql .= " AND donthuoc.maDonThuoc LIKE ?";
    }
    if (!empty($patient_id)) {
        $sql .= " AND benhnhan.maBenhNhan LIKE ?";
    }
    if (!empty($patient_name)) {
        $sql .= " AND benhnhan.tenBenhNhan LIKE ?";
    }
    if (!empty($age)) {
        $sql .= " AND phieukham.maPhieuKham LIKE ?";
    }

    // Chuẩn bị câu truy vấn
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $params = [];
    if (!empty($insurance_id)) {
        $params[] = "%$insurance_id%";
    }
    if (!empty($patient_id)) {
        $params[] = "%$patient_id%";
    }
    if (!empty($patient_name)) {
        $params[] = "%$patient_name%";
    }
    if (!empty($age)) {
        $params[] = "%$age%";
    }

    // Dynamically bind the parameters
    if ($params) {
        $stmt->bind_param(str_repeat('s', count($params)), ...$params);
    }

    // Thực thi câu truy vấn
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tra cứu đơn thuốc</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0">Tra cứu đơn thuốc</h2>
            </div>

            <div class="card-body">
                <!-- Form để tra cứu đơn thuốc -->
                <form id="searchForm">
                    <div class="form-group custom-spacing">
                        <label for="insuranceId">Mã đơn thuốc:</label>
                        <input type="text" class="form-control" id="insuranceId" name="insurance_id" placeholder="Nhập mã đơn thuốc">
                    </div>

                    <div class="form-group custom-spacing">
                        <label for="patientId">Mã Bệnh Nhân:</label>
                        <input type="text" class="form-control" id="patientId" name="patient_id" placeholder="Nhập mã bệnh nhân">
                    </div>

                    <div class="form-group custom-spacing">
                        <label for="patientName">Tên Bệnh Nhân:</label>
                        <input type="text" class="form-control" id="patientName" name="patient_name" placeholder="Nhập tên bệnh nhân">
                    </div>

                    <div class="form-group custom-spacing">
                        <label for="age">Mã phiếu khám:</label>
                        <input type="text" class="form-control" id="age" name="age" placeholder="Nhập mã phiếu khám">
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Tra cứu</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Popup Modal để hiển thị kết quả -->
    <div class="modal" tabindex="-1" id="resultModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Kết quả tìm kiếm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="resultContent">
                    <?php if ($result && $result->num_rows > 0): ?>
                        <table class='table'>
                            <thead>
                                <tr>
                                    <th>Tên Bệnh Nhân</th>
                                    <th>Mã Phiếu Khám</th>
                                    <th>Mã Đơn Thuốc</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $row['tenBenhNhan']; ?></td>
                                        <td><?php echo $row['maPhieuKham']; ?></td>
                                        <td><?php echo $row['maDonThuoc']; ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>Không có kết quả tìm kiếm nào.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Xử lý form submit với AJAX
        $("#searchForm").submit(function(event) {
            event.preventDefault(); // Ngừng form submit mặc định

            // Lấy dữ liệu từ form
            var formData = $(this).serialize();

            // Gửi dữ liệu tìm kiếm tới chính file PHP qua AJAX
            $.ajax({
                url: '', // Tạo request tới chính file này
                type: 'GET',
                data: formData,
                success: function(response) {
                    // Chỉ cần cập nhật lại nội dung của modal với dữ liệu trả về
                    $("#resultContent").html($(response).find("#resultContent").html());
                    $("#resultModal").modal('show'); // Mở modal khi có kết quả
                },
                error: function() {
                    alert("Có lỗi xảy ra, vui lòng thử lại!");
                }
            });
        });
    </script>
</body>

</html>