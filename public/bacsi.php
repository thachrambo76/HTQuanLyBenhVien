<?php
    include("class/clsbacsi.php");
    $p = new clsbacsi();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">

    <!-- link -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: white;
            color: rgb(37, 37, 37);
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px 0;
        }

        .photo{
            margin-top: 140px;
            margin-bottom: 20px;
            display: block;
            max-width: 100%;
            height: auto;
        }

        .doctor-card {
            display: flex;
            align-items: center;
            background-color: #f4f4f4;
            border-radius: 8px;
            margin-bottom: 20px;
            padding: 20px;
        }

        .doctor-card img {
            width: 220px;
            height: 220px;
            border-radius: 50%;
            margin-right: 20px;
            object-fit: cover;
        }

        .doctor-info {
            flex: 1;
        }

        .doctor-name {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .doctor-title {
            font-size: 16px;
            margin-bottom: 10px;
            color: #585858;
        }

        .doctor-desc {
            font-size: 14px;
            line-height: 1.5;
            color: #000000;
        }

        .doctor-actions {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }
        
    </style>
</head>
<body>
    <!-- header -->
    <div class="container">
    <div class="photo"><img src="public/img/headerbs.jpg" alt="" width="100%"></div>
        <?php
            $p->xemBacSi();
        ?>
    </div>

    </body>