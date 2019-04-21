import './Chart.bundle.js';

$(function() {

    const ft1 = $('.ft1').data('fatturato');
    const ft2 = $('.ft2').data('fatturato');
    const ft3 = $('.ft3').data('fatturato');
    const ft4 = $('.ft4').data('fatturato');
    const ft5 = $('.ft5').data('fatturato');

    const label1 = $('.label1').data('label');
    const label2 = $('.label2').data('label');
    const label3 = $('.label3').data('label');
    const label4 = $('.label4').data('label');
    const label5 = $('.label5').data('label');

    const ctx = $("#myChart");
    const myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["GEN", "FEB", "MAR", "APR", "MAG", "GIU", "LUG", "AGO", "SET", "OTT", "NOV", "DIC"],
            datasets: [{
                label: label1,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                data: ft1,
                fill: false,
            },{
                label: label2,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                data: ft2,
                fill: false,
            },{
                label: label3,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                data: ft3,
                fill: false,
            },{
                label: label4,
                backgroundColor: 'rgba(218, 162, 32, 0.2)',
                borderColor: 'rgba(218, 162, 32, 1)',
                data: ft4,
                fill: false,
            },{
                label: label5,
                backgroundColor: 'rgba(128, 0, 255, 0.2)',
                borderColor: 'rgba(128, 0, 255, 1)',
                data: ft5,
                fill: false,
            }]
},
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:false
                }
            }]
        },
        elements: {
            line: {
                tension: 0.2, // disables bezier curves
            }
        }
    }
});
});