<?php
require_once("../config/config.php");

// Truy vấn lấy thông tin từ bảng
$sql = "SELECT 
            benhnhan.tenBenhNhan,
            phieukham.maPhieuKham,
            donthuoc.maDonThuoc
        FROM phieukham
        INNER JOIN benhnhan ON phieukham.maBenhNhan = benhnhan.maBenhNhan
        INNER JOIN donthuoc ON phieukham.maDonThuoc = donthuoc.maDonThuoc";
$result = $conn->query($sql);

?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Danh Sách Đơn Thuốc</h2>


    <nav class="navbar bg-body-tertiary">
            <div class="container-fluid">
                <!-- <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form> -->

               <a href="index.php?quanli=tra-cuu-don-thuoc" > <button class="btn btn-info">Tra cứu đơn thuốc</button></a>
            </div>
        </nav>

    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Tên Bệnh Nhân</th>
                <th>Mã Phiếu Khám</th>
                <th>Mã Đơn Thuốc</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                // Hiển thị dữ liệu từ kết quả truy vấn
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['tenBenhNhan']}</td>
                        <td>{$row['maPhieuKham']}</td>
                        <td>{$row['maDonThuoc']}</td>
                        <td>
                            <a href='index.php?quanli=chi-tiet-don-thuoc&maDonThuoc={$row['maDonThuoc']}' class='btn btn-info btn-sm'>Xem</a>
                            <a href='index.php?quanli=edit-dt&id={$row['maDonThuoc']}' class='btn btn-warning btn-sm'>Sửa</a>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='4' class='text-center'>Không có dữ liệu</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script>
function confirmDelete(id) {
    if (confirm("Bạn có chắc muốn xóa đơn thuốc này?")) {
        window.location.href = "delete.php?id=" + id;
    }
}
</script>

<?php
// Đóng kết nối
$conn->close();
?>
