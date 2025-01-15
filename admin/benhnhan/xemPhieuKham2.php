
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xem Phiếu Khám</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f9fc;
            margin: 0;
            padding: 0;
        }
        #container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #4A63E7;
        }
        .info p {
            margin: 5px 0;
            font-size: 16px;
            color: #333;
        }
        .info p strong {
            color: #000;
        }
        .table-container {
            overflow-x: auto;
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
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
        .note {
            font-size: 14px;
            color: #333;
            margin-top: 10px;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div id="container">
        <h1>Xem Phiếu Khám</h1>
        <p style="text-align: center;">Vui lòng điền đầy đủ thông tin!</p>

        <div class="info">
            <p><strong>Mã Phiếu Khám:</strong> 23142312</p>
            <p><strong>Tên Bệnh Nhân:</strong> Nguyễn Vi Hà</p>
            <p><strong>Tên Bác Sĩ:</strong> BS. Phạm Tấn An</p>
            <p><strong>Lịch Sử Khám:</strong> 23/7/2024</p>
            <p><strong>Chuẩn Đoán:</strong> Chuẩn đoán lần 1, Viêm Gan B</p>
            <p><strong>Kết luận:</strong> Chưa kết luận, cần tái khám</p>
            <p><strong>Ngày Tái Khám:</strong> 20/11/2024</p>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên Thuốc</th>
                        <th>Số Lượng</th>
                        <th>Thời Gian Dùng</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Thuốc Entecavir (Baraclude)</td>
                        <td>12 viên</td>
                        <td>Ngày uống 3 lần/1 viên</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Thuốc Lamivudine</td>
                        <td>6 viên</td>
                        <td>Ngày uống 2 lần/1 viên</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Thuốc Telbivudine</td>
                        <td>6 viên</td>
                        <td>Ngày uống 3 lần/1 viên</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Tenofovir AF</td>
                        <td>6 viên</td>
                        <td>Ngày uống 3 lần/1 viên</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <p class="note">*Lưu ý: Thuốc không thể tự ý mua ở ngoài</p>
    </div>
</body>
</html>
