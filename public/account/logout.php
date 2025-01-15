<?php
// Bắt đầu session
session_start();

// Hủy tất cả các session
session_unset();
session_destroy();

// Chuyển hướng đến trang đăng nhập
header("Location: index.php?url=dang-nhap");
exit();
?>
