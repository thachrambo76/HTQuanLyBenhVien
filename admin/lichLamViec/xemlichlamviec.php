<?php
require_once("../config/config.php");

$search = isset($_POST['search']) ? trim($_POST['search']) : '';
$khoa = isset($_POST['khoa']) ? $_POST['khoa'] : '';
$ngayLam = isset($_POST['ngayLam']) ? $_POST['ngayLam'] : '';

// Bắt đầu câu truy vấn cơ bản
$sql = "SELECT 
                bacsi.maBacSi, 
                bacsi.tenBacSi, 
                bacsi.maKhoa, 
                lichlamviec.ngayLam
        FROM 
                bacsi bacsi
        JOIN 
                lichLamViec lichlamviec
        ON 
                bacsi.maBacSi = lichlamviec.maBacSi";

// Tạo mảng để lưu các điều kiện
$conditions = [];

// Thêm điều kiện lọc vào mảng nếu có giá trị
if (!empty($search)) {
  $conditions[] = "bacsi.maBacSi LIKE ?";
}

if (!empty($khoa)) {
  $conditions[] = "bacsi.maKhoa = ?";
}

if (!empty($ngayLam)) {
  $conditions[] = "lichlamviec.ngayLam = ?";
}

// Nếu có điều kiện lọc, thêm chúng vào câu truy vấn SQL
if (count($conditions) > 0) {
  $sql .= " WHERE " . implode(" AND ", $conditions);
}

$stmt = $conn->prepare($sql);

// Gán tham số vào câu truy vấn
$params = [];
if (!empty($search)) {
  $params[] = "%$search%"; // Tìm kiếm theo mã bác sĩ (sử dụng LIKE)
}
if (!empty($khoa)) {
  $params[] = $khoa; // Lọc theo mã khoa
}
if (!empty($ngayLam)) {
  $params[] = $ngayLam; // Lọc theo ngày làm việc
}

// Bind tham số vào câu truy vấn SQL
if (count($params) > 0) {
  $types = str_repeat('s', count($params)); // Tất cả tham số là kiểu string
  $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

?>

<style>
  .card {
    border: none;
  }

  .table td,
  .table th {
    border: 1px solid #ddd;
    text-align: center;
  }

  .container {
    width: 80%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    background-color: #f9f9f9;
  }

  h1 {
    text-align: center;
  }

  .button {
    text-align: right;
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
  <div class="container">
    <h1 class="title">Xem lịch làm việc</h1>
    <form method="POST">
      <div class="row mb-3">
        <div class="col-md-3">
          <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Tìm kiếm bác sĩ" value="<?php echo isset($_POST['search']) ? $_POST['search'] : ''; ?>">
            <button class="btn btn-primary" type="submit">Tìm</button>
          </div>
        </div>
        <div class="col-md-3">
          <select class="form-select" name="khoa">
            <option value="">Tất cả</option>
            <option value="Nội khoa" <?php echo (isset($_POST['khoa']) && $_POST['khoa'] == 'Nội khoa') ? 'selected' : ''; ?>>Nội khoa</option>
            <option value="Ngoại khoa" <?php echo (isset($_POST['khoa']) && $_POST['khoa'] == 'Ngoại khoa') ? 'selected' : ''; ?>>Ngoại khoa</option>
          </select>
        </div>
        <div class="col-md-3">
          <input type="date" class="form-control" name="ngayLam" value="<?php echo isset($_POST['ngayLam']) ? $_POST['ngayLam'] : ''; ?>">
        </div>
      </div>
    </form>

    <table class="table mt-3">
      <thead class="table-header">
        <tr>
          <th>STT</th>
          <th>Tên bác sĩ</th>
          <th>Chuyên khoa</th>
          <th>Ngày làm việc</th>
          <th>Trạng thái</th>
        </tr>
      </thead>
      <tbody id="resultTable">
        <?php
        if ($result && $result->num_rows > 0) {
          $stt = 1;
          while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $stt++ . "</td>";
            echo "<td>" . $row['tenBacSi'] . "</td>";
            echo "<td>" . $row['maKhoa'] . "</td>";
            echo "<td>" . $row['ngayLam'] . "</td>";
            echo "<td><a href='index.php?quanli=detail-lich-lam-viec&id=" . $row['maBacSi'] . "' class='btn btn-info btn-sm'>Chi tiết</a></td>";

            echo "</tr>";
          }
        } else {
          echo "<tr><td colspan='5'>Không có dữ liệu</td></tr>";
        }
        ?>
      </tbody>

    </table>

    <div class="text-center">
      <a href="index.php?quanli=detail-lich-lam-viec" class="btn btn-primary btn-sm">Chi tiết bác sĩ</a>
      <button class="btn btn-secondary" onclick="resetFilters()">Quay lại</button>
    </div>
  </div>

  <script>
    function resetFilters() {
      // Reset the form values
      document.querySelector('form').reset();

      // Submit the form again to reload the page with the full list
      document.querySelector('form').submit();
    }
  </script>
</body>