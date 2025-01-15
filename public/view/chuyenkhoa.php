<?php 
error_reporting(1);
?>
<div class="chuyenkhoa">
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="index.php"><i class="fa fa-home"></i> Trang chủ</a>
                        <span>></span>
                        <span>Chuyên khoa</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container my-5 ">
        <!-- Tìm kiếm -->
        <form action="" method="post">
            <div class="search-box mb-4 text-center">
                <input type="text" class="form-control d-inline-block" name="tenchuyenkhoa" style="width: 300px;" placeholder="Tìm chuyên khoa">
                <button class="btn btn-primary ms-2" name="timkiem_chuyenkhoa"><i class="fa fa-search"></i></button>
            </div>
        </form>
        <?php 
            if(isset($_POST['timkiem_chuyenkhoa'])){
                $tenchuyenkhoa = $_POST['tenchuyenkhoa'];
            }
        ?>
        <!-- Tiêu đề -->
        <h3 class="text-center">DANH SÁCH CHUYÊN KHOA</h3>
        <div class="text-center mb-3">
            <hr class="mx-auto" style="width: 150px; border-top: 3px solid #000;">
        </div>
        <div class="list__chuyenkhoa">
            <div class="cart d-flex flex-wrap gap-3 justify-content-center">
                <?php
                require_once("./config/config.php");
                $sql = "select * from khoakham where tenKhoa LIKE '%".$tenchuyenkhoa."%'";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                ?>
                    <div class="specialty-box text-center p-3">
                        <a href="index.php?url=detail-chuyen-khoa&idck=<?= $row['maKhoa'] ?>">
                            <img src="public/img/<?= $row['hinh'] ?>" class="card-img-top custom-img" alt="Icon">
                            <h5><b><?= $row['tenKhoa'] ?></b></h5>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>


        <!-- Pagination -->
        <div class="pagination mt-4 d-flex justify-content-center">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="#">«</a></li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item active"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">4</a></li>
                    <li class="page-item"><a class="page-link" href="#">»</a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>