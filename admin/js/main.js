
    // Biểu đồ khách truy cập
    const ctxVisitors = document.getElementById('visitorsChart').getContext('2d');
    ctxVisitors.canvas.height = 200;
    const visitorsChart = new Chart(ctxVisitors, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Visitors',
                data: [20, 25, 30, 28, 40.6, 31, 30],
                borderColor: '#38a1db',
                backgroundColor: 'rgba(56, 161, 219, 0.2)',
                borderWidth: 2,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#38a1db',
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e1e2d',
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff',
                    borderColor: '#38a1db',
                    borderWidth: 1,
                    callbacks: {
                        label: function(context) {
                            return `${context.parsed.y} visitors`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: {
                        color: '#9a9a9a',
                        font: { size: 10 },
                        maxRotation: 0,
                        minRotation: 0
                    }
                },
                y: {
                    grid: { display: false },
                    ticks: { display: false }
                }
            }
        }
    });

    // Biểu đồ hồi phục
    const ctxRecovery = document.getElementById('recoveryChart').getContext('2d');
    ctxRecovery.canvas.height = 200;
    const recoveryChart = new Chart(ctxRecovery, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Recovery',
                data: [15, 20, 28, 35, 30, 25, 20], // Dữ liệu mẫu cho biểu đồ hồi phục
                borderColor: '#4caf50', // Màu xanh lá cây cho biểu đồ hồi phục
                backgroundColor: 'rgba(76, 175, 80, 0.2)',
                borderWidth: 2,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#4caf50',
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e1e2d',
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff',
                    borderColor: '#4caf50',
                    borderWidth: 1,
                    callbacks: {
                        label: function(context) {
                            return `${context.parsed.y} recovered`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: {
                        color: '#9a9a9a',
                        font: { size: 10 },
                        maxRotation: 0,
                        minRotation: 0
                    }
                },
                y: {
                    grid: { display: false },
                    ticks: { display: false }
                }
            }
        }
    });
    // Biểu đồ bệnh nhân
    // Plugin để hiển thị nhãn ở trung tâm
    Chart.register({
        id: 'doughnutCenterText',
        beforeDraw: function(chart) {
            const { width, height, ctx } = chart;
            ctx.restore();
            const fontSize = (height / 150).toFixed(2);
            ctx.font = `${fontSize}em sans-serif`;
            ctx.textBaseline = "middle";

            const text = "90%";
            const text2 = "Recovered";
            const textX = Math.round((width - ctx.measureText(text).width) / 2);
            const textY = height / 2;

            ctx.fillStyle = "#ffffff";
            ctx.fillText(text, textX, textY - 10);

            ctx.font = `${(fontSize * 0.6).toFixed(2)}em sans-serif`;
            ctx.fillStyle = "#9a9a9a";
            ctx.fillText(text2, textX, textY + 15);
            ctx.save();
        }
    });

    const ctxPatients = document.getElementById('patientsChart').getContext('2d');
    const patientsChart = new Chart(ctxPatients, {
        type: 'doughnut',
        data: {
            labels: ['New', 'Recovered', 'Treatment'],
            datasets: [{
                data: [10, 60, 30], // Phần trăm mẫu cho từng loại
                backgroundColor: ['#4bc0c0', '#36a2eb', '#ff6384'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            cutout: '70%', // Khoảng trống ở giữa biểu đồ tròn
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#1e1e2d',
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff',
                    borderColor: '#38a1db',
                    borderWidth: 1
                }
            }
        }
    });
