<?php
include("clsbenhvien.php");
    
    class quantri extends benhvien
    {
        public function fetchAll($query) {
            $conn = $this->connect();
            $result = mysqli_query($conn, $query);
        
            if (!$result) {
                die("Lỗi truy vấn SQL: " . mysqli_error($conn));
            }
        
            $data = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        
            return $data; // Không in ra dữ liệu
        }
        public function xuatdsbenhnhanphutrach($sql) {
            $link = $this->connect();
            $ketqua = mysqli_query($link, $sql);
    
            if (!$ketqua) {
                echo 'Lỗi truy vấn: ' . mysqli_error($link);
                mysqli_close($link);
                return;
            }
    
            if (mysqli_num_rows($ketqua) > 0) {
                echo '<div id="table__danhsach">
                        <div class="row header">
                            <div class="col-4 col-sm-1 stt">STT</div>
                            <div class="col-4 col-lg-2">Mã bệnh nhân</div>
                            <div class="col-4 col-lg-2">Họ và tên</div>
                            <div class="col-4 col-lg-2">Ngày sinh</div>
                            <div class="col-4 col-lg-2">Liên hệ</div>
                            <div class="col-4 col-lg-2">Thao tác</div>
                        </div>';
    
                $dem = 1;
                while ($row = mysqli_fetch_assoc($ketqua)) {
                    echo '<div class="row">
                            <div class="col-4 col-sm-1">' . $dem . '</div>
                            <div class="col-4 col-lg-2">' . htmlspecialchars($row["maBenhNhan"]) . '</div>
                            <div class="col-4 col-lg-2">' . htmlspecialchars($row["tenBenhNhan"]) . '</div>
                            <div class="col-4 col-lg-2">' . htmlspecialchars($row["namSinh"]) . '</div>
                            <div class="col-4 col-lg-2">' . htmlspecialchars($row["sdt"]) . '</div>
                            <div class="col-4 col-lg-2"><button><a href="index.php?quanli=xem-chi-tiet-benh-nhan-phu-trach&id=' . htmlspecialchars($row["maBenhNhan"]) . '">Xem chi tiết</a></button></div>
                        </div>';
                    $dem++;
                }
                echo '</div>';
            } else {
                echo '<p>Không có dữ liệu.</p>';
            }
    
            mysqli_close($link);
        }
        
        public function laycot($sql)
        {
            $link = $this->connect();
            $ketqua = mysqli_query($link, $sql);
            if (!$ketqua) {
                echo 'Lỗi truy vấn: ' . mysqli_error($link);
                mysqli_close($link);
                return null;
            }
            $i = mysqli_num_rows($ketqua);
            $giatri = '';
            if ($i > 0) {
                while ($row = mysqli_fetch_array($ketqua)) {
                    $giatri = $row[0]; 
                }
            }
            mysqli_close($link);
            return $giatri;
        }
        public function themxoasua($sql)
            {
                // Kết nối đến cơ sở dữ liệu bằng mysqli
                $link = $this->connect();
                
                // Kiểm tra kết nối
                if ($link) {
                    // Thực thi câu lệnh SQL sử dụng mysqli_query
                    if (mysqli_query($link, $sql)) {
                        return 1; // Thêm hoặc sửa thành công
                    } else {
                        return 0; // Thực thi thất bại
                    }
                } else {
                    return 0; // Kết nối thất bại
                }
            }

            public function chonthuoc($sql) {
                $link = $this->connect();
                $result = mysqli_query($link, $sql);
                echo '<select class="medicine-name" name="tenThuoc[]" onchange="updateLieuDung(this)">
                        <option value="" selected>Chọn thuốc</option>';
                
                while ($row = mysqli_fetch_array($result)) {
                    $tenThuoc = $row['tenThuoc'];
                    $lieuDung = $row['lieuDung'];
                    echo '<option value="' . $tenThuoc . '" data-lieudung="' . $lieuDung . '">' . $tenThuoc . '</option>';
                }
                echo '</select>';
                mysqli_close($link);
            }
            

        // public function chonlieudung($tenThuoc)
        //     {
        //         // Kết nối cơ sở dữ liệu
        //         $link = $this->connect();

        //         // Truy vấn lấy thông tin liều dùng tương ứng với tên thuốc
        //         $sql = "SELECT lieuDung FROM thuoc WHERE tenThuoc = '$tenThuoc'";
        //         $ketqua = mysqli_query($link, $sql);

        //         // Kiểm tra số dòng trả về
        //         $i = mysqli_num_rows($ketqua);

        //         // Nếu có dữ liệu
        //         if ($i > 0) {
        //             echo '<select class="lieudung" name="lieudung[]">
        //                     <option value="" disabled selected>Chọn liều dùng</option>';

        //             // Duyệt qua từng dòng dữ liệu
        //             while ($row = mysqli_fetch_array($ketqua, MYSQLI_ASSOC)) {
        //                 $lieuDung = $row['lieuDung'];
        //                 echo '<option value="' . $lieuDung . '">' . $lieuDung . '</option>';
        //             }

        //             echo '</select>';
        //         } else {
        //             // Nếu không có dữ liệu
        //             echo '<select class="lieudung" name="lieudung[]">
        //                     <option value="" disabled selected>Không có liều dùng</option>
        //                 </select>';
        //         }
        //     }

        public function generateUniqueMaDonThuoc() {
            do {
                $maDonThuoc = 'DT' . rand(100000, 999999); // Tạo mã ngẫu nhiên
                $checkQuery = "SELECT COUNT(*) as count FROM donthuoc WHERE maDonThuoc = '$maDonThuoc'";
                $connection = $this->connect(); // Kết nối cơ sở dữ liệu
                $result = mysqli_query($connection, $checkQuery);
                $row = mysqli_fetch_assoc($result);
            } while ($row['count'] > 0); // Nếu tồn tại, tạo lại mã khác
            return $maDonThuoc;
        }
        
        public function xemchitietbenhnhan($sql) {
            $link = $this->connect();  // Keep connection open
        
            // Execute the query to get patient details
            $ketqua = mysqli_query($link, $sql);
            if (!$ketqua) {
                echo 'Lỗi truy vấn: ' . mysqli_error($link);
                mysqli_close($link);
                return;
            }
        
            $i = mysqli_num_rows($ketqua);
        
            if ($i > 0) {
                // Fetch the patient details (single record)
                $row = mysqli_fetch_assoc($ketqua);
                $mabenhnhan = $row["maBenhNhan"];
                $tenBenhNhan = $row["tenBenhNhan"];
                $namSinh = $row["namSinh"];
                $gioiTinh = $row["gioiTinh"];
                $diaChi = $row["diaChi"];
                $ngayTao = $row["ngayTao"];
                $tinhTrangBenh = $row["tinhTrangBenh"];
                $chanDoan = $row["chanDoan"];
                $keHoachDieuTri = $row["keHoachDieuTri"];
        
                // Display patient details
                echo '<div id="thongtin__mabn"><span>Mã bệnh nhân: </span> <p>'.$mabenhnhan.'</p></div>
                      <div id="thongtin__hoten"><span>Họ và Tên: </span><p>'.$tenBenhNhan.'</p></div>
                      <div id="thongtin__ngaysinh"><span>Ngày sinh: </span><p>'.$namSinh.'</p></div>
                      <div id="thongtin__gioitinh"><span>Giới tính:</span> <p>'.$gioiTinh.'</p></div>
                      <div id="thongtin__diachi"><span>Địa chỉ: </span><p>'.$diaChi.'</p></div>
                      <div id="thongtin__ngaykham"><span>Ngày khám: </span><p>'.$ngayTao.'</p></div>
                      <div id="thongtin__tinhtrangbenh"><span>Tình trạng bệnh: </span><p>'.$tinhTrangBenh.'</p></div>
                      <div id="thongtin__chandoan"><span>Chẩn đoán: </span><p>'.$chanDoan.'</p></div>
                      <div id="thongtin__kehoachdieutri"><span>Kế hoạch điều trị: </span><p>'.$keHoachDieuTri.'</p></div>';
        
                // Fetch the medical history (multiple records)
                $sql_history = "SELECT maPhieuKham, ngayTao, tinhTrangBenh 
                                FROM phieukham 
                                WHERE maBenhNhan = '$mabenhnhan' 
                                ORDER BY ngayTao DESC";
                $history_result = mysqli_query($link, $sql_history);
        
                if ($history_result && mysqli_num_rows($history_result) > 0) {
                    echo '<div id="thongtin__lichsukhambenh"><span>Lịch sử khám: </span><div class="history-list">';
                    while ($history_row = mysqli_fetch_assoc($history_result)) {
                        $ngayTaoHistory = $history_row["ngayTao"];
                        $tinhTrangBenhHistory = $history_row["tinhTrangBenh"];
                        $maPhieuKham = $history_row["maPhieuKham"]; // Get maPhieuKham
        
                        // Format the date
                        $ngayTaoFormatted = date('d-m-y', strtotime($ngayTaoHistory));
        
                        // Use maPhieuKham in the link
                        echo '<div class="history-item">
                                <a href="index.php?quanli=xem-chi-tiet-benh-nhan-phu-trach&id='.$maPhieuKham.'">
                                    '.$ngayTaoFormatted.'&nbsp;&nbsp;&nbsp;'.$tinhTrangBenhHistory.'
                                </a>
                              </div>';
                    }
                    echo '</div></div>';
                } else {
                    echo '<div id="thongtin__lichsu"><span>Lịch sử khám: </span><p>Không có dữ liệu lịch sử khám.</p></div>';
                }
            } else {
                echo 'Không có dữ liệu';
            }
        
            // Close the connection after all queries are executed
            mysqli_close($link);
        }
        
        
        

        public function xemthongkedoanhthu($sql) {
            // Kết nối cơ sở dữ liệu
            $link = $this->connect();
            
            // Kiểm tra kết nối
            if (!$link) {
                echo 'Lỗi kết nối cơ sở dữ liệu: ' . mysqli_connect_error();
                return;
            }
        
            // Thực thi truy vấn
            $ketqua = mysqli_query($link, $sql);
        
            // Kiểm tra lỗi trong quá trình thực thi truy vấn
            if (!$ketqua) {
                echo 'Lỗi truy vấn: ' . mysqli_error($link);
                mysqli_close($link);
                return;
            }
        
            // Mảng lưu kết quả
            $results = [];
            while ($row = mysqli_fetch_assoc($ketqua)) {
                $results[] = $row;
            }
        
            mysqli_close($link);
        
            return $results;
        }

        public function tinhTongTien($sql) {
            // Kết nối cơ sở dữ liệu
            $link = $this->connect();
            
            // Thực thi câu truy vấn
            $ketqua = mysqli_query($link, $sql);
            
            // Kiểm tra lỗi truy vấn
            if (!$ketqua) {
                echo 'Lỗi truy vấn: ' . mysqli_error($link);
                mysqli_close($link);
                return;
            }
        
            $tongTien = 0;  
        
            // Tính tổng tiền từ các hóa đơn
            while ($row = mysqli_fetch_assoc($ketqua)) {
                $tienDichVu = $row["tienDichVu"];
                $tienThuoc = $row["tienThuoc"];
                // Cộng dồn tổng tiền
                $tongTien += $tienDichVu+ $tienThuoc;  
            }
        
            // Đóng kết nối
            mysqli_close($link);
        
            // Hiển thị tổng doanh thu
            echo '<div id="title__tongtien"><strong>Tổng doanh thu: <p>' . number_format($tongTien, 0, ',', '.') . 'đ</p></strong></div>';
        }

        public function laymabenhnhan($sql){
            $link = $this->connect();  // Keep connection open
        
            // Execute the first query for patient details
            $ketqua = mysqli_query($link, $sql);
            if (!$ketqua) {
                echo 'Lỗi truy vấn: ' . mysqli_error($link);
                mysqli_close($link);
                return;
            }
        
            $i = mysqli_num_rows($ketqua);
        
            if ($i > 0) {
                // Fetch the patient details (single record)
                $row = mysqli_fetch_assoc($ketqua);
                $mabenhnhan = $row["maBenhNhan"];
                $tenBenhNhan = $row["tenBenhNhan"];
                $namSinh = $row["namSinh"];
                $gioiTinh = $row["gioitinh"];
                $sodienthoai = $row["sdt"];
                $diaChi = $row["diaChi"];
                
        
                
                echo '<div id="phieukham__mabn"><span>Mã bệnh nhân :</span> 
                    <input name="txtmabenhnhan" id="txtmabenhnhan" type="text" value="'.$mabenhnhan.'">
                    <button type="button" id="checkPatient">Kiểm tra</button>
                    <span id="checkResult"></span> <!-- Hiển thị kế t quả kiểm tra -->
                </div>
                
                <div id="phieukham__hoten"><span>Họ và tên :</span>
                    <input name="txttenbenhnhan" id="txttenbenhnhan" type="text" value="'.$tenBenhNhan.'" readonly>
                </div>
                
                <div id="phieukham__ngaysinh"><span>Ngày sinh :</span>
                    <input name="txtngaysinh" id="txtngaysinh" type="date" value="'.$namSinh.'" readonly>
                </div>
                
                <div id="phieukham__gioitinh">
                    <span>Giới tính:</span>
                    <input type="radio" id="nam" name="gioitinh" value="Nam" '.($gioiTinh == 'Nam' ? 'checked' : '').' disabled>
                    <label for="nam">Nam</label>
                    <input type="radio" id="nu" name="gioitinh" value="Nữ" '.($gioiTinh == 'Nữ' ? 'checked' : '').' disabled>
                    <label for="nu">Nữ</label>
                </div>
                
                <div id="phieukham__sodienthoai"><span>Số điện thoại :</span>
                    <input name="txtsdt" id="txtsdt" type="number" value="'.$sodienthoai.'" readonly>
                </div>
                
                <div id="phieukham__diachi"><span>Địa chỉ :</span>
                    <textarea name="txtdiachi" id="txtdiachi" readonly>'.$diaChi.'</textarea>
                </div>';

        
            } else {
                echo 'Không có dữ liệu';
            }
        
            // Close the connection after all queries are executed
            mysqli_close($link);
        }


        public function doanhthuDasboard($sql) {
            // Kết nối cơ sở dữ liệu
            $link = $this->connect();
            
            // Thực thi câu truy vấn
            $ketqua = mysqli_query($link, $sql);
            
            // Kiểm tra lỗi truy vấn
            if (!$ketqua) {
                echo 'Lỗi truy vấn: ' . mysqli_error($link);
                mysqli_close($link);
                return;
            }
        
            $tongTien = 0;  
        
            // Tính tổng tiền từ các hóa đơn
            while ($row = mysqli_fetch_assoc($ketqua)) {
                $tienDichVu = $row["tienDichVu"];
               
                $tienThuoc = $row["tienThuoc"];
               
                // Cộng dồn tổng tiền
                $tongTien += $tienDichVu  + $tienThuoc;  
            }
        
            // Đóng kết nối
            mysqli_close($link);
        
            // Hiển thị tổng doanh thu
            echo '' . number_format($tongTien, 0, ',', '.') . 'đ';
        }


        public function tinhTongBenhNhan($sql) {
            // Kết nối cơ sở dữ liệu
            $link = $this->connect();
            
            // Thực thi câu truy vấn
            $ketqua = mysqli_query($link, $sql);
            
            // Kiểm tra lỗi truy vấn
            if (!$ketqua) {
                echo 'Lỗi truy vấn: ' . mysqli_error($link);
                mysqli_close($link);
                return;
            }
        
            // Lấy tổng số bệnh nhân từ kết quả truy vấn
            $tongBenhNhan = 0;
            if ($row = mysqli_fetch_assoc($ketqua)) {
                $tongBenhNhan = $row["totalPatients"];
            }
            
            // Đóng kết nối
            mysqli_close($link);
            
            // Hiển thị tổng số bệnh nhân
            echo $tongBenhNhan;
        }
       
        public function tinhTongLichHen($sql) {
            
            $link = $this->connect();
            
            
            $ketqua = mysqli_query($link, $sql);
            
            
            if (!$ketqua) {
                echo 'Lỗi truy vấn: ' . mysqli_error($link);
                mysqli_close($link);
                return;
            }
        
            // Lấy tổng số bệnh nhân từ kết quả truy vấn
            $tongLichHen = 0;
            if ($row = mysqli_fetch_assoc($ketqua)) {
                $tongLichHen = $row["totalLichHen"];
            }
            
            
            mysqli_close($link);
            
            // Hiển thị tổng số bệnh nhân
            echo $tongLichHen;
        }
    }


    
    
?>