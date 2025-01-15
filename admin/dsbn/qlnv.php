<?php
require_once("../config/config.php");

$sql = "SELECT maNhanVien, tenNhanVien, email, sdt, vaiTro FROM nhanvien";
$result = $conn->query($sql);
?>


<div class="container mt-5">
    <h2 class="text-center">Quản Lý Nhân Viên</h2>
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Số điện thoại</th>

                <th>Chức Vụ</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <!-- <tr>
                    <td>1</td>
                    <td>Nguyễn Văn A</td>
                    <td>01/01/1990</td>
                    <td>Hà Nội</td>
                    <td>34</td>
                    <td>Nhân viên</td>
                    <td>vana@gmail.com</td>
                    <td>
                       <a href="index.php?quanli=chi-tiet-nhan-vien"> <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#viewModal1">Xem</button></a>
                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal1">Sửa</button>
                        <button class="btn btn-danger btn-sm">Xóa</button>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Trần Thị B</td>
                    <td>02/02/1985</td>
                    <td>TP.HCM</td>
                    <td>39</td>
                    <td>Quản lý</td>
                    <td>tb@gmail.com</td>
                    <td>
                        <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#viewModal2">Xem</button>
                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal2">Sửa</button>
                        <button class="btn btn-danger btn-sm">Xóa</button>
                    </td>
                </tr> -->
            <!-- Thêm các hàng dữ liệu khác tại đây -->

            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
            <td>{$row['maNhanVien']}</td>
            <td>{$row['tenNhanVien']}</td>
            <td>{$row['email']}</td>
            <td>{$row['sdt']}</td>
            <td>{$row['vaiTro']}</td>
            <td>
                <a href='index.php?quanli=chi-tiet-nhan-vien&id={$row['maNhanVien']}'>
                    <button class='btn btn-info btn-sm'>Xem</button>
                </a>
             <a href='index.php?quanli=edit-nv&id={$row['maNhanVien']}'>
    <button class='btn btn-warning btn-sm'>Sửa</button>
</a>

          
            </td>
        </tr>";
                }
            } else {
                echo "<tr><td colspan='6' class='text-center'>Không có dữ liệu</td></tr>";
            }
            ?>



        </tbody>
    </table>



    <?php
    $conn->close();
    ?>