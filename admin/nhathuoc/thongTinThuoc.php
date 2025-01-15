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
        width: 60%;
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

    .info-box {
        background-color: #f7f7f7;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .info-box h2 {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .info-box p {
        margin: 5px 0;
    }

    .button-container {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .button {
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        color: #fff;
        cursor: pointer;
        font-size: 16px;
    }

    .back-button {
        background-color: #f28b82;
    }

    .ok-button {
        background-color: #aecbfa;
    }

    .back-button:hover {
        background-color: #e57373;
    }

    .ok-button:hover {
        background-color: #90caf9;
    }
</style>
</head>
<body>
<div class="container">
    <div class="header">Loại thuốc</div>
    
    <!-- <div class="info-box">
        <h2>Thông tin thuốc</h2>
        <p><strong>Mã thuốc:</strong> MT0001</p>
        <p><strong>Tên thuốc:</strong> Levothyroxine</p>
        <p><strong>Số lượng tồn kho:</strong> 300 hộp</p>
        <p><strong>Giá tiền:</strong> 75.000 VND</p>
        <p><strong>Liều dùng:</strong> 1 lần/ ngày</p>
        <p><strong>Hạn sử dụng:</strong> 08/2025</p>
        <p><strong>Chi tiết:</strong> Levothyroxine là một loại hormone tổng hợp của tuyến giáp, được sử dụng để điều trị các bệnh liên quan đến suy giáp (tuyến giáp hoạt động kém).</p>
    </div> -->
    <div class="info-box">
        <?php
            $idsp=$_REQUEST['id'];
            $p->xemthongtinthuoc("SELECT * FROM thuoc where maThuoc = '$idsp' limit 1");
        ?>
    </div>
    <div class="button-container">
    <a href="index.php?quanli=xem-thuoc-ton-kho" style="color:white;text-decoration:none;"><button class="button back-button">Trở lại</button></a>
    </div>
</div>
</body>