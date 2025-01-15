
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký Tài Khoản</title>
    <style>
        
        #container {
            box-sizing: border-box;
            width: 50%;
            margin: 40px auto;
            background-color: #fff;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            color: #333;
            font-size: 24px;
            margin-bottom: 5px;
        }
        p {
            color: #666;
            margin-bottom: 20px;
            font-size: 14px;
        }
        label {
            display: block;
            text-align: left;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }
        .input-group {
            display: flex;
            justify-content: space-between;
        }
        .input-group input {
            width: 48%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        input, select, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        button {
            background-color: #52b788;
            color: white;
            font-size: 16px;
            border: none;
            cursor: pointer;
            padding: 15px;
            margin-top: 20px;
        }
        button:hover {
            background-color: #40916c;
        }
        .gender-group {
            display: flex;
            justify-content: space-between;
            padding: 0 10px;
        }
        .gender-group label {
            width: 32%;
            text-align: center;
            font-weight: normal;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
            cursor: pointer;
        }
        .gender-group input[type="radio"] {
            display: none;
        }
        .gender-group input[type="radio"]:checked + label {
            background-color: #e6f4ea;
            border-color: #52b788;
        }
        h1,p{
            color: #4A63E7;
        }
    </style>
</head>
<body>

    <div id="container">
        <h1 style="text-align: center;">Đăng Ký Tài Khoản</h1>
        <p style="text-align: center;">để đăng và nhanh chóng</p>
        
        <form>
        <label>Tên</label>
            <div class="input-group">
                <input type="text" placeholder="Họ" required>
                <input type="text" placeholder="Tên" required>
            </div>

            <label>Ngày Sinh</label>
            <div class="input-group">
            <input type="number" placeholder="Ngày" min="1" max="31" required>
                <select required>
                    <option value="">Tháng</option>
                    <option value="1">Tháng 1</option>
                    <option value="2">Tháng 2</option>
                    <option value="3">Tháng 3</option>
                    <option value="4">Tháng 4</option>
                    <option value="5">Tháng 5</option>
                    <option value="6">Tháng 6</option>
                    <option value="7">Tháng 7</option>
                    <option value="8">Tháng 8</option>
                    <option value="9">Tháng 9</option>
                    <option value="10">Tháng 10</option>
                    <option value="11">Tháng 11</option>
                    <option value="12">Tháng 12</option>
                </select>
                <input type="number" placeholder="Năm" min="1900" max="2024" required>
                    <!-- Các năm khác -->
            </div>

            <label>Giới Tính</label>
            <div class="gender-group" >
                <input type="radio" id="female" name="gender" value="Nữ">
                <label for="female">Nữ</label>
                
                <input type="radio" id="male" name="gender" value="Nam">
                <label for="male">Nam</label>
                
                <input type="radio" id="other" name="gender" value="Tùy chỉnh">
                <label for="other">Tùy chỉnh</label>
            </div>
            <label>Thông Tin</label>
            <input type="tel" placeholder="Số điện thoại di động" required>
            <input type="email" placeholder="Email" required>
            <input type="password" placeholder="Mật khẩu mới" required>

            <button type="submit">Đăng Ký</button>
        </form>
    </div>

</body>
</html>
