<?php
    error_reporting(1);
    include("./xuly/clsquantri.php");
    $p = new quantri();
    $maBenhNhan = $_REQUEST["idht"];
    
?>

<div class="taoPhieuKham">
    <section class="container-fluid pt-4 px-4">
        <div class="bg-light text-center rounded p-4">
            <form method="post" enctype="multipart/form-data" name="form1" id="form1">
                <h4 id="title_taophieukham">Tạo Phiếu Khám</h4>
                <div class="danhsach__thongtin">
                    <!-- Thông tin bệnh nhân -->
                    <?php
                    if ($maBenhNhan) {
                        // Nếu có mã bệnh nhân, lấy thông tin từ database
                        $p->laymabenhnhan("SELECT * FROM benhnhan WHERE maBenhNhan='$maBenhNhan'");

                    } else {
                        
                        echo '<div id="phieukham__mabn">
                                <span>Mã bệnh nhân :</span>
                                <input name="txtmabenhnhan" id="txtmabenhnhan" type="text" value="">
                                <button type="button" id="checkPatient">Kiểm tra</button>
                                <span id="checkResult"></span>
                              </div>
                              <div id="phieukham__hoten"><span>Họ và tên :</span>
                                <input name="txttenbenhnhan" id="txttenbenhnhan" type="text" value="" readonly>
                              </div>
                              <div id="phieukham__ngaysinh"><span>Ngày sinh :</span>
                                <input name="txtngaysinh" id="txtngaysinh" type="date" value="" readonly>
                              </div>
                              <div id="phieukham__gioitinh">
                                <span>Giới tính:</span>
                                <input type="radio" id="nam" name="gioitinh" value="Nam" disabled>
                                <label for="nam">Nam</label>
                                <input type="radio" id="nu" name="gioitinh" value="Nữ" disabled>
                                <label for="nu">Nữ</label>
                              </div>
                              <div id="phieukham__sodienthoai"><span>Số điện thoại :</span>
                                <input name="txtsdt" id="txtsdt" type="number" value="" readonly>
                              </div>
                              <div id="phieukham__diachi"><span>Địa chỉ :</span>
                                <textarea name="txtdiachi" id="txtdiachi" readonly></textarea>
                              </div>';
                    }
                    ?>
                    <div id="phieukham__tinhtrangbenh"><span>Tình trạng bệnh :</span><textarea name="txttinhtrangbenh" id="txttinhtrangbenh" placeholder="Nhập tình trạng bệnh" ></textarea></div>
                    <div id="phieukham__chandoan"><span>Chẩn đoán :</span><textarea name="txtchandoan" id="txtchandoan" placeholder="Nhập chẩn đoán bệnh"></textarea></div>
                    <div id="phieukham__kehoachdieutri"><span>Kế hoạch điều trị :</span><textarea name="txtkehoachdieutri" id="txtkehoachdieutri" placeholder="Nhập kế hoạch điều trị"></textarea></div>

                    
                    <div id="phieukham__thuockedon">
                        <span>Thuốc kê đơn :</span>
                        <div id="medicine-list">
                            <div class="medicine-entry">
                            <p class="title__donthuoc">Tên thuốc:</p>
                                <?php $p->chonthuoc("SELECT * FROM thuoc ORDER BY tenThuoc ASC"); ?>
                                <p class="title2__donthuoc">Số lượng:</p>
                                <input type="number" class="medicine-quantity" name="soluong[]" id="soluong" value="1" min="1" />
                                <p class="title2__donthuoc">Liều dùng:</p>
                                <input type="text" class="lieudung" name="lieudung[]" id="lieudung" readonly />
                                <button type="button" class="remove-medicine btn btn-danger btn-sm" style="margin-left: 10px;">X</button>
                            </div>
                        </div>
                        
                    </div>
                    <div class="nutthemthuoc">
                            <button type="button" onclick="addMedicineEntry()" class="nut__themthuoc"><i class="fa-solid fa-plus" style="color: #ffffff;"></i></button>
                        </div>
                    
                    <div id="phieukham__ghichu"><span>Ghi chú :</span><textarea name="txtghichu" id="txtghichu" placeholder="Ghi chú của bác sĩ"></textarea></div>
                    
                   
                    <button name="btn__taophieukham"  id="btn__taophieukham" value="Tạo Phiếu Khám">Tạo Phiếu Khám</button>
                </div>
            </form>

            <?php
    $tenBacSi = $_SESSION['hoTen']; // Tên bác sĩ từ session
    if (isset($_POST['btn__taophieukham']) && $_POST['btn__taophieukham'] == 'Tạo Phiếu Khám') {
        $maBenhNhan = trim($_REQUEST['txtmabenhnhan']); 
        $tenBenhNhan = $_REQUEST['txttenbenhnhan'];
        $ngaySinh = $_REQUEST['txtngaysinh'];
        $gioiTinh = isset($_POST['gioitinh']) ? $_POST['gioitinh'] : 'Nam';
        $sdt = $_REQUEST['txtsdt'];
        $diaChi = $_REQUEST['txtdiachi'];
        $tinhTrangBenh = trim($_REQUEST['txttinhtrangbenh']);
        $chanDoan = $_REQUEST['txtchandoan'];
        $keHoachDieuTri = $_REQUEST['txtkehoachdieutri'];
        $ghiChu = $_REQUEST['txtghichu'];

        // Lấy thông tin thuốc
        $tenThuoc = isset($_POST['tenThuoc']) ? $_POST['tenThuoc'] : [];
        $soLuong = isset($_POST['soluong']) ? $_POST['soluong'] : [];
        $lieuDung = isset($_POST['lieudung']) ? $_POST['lieudung'] : [];

        // Kiểm tra các trường bắt buộc
        if (empty($maBenhNhan)) {
            echo '<script>alert("Mã bệnh nhân không được để trống!");</script>';
            exit;
        }
        if (empty($tinhTrangBenh)) {
            echo '<script>alert("Tình trạng bệnh không được để trống!");</script>';
            exit;
        }
        if (empty($chanDoan)) {
            echo '<script>alert("Chẩn đoán không được để trống!");</script>';
            exit;
        }
        if (empty($keHoachDieuTri)) {
            echo '<script>alert("Kế hoạch điều trị không được để trống!");</script>';
            exit;
        }
        if (empty($tenThuoc) || count($tenThuoc) === 0) {
            echo '<script>alert("Đơn thuốc không được để trống!");</script>';
            exit;
        }

        $ngayTao = date('Y-m-d'); 

        // Kết nối database
        $conn = $p->connect();

        // Kiểm tra trùng lặp tình trạng bệnh và ngày tạo
        $checkDuplicateQuery = "SELECT * FROM phieukham WHERE tinhTrangBenh = '$tinhTrangBenh' AND ngayTao = '$ngayTao'";
        $duplicateResult = mysqli_query($conn, $checkDuplicateQuery);
        if ($duplicateResult && mysqli_num_rows($duplicateResult) > 0) {
            echo '<script>alert("Phiếu khám với tình trạng bệnh tương tự và ngày tạo đã tồn tại!");</script>';
            exit;
        }

        // Tạo mã đơn thuốc
        $maDonThuoc = $p->generateUniqueMaDonThuoc(); 
        $danhSachThuoc = [];
        $tongTien = 0;

        foreach ($tenThuoc as $index => $thuoc) {
            $soLuongThuoc = $soLuong[$index];
            $thuocQuery = "SELECT giaTien FROM thuoc WHERE tenThuoc = '$thuoc'";
            $thuocResult = mysqli_query($conn, $thuocQuery);

            if ($thuocResult && $row = mysqli_fetch_assoc($thuocResult)) {
                $giaTien = $row['giaTien'];
                $tongTien += $giaTien * $soLuongThuoc;
                $danhSachThuoc[] = "$thuoc, $soLuongThuoc, $lieuDung[$index]";
            } else {
                echo '<script>alert("Thuốc ' . htmlspecialchars($thuoc) . ' không tồn tại trong danh sách thuốc!");</script>';
                exit;
            }
        }

        $danhSachThuocStr = implode('; ', $danhSachThuoc);

        // Thêm đơn thuốc vào bảng donthuoc
        $queryDonThuoc = "INSERT INTO donthuoc(maDonThuoc, maBenhNhan, danhSachThuoc) 
                          VALUES ('$maDonThuoc', '$maBenhNhan', '$danhSachThuocStr')";
        if ($p->themxoasua($queryDonThuoc) != 1) {
            echo '<script>alert("Có lỗi khi tạo đơn thuốc!");</script>';
            exit;
        }

        // Tạo phiếu khám và gán mã đơn thuốc
        $maPhieuKham = 'PK' . rand(100000, 999999);
        $queryPhieuKham = "INSERT INTO phieukham(maPhieuKham, maBenhNhan, tinhTrangBenh, chanDoan, keHoachDieuTri, maDonThuoc, ghiChu, tenBacSi, ngayTao) 
                           VALUES ('$maPhieuKham', '$maBenhNhan', '$tinhTrangBenh', '$chanDoan', '$keHoachDieuTri', '$maDonThuoc', '$ghiChu', '$tenBacSi', '$ngayTao')";

        if ($p->themxoasua($queryPhieuKham) == 1) {
            // Cập nhật mã phiếu khám vào bảng bệnh nhân
            $updateQuery = "UPDATE benhnhan SET maPhieuKham = '$maPhieuKham' WHERE maBenhNhan = '$maBenhNhan'";
            if (!$p->themxoasua($updateQuery)) {
                echo '<script>alert("Có lỗi khi cập nhật mã phiếu khám vào bệnh nhân!");</script>';
                exit;
            }

            // Tạo hóa đơn
            $maHoaDon = 'HD' . rand(100000, 999999);
            $queryHoaDon = "INSERT INTO hoadon(maHoaDon, maBenhNhan, tienThuoc) 
                            VALUES ('$maHoaDon', '$maBenhNhan', '$tongTien')";
            
            if ($p->themxoasua($queryHoaDon) == 1) {
                // Sau khi tạo hóa đơn thành công, lưu vào bảng hoadonthuoc
                $queryHoaDonThuoc = "INSERT INTO hoadonthuoc(maHoaDon, maDonThuoc, maBenhNhan, tongTien) 
                                     VALUES ('$maHoaDon', '$maDonThuoc', '$maBenhNhan', '$tongTien')";
                
                if ($p->themxoasua($queryHoaDonThuoc) == 1) {
                    echo '<script>alert("Tạo phiếu khám và đơn thuốc thành công!");</script>';
                } else {
                    echo '<script>alert("Có lỗi khi lưu vào bảng hóa đơn thuốc!");</script>';
                }
            } else {
                echo '<script>alert("Có lỗi khi tạo hóa đơn!");</script>';
            }
        } else {
            echo '<script>alert("Có lỗi khi tạo phiếu khám. Vui lòng thử lại!");</script>';
        }
    }
?>





        </div>
    </section>
</div>

<script>
            
        // Hàm thêm một ô nhập thuốc mới
        function addMedicineEntry() {
            const medicineList = document.getElementById("medicine-list");
            const newEntry = document.createElement("div");
            newEntry.classList.add("medicine-entry");

            newEntry.innerHTML = `
               <p class="title__donthuoc">Tên thuốc:</p>
                                <?php $p->chonthuoc("SELECT * FROM thuoc ORDER BY tenThuoc ASC"); ?>
                                <p class="title2__donthuoc">Số lượng:</p>
                                <input type="number" class="medicine-quantity" name="soluong[]" id="soluong" value="1" min="1" />
                                <p class="title2__donthuoc">Liều dùng:</p>
                                <input type="text" class="lieudung" name="lieudung[]" id="lieudung" readonly />
                                <button type="button" class="remove-medicine btn btn-danger btn-sm" style="margin-left: 10px;">X</button>
            `;

            medicineList.appendChild(newEntry);
        }
        function updateLieuDung(selectElement) {
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            const lieuDung = selectedOption.getAttribute("data-lieudung");
            const parent = selectElement.closest(".medicine-entry");
            const lieuDungInput = parent.querySelector(".lieudung");
            lieuDungInput.value = lieuDung || "";
        }


                // Xóa một ô nhập thuốc
                document.addEventListener('click', function(e) {
                    if (e.target && e.target.classList.contains('remove-medicine')) {
                        e.target.parentElement.remove();
                    }
                });
                

                /// check benh nhan
                document.getElementById('checkPatient').addEventListener('click', function() {
                var maBenhNhan = document.getElementById('txtmabenhnhan').value;

                if (maBenhNhan.trim() === "") {
                    alert("Vui lòng nhập mã bệnh nhân!");
                    return;
                }

                // Gửi yêu cầu AJAX kiểm tra mã bệnh nhân
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "./xuly/check_patient.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        var response = JSON.parse(xhr.responseText);

                        if (response.status === 'success') {
                            // Điền thông tin vào các trường nếu tìm thấy
                            document.getElementById('txttenbenhnhan').value = response.data.tenBenhNhan;
                            document.getElementById('txtngaysinh').value = response.data.namSinh;
                            document.getElementById('txtsdt').value = response.data.sdt;
                            document.getElementById('txtdiachi').value = response.data.diaChi;

                            // Điền giới tính vào radio button
                            if (response.data.gioitinh === 'Nam') {
                                document.getElementById('nam').checked = true;
                            } else if (response.data.gioitinh === 'Nữ') {
                                document.getElementById('nu').checked = true;
                            }

                            // Hiển thị kết quả kiểm tra
                            document.getElementById('checkResult').innerHTML = "<span style='color: green;'>✓</span>";
                        } else {
                            // Nếu không tìm thấy mã bệnh nhân
                            document.getElementById('checkResult').innerHTML = "<span style='color: red;'>X</span>";
                        }
                    }
                };

                xhr.send("maBenhNhan=" + maBenhNhan);
            });



            


</script>
