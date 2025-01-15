<?php
require_once("../config/config.php");

// Kiểm tra nếu người dùng nhấn nút tìm kiếm
if (isset($_POST['timKiemThanhToan'])) {
    $keyword = $_POST['maBenhNhan'];

    // Xây dựng câu truy vấn
    $sql = "SELECT lhk.maLichHen, bn.maBenhNhan, bn.tenBenhNhan, bn.sdt, bn.diaChi, bn.maBHYT, bs.maKhoa, kk.tenKhoa, bs.tenBacSi, lhk.ngayKham, lhk.gioKham, lhk.moTa
            FROM benhnhan bn 
            JOIN lichhenkham lhk ON bn.maBenhNhan = lhk.maBenhNhan
            JOIN bacsi bs ON lhk.maBacSi = bs.maBacSi 
            JOIN khoakham kk ON bs.maKhoa = kk.maKhoa
            WHERE lhk.maBenhNhan = '$keyword'";
    
    $result = mysqli_query($conn, $sql);
    // Kiểm tra nếu không tìm thấy kết quả
    if (mysqli_num_rows($result) == 0) {
        echo "<script>
                alert('Không tìm thấy bệnh nhân');
                window.location.href = 'index.php?quanli=thanh-toan'; // Chuyển hướng về trang tìm kiếm
              </script>";
        exit; // Dừng thực thi mã tiếp theo
    }

    // Lấy thông tin bệnh nhân
    $row = mysqli_fetch_assoc($result);
    $_SESSION['maBenhNhan']= $row['maBenhNhan'];
}
?>
<div class="detailThanhToan">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 p-5">
                <div class="bg-light h-100 p-5">
                    <h3>THÔNG TIN THANH TOÁN</h3>
                    <form action="" method="post">
                        <div class="info">
                            <p><strong>Tên Bệnh Nhân: </strong><?=$row['tenBenhNhan'] ?></p>
                            <p><strong>Mã khám bệnh: </strong> <?=$row['maBenhNhan']  ?></p>
                            <p><strong>Số điện thoại: </strong> <?=$row['sdt'] ?></p>
                            <p><strong>Địa chỉ: </strong><?= $row['diaChi']  ?></p>
                            <p><strong>Mã BHYT: </strong> <?= $row['maBHYT']  ?></p>
                            <p><strong>Ngày khám bệnh: </strong><?= $row['ngayKham']  ?></p>
                        </div>

                        <!-- Kiểm tra và hiển thị thông tin dịch vụ -->
                        <div class="table-container">
                            <div class="info_service">
                                <?php 
                                $sql_str = "SELECT dichvu_benhnhan.maDichVu, tenDichVu, donGia 
                                            FROM dichVu, dichvu_benhnhan 
                                            WHERE dichvu.maDichVu = dichvu_benhnhan.maDichVu 
                                            AND maBenhNhan='$keyword'";
                                $res = mysqli_query($conn, $sql_str);
                                $stt = 0;
                                $tongTien = 0;

                                // Kiểm tra nếu không có dịch vụ
                                if (mysqli_num_rows($res) == 0) {
                                    echo "<p style='color: red;'>Không có thông tin thanh toán</p>";
                                } else {
                                ?>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Mã dịch vụ</th>
                                            <th>Dịch vụ khám</th>
                                            <th>Tổng tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                    while ($item = mysqli_fetch_assoc($res)) {
                                        $tongTien += $item['donGia'];
                                        $_SESSION['tongtien'] = $tongTien;
                                    ?>
                                        <tr>
                                            <td><?= ++$stt ?></td>
                                            <td><?= $item['maDichVu'] ?></td>
                                            <td><?= $item['tenDichVu'] ?></td>
                                            <td><?= number_format($item['donGia'], 0, ',', '.'); ?> VND</td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                                <?php } ?>
                            </div>
                        </div>

                        <!-- Hiển thị tổng tiền nếu có dịch vụ -->
                        <?php if ($tongTien > 0) { ?>
                        <div class="sumCost">
                            <h5>Thành tiền: <?= number_format($tongTien, 0, ',', '.'); ?> VND</h5>
                        </div>
                        <?php } ?>

                        <div class="d-flex justify-content-end">
                            <button type="reset" class="btn btn-danger me-2" name="btnHuy" onclick="window.location.href='index.php?quanli=thanh-toan'">Hủy</button>
                            <?php if ($tongTien > 0) { ?>
                            <a href="index.php?quanli=thong-tin-thanh-toan&maLichHen=<?=$row['maLichHen'] ?>" class="btn btn-success me-2" name="btnThanhToan">Thanh toán</a>
                            <?php } ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
