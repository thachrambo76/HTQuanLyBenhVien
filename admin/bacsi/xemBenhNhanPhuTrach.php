<?php
include("./xuly/clsquantri.php");
$p = new quantri();
?>

<div class="xemBenhNhanPhuTrach">
    <section class="container-fluid pt-4 px-4">
        <div class="bg-light text-center rounded p-4">
            <h4>DANH SÁCH BỆNH NHÂN PHỤ TRÁCH</h4>
            <div id="top__header" class="d-flex justify-content-between align-items-center">
                <div>
                    <!-- Hiển thị tổng số bệnh nhân phụ trách -->
                    <?php
                    // Lấy tên bác sĩ từ session
                    $tenBacSi = isset($_SESSION['hoTen']) ? $_SESSION['hoTen'] : '';

                    if (empty($tenBacSi)) {
                        echo "Bạn chưa đăng nhập.";
                        exit;
                    }
                    ?>
                </div>
                <div>
                    <!-- Form tìm kiếm -->
                    <form class="d-flex" method="POST" action="" id="nav__benhnhan">
                        <input id="form__search" type="search" placeholder="Tìm kiếm mã hoặc tên bệnh nhân..." aria-label="Search" name="search" value="<?= isset($_POST['search']) ? htmlspecialchars($_POST['search']) : '' ?>">
                        <button id="btn__search" type="submit" name="timkiem" onclick="return validateSearch();"><i class="fa-solid fa-magnifying-glass"></i></button>
                        <button id="btn__reset" type="submit" name="reset">Làm mới</button>
                    </form>
                </div>
                <script>
                    function validateSearch() {
                        const searchField = document.getElementById('form__search');
                        if (!searchField.value.trim()) {
                            alert("Vui lòng nhập từ khóa để tìm kiếm!");
                            return false;
                        }
                        return true;
                    }
                </script>
            </div>

            <div id="table__danhsach">
                <div id="content__thongke">
                    <?php
                    // Xử lý nút "Làm mới"
                    if (isset($_POST['reset'])) {
                        $_POST['search'] = ''; // Xóa nội dung tìm kiếm
                    }

                    // Khởi tạo câu truy vấn mặc định
                    $query = "SELECT DISTINCT benhnhan.maBenhNhan, benhnhan.tenBenhNhan, benhnhan.namSinh, benhnhan.sdt 
                              FROM benhnhan 
                              JOIN phieukham ON benhnhan.maBenhNhan = phieukham.maBenhNhan
                              WHERE phieukham.tenBacSi = '$tenBacSi'";

                    // Kiểm tra điều kiện tìm kiếm
                    if (isset($_POST['timkiem']) && !empty(trim($_POST['search']))) {
                        $search = trim($_POST['search']);
                        $link = $p->connect();
                        $search = mysqli_real_escape_string($link, $search);
                        mysqli_close($link);

                        // Thêm điều kiện tìm kiếm
                        $query .= " AND (benhnhan.maBenhNhan LIKE '%$search%' OR benhnhan.tenBenhNhan LIKE '%$search%')";
                    }

                    $query .= " ORDER BY benhnhan.maBenhNhan ASC";

                    // Gọi phương thức hiển thị danh sách bệnh nhân
                    $p->xuatdsbenhnhanphutrach($query);
                    ?>
                </div>
                <?php
                    // Câu truy vấn đếm tổng số bệnh nhân mà bác sĩ đang phụ trách
                    $countQuery = "SELECT COUNT(DISTINCT benhnhan.maBenhNhan) AS totalPatients
                                   FROM benhnhan 
                                   JOIN phieukham ON benhnhan.maBenhNhan = phieukham.maBenhNhan
                                   WHERE phieukham.tenBacSi = '$tenBacSi'";
                    $link = $p->connect();
                    $result = mysqli_query($link, $countQuery);
                    $row = mysqli_fetch_assoc($result);
                    $totalPatients = $row['totalPatients'];
                    mysqli_close($link);

                    echo '<span class="tongsobenhnhan">Tổng số bệnh nhân đang phụ trách: <strong>'.$totalPatients.'</strong></span>';
                ?>
            </div>
        </div>
    </section>
</div>  
