<?php
    include("myclass/clsthuoc.php");
    $p = new clsthuoc();
?>
<style>
    body {
        font-family: Arial, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        background-color: #f4f4f4;
    }

    .container {
        margin-top:20px;
        width: 70%;
        background-color: #fff;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    .header {
        text-align: center;
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .search-box {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 10px;
    }

    .search-box input {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
        outline: none;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table, th, td {
        border: 1px solid #ddd;
    }

    th, td {
        padding: 12px;
        text-align: left;
    }

    th {
        background-color: #f4f4f4;
    }

    .button {
        background-color: #c7e5c8;
        color: #333;
        padding: 8px 16px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-align: center;
    }

    .button:hover {
        background-color: #b0d6b1;
    }
</style>

<body>
<div class="container">
    <div class="header">Danh sách thuốc</div>
    
    <div class="search-box">
        <form action="" method="post">
        <input type="text" placeholder="Tìm kiếm" id="search" name="search">
        <button type="submit" class="btn btn-primary" id="timkiem" name="timkiem" style="border-radius:20px;margin-left:5px">Search</button>
        </form>
    </div>
    
    <table>
        <tr>
            <th>STT</th>
            <th>Mã thuốc</th>
            <th>Tên thuốc</th>
            <th>Số lượng</th>
            <th>Giá tiền</th>
            <th>Liều dùng</th>
            <th></th>
        </tr>
        <!-- <tr>
            <td>1</td>
            <td>MT0001</td>
            <td>Levothyroxine</td>
            <td>300 hộp</td>
            <td>75.000 VND</td>
            <td>1 lần/ngày</td>
            <td><button class="button"><a href="?quanli=xem-thong-tin-thuoc">Xem</a></button></td>
        </tr>
        <tr>
            <td>2</td>
            <td>MT0002</td>
            <td>Memantine</td>
            <td>278 hộp</td>
            <td>350.000 VND</td>
            <td>2 lần/ ngày</td>
            <td><button class="button"><a href="?quanli=xem-thong-tin-thuoc">Xem</a></button></td>
        </tr>
        <tr>
            <td>3</td>
            <td>MT0003</td>
            <td>Donepezil</td>
            <td>435 hộp</td>
            <td>450.000 VND</td>
            <td>1 lần/ngày</td>
            <td><button class="button"><a href="?quanli=xem-thong-tin-thuoc">Xem</a></button></td>
        </tr> -->
        <?php
            $query = "SELECT * from thuoc where 1=1";
            if(!isset($_POST['timkiem'])){
                $p->xemThuocTonKho();
            }
            if(isset($_POST['timkiem']) && !empty($_POST['search'])){
                $search = $_POST['search'];
                $query .=" AND tenThuoc LIKE '%$search%'";
                $ketqua = $p->timKiemThuoc($query);
                if(!empty($ketqua)){
                    $stt=1;
                    foreach ($ketqua as $row){
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
                }
                else {
                    echo "<tr><td colspan='7'>Không tìm thấy loại thuốc cần tìm.</td></tr>";
                    
                }
            }
        ?>
                <tr>
        </tr>
    </table>
</div>
</body>
<?php
    

?>
