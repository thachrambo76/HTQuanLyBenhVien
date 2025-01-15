<?php
require_once("../config/config.php");
if (isset($_SESSION['tongtien']) && isset($_SESSION['maBenhNhan'])) {
    $tongtien = $_SESSION['tongtien'];
    $maBenhNhan = $_SESSION['maBenhNhan'];
} else {
    $tongtien = 0; // Giá trị mặc định
}

$maLichHen = $_GET['maLichHen'];
if (isset($_POST['inHoaDon'])) {
    $maHoaDon = 'HD' . rand(100000, 999999);
    $tenNguoiThanhToann = $_POST['tenNguoiThanhToan'];
    $sodienthoai = $_POST['sodienthoai'];
    $hinhThucThanhToan = $_POST['hinhThucThanhToan'];
    $tienthu = $_POST['tienthu'];
    $tienthua = $tongtien - $tienthu;

    // Bắt đầu transaction
    mysqli_begin_transaction($conn);

    $trangThai = 0; // Mặc định trạng thái là 0 (thất bại)

    try {
        // Insert vào bảng hoadondichvu
        $sql_hoadondichvu = "INSERT INTO hoadondichvu (maHoaDon, maLichHen,maBenhNhan,nguoiThanhToan, sodienthoai, hinhThucThanhToan, tongTien, tienthu, tienthua, thoiGianThanhToan) 
            VALUES ('$maHoaDon', '$maLichHen','$maBenhNhan', '$tenNguoiThanhToann', $sodienthoai, '$hinhThucThanhToan', $tongtien, $tienthu, $tienthua, NOW());";
        if (!mysqli_query($conn, $sql_hoadondichvu)) {
            throw new Exception("Lỗi khi thêm vào bảng hoadondichvu.");
        }

        // Insert vào bảng hoadon
        $sql_hoadon = "INSERT INTO hoadon (maHoaDon, maBenhNhan, tienDichVu, tienThuoc, ngayGiaoDich, trangthai) 
            VALUES ('$maHoaDon', '$maBenhNhan', '$tongtien', '', NOW(), '1');";
        if (!mysqli_query($conn, $sql_hoadon)) {
            throw new Exception("Lỗi khi thêm vào bảng hoadon.");
        }

        // Nếu không có lỗi, commit transaction và đặt trạng thái là thành công (1)
        mysqli_commit($conn);
        $trangThai = 1;

        echo "<script>
            alert('Thanh toán thành công !');
            window.location.href='index.php?quanli=hoa-don-thanh-toan';
        </script>";
    } catch (Exception $e) {
        // Nếu có lỗi, rollback transaction và giữ trạng thái là thất bại (0)
        mysqli_rollback($conn);

        echo "<script>
            alert('Thanh toán thất bại: " . $e->getMessage() . "');
        </script>";
    } finally {
        // Cập nhật trạng thái vào bảng hoadon
        $sql_update_trangthai = "UPDATE hoadon SET trangthai = '$trangThai' WHERE maHoaDon = '$maHoaDon'";
        mysqli_query($conn, $sql_update_trangthai);
    }
}


?>
<div class="detailThanhToan">
    <div class="container" style="width: 800px;">
        <div class="row">
            <div class="col-lg-12 p-4">
                <div class="bg-light rounded h-100 p-5">
                    <h3 style="text-align: center; color: #009CFF; padding: 20px;">THÔNG TIN THANH TOÁN</h3>
                    <form action="" method="post">
                        <div class="form-group row mb-3">
                            <label for="tenNguoiThanhToan" class="col-sm-4 col-form-label fw-bold">Tên người thanh toán</label>
                            <div class="col-sm-8">
                                <input type="text" name="tenNguoiThanhToan" id="tenNguoiThanhToan" class="form-control" placeholder="Tên người thanh toán" style="width: 400px;" required>
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="sdt" class="col-sm-4 col-form-label fw-bold">Số điện thoại</label>
                            <div class="col-sm-8">
                                <input type="text" name="sodienthoai" id="sodienthoai" class="form-control" placeholder="Nhập số điện thoại" style="width: 400px;" required>
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="tongtien" class="col-sm-4 col-form-label fw-bold">Tổng tiền: <b style="color:red"><?php echo number_format($tongtien, 0, ',', '.'); ?> VND</b></label>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="sdt" class="col-sm-4 col-form-label fw-bold">Hình thức thanh toán</label>
                            <div class="col-sm-2" style="padding-top: 7px;">
                                <input type="radio" value="Tiền mặt" name="hinhThucThanhToan"> Tiền mặt
                            </div>
                            <div class="col-sm-3" style="padding-top: 7px;">
                                <input type="radio" value="Chuyển khoản" name="hinhThucThanhToan"> Chuyển khoản
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="tienthu" class="col-sm-4 col-form-label fw-bold">Số tiền thu </label>
                            <div class="col-sm-8">
                                <input type="text" name="tienthu" id="tienthu" class="form-control" placeholder="Số tiền thu" style="width: 400px;" required>
                            </div>
                        </div>
                        <div class="submit" style="text-align: center;">
                            <input type="reset" class="btn btn-danger" name="troLai" value="Trở về" onclick="window.location.href='index.php?quanli=thanh-toan'">
                            <input type="submit" class="btn btn-success" name="inHoaDon" value="In hóa đơn">
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
</div>