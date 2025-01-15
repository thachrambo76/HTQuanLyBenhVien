<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên Mật Khẩu</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #667eea, #764ba2);
            font-family: Arial, sans-serif;
        }
        .forgot-container {
            background-color: #ffffff;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .forgot-container h2 {
            color: #333;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .form-group label {
            font-weight: 600;
            color: #555;
        }
        .form-control {
            height: 45px;
            border-radius: 10px;
            border: 1px solid #ddd;
            padding-left: 15px;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #667eea;
        }
        .btn-reset {
            background-color: #667eea;
            color: #fff;
            font-weight: 600;
            border: none;
            width: 100%;
            height: 45px;
            border-radius: 10px;
            transition: background 0.3s;
        }
        .btn-reset:hover {
            background-color: #5a67d8;
        }
        .footer-links {
            margin-top: 20px;
        }
        .footer-links a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
        .footer-links a:hover {
            text-decoration: underline;
        }
        .alert {
            margin-top: 15px;
            display: none;
            font-weight: 600;
        }
        .alert-success {
            color: green;
        }
        .alert-danger {
            color: red;
        }
    </style>
</head>
<body>
    <div class="forgot-container">
        <h2>Quên Mật Khẩu</h2>
        <p>Nhập email hoặc số điện thoại để đặt lại mật khẩu</p>
        <form onsubmit="return handleSubmit(event)">
            <div class="form-group">
                <label for="emailOrPhone">Email hoặc Số điện thoại</label>
                <input type="text" class="form-control" id="emailOrPhone" placeholder="Nhập email hoặc số điện thoại">
            </div>
            <button type="submit" class="btn btn-reset">Gửi Yêu Cầu</button>
            <div id="alert-success" class="alert alert-success">Đã gửi mã xác thực!</div>
            <div id="alert-fail" class="alert alert-danger">Thông tin không hợp lệ. Vui lòng kiểm tra lại!</div>
        </form>
        <div class="footer-links mt-3">
            <a href="/HTQuanLyBenhVien-master/index.php?url=dang-nhap">Quay lại Đăng Nhập</a>
        </div>
    </div>

    <script src="../js/bootstrap.bundle.min.js"></script>
    <script>
        function validateInput(input) {
    // Kiểm tra email
    const emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
    // Kiểm tra số điện thoại
    const phoneRegex = /^\d{10,11}$/;
    return emailRegex.test(input) || phoneRegex.test(input);
    }

function handleSubmit(event) {
    event.preventDefault();
    const input = document.getElementById("emailOrPhone").value;
    const alertSuccess = document.getElementById("alert-success");
    const alertFail = document.getElementById("alert-fail");

    if (validateInput(input)) {
        // Nếu thành công, hiển thị thông báo thành công
        alertSuccess.style.display = "block";
        alertFail.style.display = "none";
    } else {
        // Nếu thất bại, hiển thị thông báo thất bại
        alertSuccess.style.display = "none";
        alertFail.style.display = "block";
    }
    }

    </script>
</body>
</html>
