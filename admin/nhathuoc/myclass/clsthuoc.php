<?php        
        class clsthuoc{
            public function connect() {
                $con = new mysqli("localhost", "root", "", "qlbenhvien");

                if ($con->connect_error) {
                    die("Không Kết Nối Được: " . $con->connect_error);
                }

                $con->set_charset("utf8");
        
                return $con;
            }
            public function timKiemThuoc($sql){
                $link = $this->connect();
                $result = mysqli_query($link,$sql);
            
                $kq = [];
                while ($row = mysqli_fetch_assoc($result)) {
                    $kq[] = $row;
                }
                mysqli_close($link);
                return $kq;
            }
            public function xemThuocTonKho(){
                $link = $this->connect();
                $sql = "SELECT * FROM thuoc";
                $result = mysqli_query($link,$sql);
                if ($result->num_rows > 0) {
                    $stt = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $stt++ . "</td>";
                        echo "<td>" . $row['maThuoc'] . "</td>";
                        echo "<td>" . $row['tenThuoc'] . "</td>";
                        echo "<td>" . $row['soLuong'] . " hộp</td>";
                        echo "<td>" . number_format($row['giaTien'], 0, ',', '.') . " VND</td>";
                        echo "<td>" . $row['lieuDung'] . "</td>";
                        echo '<td><a href="index.php?quanli=xem-thong-tin-thuoc&id='.$row['maThuoc'].'" ><button class="button"><span style="color:white;">Xem</span></button></a></td>';
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Không có dữ liệu</td></tr>";
                }
            }
            public function xemthongtinthuoc($sql){
                $link = $this->connect();
                $result = mysqli_query($link,$sql);
                $i = mysqli_num_rows($result);
                if($i>0){
                    echo '<h2>Thông tin thuốc</h2>';
                    while($row=mysqli_fetch_array($result))
                    {
                        echo "<img src='nhathuoc/hinh/".$row['hinhAnh']."' width='300' height='200'>";
                        echo "<p><strong>Mã thuốc:</strong> ".$row['maThuoc']."</p>";
                        echo "<p><strong>Tên thuốc:</strong> ".$row['tenThuoc']."</p>";
                        echo "<p><strong>Số lượng tồn kho:</strong> ".$row['soLuong']." hộp</p>";
                        echo "<p><strong>Giá tiền:</strong> ".number_format($row['giaTien'], 0, ',', '.')." VNĐ</p>";
                        echo "<p><strong>Liều dùng:</strong> ".$row['lieuDung']."</p>";
                        echo "<p><strong>Ngày sản xuất:</strong> ".$row['ngaySanXuat']."</p>";
                        echo "<p><strong>Hạn sử dụng:</strong> ".$row['hanSuDung']."</p>";
                    }
                }
            }
            public function baoCaoTonKho(){
                $link = $this->connect();
                $sql = "SELECT * FROM thuoc";
                $result = mysqli_query($link,$sql);
                if ($result->num_rows > 0) {
                    $stt = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $stt++ . "</td>";
                        echo "<td>" . $row['maThuoc'] . "</td>";
                        echo "<td>" . $row['tenThuoc'] . "</td>";
                        echo "<td>" . $row['soLuong'] . " hộp</td>";
                        echo "<td>" . number_format($row['giaTien'], 0, ',', '.') . " VND</td>";
                        echo "<td>" . $row['lieuDung'] . "</td>";
                        echo "<td>" . $row['hanSuDung'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Không có dữ liệu</td></tr>";
                }
            }
            public function thongTinTonKho(){
                $link = $this->connect();
                $sql = "SELECT * FROM thuoc";
                $result = mysqli_query($link,$sql);
            }
            public function baoCaoHetHan(){
                $link = $this->connect();
                $sql = "SELECT * FROM thuoc order by hanSuDung ASC";
                $result = mysqli_query($link,$sql);
                if ($result->num_rows > 0) {
                    $stt = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $stt++ . "</td>";
                        echo "<td>" . $row['maThuoc'] . "</td>";
                        echo "<td>" . $row['tenThuoc'] . "</td>";
                        echo "<td>" . $row['soLuong'] . " hộp</td>";
                        echo "<td>" . number_format($row['giaTien'], 0, ',', '.') . " VND</td>";
                        echo "<td>" . $row['hanSuDung'] . "</td>";
                        echo '<td style="text-align: center;"><a href="index.php?quanli=thong-tin-het-han&id='.$row['maThuoc'].'" style="color:white;"><button class="button btn-primary">Tạo</button></a></td>';
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Không có dữ liệu</td></tr>";
                }
            }
            public function thongTinHetHan($sql){
                $link = $this->connect();
                $result = mysqli_query($link,$sql);
                $i = mysqli_num_rows($result);
                if($i>0){
                    echo '<h2>Thông tin thuốc</h2>';
                    while($row=mysqli_fetch_array($result))
                    {
                        echo "<img src='nhathuoc/hinh/".$row['hinhAnh']."' width='300' height='200'>";
                        echo "<p><strong>Mã thuốc:</strong> ".$row['maThuoc']."</p>";
                        echo "<p><strong>Tên thuốc:</strong> ".$row['tenThuoc']."</p>";
                        echo "<p><strong>Số lượng tồn kho:</strong> ".$row['soLuong']." hộp</p>";
                        echo "<p><strong>Giá tiền:</strong> ".number_format($row['giaTien'], 0, ',', '.')." VNĐ</p>";
                        echo "<p><strong>Liều dùng:</strong> ".$row['lieuDung']."</p>";
                        echo "<p><strong>Ngày sản xuất:</strong> ".$row['ngaySanXuat']."</p>";
                        echo "<p><strong>Hạn sử dụng:</strong> ".$row['hanSuDung']."</p>";
                        echo "<p><strong>Ghi chú:</strong><br><textarea name='text' id='text' cols='60' rows='4'></textarea> </p>";
                    }
                }
            }
    }
    
    
?>


