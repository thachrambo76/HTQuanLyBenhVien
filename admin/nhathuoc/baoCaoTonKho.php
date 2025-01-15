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
            margin-bottom: 10px;
        }

        .date {
            text-align: center;
            font-size: 14px;
            margin-bottom: 20px;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        .total {
            text-align: right;
            margin-top: 10px;
            font-weight: bold;
            font-size: 16px;
        }

        .button-container {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        .button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            color: #fff;
            cursor: pointer;
            font-size: 16px;
        }

        .cancel-button {
            background-color: #f28b82;
        }

        .report-button {
            background-color: #aecbfa;
        }

        .cancel-button:hover {
            background-color: #e57373;
        }

        .report-button:hover {
            background-color: #90caf9;
        }
    </style>

<body>

<div class="container">
    <div class="header">Báo cáo thuốc tồn kho</div>
    <div class="date">Ngày: <?php
    echo  date("d/m/Y");
        ?></div>
    
    <table>
        <tr>
            <th>STT</th>
            <th>Mã thuốc</th>
            <th>Tên thuốc</th>
            <th>SL Tồn</th>
            <th>Đơn giá</th>
            <th>Liều dùng</th>
            <th>HSD</th>
        </tr>
        <!-- <tr>
            <td>1</td>
            <td>MT0001</td>
            <td>Levothyroxine</td>
            <td>300 hộp</td>
            <td>75.000 VND</td>
            <td>22.500.000 VND</td>
            <td>08/2025</td>
        </tr>
        <tr>
            <td>2</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>3</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr> -->
        <?php
            $p->baoCaoTonKho();
        ?>
    </table>

    <div class="button-container">
    <a href="../admin/"style="color:white;"><button class="button cancel-button">Hủy</button></a>
        <button class="button report-button">In báo cáo</button>
    </div>
</div>

</body>