<?php
    $pdo = new PDO("mysql:host=localhost;dbname=qlbenhvien", "usertmdt", "passtmdt");
    $maKhoa = $_GET['maKhoa'] ?? '';

    // Debug: Kiểm tra giá trị của $maKhoa
    if (empty($maKhoa)) {
        echo json_encode(['error' => 'Không có mã khoa']);
        exit;
    }

    $stmt = $pdo->prepare("SELECT maBacSi, tenBacSi FROM bacsi WHERE maKhoa = ?");
    $stmt->execute([$maKhoa]);
    $doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Debug: Kiểm tra kết quả của truy vấn
    if (empty($doctors)) {
        echo json_encode(['error' => 'Không có bác sĩ trong khoa này']);
        exit;
    }

    echo json_encode($doctors);
?>
