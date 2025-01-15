<?php 
    require_once("./config/config.php");
    $idck = $_REQUEST['idck'];
?>
<div class="detail__chuyenkhoa">
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="index.php"><i class="fa fa-home"></i> Trang chủ</a>
                        <span>></span>
                        <span><a href="?url=chuyen-khoa">Chuyên khoa</a></span>
                        <span>></span>
                        <span>Chi tiết khoa</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="gioithieu container-fluid">
        <div class="row">
                <?php 
                    $sql = "select*from khoakham where maKhoa = '$idck'";
                    $result = mysqli_query($conn,$sql);
                    while($row = mysqli_fetch_assoc($result)){

                    ?> 
            <div class="col-lg-6">
                <img src="public/img/<?=$row['hinh']?>" alt="khoa nhi">
            </div>
            <div class="col-lg-6">
                    <div>
                        <h4>Giới thiệu <?=$row['tenKhoa']?></h4>
                    </div>
                    <div>
                        <p><?= $row['chucNang']?></p>
                    </div>
                    <div>
                        <input type="submit" class="btn" value="Đặt lịch khám">
                    </div>
                    
                <?php }?>
            </div>
        </div>
    </div>
    <div class="noidung__khoanhi">
        <div class="container">
                <?php 
                    $sql = "select*from khoakham where maKhoa = '$idck'";
                    $result = mysqli_query($conn,$sql);
                    while($row = mysqli_fetch_assoc($result)){

                ?> 
                <h3 class="header-text">Tổng quát <?=$row['tenKhoa']?></h3>
                <div class="content">
                    <p><?=$row['mota']?></p>
                    
                </div>
                <?php }?>
        </div>
    </div>

</div>