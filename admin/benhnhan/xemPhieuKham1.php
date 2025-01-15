
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xem Phiếu Khám</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f9fc;
        }
        #container {
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header h1 {
            text-align: center;
            color: #4A63E7;
        }
        .info {
            background-color: #f2f2f2;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
        }
        .info p {
            margin: 5px 0;
            color: #333;
        }
        .table-container {
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #4A63E7;
            color: #fff;
        }
        .action-btn {
            background-color: #4A63E7;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin: 2px;
        }
        .action-btn:hover {
            background-color: #3b51c8;
        }
    </style>
</head>
<body>
    <div id="container">
        <div class="header">
            <h1>Xem Phiếu Khám</h1>
            <p>Vui lòng điền đầy đủ thông tin!</p>
        </div>

        <div class="info">
            <p><strong>Họ tên bệnh nhân:</strong> Nguyễn Vi Hà</p>
            <p><strong>Mã bệnh nhân:</strong> 13456742</p>
            <p><strong>Số điện thoại:</strong> 0365456985</p>
            <p><strong>Email:</strong> viha@gmail.com</p>
            <p><strong>Địa chỉ:</strong> 231 Thống Nhất, phường 16, Gò Vấp, thành phố HCM</p>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã Phiếu Khám/Tên Bác Sĩ</th>
                        <th>Chức Năng</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>23142312 - BS. Phạm Tấn An</td>
                        <td>
                            <button class="action-btn">Xóa</button>
                            <button class="action-btn" onclick="window.location.href='index.php?quanli=xem-chi-tiet-phieu-kham'">Xem</button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>34576892 - BS. Lê Thị Hồng</td>
                        <td>
                            <button class="action-btn">Xóa</button>
                            <button class="action-btn">Xem</button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>13465245 - BS. Phạm Tấn An</td>
                        <td>
                            <button class="action-btn">Xóa</button>
                            <button class="action-btn">Xem</button>
                        </td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>25437668 - BS. Ngô Thành Huy</td>
                        <td>
                            <button class="action-btn">Xóa</button>
                            <button class="action-btn">Xem</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>