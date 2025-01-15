<?php
    include("./xuly/clsquantri.php");
    $p = new quantri();

?>
<div class="home">
    <section class="container-fluid pt-4 px-4" >
        <div class="menu__thongso">
            <div id="thongso__1">
            <img src="../admin/img/money.png" alt="">    
            <p class="thongso__name">Doanh thu</p>
            <p class="thongso__number">
                    <?php
                        $p->doanhthuDasboard("SELECT * FROM hoadon WHERE 1=1");
                    ?>
            </p>
            </div>
            <div id="thongso__2">
                    <img src="../admin/img/patient.png" alt="">
                    <p class="thongso__name">Tổng bệnh nhân</p>
                    <p class="thongso__number">
                        <?php
                            $sql = "SELECT COUNT(*) AS totalPatients FROM benhnhan";
                            $p->tinhTongBenhNhan($sql);
                        ?>
                    </p>
            </div>
            <div id="thongso__3">
                    <img src="../admin/img/operation.png" alt="">
                    <p class="thongso__name">Hoạt động</p>
                    <p class="thongso__number">
                        <?php
                            $hoatDong = rand(1,100);
                            echo $hoatDong;
                        ?>
                    </p>
            </div>
            <div id="thongso__4">
                    <img src="../admin/img/lich.png" alt="">
                    <p class="thongso__name">Lịch hẹn</p>
                    <p class="thongso__number">
                        <?php
                            $sql = "SELECT COUNT(*) AS totalLichHen FROM lichhenkham";
                            $p->tinhTongLichHen($sql);
                        ?>
                        
                    </p>
            </div>
        </div>
        <div class="menu__thongso2">
            <div id="thongso__doctor">
                <p id="thongso__title">Bác Sĩ Tốt Nhất</p>
                <a href="#">Xem thêm <img src="../admin/img/arrow.png" alt=""></a></a>
                <div id="thongso__listbacsi">
                    <img src="../admin/img/bacsi1.png" alt="" >
                    <img src="../admin/img/bacsi2.png" alt="" style="margin-left: 10px;">
                    <img src="../admin/img/bacsi3.png" alt="" style="margin-left: 10px;">
                    <img src="../admin/img/bacsi4.png" alt="" style="margin-left: 10px;">
                </div>
            </div>
            <div id="thongso__khach">
                <p id="thongso__title">Lượt khách</p>
                <div class="chart-container">
                    <canvas id="visitorsChart"></canvas>
                </div>
            </div>
            <div id="thongso__hoiphuc">
                <p id="thongso__title">Hồi phục</p>
                <div class="chart-container">
                    <canvas id="recoveryChart"></canvas>
                </div>
            </div>
        </div>
        <div class="menu__thongso3">
            <div id="thongso__benhnhan">
                <p id="thongso__title">Bệnh nhân</p>
                <a href="index.php?quanli=danh-sach-benh-nhan">Xem thêm <img src="../admin/img/arrow.png" alt=""></a></a>
                <div class="patients-container">
                    <div class="patients-info">
                        <p>Tổng bệnh nhân</p>
                        <h2><?php
                            $sql = "SELECT COUNT(*) AS totalPatients FROM benhnhan";
                            $p->tinhTongBenhNhan($sql);
                        ?></h2>
                        <div class="legend">
                            <div class="legend-item">
                                <span class="color-box new"></span> Mới
                            </div>
                            <div class="legend-item">
                                <span class="color-box recovered"></span> Đã hồi phục
                            </div>
                            <div class="legend-item">
                                <span class="color-box treatment"></span> Điều trị
                            </div>
                        </div>
                    </div>
                    <div class="chart-container-pie">
                        <canvas id="patientsChart"></canvas>
                    </div>
                </div>
            </div>
            <div id="thongso__tuvan">
                <p id="thongso__title">Khung giờ tư vấn</p>
                <a href="#">Xem thêm <img src="../admin/img/arrow.png" alt=""></a></a>
                <div id="bacsi__tuvan1">
                    <img src="../admin/img/bacsi5.png" alt="">
                    <p id="ten__bacsi">Dr.Phúc Hưng</p>
                    <p id="chuyenkhoa__bacsi">Khoa nội tổng hợp</p>
                    <p id="giolamviec__bacsi">10:20AM - 12:30PM</p>
                    <button id="xem__bacsi">Xem</button>
                </div>
                <div id="bacsi__tuvan2">
                    <img src="../admin/img/bacsi4.png" alt="">
                    <p id="ten__bacsi">Dr.Tuấn Anh</p>
                    <p id="chuyenkhoa__bacsi">Khoa hồi sức cấp cứu</p>
                    <p id="giolamviec__bacsi">10:20AM - 12:30PM</p>
                    <button id="xem__bacsi">Xem</button>
                </div>
            </div>
        </div>
    </section>
</div>

