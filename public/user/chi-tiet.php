<?php
    session_start();
    error_reporting(1);

    // Kiểm tra đăng nhập
    if (!isset($_SESSION['id']) || !isset($_SESSION['hoTen']) || !isset($_SESSION['user'])) {
        header('location:/QLBENHVIEN/index.php?url=dang-nhap');
        exit();
    }

    // Kết nối cơ sở dữ liệu
    $host = 'localhost'; // Thay thông tin của bạn
    $db = 'qlbenhvien';
    $user = 'usertmdt';
    $pass = 'passtmdt'; 

    $conn = new mysqli($host, $user, $pass, $db);
    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    // Lấy mã phiếu khám từ URL
    if (isset($_GET['maPhieuKham'])) {
        $maPhieuKham = $_GET['maPhieuKham'];

        // Truy vấn thông tin chi tiết từ mã phiếu khám
        $sql = "SELECT pk.maPhieuKham, bn.tenBenhNhan, bs.tenBacSi, pk.tinhTrangBenh, pk.chanDoan, pk.keHoachDieuTri, pk.maDonThuoc, pk.ghiChu, pk.ngayTao
                FROM phieukham pk
                JOIN benhnhan bn ON pk.maBenhNhan = bn.maBenhNhan
                JOIN bacsi bs ON pk.maBacSi = bs.maBacSi
                WHERE pk.maPhieuKham = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $maPhieuKham);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $chiTietPhieuKham = $result->fetch_assoc();
        } else {
            echo "Không tìm thấy thông tin cho mã phiếu khám này!";
            exit();
        }
    } else {
        echo "Không có mã phiếu khám!";
        exit();
    }

    $conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xem Phiếu Khám</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href=".../css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/style_public.css">
</head>
<style>
    body {
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f7f9fc;
        color: #333;
        justify-content: center; /* Căn giữa theo chiều ngang */
    }

    .container {
        margin: auto 0px;
        max-width: 800px;
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    h1 {
        
        text-align: center;
        color: #4A63E7;
        font-size: 35px;
    }

    .info-section {
        margin: 20px 0;
        margin: 0 auto;
        padding: 15px;
        background-color: #f1f4f9;
        border-radius: 8px;
    }

    table {
        width: 600px; /* Set the width of the table */
        margin: 0 auto; /* Center the table horizontally */
        border-collapse: collapse;
        margin-top: 20px;
        font-size: 16px;
    }

    table th, table td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
    }

    table th {
        background-color: #4A63E7;
        color: #fff;
        font-weight: bold;
    }

    table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    table tr:hover {
        background-color: #eaeaea;
    }

    table td {
        font-size: 16px;
        color: #555;
    }

    .btn {
        text-align: center;
        display: inline-block;
        text-decoration: none;
        padding: 10px 20px;
        color: #fff;
        background-color: #4A63E7;
        border-radius: 5px;
        text-align: center;
        font-size: 16px;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }
    .btn-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh; /* Chiều cao của toàn bộ trang */
    }



    .btn:hover {
        background-color: #2b43b8;
    }

    .note {
        font-size: 14px;
        color: #666;
        margin-top: 20px;
        text-align: center;
    }
    #button-container {
        display: flex;
        justify-content: center;
        margin-top: 20px; /* Tùy chỉnh khoảng cách từ nút đến phần tử khác */
    }

    #button-container .btn {
        padding: 10px 20px; /* Tùy chỉnh kích thước nút */
        font-size: 16px;
        text-align: center;
    }
        #color{
            box-sizing: border-box;
            margin: 0 auto;
            width: 700px;
            height: 700px;
            color: #555; 
            
        }

</style>
<body>
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
    <div id="container" style="margin-top:200px;">
        <div id="color">
            <h1>Xem Phiếu Khám</h1>
            <div class="info-section" style="border: 1px solid #ddd;">
                <table >
                    <tr>
                        <th style="width: 30%;">Mã Phiếu Khám</th>
                        <td><?php echo htmlspecialchars($chiTietPhieuKham['maPhieuKham']); ?></td>
                    </tr>
                    <tr>
                        <th>Tên Bệnh Nhân</th>
                        <td><?php echo htmlspecialchars($chiTietPhieuKham['tenBenhNhan']); ?></td>
                    </tr>
                    <tr>
                        <th>Tên Bác Sĩ</th>
                        <td><?php echo htmlspecialchars($chiTietPhieuKham['tenBacSi']); ?></td>
                    </tr>
                    <tr>
                        <th>Tình Trạng Bệnh</th>
                        <td><?php echo htmlspecialchars($chiTietPhieuKham['tinhTrangBenh']); ?></td>
                    </tr>
                    <tr>
                        <th>Chẩn Đoán</th>
                        <td><?php echo htmlspecialchars($chiTietPhieuKham['chanDoan']); ?></td>
                    </tr>
                    <tr>
                        <th>Kế Hoạch Điều Trị</th>
                        <td><?php echo htmlspecialchars($chiTietPhieuKham['keHoachDieuTri']); ?></td>
                    </tr>
                    <tr>
                        <th>Mã Đơn Thuốc</th>
                        <td><?php echo htmlspecialchars($chiTietPhieuKham['maDonThuoc']); ?></td>
                    </tr>
                    <tr>
                        <th>Ghi Chú</th>
                        <td><?php echo htmlspecialchars($chiTietPhieuKham['ghiChu']); ?></td>
                    </tr>
                    <tr>
                        <th>Ngày Tạo</th>
                        <td><?php echo htmlspecialchars($chiTietPhieuKham['ngayTao']); ?></td>
                    </tr>
                </table>
                <div id="button-container">
                    <a href="/QLBENHVIEN/public/user/xemPhieuKham.php" class="btn btn-primary">Quay Lại</a>
                </div>
            </div>
        </div>
        <p class="note">*Lưu ý: Thuốc không thể tự ý mua ở ngoài</p>
</div>

    </div>
</body>
</html>
