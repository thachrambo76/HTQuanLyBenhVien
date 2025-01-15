<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link rel="stylesheet" href="./public/css/bootstrap.min.css">
    <link rel="stylesheet" href="./public/css/font-awesome.min.css">
    <link rel="stylesheet" href="./public/css/style_public.css">

    <!-- link -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
</head>
<body>
    <!-- header -->
    <header class="header">
        <div class="container-fluid">
            <div class="row">
                    <div class="header__top">
                        <ul>
                            <li><button href="tel:19002003" style="border-radius:20px;background-color: rgb(10, 104, 10); border: none;" >
                                <i class="fa fa-phone" style="color: #ffffff;"></i>	<span style="color: #ffffff; padding: 10px;">1900 2003</span>
                                </button>
                            </li>
                            <li ><button  rel="tel:0284567890" style="border-radius:20px; background-color: rgb(243, 11, 11); border: none;">
                                <i class="fa fa-heart" style="color: #ffffff;"></i>	<span style="color: #ffffff;padding: 10px;">Cấp cứu (028) 456 7890</span>
                                </button>
                            </li>
                            <li><a href="/QLBENHVIEN/public/user/datLichKham.php" class="btn" style="border-radius:20px;background-color: rgb(21, 176, 21); border: none;" >
                                <i  class="fa fa-calendar" style="color: #ffffff;"></i>	<span style="color: #ffffff;padding: 10px;">Đặt lịch khám</span>
                                </a>
                            </li>
                            <li>
                            <?php
                                 // Khởi tạo session nếu chưa

                                if (isset($_SESSION['id'])) {
                                    // Người dùng đã đăng nhập
                                    echo '<a href="/QLBENHVIEN/index.php?url=dang-xuat">Thoát !</a>';
                                } else {
                                    // Người dùng chưa đăng nhập
                                    echo '<a href="index.php?url=dang-nhap">Đăng nhập</a><span style="color: #ffffff;"> / </span>';
                                    echo '<a href="/QLBENHVIEN/public/account/register.php">Đăng kí</a>';
                                }
                            ?>
                            </li>
                        </ul>
                    </div>
            </div>
        </div>
        <div class="container-fluid header__menu">
            <div class="row">
                <div class="col-lg-4 col-sm-3 " style="text-align: center; padding-bottom: 5px;">
                    <div class="header__img">
                        <a href="?url=trang-chu">
                            <img src="public/img/sang tao hospital.png" alt="" style="width: 300px;">
                        </a>
                    </div> 
                </div>
                <div class="col-lg-8 col-sm-3 ml-5">
                    <div class="header__right">
                        <div class="header__menu">
                            <ul>
                                <li><a href="index.php?url=trang-chu"><h5>TRANG CHỦ</h5></a></li>
                                <li><a href="index.php?url=chuyen-khoa"><h5>CHUYÊN KHOA</h5></a></li>
                                <li><a href="index.php?url=bac-si"><h5>BÁC SĨ</h5></a></li>
                                <li><a href=""><h5>DỊCH VỤ</h5></a>
                                    <ul class="dropdown">
                                        <li><a href="index.php?url=bang-gia-dich-vu">Bảng giá dịch vụ</a></li>
                                        <li><a href="index.php?url=quy-trinh-nhap-vien">Quy trình nhập viện</a></li>
                                        <li><a href="index.php?url=quy-trinh-xuat-vien">Quy trình xuất viện</a></li>
                                        <li><a href="index.php?url=trang-lien-lac">Liên hệ với chúng tôi</a></li>
                                    </ul>
                                </li>
                                <li><a href="index.php?url=thanh-tuu"><h5>THÀNH TỰU</h5></a></li>
                                <li><a href="index.php?url=tin-tuc"><h5>TIN TỨC</h5></a></li>
                                <li><a href=""><h5>BỆNH NHÂN</h5></a>
                                    <ul class="dropdown">
                                        <li><a href="/QLBENHVIEN/public/user/datLichKham.php">Đặt lịch khám</a></li>
                                        <li><a href="/QLBENHVIEN/public/user/xemPhieuKham.php">Xem Phiếu Khám</a></li>
                                        <li><a href="index.php?url=tra-cuu-thong-tin">Tra cứu thông tin</a></li>
                                    </ul>
                                </li>
                            </ul>
    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- end header  -->
