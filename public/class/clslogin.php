<?php
// error_reporting(0);
session_start();
ob_start();
class login {
    private $con;

    public function connectlogin() {
        // Sử dụng `mysqli` để kết nối
        $this->con = new mysqli("localhost", "usertmdt", "passtmdt", "qlbenhvien");
        
        // Kiểm tra lỗi kết nối
        if ($this->con->connect_error) {
            die("Không Kết Nối Được: " . $this->con->connect_error);
        }

        // Thiết lập mã hóa UTF-8
        $this->con->set_charset("utf8");

        return $this->con;
    }
    
    public function mylogin($user, $pass) {
        $pass = md5($pass);
        $sql = "SELECT maUser, hoTen, ngaySinh, diaChi, gioiTinh, sdt, email, password, quyen FROM user WHERE sdt=? AND password=? LIMIT 1";

        // Chuẩn bị câu truy vấn với prepared statement để ngăn chặn SQL Injection
        $stmt = $this->connectlogin()->prepare($sql);
        $stmt->bind_param("ss", $user, $pass);
        $stmt->execute();
        
        // Lấy kết quả trả về
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $_SESSION['id'] = $row['maUser'];
            $_SESSION['hoTen'] = $row['hoTen'];
            $_SESSION['ngaySinh'] = $row['ngaySinh'];
            $_SESSION['diaChi'] = $row['diaChi'];
            $_SESSION['gioiTinh'] = $row['gioiTinh'];          
            $_SESSION['user'] = $row['sdt'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['pass'] = $row['password'];
            $_SESSION['quyen'] = $row['quyen'];          
            
            // Chuyển hướng dựa trên quyền
            if ($row['quyen'] == 1) {
                header('Location: ../QLBENHVIEN/admin/'); // Trang quản trị viên
            }elseif ($row['quyen'] == 0) {
                header('Location:/QLBENHVIEN/public/user/datLichKham.php'); // Trang người dùng
            }
        } else {
            return 0; // Không tìm thấy tài khoản
        }
    }

    public function confirmlogin($id, $hoTen, $ngaySinh, $diaChi, $gioiTinh, $user, $email, $pass, $quyen) {
        $sql = "SELECT maUser FROM user WHERE maUser=? AND hoTen=? AND ngaySinh=? AND diaChi=? AND gioiTinh=? AND sdt=? AND email=? AND password=? AND quyen=? LIMIT 1";

        // Chuẩn bị câu truy vấn
        $stmt = $this->connectlogin()->prepare($sql);
        $stmt->bind_param("isssssssi", $id, $hoTen, $ngaySinh, $diaChi, $gioiTinh, $user, $email, $pass, $quyen);

        $stmt->execute();
        
        // Lấy kết quả trả về
        $result = $stmt->get_result();
        if ($result->num_rows != 1) {
            header('location:../login/');
        }
    }  
}
?>
