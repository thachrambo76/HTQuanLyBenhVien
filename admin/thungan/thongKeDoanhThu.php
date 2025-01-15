<?php
include("./xuly/clsquantri.php");
$p = new quantri();
?>

<div class="thongKeDoanhThu">
    <section class="container-fluid pt-4 px-4">
        <div class="bg-light text-center rounded p-4">
            <h4>THỐNG KÊ DOANH THU HẰNG NGÀY</h4>
            <div id="top__header">
                <div class="nav__doanhthu">
                    <strong id="title_header">Chọn ngày: 
                        <form method="POST" action="">
                            <input type="date" id="chonngay" name="ngayGiaoDich" onchange="this.form.submit();">
                        </form>
                    </strong>

                    <!-- Form tìm kiếm -->
                    <form class="d-flex" method="POST">
                        <input id="form__search" type="search" placeholder="Tìm kiếm mã hóa đơn..." aria-label="Search" name="search">
                        <button id="btn__search" type="submit" name="timkiem"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                </div>

                <div id="table__danhsach">
                    <div class="row header">
                        <div class="col-4 col-sm-1 stt">STT</div>
                        <div class="col-4 col-lg-2">Mã hóa đơn</div>
                        <div class="col-4 col-lg-2">Mã bệnh nhân</div>
                        <div class="col-4 col-lg-2">Tiền dịch vụ</div>
                        <div class="col-4 col-lg-2">Tiền thuốc</div>
                        <div class="col-4 col-lg-2">Ngày giao dịch</div>
                    </div>

                    <div id="content__thongke">
                    <?php
                        // Lọc dữ liệu theo ngày và mã hóa đơn
                        $query = "SELECT maHoaDon, maBenhNhan, tienDichVu, tienThuoc, ngayGiaoDich FROM hoadon WHERE 1=1";

                        // Lọc theo mã hóa đơn
                        if (isset($_POST['timkiem']) && !empty($_POST['search'])) {
                            $search = addslashes($_POST['search']);
                            $query .= " AND maHoaDon LIKE '%$search%'";
                        }

                        // Lọc theo ngày giao dịch
                        if (isset($_POST['ngayGiaoDich']) && !empty($_POST['ngayGiaoDich'])) {
                            $ngayGiaoDich = $_POST['ngayGiaoDich'];
                            $query .= " AND ngayGiaoDich = '$ngayGiaoDich'";
                        }

                        // Truy vấn và hiển thị kết quả
                        $result = $p->xemthongkedoanhthu($query);
                        $stt = 1;  // Khởi tạo biến đếm số thứ tự

                        // Kiểm tra và hiển thị kết quả
                        if (!empty($result)) {
                            foreach ($result as $row) {
                                echo "<div class='row'>";
                                echo "<div class='col-4 col-sm-1'>" . $stt . "</div>";  // Hiển thị số thứ tự
                                echo "<div class='col-4 col-lg-2'>" . htmlspecialchars($row['maHoaDon']) . "</div>";  // Hiển thị mã hóa đơn (chuỗi)
                                echo "<div class='col-4 col-lg-2'>" . htmlspecialchars($row['maBenhNhan']) . "</div>";  // Hiển thị mã bệnh nhân (chuỗi)
                                echo "<div class='col-4 col-lg-2'>" . number_format(floatval($row['tienDichVu']), 0, ',', '.') . "đ</div>";
                                echo "<div class='col-4 col-lg-2'>" . number_format(floatval($row['tienThuoc']), 0, ',', '.') . "đ</div>";
                                echo "<div class='col-4 col-lg-2'>" . $row['ngayGiaoDich'] . "</div>";
                                echo "</div>";
                                $stt++;  // Tăng giá trị số thứ tự sau mỗi vòng lặp
                            }
                        } else {
                            echo "<p style='color: red;'>Không có giao dịch này.</p>";
                        }
                    ?>
                    
            </div>
            
        </div>
        <?php
                // Tính tổng doanh thu sau khi có tìm kiếm hoặc chọn ngày
                if (isset($_POST['timkiem']) && !empty($_POST['search'])) {
                    $p->tinhTongTien("SELECT * FROM hoadon WHERE maHoaDon LIKE '%$search%'");
                } elseif (isset($_POST['ngayGiaoDich']) && !empty($_POST['ngayGiaoDich'])) {
                    $ngayGiaoDich = $_POST['ngayGiaoDich'];
                    $p->tinhTongTien("SELECT * FROM hoadon WHERE ngayGiaoDich = '$ngayGiaoDich'");
                } else {
                    $p->tinhTongTien("SELECT * FROM hoadon");
                }
                ?>
    </section>
</div>