<?php 
error_reporting(1);
?>
<div class="xemLichHen">
    <div class="container">
        <div class="bg-light m-4">
            <div class="row">
                <div class="col-lg-12 p-4">
                    <h3>Danh sách Lịch hẹn khám</h3>
                </div>
            </div>
            <div class="container-fluid">
                <form action="" method="post">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="d-flex">
                            <label for="date">Chọn ngày:</label>
                            <div class="form-group mb-1">
                                <input type="date" id="date" name="date" class="form-control">
                            </div>
    
                        </div>
                        <div class="d-flex">
                            <div class="form-group">
                                <input type="search" class="form-control" name="keyword" placeholder="Tìm bệnh nhân">
                            </div>
                            <input type="submit" name="timBenhNhan" class="btn btn-primary" value="Tìm">
    
                        </div>
                    </div>
                </form>
                <?php 
                if(isset($_POST['timBenhNhan'])){
                    $keyword = $_POST['keyword'];
                    $date = $_POST['date'];
                }
                
                ?>
            </div>
            <div class="container-fluid justify-content-between mb-4">
                <div class="table-container pb-4">
                    <table>
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Mã bệnh nhân</th>
                                <th>Tên bệnh nhân</th>
                                <th>Giờ hẹn khám</th>
                                <th>Chức năng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                require_once("../config/config.php");
                                $sql = "select maLichHen, bn.maBenhNhan, bn.tenBenhNhan, gioKham from benhnhan bn join lichhenkham lhk on bn.maBenhNhan = lhk.maBenhNhan  AND bn.tenBenhNhan LIKE '%".$keyword."%'";
                                $result = mysqli_query($conn,$sql);
                                $stt = 0;
                                while($row= mysqli_fetch_assoc($result)){
                                ?> 
                                <tr>
                                    <td><?= ++$stt ?></td>
                                    <td><?=$row['maBenhNhan']?></td>
                                    <td><?=$row['tenBenhNhan']?></td>
                                    <td><?= $row['gioKham']?></td>
                                    <td><button class="action-btn" onclick="window.location.href='index.php?quanli=xem-chi-tiet-lich-hen-benh-nhan&id=<?=$row['maLichHen']?>'">Xem</button></td>
                                </tr>
                                <?php }?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
</div>