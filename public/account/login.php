<?php
  ob_start(); 
  error_reporting(0);
  $p=new login();
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

    <!-- link -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" />
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
    <style>
        .login-container {
            margin: 0px auto;
            background-color: #ffffff;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .header-spacing {
            margin-top: 200px; /* Tạo khoảng cách 50px giữa header và form */
            margin-bottom: 100px;
        }
        .login-container h2 {
            color: #4b72fa;
            font-weight: bold;
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
        .btn-login {
            background-color: #667eea;
            color: #fff;
            font-weight: 600;
            border: none;
            width: 100%;
            height: 45px;
            border-radius: 10px;
            transition: background 0.3s;
        }
        .btn-login:hover {
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
    </style>
<body>

    <!-- section  -->
     <div class="header-spacing" >
        <div class="login-container">
            <h2>Đăng Nhập</h2>
            <p>đơn giản và dễ dàng</p>
            <form id="form1" name="form1" method="post">
                <div class="form-group">
                    <input type="text" class="form-control" id="txtuser" name="txtuser" placeholder="Nhập email hoặc số điện thoại">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="txtpass" id="txtpass" placeholder="Nhập mật khẩu">
                </div>
                <button type="submit" name="nut" id="nut" value="Đăng Nhập" class="btn btn-login">Đăng Nhập</button>
                <div align="center">
                <?php
                switch($_POST['nut']){
                  case 'Đăng Nhập':{
                    $user=$_REQUEST['txtuser'];
                    $pass=$_REQUEST['txtpass'];
                    if($user!='' && $pass!=''){
                      if($p->mylogin($user,$pass)==0){
                        echo 'Sai username hoặc password';
                      }
                    }else{
                      echo 'Vui lòng nhập đầy đủ username và password.';
                    }
                    break;
                  }	
                }
                ?>
                </div>
            </form>
            <div class="footer-links mt-3">
                <a href="/QLBENHVIEN/public/account/forgotpass.php">Quên mật khẩu?</a> | <a href="/QLBENHVIEN/public/account/register.php">Đăng ký tài khoản</a>
            </div>
        </div>
     </div>

</body>
</html>