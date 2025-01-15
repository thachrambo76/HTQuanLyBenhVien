<?php
include("clsbenhvien.php");
$p = new quantri();

if (isset($_POST['maBenhNhan'])) {
    $maBenhNhan = $_POST['maBenhNhan'];

    // Truy vấn kiểm tra mã bệnh nhân
    $query = "SELECT * FROM benhnhan WHERE maBenhNhan = '$maBenhNhan'";
    $result = $p->fetchAll($query);

    if (count($result) > 0) {
        // Nếu mã bệnh nhân tồn tại
        $benhNhan = $result[0]; // Lấy thông tin bệnh nhân
        echo json_encode([
            'status' => 'success',
            'data' => $benhNhan
        ]);
    } else {
        // Nếu không tìm thấy mã bệnh nhân
        echo json_encode(['status' => 'error']);
    }
}
?>
