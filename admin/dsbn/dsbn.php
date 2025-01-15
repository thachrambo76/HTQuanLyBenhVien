<?php
require_once("../config/config.php");

// Fetch patient data
$sql = "SELECT * FROM benhnhan"; // Replace 'benhnhan' with your actual table name
$result = $conn->query($sql);

// Check if data exists
if ($result->num_rows > 0) {
    $patients = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $patients = [];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Bệnh Nhân</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="p-6">
    <div class="mx-auto bg-white rounded-lg p-6">
        <h1 class="text-3xl font-bold mb-4 text-gray-700">Danh Sách Bệnh Nhân</h1>
        <!-- Search bar and buttons below title -->
        <nav class="navbar bg-body-tertiary">
            <div class="container-fluid">
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
               <a href="index.php?quanli=tra-cuu-benh-nhan" > 
                    <button class="btn btn-info">Tra cứu bệnh nhân</button>
               </a>
            </div>
        </nav>

        <!-- Patient list table -->
        <table class="w-full border-collapse shadow-sm rounded-lg overflow-hidden mt-4">
            <thead>
                <tr class="table-header">
                    <th class="border p-3">STT</th>
                    <th class="border p-3">Họ tên</th>
                    <th class="border p-3">Mã khám bệnh</th>
                    <th class="border p-3">Số điện thoại</th>
                    <th class="border p-3">Lịch sử khám chữa bệnh</th>
                    <th class="border p-3">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($patients) > 0): ?>
                    <?php foreach ($patients as $index => $patient): ?>
                        <tr class="table-row">
                            <td class="border p-3 text-center"><?= $index + 1 ?></td>
                            <td class="border p-3"><?= htmlspecialchars($patient['tenBenhNhan'] ?? '') ?></td>
                            <td class="border p-3 text-center"><?= htmlspecialchars($patient['maKhamBenh'] ?? '') ?></td>
                            <td class="border p-3 text-center"><?= htmlspecialchars($patient['sdt'] ?? '') ?></td>
                            <td class="border p-3"><?= htmlspecialchars($patient['lichSuKham'] ?? '') ?></td>
                            <td class="border p-3 flex space-x-2 justify-center">
                                <a href=""><button class="btn btn-outline-primary">Xem</button></a>
                                <button class="btn btn-outline-success">Chỉnh sửa</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center p-3">Không có dữ liệu bệnh nhân</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
