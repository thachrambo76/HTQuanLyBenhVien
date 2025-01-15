
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    #container{
        box-sizing: border-box;
        margin: 0 auto;
        margin-top: 10px;
        height: 800px;
        width: auto;
    }
    #content{
        text-align: center;
    }#content-1{
        padding : 10px 10px 10px;
        text-align: center;
        width: auto;
        height:550px;
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }
    #left{
        flex:50%;
    }
    #right{
        flex:50%;

    }
    h1 {
        text-align: center;
        color: #4A63E7;
    }
    h2{
        color: #4A63E7 ;
    }
    label {
            display: block;
            text-align: left;
            margin: 10px 50px 5px;
            font-weight: bold;
            color: #333;
    }
    input, select, textarea, button {
            width: 80%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
    }
    button {
            margin-left: 300px;
            background-color: #52b788;
            color: white;
            font-size: 16px;
            border: none;
            cursor: pointer;
            padding: 15px;
            width: 50%;
            margin-top: 50px;
    }
    button:hover {
            background-color: #40916c;
    }
</style>
<body>
    <div id="container">
      <div id="content">
        <h1>Đặt Lịch Khám</h1>
        <p>Cảm ơn Quý Khách hàng đã quan tâm đến dịch vụ chăm sóc sức khỏe của Chúng tôi.<br>
            Vui lòng gửi thông tin chi tiết để chúng tôi có thể sắp xếp cuộc hẹn.</p>
      </div>
        <form>
            <div id="content-1">
                <!-- Bảng Bên Trái -->
                <div id="left">
                    <h2>Thông Tin Bệnh Nhân</h2>
                    <label for="name">Họ Và Tên</label>
                    <input type="text" id="name" name="name" required>

                    <label for="birthdate">Ngày Sinh</label>
                    <input type="date" id="birthdate" name="birthdate" required>

                    <label for="phone">Số Điện Thoại</label>
                    <input type="tel" id="phone" name="phone" required>

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email">

                    <label for="address">Địa Chỉ</label>
                    <input type="text" id="address" name="address">
                </div>

                <!-- Bảng Bên Phải -->
                <div id="right">
                    <h2>Chọn Lịch Đặt</h2>
                    <label for="department">Khoa Khám</label>
                    <select id="department" name="department" required>
                        <option value="">Chọn khoa khám</option>
                        <option value="Cơ Xương Khớp">Cơ Xương Khớp</option>
                        <option value="Hô Hấp">Hô Hấp</option>
                        <option value="Xét Nghiệm">Xét Nghiệm</option>
                        <!-- Add more departments as needed -->
                    </select>

                    <label for="doctor">Bác Sĩ</label>
                    <select id="doctor" name="doctor" required>
                        <option value="">Chọn bác sĩ</option>
                        <option value="Nguyễn Văn Hùng">Nguyễn Văn Hùng</option>
                        <option value="Lê Thùy Trang">Lê Thùy Trang</option>
                        <!-- Add more doctors as needed -->
                    </select>

                    <label for="appointmentDate">Ngày Khám</label>
                    <input type="date" id="appointmentDate" name="appointmentDate" required>

                    <label for="appointmentTime">Giờ Khám</label>
                    <input type="time" id="appointmentTime" name="appointmentTime" required>

                    <label for="description">Mô Tả Bệnh</label>
                    <textarea id="description" name="description" rows="4" placeholder="Mô tả tình trạng sức khỏe của bạn"></textarea>
                </div>
            </div>
            <button type="submit">Đặt lịch khám</button>
        </form>
    </div>
</body>
</html>
