<?php
class quantri
{
    private $con;

    public function connect() {
        // Kết nối cơ sở dữ liệu bằng mysqli
        $this->con = new mysqli("localhost", "usertmdt", "passtmdt", "qlbenhvien");

        // Kiểm tra lỗi kết nối
        if ($this->con->connect_error) {
            die("Không Kết Nối Được: " . $this->con->connect_error);
        }

        // Thiết lập mã hóa UTF-8
        $this->con->set_charset("utf8");

        return $this->con;
    }
    public function xuatdsbacsi($sql){
        // Kết nối đến cơ sở dữ liệu
        $link = $this->connect();  // Giả sử connect() đã sử dụng mysqli để kết nối
        
        // Thực hiện truy vấn
        $ketqua = mysqli_query($link, $sql);
        
        // Kiểm tra số dòng trả về
        if(mysqli_num_rows($ketqua) > 0){
            // Duyệt qua kết quả trả về
            while($row = mysqli_fetch_array($ketqua, MYSQLI_ASSOC)){
                $makhoa = $row['makhoa']; // Mã khoa
                $tenbacsi = $row['tenbacsi']; // Tên bác sĩ
                echo '<a id="link" href="?makhoa=' . $makhoa . '">' . $tenbacsi . '</a>';
                echo '<br>';
            }
        } else {
            echo 'Danh sách bác sĩ đang cập nhật';
        }
        
        // Đóng kết nối
        mysqli_close($link);
    }
    
    
}
?>
