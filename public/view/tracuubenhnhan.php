<head>
    <style>
        body {
            background-image: url('https://arteria.workvision.net/wp/wp-content/uploads/2022/04/img002.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: #fff;
        }

        .form-container {
            background: rgba(0, 0, 0, 0.6);
            padding: 20px;
            border-radius: 8px;
        }
    </style>
</head>

<body>
    <article>
        <section style="margin-top: 230px;">

            <div class="container mt-5">
                <h2 class="text-center mb-4">Tra cứu thông tin bệnh nhân</h2>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-container">
                            <form>
                                <div class="mb-3">
                                    <label for="patientID" class="form-label">Mã bệnh nhân</label>
                                    <input type="text" class="form-control" id="patientID"
                                        placeholder="Nhập mã bệnh nhân">
                                </div>
                                <div class="mb-3">
                                    <label for="patientName" class="form-label">Tên bệnh nhân</label>
                                    <input type="text" class="form-control" id="patientName"
                                        placeholder="Nhập tên bệnh nhân">
                                </div>
                                <div class="mb-3">
                                    <label for="patientDOB" class="form-label">Số điện thoại </label>
                                    <input type="number" class="form-control" id="patientDOB"
                                        placeholder="Nhập số điện thoại">
                                </div>
                                <div class="mb-3">
                                    <label for="patientDOB" class="form-label">Mã BHYT</label>
                                    <input type="number" class="form-control" id="patientDOB"
                                        placeholder="không bắt buột Nhập">
                                </div>
                                <button type="submit" class="btn btn-primary">Tra cứu</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex justify-content-center ">
                        <img src="https://th.bing.com/th/id/OIP.xQHTj6QJKtG_rSeP40A__AHaER?w=1024&h=591&rs=1&pid=ImgDetMain"
                            alt="Ảnh bệnh nhân" class="img-fluid border" style="width: 100%;">
                    </div>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        </section>
    </article>
    <br>
    <br>
    <br>
    <br>

</body>

</html>