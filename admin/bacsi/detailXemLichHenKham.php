<?php 
    require_once("../config/config.php");
    $id = $_GET['id'];
?>

<div class="detailXemLichHenKham">
    <div class="container">
        <div class="bg-light mt-5">
            <h3 class="d-flex justify-content-center pt-4">Thông tin lịch hẹn bệnh nhân</h3>
            <form action="" method="post">

                <div class="d-flex justify-content-between ">
                    <?php 
                    $sql = "SELECT lhk.maLichHen, bn.maBenhNhan, bn.tenBenhNhan, bn.sdt, bn.diaChi, bn.maBHYT, bs.maKhoa, kk.tenKhoa, bs.tenBacSi, lhk.ngayKham, lhk.gioKham, lhk.moTa
                    FROM benhnhan bn 
                    JOIN lichhenkham lhk ON bn.maBenhNhan = lhk.maBenhNhan
                    JOIN bacsi bs ON lhk.maBacSi = bs.maBacSi 
                    JOIN khoakham kk ON bs.maKhoa = kk.maKhoa
                    WHERE lhk.maLichHen = '$id'";
                    $result = mysqli_query($conn,$sql);
                    while($row = mysqli_fetch_assoc($result)){
                    ?> 
                    
                    <div class="d-flex">
                        <div class="detailThongTin pb-5">
                            <h4 class="p-3">Thông tin bệnh nhân</h4>
                                <p><strong>Tên Bệnh Nhân:</strong><?= $row['tenBenhNhan'] ?></p>
                                <p><strong>Mã bệnh nhân:</strong> <?= $row['maBenhNhan'] ?></p>
                                <p><strong>Số điện thoại:</strong><?= $row['sdt'] ?></p>
                                <p><strong>Địa chỉ:</strong> <?= $row['diaChi'] ?></p>
                                <p><strong>Mã BHYT:</strong> <?= $row['maBHYT'] ?></p>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="detailKhoaKham pb-5">
                            <h4 class="p-3">Khoa Khám bệnh</h4>
                            <p><strong>Khoa Khám: </strong><?= $row['maKhoa']?></p>
                            <p><strong>Bác sĩ khám:</strong><?= $row['tenBacSi']?></p>
                            <p><strong>Ngày khám: </strong><?= $row['ngayKham']?></p>
                            <p><strong>Giờ khám: </strong><?= $row['gioKham']?></p>
                            <p><strong>Mô tả tình trạng sức khỏe:</strong><?= $row['moTa']?></p>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end p-3">
                    <button type="reset" class="btn btn-danger me-2" name="btnHuy" onclick="window.location.href='index.php?quanli=xem-lich-hen-benh-nhan'">Quay Lại</button>
                    <a type="submit" class="btn btn-success" name="btnHoanThanhKham" onclick="window.location.href='index.php?quanli=tao-phieu-kham&idht=<?= $row['maBenhNhan'] ?>'">Hoàn Thành Khám</a>
                </div>
                    <?php }?>

            </form>
        </div>
    </div>
</div>