import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import '../css/app.css';
import Chart from 'chart.js/auto';
window.Chart = Chart;

document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('contentChart');
    if (canvas) {
        const labels = window.chartData.labels;
        const instagramData = window.chartData.instagram;
        const facebookData = window.chartData.facebook;

        console.log('Labels:', labels);
        console.log('Instagram Data:', instagramData);
        console.log('Facebook Data:', facebookData);

        if (labels.length > 0 && (instagramData.length > 0 || facebookData.length > 0)) {
            const ctx = canvas.getContext('2d');
            const contentChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Instagram',
                            data: instagramData,
                            borderColor: 'rgba(54, 162, 235, 1)',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                            pointBorderColor: '#fff',
                            pointHoverBackgroundColor: '#fff',
                            pointHoverBorderColor: 'rgba(54, 162, 235, 1)',
                        },
                        {
                            label: 'Facebook',
                            data: facebookData,
                            borderColor: 'rgba(59, 89, 152, 1)',
                            backgroundColor: 'rgba(59, 89, 152, 0.2)',
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: 'rgba(59, 89, 152, 1)',
                            pointBorderColor: '#fff',
                            pointHoverBackgroundColor: '#fff',
                            pointHoverBorderColor: 'rgba(59, 89, 152, 1)',
                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true
                        }
                    }
                }
            });
        } else {
            console.log('Tidak ada data untuk menampilkan chart.');
        }
    } else {
        console.log('Canvas element not found');
    }
});