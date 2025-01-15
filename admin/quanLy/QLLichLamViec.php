<?php
// Kết nối cơ sở dữ liệu
require_once("../config/config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $search = trim($_POST['search']);

    $sql = "SELECT 
                nhanvien.maNhanVien, 
                nhanvien.tenNhanVien, 
                lichlamviec.ngayLam
            FROM 
                nhanVien nhanvien
            JOIN 
                lichLamViec lichlamviec
            ON 
                nhanvien.maNhanVien = lichlamviec.maNhanVien";
    
    if (!empty($search)) {
        $sql .= " WHERE nhanvien.maNhanVien LIKE ?";
        $stmt = $conn->prepare($sql);
        $param = "%$search%";
        $stmt->bind_param("s", $param);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $result = $conn->query($sql);
    }

  
}

$sql = "SELECT nhanvien.maNhanVien, nhanvien.tenNhanVien, lichlamviec.ngayLam
        FROM nhanVien nhanvien
        JOIN lichLamViec lichlamviec
        ON nhanvien.maNhanVien = lichlamviec.maNhanVien";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách lịch làm việc</title>
    <style>
        .container {
            width: 80%;
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid black;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #f9f9f9;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }
        .table {
            border-collapse: collapse;
            width: 100%;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: center;
        }
        .table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .btn {
            border-radius: 5px;
            padding: 10px 20px;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            color: #fff;
        }
        .title {
            color: #007bff;
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="title">Danh sách lịch làm việc của nhân viên</h2>
    <div class="input-group mb-4">
        <form id="searchForm" style="display: flex; gap: 10px;">
            <input 
                type="text" 
                name="search" 
                id="searchInput" 
                class="form-control" 
                placeholder="Nhập mã nhân viên để tìm kiếm">
            <button class="btn btn-primary" type="button" id="searchButton">Tìm</button>
        </form>
    </div>
    <table class="table">
        <thead style="color: #007bff;">
            <tr>
                <th>STT</th>
                <th>Mã Nhân Viên</th>
                <th>Tên Nhân Viên</th>
                <th>Ngày Làm</th>
                <th>Chỉnh sửa</th>
            </tr>
        </thead>
        <tbody id="resultTable">
            <?php
            if ($result && $result->num_rows > 0) {
                $stt = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $stt++ . "</td>";
                    echo "<td>" . $row['maNhanVien'] . "</td>";
                    echo "<td>" . $row['tenNhanVien'] . "</td>";
                    echo "<td>" . $row['ngayLam'] . "</td>";
                    echo '<td><a href="index.php?quanli=lv-nv&maNhanVien=' . $row['maNhanVien'] . '" class="btn btn-warning btn-sm">Chỉnh sửa</a></td>';



                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Không có dữ liệu</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script>
document.getElementById('searchButton').addEventListener('click', function () {
    const searchInput = document.getElementById('searchInput').value;
    const resultTable = document.getElementById('resultTable');

    const data = new URLSearchParams();
    data.append('search', searchInput);

    fetch('quanly/searchNhanVien.php', {
      method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',  
        },
        body: data.toString()  
    })
    .then(response => response.json())  
    .then(data => {
        resultTable.innerHTML = '';  

        if (data.length > 0) {
            let stt = 1;
            data.forEach(item => {
                let row = document.createElement('tr');
                row.innerHTML = `
                    <td>${stt++}</td>
                    <td>${item.maNhanVien}</td>
                    <td>${item.tenNhanVien}</td>
                    <td>${item.ngayLam}</td>
                    <td><a href="edit.php?maNhanVien=${item.maNhanVien}" class="btn btn-primary">Chỉnh sửa</a></td>
                `;
                resultTable.appendChild(row);
            });
        } else {
            resultTable.innerHTML = '<tr><td colspan="5">Không tìm thấy nhân viên</td></tr>';
        }
    })
    .catch(error => {
        console.error('Lỗi:', error);
    });
});
</script>

</body>
</html>

<?php
$conn->close();
?>
