<?php
session_start();
error_reporting(1);

// Kiểm tra nếu tất cả thông tin session tồn tại
if (isset($_SESSION['id']) && isset($_SESSION['hoTen']) && isset($_SESSION['ngaySinh']) && isset($_SESSION['diaChi']) && isset($_SESSION['gioiTinh']) && isset($_SESSION['user']) && isset($_SESSION['email']) && isset($_SESSION['pass']) && isset($_SESSION['quyen'])) {
    include("../class/clslogin.php");
    $p = new login();
    // Xác thực session với cơ sở dữ liệu
    $p->confirmlogin($_SESSION['id'], $_SESSION['hoTen'], $_SESSION['ngaySinh'], $_SESSION['diaChi'], $_SESSION['gioiTinh'], $_SESSION['user'], $_SESSION['email'], $_SESSION['pass'], $_SESSION['quyen']);
} else {
    // Chuyển hướng đến trang đăng nhập nếu thiếu session
    header('location:/QLBENHVIEN/index.php?url=dang-nhap');
    exit();
}

// Lấy thông tin từ session
$hoTen = isset($_SESSION['hoTen']) ? $_SESSION['hoTen'] : '';
$ngaySinh = isset($_SESSION['ngaySinh']) ? $_SESSION['ngaySinh'] : '';
$sdt = isset($_SESSION['user']) ? $_SESSION['user'] : '';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';

// Kết nối cơ sở dữ liệu
$host = 'localhost'; // Thay bằng thông tin của bạn
$db = 'qlbenhvien';
$user = 'usertmdt';
$pass = 'passtmdt';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
// Truy vấn để lấy mã bệnh nhân từ số điện thoại
$sql = "SELECT maBenhNhan FROM benhnhan WHERE sdt = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $sdt); // Sử dụng số điện thoại trong session
$stmt->execute();
$result = $stmt->get_result();

// Kiểm tra và lấy mã bệnh nhân
$maBenhNhan = ''; // Khởi tạo biến $maBenhNhan
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $maBenhNhan = $row['maBenhNhan']; // Lưu giá trị maBenhNhan vào biến $maBenhNhan
} else {
    echo "Không tìm thấy bệnh nhân với số điện thoại này!";
    exit;
}
// Truy vấn để lấy lịch sử khám của bệnh nhân (bao gồm bác sĩ và ngày khám)
$sql = "SELECT pk.maPhieuKham, bs.tenBacSi, pk.ngayTao
        FROM phieukham pk 
        JOIN bacsi bs ON pk.maBacSi = bs.maBacSi 
        WHERE pk.maBenhNhan = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $maBenhNhan); // Sử dụng maBenhNhan từ session
$stmt->execute();
$result = $stmt->get_result();

// Kiểm tra kết quả
if ($result->num_rows > 0) {
    $history = [];
    while ($row = $result->fetch_assoc()) {
        $history[] = $row;
    }
} else {
    $history = null;
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
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f7f9fc;
            }
            .container {
                max-width: 1000px;
                margin: 20px auto;
                padding: 20px;
                background-color: #fff;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            .header-title h1 {
                text-align: center;
                color: #4A63E7;
            }
            .info-section {
                background-color: #f2f2f2;
                padding: 20px;
                margin: 20px 0;
                border-radius: 8px;
            }
            .info-section p {
                margin: 5px 0;
                color: #333;
            }
            .table-container {
                overflow-x: auto;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 10px;
            }
            table, th, td {
                border: 1px solid #ddd;
            }
            th, td {
                padding: 10px;
                text-align: center;
            }
            th {
                background-color: #4A63E7;
                color: #fff;
            }
            .action-button {
                background-color: #4A63E7;
                color: white;
                padding: 8px 12px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                margin: 2px;
            }
            .action-button:hover {
                background-color: #3b51c8;
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
        <div class="container" style="margin-top: 150px;">
            <div class="header-title">
                <h1>Xem Phiếu Khám</h1>
                <p style="color: #4A63E7;text-align: center;">Vui lòng điền đầy đủ thông tin!</p>
            </div>
            <div class="info-section">
                <div class="row" style="font-size: 1.3em; line-height: 1.8; font-family: 'Roboto', sans-serif; color: #333;">
                    <div class="mb-2">
                        <strong>Họ Và Tên:</strong> <?php echo htmlspecialchars($hoTen); ?>
                    </div>
                    <div class="mb-2">
                        <strong>Ngày Sinh:</strong> <?php echo htmlspecialchars($ngaySinh); ?>
                    </div>
                    <div class="mb-2">
                        <strong>Số Điện Thoại:</strong> <?php echo htmlspecialchars($sdt); ?>
                    </div>
                    <div class="mb-2">
                        <strong>Email:</strong> <?php echo htmlspecialchars($email); ?>
                    </div>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Mã Phiếu Khám/Tên Bác Sĩ</th>
                                <th>Ngày Khám</th>
                                <th>Chức Năng</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if ($history !== null && count($history) > 0): ?>
                            <?php foreach ($history as $index => $record): ?>
                                <tr>
                                    <td><?php echo $index + 1; ?></td>
                                    <td><?php echo htmlspecialchars($record['maPhieuKham']) . ' - ' . htmlspecialchars($record['tenBacSi']); ?></td>
                                    <td><?php echo htmlspecialchars($record['ngayTao']); ?></td>
                                    <td>
                                        <a href="chi-tiet.php?maPhieuKham=<?php echo urlencode($record['maPhieuKham']); ?>" class="btn btn-detail">Xem Chi Tiết</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4">Không có lịch sử khám nào.</td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>

        </div>
    </body>
    </html>
