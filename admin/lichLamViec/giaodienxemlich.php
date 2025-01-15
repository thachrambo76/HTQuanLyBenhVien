<?php
require_once("../config/config.php");

// Lấy ID bác sĩ từ URL
$maBacSi = isset($_GET['id']) ? $_GET['id'] : '';

// Truy vấn thông tin bác sĩ
$sql = "SELECT bacsi.maBacSi, bacsi.tenBacSi, bacsi.sdt, bacsi.email, bacsi.maKhoa, lichlamviec.ngayLam, lichlamviec.phongKham, lichlamviec.caLamViec
        FROM bacsi
        LEFT JOIN lichLamViec lichlamviec ON bacsi.maBacSi = lichlamviec.maBacSi
        WHERE bacsi.maBacSi = ?";


$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $maBacSi); // Bind tham số
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
  $doctor = $result->fetch_assoc();
} else {
  die("Bác sĩ không tồn tại.");
}
?>

<style>
  /* Định dạng chung */
  body {
    font-family: sans-serif;
    margin: 0;
    padding: 0;
  }

  /* Thanh tiêu đề */
  .container {
    width: 80%;
    max-width: 1000px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid black;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    background-color: #f9f9f9;
  }

  h1 {
    text-align: center;
    margin-bottom: 20px;
  }

  /* Tìm kiếm, chuyên khoa, chọn ngày */
  .row {
    margin-bottom: 20px;
  }

  .form-control,
  .form-select {
    height: 40px;
  }

  /* Bảng lịch làm việc */
  .table {
    text-align: center;
  }

  th,
  td {
    padding: 10px;
  }

  /* Các nút chức năng */
  .text-center button {
    margin-left: 5px;
  }

  .table-header {
    background-color: #007bff;
    color: white;
  }

  .title {
    color: #007bff;
  }
</style>

<body>
  <div class="container mt-5">
    <div class="card">
      <div class="card-body">
        <h1 class="title">Thông tin lịch làm việc</h1>
        <h5 class="card-title" style="color: blue;">Thông tin bác sĩ</h5>
        <p class="card-text">Họ và Tên: <?php echo $doctor['tenBacSi']; ?></p>
        <p class="card-text">Mã bác sĩ: <?php echo $doctor['maBacSi']; ?></p>
        <p class="card-text">Ngày sinh: <?php echo $doctor['sdt']; ?></p>
        <p class="card-text">SĐT: <?php echo $doctor['sdt']; ?></p>
        <p class="card-text">Chuyên khoa: <?php echo $doctor['maKhoa']; ?></p>
      </div>
    </div>
    <div class="card mt-3">
      <div class="card-body">
        <h5 class="card-title" style="color: blue;">Lịch làm việc</h5>
        <table class="table">
          <thead class="table-header">
            <tr>
              <th>Phòng khám</th>
              <th>Ngày làm việc</th>
              <th>Ca làm việc</th>
              <th>Phòng khám</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // Rewind the result to display all work schedules for the doctor
            $stmt->execute();  // Execute again to fetch all schedules
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . $row['phongKham'] . "</td>";
              echo "<td>" . $row['ngayLam'] . "</td>";
              echo "<td>" . $row['caLamViec'] . "</td>";
              echo "<td>" . $row['phongKham'] . "</td>";
              echo "</tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
    <div class="button">
      <a href="index.php?quanli=xem-lich-lam-viec" class="btn btn-secondary">Quay Lại</a>
      <button class="btn btn-primary btn-sm">In thông tin</button>
    </div>
  </div>
</body>