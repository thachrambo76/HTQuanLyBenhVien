<?php        
        class clsbacsi{
            public function connect() {
                $con = new mysqli("localhost", "root", "", "qlbenhvien");

                if ($con->connect_error) {
                    die("Không Kết Nối Được: " . $con->connect_error);
                }
                
                $con->set_charset("utf8");
        
                return $con;
            }
            public function xemBacSi(){
                $link = $this->connect();
                $sql = "SELECT * FROM publicbacsi";
                $result = mysqli_query($link,$sql);
                if ($result->num_rows > 0) {
                    $stt = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="doctor-card">';
                        echo '<img src="public/img/bacsi/' . $row["hinhAnh"] . '" alt="' . $row["tenBacSi"] . '">';
                        echo '<div class="doctor-info">';
                        echo '<div class="doctor-name">' . $row["tenBacSi"] . '</div>';
                        echo '<div class="doctor-title">' . $row["tenKhoa"] .'</br>'. $row["tenBenhVien"] . '</div>';
                        echo '<div class="doctor-desc">' . $row["moTa"] . '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo "<tr><td colspan='7'>Không có dữ liệu</td></tr>";
                }
            }
            
    }
    
    
?>


