<?php
    session_start();   
    error_reporting(1);
    if (isset($_SESSION['id']) && isset($_SESSION['hoTen']) && isset($_SESSION['ngaySinh']) && isset($_SESSION['diaChi']) && isset($_SESSION['gioiTinh']) && isset($_SESSION['user']) && isset($_SESSION['email']) && isset($_SESSION['pass']) && isset($_SESSION['quyen'])){
        include("../class/clslogin.php");
        $p = new login();
        // Kiểm tra lại các giá trị session với cơ sở dữ liệu để xác nhận tính hợp lệ
        $p->confirmlogin($_SESSION['id'], $_SESSION['hoTen'],$_SESSION['ngaySinh'],$_SESSION['diaChi'],$_SESSION['gioiTinh'],$_SESSION['user'],$_SESSION['email'],$_SESSION['pass'],$_SESSION['quyen']);
    } else {
        // Nếu thiếu bất kỳ giá trị nào, chuyển hướng đến trang đăng nhập
        header('location:/QLBENHVIEN/index.php?url=dang-nhap');
        exit();
        }

    $hoTen = isset($_SESSION['hoTen']) ? $_SESSION['hoTen'] : '';  
    $ngaySinh = isset($_SESSION['ngaySinh']) ? $_SESSION['ngaySinh'] : '';
    $sdt = isset($_SESSION['user']) ? $_SESSION['user'] : '';
    $email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
    // if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //     $hoTen = isset($_POST['hoTen']) ? $_POST['hoTen'] : $hoTen;
    //     $ngaySinh = isset($_POST['ngaySinh']) ? $_POST['ngaySinh'] : $ngaySinh;
    //     $sdt = isset($_POST['sdt']) ? $_POST['sdt'] : $sdt;
    //     $email = isset($_POST['email']) ? $_POST['email'] : $email;
    // }
?>
<?php

    $pdo = new PDO("mysql:host=localhost;dbname=qlbenhvien", "usertmdt", "passtmdt");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Câu lệnh SQL để lấy các khoa khám
    $sqlKhoa = "SELECT maKhoa, tenKhoa FROM khoakham";
    $stmtKhoa = $pdo->prepare($sqlKhoa);
    $stmtKhoa->execute();
    $khoaKhamList = $stmtKhoa->fetchAll(PDO::FETCH_ASSOC);

    // Câu lệnh SQL để lấy các bác sĩ
    $sqlBacSi = "SELECT maBacSi, tenBacSi FROM bacsi";
    $stmtBacSi = $pdo->prepare($sqlBacSi);
    $stmtBacSi->execute();
    $bacSiList = $stmtBacSi->fetchAll(PDO::FETCH_ASSOC);
   
?>
<?php 

    if (isset($_POST['nut'])) {
    // Tắt thông báo lỗi
        error_reporting(0);

        // Lấy dữ liệu từ form
        $diaChi = $_POST['diaChi'];
        $khoaKham = $_POST['khoaKham'];
        $bacSi = $_POST['bacSi'];
        $ngayKham = $_POST['ngayKham'];
        $gioKham = $_POST['gioKham'];
        $moTa = $_POST['moTa'];
        $hoTen = $_POST['hoTen'];
        $ngaySinh = $_POST['ngaySinh'];
        $sdt = $_POST['sdt'];
        $email = $_POST['email'];

        // Kiểm tra nếu bất kỳ trường nào để trống
        if (empty($hoTen) || empty($ngaySinh) || empty($sdt) || empty($email) || empty($diaChi) || 
            empty($khoaKham) || empty($bacSi) || empty($ngayKham) || empty($gioKham) || empty($moTa)) {
            echo "<script>alert('Vui lòng nhập đầy đủ thông tin trước khi đặt lịch khám.');</script>";
        } else {
            // Kiểm tra ngày giờ hợp lệ
            $currentDate = date('Y-m-d');
            $currentTime = date('H:i');

            if ($ngayKham < $currentDate || ($ngayKham == $currentDate && $gioKham <= $currentTime)) {
                echo "<script>alert('Ngày và giờ đặt lịch phải sau thời gian hiện tại.');</script>";
            } else {
                try {
                    // Kết nối cơ sở dữ liệu
                    $pdo = new PDO("mysql:host=localhost;dbname=qlbenhvien", "usertmdt", "passtmdt");
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Kiểm tra lịch khám trùng giờ cho bác sĩ và ngày
                    $queryCheckLich = $pdo->prepare("
                        SELECT gioKham
                        FROM lichhenkham
                        WHERE maBacSi = ? AND ngayKham = ? AND gioKham = ?
                    ");
                    $queryCheckLich->execute([$bacSi, $ngayKham, $gioKham]);
                    $existingAppointments = $queryCheckLich->fetchAll(PDO::FETCH_ASSOC);

                    if (count($existingAppointments) > 0) {
                        // Nếu giờ đã được đặt
                        echo "<script>alert('Giờ khám đã được đặt cho bác sĩ vào ngày $ngayKham lúc $gioKham. Vui lòng chọn giờ khác.');</script>";
                    } else {
                        // Truy vấn để lấy `maBenhNhan` từ số điện thoại
                        $queryBenhNhan = $pdo->prepare("SELECT maBenhNhan FROM benhnhan WHERE sdt = ?");
                        $queryBenhNhan->execute([$sdt]);
                        $maBenhNhan = $queryBenhNhan->fetchColumn();

                        // Hàm sinh mã ngẫu nhiên bắt đầu bằng 'LH'
                        function generateUniqueCode($pdo) {
                            do {
                                $randomCode = 'LH' . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
                                $queryCheck = $pdo->prepare("SELECT COUNT(*) FROM lichhenkham WHERE maLichHen = ?");
                                $queryCheck->execute([$randomCode]);
                                $exists = $queryCheck->fetchColumn();
                            } while ($exists > 0); // Tiếp tục sinh mã nếu trùng

                            return $randomCode;
                        }

                        // Gọi hàm sinh mã
                        $maLichHen = generateUniqueCode($pdo);

                        // Chèn dữ liệu vào bảng `lichhenkham`
                        $sql = "INSERT INTO lichhenkham (maLichHen, ngayKham, gioKham, moTa, maKhoa, maBacSi, maBenhNhan) 
                                VALUES (?, ?, ?, ?, ?, ?, ?)";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([
                            $maLichHen, // Mã lịch hẹn
                            $ngayKham,  // Ngày khám
                            $gioKham,   // Giờ khám
                            $moTa,      // Mô tả bệnh
                            $khoaKham,  // Mã khoa khám
                            $bacSi,     // Mã bác sĩ
                            $maBenhNhan // Mã bệnh nhân lấy từ bảng `benhnhan`
                        ]);

                        echo "<script>alert('Đặt lịch khám thành công! Mã lịch hẹn: $maLichHen');</script>";
                    }
                } catch (PDOException $e) {
                    echo "Lỗi: " . $e->getMessage();
                }

                // Đóng kết nối
                $pdo = null;
            }
        }
    }

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Chỉnh Sửa Dữ Liệu</title>
<link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/style2.css">
    <script src="../js/datLichKham.js"></script> 
    <script src="../js/datLichKham2.js"></script>
    <script src="../js/locgio.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
	integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" />
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href=".../css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/style_public.css">

    <!-- link -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
<style>
        #ctn {
            margin: 0px auto;
            margin-top: 200px;
            max-width: 800px;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            color: #4a56e2;
        }
        .header h2 {
            font-weight: bold;
        }
        .section-title {
            font-size: 20px;
            font-weight: bold;
            color: #4a56e2;
            margin-top: 20px;
            margin-bottom: 15px;
        }
        .form-control, .form-select {
            border-radius: 10px;
        }
        label{
            color: black;
            font-weight: bold;
        }
        #bt1 {
            margin-left: -200px;
            background-color: #52b788;
            color: white;
            font-size: 16px;
            border: none;
            cursor: pointer;
            padding: 15px;
            width: 100%;
            margin-top: 50px;
        }
        
    </style>
    <script src="js/bootstrap.bundle.min.js"></script>
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
                                <a href="/QLBENHVIEN/index.php?url=dang-xuat">Thoát !</a></li>
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
                                <li><a href="/QLBENHVIEN/index.php?url=thanh-tuu"><h5>THÀNH TỰU</h5></a></li>
                                <li><a href=""><h5>TIN TỨC</h5></a></li>
                                <li><a href=""><h5>BỆNH NHÂN</h5></a>
                                    <ul class="dropdown">
                                        <li><a href="/QLBENHVIEN/public/user/datLichKham.php">Đặt lịch khám</a></li>
                                        <li><a href="/QLBENHVIEN/public/user/xemPhieuKham.php">Xem Phiếu Khám</a></li>
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
    <!-- end header  -->
    <!-- section  -->
    <?php
	$myid=$_REQUEST['id'];
    ?>
    <div id="ctn">
        <div class="header">
            <h2 style="color: #4a56e2;">Đặt Lịch Khám</h2>
            <p>Cảm ơn Quý Khách hàng đã quan tâm đến dịch vụ chăm sóc sức khỏe của Chúng tôi. Vui lòng gửi thông tin chi tiết để chúng tôi có thể sắp xếp cuộc hẹn.</p>
        </div>
        <form action="" method="POST">
            <div class="row">
                <!-- Thông Tin Bệnh Nhân -->
                <div class="col-md-6">
                        <div class="section-title">Thông Tin Bệnh Nhân</div>
                            <div class="mb-3">
                                <label for="fullName" class="form-label">Họ Và Tên</label>
                                <input type="text" class="form-control" name="hoTen" id="fullName" value="<?php echo htmlspecialchars($hoTen); ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="dob" class="form-label">Ngày Sinh</label>
                                <input type="date" class="form-control" name="ngaySinh" id="dob" value="<?php echo htmlspecialchars($ngaySinh); ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Số Điện Thoại</label>
                                <input type="text" class="form-control" name="sdt" id="phone"  value="<?php echo htmlspecialchars($sdt); ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>" readonly> 
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Địa Chỉ</label>
                                <input type="text" class="form-control" name="diaChi" id="address" placeholder="Nhập địa chỉ">
                            </div>
                </div>        
                    <!-- Chọn Lịch Đặt -->
                <div class="col-md-6">
                        <div class="section-title">Chọn Lịch Đặt</div>
                            <div class="mb-3">
                                <label for="department" class="form-label">Khoa Khám</label>
                                <select id="department" name="khoaKham" class="form-select"onchange="filterDoctors()" >
                                <option selected>Chọn khoa khám</option>
                                <?php
                                    foreach ($khoaKhamList as $khoa) {
                                        echo "<option value='" . htmlspecialchars($khoa['maKhoa']) . "'>" . htmlspecialchars($khoa['tenKhoa']) . "</option>";
                                    }
                                ?>
                            </select>
                            </div>
                            <div class="mb-3">
                                <label for="doctor" class="form-label">Bác Sĩ</label>
                                <select id="doctor" name="bacSi" class="form-select">
                                    <option selected>Chọn bác sĩ</option>
                                    <?php
                                        // Lặp qua các bác sĩ và hiển thị dưới dạng các thẻ <option>
                                        // foreach ($bacSiList as $bacSi) {
                                        //     echo "<option value='" . htmlspecialchars($bacSi['maBacSi']) . "'>" . htmlspecialchars($bacSi['tenBacSi']) . "</option>";
                                        // }
                                    ?>
                                </select>
                            </div>
                            <script>
                                function filterDoctors() {
                                    const maKhoa = document.getElementById("department").value;
                                    fetch(`getDoctorsByDepartment.php?maKhoa=${maKhoa}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            console.log(data); // Kiểm tra dữ liệu nhận được
                                            const doctorSelect = document.getElementById("doctor");
                                            doctorSelect.innerHTML = '<option selected>Chọn bác sĩ</option>';
                                            if (data.error) {
                                                console.error(data.error); // Nếu có lỗi, in ra lỗi
                                                return;
                                            }
                                            data.forEach(doctor => {
                                                const option = document.createElement("option");
                                                option.value = doctor.maBacSi;
                                                option.textContent = doctor.tenBacSi;
                                                doctorSelect.appendChild(option);
                                            });
                                        })
                                        .catch(error => console.error("Error fetching doctors:", error));
                                }


                            </script>
                            <div class="mb-3">
                                <label for="appointmentDate" class="form-label">Ngày Khám</label>
                                <input type="date" class="form-control" id="appointmentDate"name="ngayKham" placeholder="mm/dd/yyyy">
                            </div>
                            <div class="mb-3">
                                <label for="appointmentTime" class="form-label">Giờ Khám</label>
                                <select name="gioKham" class="form-select">
                                    <option selected>Chọn giờ khám</option>
                                    <option value="08:00 AM">08:00 AM</option>
                                    <option value="09:00 AM">09:00 AM</option>
                                    <option value="10:00 AM">10:00 AM</option>
                                    <option value="11:00 AM">13:00 AM</option>
                                    <option value="13:30 PM">12:30 PM</option>
                                    <option value="14:30 PM">14:30 PM</option>
                                    <option value="15:30 PM">15:30 PM</option>
                                    <option value="16:30 PM">16:30 PM</option>
                                    <option value="17:30 PM">17:30 PM</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="symptoms" class="form-label">Mô Tả Bệnh</label>
                                <textarea id="symptoms" class="form-control" name="moTa" rows="3" placeholder="Mô tả tình trạng sức khỏe của bạn"></textarea>
                            </div>
                            <button id="bt1" type="submit" name="nut">Đặt lịch khám</button>
                </div>
            </div>
        </form>
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

    <?php 
    require("script.php");
    ?>
</body>
</html>
</body>
</html>