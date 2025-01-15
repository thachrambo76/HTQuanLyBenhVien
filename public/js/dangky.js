document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const inputs = form.querySelectorAll("input");
    const emailInput = form.querySelector("input[name='email']");
    const passwordInput = form.querySelector("input[name='pass']");
    const genderInputs = form.querySelectorAll("input[name='gioiTinh']");
    const phoneInput = form.querySelector("input[name='sdt']");
    const submitButton = form.querySelector("button[type='submit']");

    // Hàm kiểm tra xem tất cả trường có dữ liệu không
    function validateForm() {
        let isValid = true;

        // Kiểm tra các trường bắt buộc
        inputs.forEach(input => {   
            if (input.type !== "radio" && input.type !== "submit" && input.value.trim() === "") {
                input.style.borderColor = "red";
                isValid = false;
            } else {
                input.style.borderColor = "#ddd";
            }
        });

        // Kiểm tra giới tính
        const genderChecked = Array.from(genderInputs).some(input => input.checked);
        if (!genderChecked) {
            document.querySelector(".gender-group").style.borderColor = "red";
            isValid = false;
        } else {
            document.querySelector(".gender-group").style.borderColor = "transparent";
        }

        // Kiểm tra số điện thoại
        const phoneRegex = /^(03|09|07)\d{8}$/;
        if (!phoneRegex.test(phoneInput.value)) {
            phoneInput.style.borderColor = "red";
            isValid = false;
        } else {
            phoneInput.style.borderColor = "#ddd";
        }

        return isValid;
    }

    // Kiểm tra định dạng email
    emailInput.addEventListener("input", function () {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(emailInput.value)) {
            emailInput.style.borderColor = "red";
        } else {
            emailInput.style.borderColor = "#ddd";
        }
    });

    // Kiểm tra độ dài mật khẩu
    passwordInput.addEventListener("input", function () {
        if (passwordInput.value.length < 6) {
            passwordInput.style.borderColor = "red";
        } else {
            passwordInput.style.borderColor = "#ddd";
        }
    });

    // Gắn sự kiện kiểm tra form trước khi submit
    form.addEventListener("submit", function (event) {
        if (!validateForm()) {
            event.preventDefault();
            alert("Vui lòng điền đầy đủ và chính xác thông tin.");
        }
    });

    // Đổi màu nút khi di chuột
    submitButton.addEventListener("mouseover", function () {
        submitButton.style.backgroundColor = "#3a5ec4";
    });

    submitButton.addEventListener("mouseout", function () {
        submitButton.style.backgroundColor = "#4b72fa";
    });
});
