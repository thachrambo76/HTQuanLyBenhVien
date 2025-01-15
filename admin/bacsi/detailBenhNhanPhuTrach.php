<?php
include("./xuly/clsquantri.php");
$p = new quantri();
?>
<div class="detailBenhNhanPhuTrach">
    <section class="container-fluid pt-4 px-4">
        <div class="bg-light text-center rounded p-4">
            <p><a href="index.php?quanli=xem-benh-nhan-phu-trach">< Back</a></p>
            <div id="thongtin__left">
                <?php
                $id = $_REQUEST['id']; // id có thể là maPhieuKham hoặc maBenhNhan

                // Kiểm tra nếu id là mã phiếu khám hay mã bệnh nhân
                if (substr($id, 0, 2) == "PK") {
                    // Trường hợp id là maPhieuKham
                    $sql = "SELECT 
                                benhnhan.maBenhNhan, benhnhan.tenBenhNhan, benhnhan.namSinh, benhnhan.gioiTinh, benhnhan.diaChi,
                                phieukham.maPhieuKham, phieukham.ngayTao, phieukham.tinhTrangBenh, 
                                phieukham.chanDoan, phieukham.keHoachDieuTri
                            FROM phieukham
                            INNER JOIN benhnhan ON phieukham.maBenhNhan = benhnhan.maBenhNhan
                            WHERE phieukham.maPhieuKham = '$id'";  
                } else {
                    // Trường hợp id là maBenhNhan
                    $sql = "SELECT 
                                benhnhan.maBenhNhan, benhnhan.tenBenhNhan, benhnhan.namSinh, benhnhan.gioiTinh, benhnhan.diaChi,
                                phieukham.ngayTao, phieukham.tinhTrangBenh, 
                                phieukham.chanDoan, phieukham.keHoachDieuTri
                            FROM benhnhan
                            INNER JOIN phieukham ON benhnhan.maBenhNhan = phieukham.maBenhNhan
                            WHERE benhnhan.maBenhNhan = '$id'";  
                }

                $p->xemchitietbenhnhan($sql);
                ?>
            </div>
            <div id="thongtin__right"><img src="img/anhthe.png" alt=""></div>
        </div>
    </section>
</div>
