<?php
require_once("../config/config.php");

// Khởi tạo biến $result
$result = null;
$error_message = "";

// Kiểm tra nếu form được submit qua POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ form
    $insurance_id = isset($_POST['insurance_id']) ? $_POST['insurance_id'] : '';
    $patient_id = isset($_POST['patient_id']) ? $_POST['patient_id'] : '';
    $patient_name = isset($_POST['patient_name']) ? $_POST['patient_name'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';

    // Kiểm tra nếu không có dữ liệu nhập
    if (empty($insurance_id) && empty($patient_id) && empty($patient_name) && empty($phone)) {
        $error_message = "Vui lòng nhập ít nhất một thông tin để tìm kiếm.";
    } else {
        // Xây dựng câu truy vấn SQL
        $sql = "SELECT * FROM benhnhan WHERE 1=1";
        if (!empty($insurance_id)) {
            $sql .= " AND maBHYT LIKE '%" . $conn->real_escape_string($insurance_id) . "%'";
        }
        if (!empty($patient_id)) {
            $sql .= " AND maBenhNhan LIKE '%" . $conn->real_escape_string($patient_id) . "%'";
        }
        if (!empty($patient_name)) {
            $sql .= " AND tenBenhNhan LIKE '%" . $conn->real_escape_string($patient_name) . "%'";
        }
        if (!empty($phone)) {
            $sql .= " AND sdt LIKE '%" . $conn->real_escape_string($phone) . "%'";
        }

        // Thực hiện truy vấn và gán kết quả vào `$result`
        $result = $conn->query($sql);

        // Kiểm tra nếu truy vấn không thành công
        if (!$result) {
            die('Lỗi truy vấn: ' . $conn->error);
        }

        // Kiểm tra nếu không tìm thấy kết quả
        if ($result->num_rows == 0) {
            $error_message = "Không tìm thấy bệnh nhân nào phù hợp với tiêu chí tìm kiếm.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết quả tra cứu bệnh nhân</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<form method="POST">
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0">Tra Cứu Bệnh Nhân</h2>
            </div>
            <div class="card-body">
                <div class="form-group custom-spacing">
                    <label for="insuranceId">Mã Bảo Hiểm Y Tế:</label>
                    <input type="text" class="form-control" id="insuranceId" name="insurance_id" placeholder="Nhập mã bảo hiểm y tế">
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
                    <label for="phone">Số Điện Thoại:</label>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Nhập số điện thoại">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Tra cứu</button>
            </div>
        </div>
    </div>
</form>

<!-- Modal to display search results -->
<div class="modal fade" id="resultModal" tabindex="-1" role="dialog" aria-labelledby="resultModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resultModalLabel">Kết quả tra cứu bệnh nhân</h5>
                <button type="button" class="close" id="closeModalButton" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php if ($error_message): ?>
                    <div class="alert alert-warning"><?php echo $error_message; ?></div>
                <?php elseif ($result && $result->num_rows > 0): ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Mã Bệnh Nhân</th>
                                <th>Tên Bệnh Nhân</th>
                                <th>Ngày Sinh</th>
                                <th>Địa Chỉ</th>
                                <th>Số Điện Thoại</th>
                                <th>Mã BHYT</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $row['maBenhNhan'] ?></td>
                                    <td><?= $row['tenBenhNhan'] ?></td>
                                    <td><?= $row['namSinh'] ?></td>
                                    <td><?= $row['diaChi'] ?></td>
                                    <td><?= $row['sdt'] ?></td>
                                    <td><?= $row['maBHYT'] ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<script>
<?php if ($error_message || ($result && $result->num_rows > 0)): ?>
    $(document).ready(function() {
        $('#resultModal').modal('show');
    });
<?php endif; ?>

$(document).ready(function() {
    $('#closeModalButton').click(function() {
        $('#resultModal').modal('hide');
    });
});
</script>

</body>
</html>
