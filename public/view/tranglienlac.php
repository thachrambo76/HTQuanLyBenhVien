<head>
    <style>
        body {
            margin-top: 200px;
            margin-bottom: 100px;
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        h2 {
            color: #007bff;
            font-weight: bold;
        }
        .form-label {
            font-weight: 500;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    
        form {
            background-color: #f0f0f0;
            padding: 20px;
        }
    p{
        color: red;
    }
   
    </style>
</head>
<body>
<div class="container">
        
        <h2 class="text-center mb-4">LIÊN HỆ BỆNH VIỆN SÁNG TẠO</h2>
        <p class="text-center">Để được hỗ trợ hoặc góp ý cho Bệnh viện Sáng Tạo, Quý Khách hàng vui lòng liên hệ theo thông tin bên dưới!</p>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form>
                    <div class="mb-3">
                        <label for="hoten" class="form-label">Họ và tên</label>
                        <input type="text" class="form-control" id="hoten" name="hoten" placeholder="Nhập họ và tên của bạn">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email của bạn">
                    </div>
                    <div class="mb-3">
                        <label for="diachi" class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control" id="diachi" name="diachi">
                    </div>
                    <div class="mb-3">
                        <label for="sodienthoai" class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" id="sodienthoai" name="sodienthoai">
                    </div>
                    <div class="mb-3">
                        <label for="noidung" class="form-label">Nội dung</label>
                        <textarea class="form-control" id="noidung" name="noidung" rows="4" placeholder="Nhập nội dung cần hỗ trợ"></textarea>
                    </div>
                    <form id="infoForm">
                        <!-- Các trường thông tin khác ở đây -->
                        <button type="submit" class="btn btn-primary" onclick="showSuccessMessage(event)">Gửi thông tin</button>
                    </form>
                    <!-- Vùng hiển thị thông báo -->
                    <div id="successMessage" class="alert alert-success mt-3" style="display: none;">
                        Thông tin đã được gửi thành công!
                    </div>
                </form>
            </div>
        </div>


    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showSuccessMessage(event) {
            // Ngăn chặn hành động submit mặc định
            event.preventDefault();
            
            // Hiển thị thông báo
            const messageElement = document.getElementById('successMessage');
            messageElement.style.display = 'block';

            // Tự động ẩn thông báo sau 3 giây (tùy chọn)
            setTimeout(() => {
                messageElement.style.display = 'none';
            }, 3000);
        }
    </script>
</body>
</html>
