document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const phoneInput = form.querySelector("[name='sdt']");
    const departmentSelect = form.querySelector("[name='khoaKham']");
    const doctorSelect = form.querySelector("[name='bacSi']");
    const appointmentDateInput = form.querySelector("[name='ngayKham']");
    const appointmentTimeInput = form.querySelector("[name='gioKham']");
    const fullNameInput = form.querySelector("[name='hoTen']");
    const addressInput = form.querySelector("[name='diaChi']");
    const emailInput = form.querySelector("[name='email']");
    const dobInput = form.querySelector("[name='ngaySinh']");

    form.addEventListener("submit", function (event) {
        let isValid = true;
        let errorMessage = "";

        // Kiểm tra họ tên (không được để trống)
        const fullName = fullNameInput.value.trim();
        if (!fullName) {
            isValid = false;
            errorMessage += "Họ và tên không được để trống.\n";
        }

        // Kiểm tra địa chỉ (không được để trống)
        const address = addressInput.value.trim();
        if (!address) {
            isValid = false;
            errorMessage += "Địa chỉ không được để trống.\n";
        }

        // Kiểm tra email (cần đúng cú pháp)
        const email = emailInput.value.trim();
        const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!emailRegex.test(email)) {
            isValid = false;
            errorMessage += "Email không hợp lệ.\n";
        }

        // Kiểm tra ngày sinh (phải sau thời gian hiện tại ít nhất 1 năm)
        const dob = new Date(dobInput.value);
        const currentDate = new Date();
        currentDate.setFullYear(currentDate.getFullYear() - 1); // 1 năm trước
        if (dob > currentDate) {
            isValid = false;
            errorMessage += "Ngày sinh phải ít nhất 1 năm trước thời điểm hiện tại.\n";
        }

        // Kiểm tra số điện thoại
        const phone = phoneInput.value.trim();
        const phoneRegex = /^(09|07|03)\d{8}$/;
        if (!phoneRegex.test(phone)) {
            isValid = false;
            errorMessage += "Số điện thoại không hợp lệ. Số phải có 10 chữ số và bắt đầu bằng 09, 07 hoặc 03.\n";
        }

        // Kiểm tra chọn khoa khám
        if (departmentSelect.value === "Chọn khoa khám") {
            isValid = false;
            errorMessage += "Vui lòng chọn khoa khám.\n";
        }

        // Kiểm tra chọn bác sĩ
        if (doctorSelect.value === "Chọn bác sĩ") {
            isValid = false;
            errorMessage += "Vui lòng chọn bác sĩ.\n";
        }
        

        // Kiểm tra ngày và giờ khám
        const appointmentDate = new Date(appointmentDateInput.value);
        const appointmentTime = appointmentTimeInput.value;

        if (appointmentDate < currentDate.setHours(0, 0, 0, 0)) {
            isValid = false;
            errorMessage += "Ngày khám phải sau ngày hiện tại.\n";
        }

        if (appointmentTime) {
            const [hours, minutes] = appointmentTime.split(":").map(Number);
            if (
                hours < 8 || 
                hours > 20 || 
                (hours === 11 && minutes >= 0) || 
                hours === 12 || 
                (hours === 13 && minutes === 0)
            ) {
                isValid = false;
                errorMessage += "Giờ khám phải từ 8:00 sáng đến 8:00 tối, trừ khoảng thời gian từ 11:00 sáng đến 1:00 chiều.\n";
            }
        } else {
            isValid = false;
            errorMessage += "Vui lòng chọn giờ khám.\n";
        }

        // Nếu không hợp lệ, ngăn gửi form và hiển thị thông báo lỗi
        if (!isValid) {
            event.preventDefault();
            alert(errorMessage);
        }
    });
});

