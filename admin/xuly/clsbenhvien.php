<?php
class benhvien{
    public function connect()
    {
        $host = "localhost";
        $username = "quanlibenhvien";
        $password = "1234";
        $dbname = "qlbenhvien";

        // Kết nối đến cơ sở dữ liệu bằng mysqli
        $con = mysqli_connect($host, $username, $password, $dbname);

        // Kiểm tra kết nối
        if (!$con) {
            echo 'Không kết nối được cơ sở dữ liệu: ' . mysqli_connect_error();
            exit();
        } else {
            // Thiết lập charset UTF-8
            mysqli_set_charset($con, "utf8");
            return $con;
        }
    }
    

}
?>