<?php
error_reporting(1);
    if (isset($_POST['nut']) == true) {
        //error_reporting(0);

        // Lấy dữ liệu từ form
        $ho = $_POST['ho'];
        $ten = $_POST['ten'];
        $ngay = $_POST['ngay'];
        $thang = $_POST['thang'];
        $nam = $_POST['nam'];
        $gioiTinh = $_POST['gioiTinh'];
        $sdt = $_POST['sdt'];
        $email = $_POST['email'];
        $password = md5($_POST['pass']);

        // Kiểm tra tính hợp lệ của ngày tháng năm
        if (!checkdate($thang, $ngay, $nam)) {
            echo "<script>alert('Ngày tháng năm không hợp lệ. Vui lòng kiểm tra lại!'); window.location.href='/QLBENHVIEN/public/account/register.php';</script>";
            exit; // Dừng xử lý nếu ngày tháng năm không hợp lệ
        }
        // Dữ liệu liên quan đến bảng benhnhan
        $quyen= "";
        $hoTen = $ho . " " . $ten;
        $tenBenhNhan = $ho . " " . $ten; // Ghép họ và tên
        $namSinh = $nam . "-" . $thang . "-" . $ngay; // Chuyển ngày sinh thành định dạng YYYY-MM-DD
        $ngaySinh = $nam . "-" . $thang . "-" . $ngay;
        $diaChi = "";                   // Để trống nếu không nhập
        $maBHYT = NULL;                 // Mã BHYT, để NULL nếu không có
        $maPhieuKham = NULL;            // Mã phiếu khám, để NULL nếu không có

        try {
            // Kết nối cơ sở dữ liệu bằng PDO
            $pdo = new PDO("mysql:host=localhost;dbname=qlbenhvien", "usertmdt", "passtmdt");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Kiểm tra số điện thoại đã tồn tại hay chưa
            $checkPhoneQuery = "SELECT COUNT(*) FROM user WHERE sdt = ?";
            $stmt = $pdo->prepare($checkPhoneQuery);
            $stmt->execute([$sdt]);
            $phoneExists = $stmt->fetchColumn();

            if ($phoneExists) {
                echo "<script>alert('Số điện thoại này đã được đăng ký. Vui lòng nhập số điện thoại khác.');</script>";
            } else {
                // Bắt đầu giao dịch
                $pdo->beginTransaction();

                // Chèn dữ liệu vào bảng user
                $sqluser = "INSERT INTO user (maUser, hoTen, ngaySinh, diaChi, gioiTinh, sdt, email, password, quyen)
                            VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($sqluser);
                $stmt->execute([$hoTen, $ngaySinh, $diaChi, $gioiTinh, $sdt, $email, $password, $quyen]);


                // Chèn dữ liệu vào bảng benhnhan
                $sqlBenhNhan = "INSERT INTO benhnhan (maBenhNhan, tenBenhNhan, namSinh, gioiTinh, diaChi, sdt, maBHYT, maPhieuKham) 
                                VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($sqlBenhNhan);
                $stmt->execute([$tenBenhNhan, $namSinh, $gioiTinh, $diaChi, $sdt, $maBHYT, $maPhieuKham]);

                // Xác nhận giao dịch
                $pdo->commit();

                $_SESSION['ten'] = $hoTen; // Lưu tên vào session

                echo "<script>alert('Thêm tài khoản và bệnh nhân thành công!');</script>";
            }
        } catch (PDOException $e) {
            // Rollback nếu có lỗi
            $pdo->rollBack();
            echo "Lỗi: " . $e->getMessage();
        }

        // Đóng kết nối
        $pdo = null;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/style2.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href=".../css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/style_public.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" />
    <script src="..js/bootstrap.bundle.min.js"></script>
    <script src="../js/dangky.js"></script>

    <!-- link -->
    <style>
        label {
            display: block;
            text-align: left;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }
        .gender-group {
            display: flex;
            justify-content: space-between;
            padding: 0 10px;
        }
        .gender-group label {
            width: 32%;
            text-align: center;
            font-weight: normal;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        } 
        .gender-group input[type="radio"] {
            display: none;
        }
        .gender-group input[type="radio"]:checked + label {
            background-color: #e6f4ea;
            border-color: #52b788;
        } 
        .header-spacing {
            margin-top: 200px; /* Tạo khoảng cách 50px giữa header và form */
        }
        .form-container {
            margin: 0 auto;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            padding: 30px;
            width: 400px;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .form-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
        }
        .form-container h2 {
            color: #4b72fa;
            font-weight: bold;
            text-align: center;
        }
        .form-container p {
            text-align: center;
            color: #666;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .gender-buttons {
            display: flex;
            justify-content: space-between;
        }
        .gender-buttons button {
            width: 32%;
            border: 1px solid #ddd;
            background-color: #f8f9fa;
            color: #555;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }
        .gender-buttons button:hover {
            background-color: #4b72fa;
            color: white;
        }
        .btn-primary {
            background-color: #4b72fa;
            border: none;
            width: 100%;
            padding: 10px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .btn-primary:hover {
            background-color: #3a5ec4;
        }
    </style>
    
</head>
<body>
</head>
<body>
    <!-- header -->
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
                                <a href="/QLBENHVIEN/index.php?url=dang-nhap">Đăng nhập</a><span style="color: #ffffff;"> / </span>
                                <a href="/QLBENHVIEN/public/account/register.php">Đăng kí</a>
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
                            <!-- <img src="public/img/sang tao hospital.png" alt="" style="width: 300px;"> -->
                        </a>
                    </div> 
                </div>
                <div class="col-lg-8 col-sm-3 ml-5">
                    <div class="header__right">
                        <div class="header__menu">
                            <ul>
                                <li><a href="/QLBENHVIEN/index.php?url=trang-chu"><h5>TRANG CHỦ</h5></a></li>
                                <li><a href="/QLBENHVIEN/index.php?url=chuyen-khoa"><h5>CHUYÊN KHOA</h5></a></li>
                                <li><a href="/QLBENHVIEN/index.php?url=bac-si"><h5>BÁC SĨ</h5></a></li>
                                <li><a href=""><h5>DỊCH VỤ</h5></a>
                                    <ul class="dropdown">
                                        <li><a href="">Bảng giá dịch vụ</a></li>
                                        <li><a href="">Quy trình nhập viện</a></li>
                                        <li><a href="">Quy trình xuất viện</a></li>
                                        <li><a href="">Liên hệ với chúng tôi</a></li>
                                    </ul>
                                </li>
                                <li><a href=""><h5>THÀNH TỰU</h5></a></li>
                                <li><a href=""><h5>TIN TỨC</h5></a></li>
                                <li><a href=""><h5>BỆNH NHÂN</h5></a>
                                    <ul class="dropdown">
                                        <li><a href="/QLBENHVIEN/public/user/datLichKham.php">Đặt lịch khám</a></li>
                                        <li><a href="">Tra cứu thông tin</a></li>
                                    </ul>
                                </li>
                            </ul>
    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>  

    <!-- form đăng ký -->
    <div class="header-spacing">
        <div class="form-container">
            <h2>Đăng Ký Tài Khoản</h2>
            <p>để đăng ký nhanh chóng</p>
            <form action="" method="POST">
                <!-- Tên -->
                <div class="form-group">
                    <input type="text" class="form-control" name="ho" placeholder="Họ">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="ten" placeholder="Tên">
                </div>

                <!-- Ngày Sinh -->
                <div class="form-group">
                    <label for="dob" class="text-muted">Ngày Sinh</label>
                    <div class="d-flex">
                        <input type="number" class="form-control mr-2" name="ngay" placeholder="Ngày" min="1" max="31" required>
                        <select class="form-control mr-2" name="thang">
                            <option value="">Tháng</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                        <input type="number" class="form-control" name="nam" placeholder="Năm" min="1960" max="2024" required>
                    </div>
                </div>

                <!-- Giới Tính -->
                <label for="dob" class="text-muted">Giới Tính</label>
                <div class="gender-group">
                    <input type="radio" id="female" name="gioiTinh" value="Nữ">
                    <label for="female">Nữ</label>

                    <input type="radio" id="male" name="gioiTinh" value="Nam">
                    <label for="male">Nam</label>

                    <input type="radio" id="other" name="gioiTinh" value="Tùy chỉnh">
                    <label for="other">Tùy chỉnh</label>
                </div>

                <!-- Thông Tin -->
                <div class="form-group">
                    <input type="text" class="form-control" name="sdt" placeholder="Số điện thoại di động">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" name="email" placeholder="Email">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="pass" placeholder="Mật khẩu mới">
                </div>
                <button type="submit" class="btn btn-primary" id="nu    t" name="nut">Đăng Ký</button>
            </form>

        </div>
    </div>
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 footer__descrice">
                    <h4>Bệnh viện Sáng Tạo</h4>
                    <hr>
                    <p>Số 3, đường 17A, P. Bình Trị Đông B, Quận Bình Tân, TP.HCM</p>
                    <p>Tổng đài: 1900 8146</p>
                    <p>Cấp cứu 24/7: (028) 6290 1155</p>
                    <p>Email: sangtaoHospital@st.com.vn</p>    
                </div>
                <div class="col-lg-4 footer__system" >
                    <h4>Dịch vụ</h4>
                    <ul>
                        <li><a href="#">Chuyên Khoa</a></li>
                        <li><a href="#">Gói dịch vụ </a></li>
                        <li><a href="#">Bảo hiểm</a></li>
                        <li><a href="#">Đặt lịch hẹn</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 footer__search" >
                  <div><img src="public/img/logoFooter.png" alt="logoFooter"></div>
                  <div><p>THEO DÕI TIN TỨC VÀ DỊCH VỤ MỚI NHẤT CỦA CHÚNG TÔI</p></div>
                  <div class=" email-container">
                    <label><input class="text-content-footer input-email form-control" type="email" placeholder="Email của bạn"></label>
                    <button class="btn btn-success">Gửi</button>
                </div>
              </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    <div class="footer__copyright__text">
                        <p>Bản quyền &copy; 2024 thuộc về Bệnh viện Sáng Tạo <i class="fa fa-heart" aria-hidden="true"></i> by <a href="#" target="_blank">Sáng Tạo Hospital</a></p>
                    </div>
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                </div>
            </div>
        </div>
     </footer>


</body>
</html>
