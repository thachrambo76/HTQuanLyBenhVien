document.getElementById("appointmentTime").addEventListener("input", function (e) {
    // Lấy giá trị giờ và phút
    const timeValue = e.target.value; // Ví dụ: "13:45"
    const hour = timeValue.split(":")[0]; // Lấy phần giờ
    // Cập nhật lại giá trị chỉ bao gồm giờ
    e.target.value = `${hour}:00`; // Đặt phút luôn là 00
});
