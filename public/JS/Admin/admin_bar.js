function drawBarChart(currentYearmonthlyIncome) {
    var ctx = document.getElementById("current_year_monthly_income_bar").getContext('2d');
    var labels = Object.keys(currentYearmonthlyIncome);
    var data = Object.values(currentYearmonthlyIncome);

    var gradientIncomeData = ctx.createLinearGradient(0, 0, 0, 400);
    gradientIncomeData.addColorStop(0.25, '#C1FF72'); // Start color
    gradientIncomeData.addColorStop(1, '#00BF63');


    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Monthly Income',
                    data: data,
                    backgroundColor: gradientIncomeData, // Customize bar color and opacity
                    borderColor: "green", // Border color
                    borderWidth: 1
                }              
            ]
        },
        options: {
            scales: {
                y: {
                    ticks: {
                        callback: function (value) {
                            return 'Tk ' + value; // Append 'Tk' to income value
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            var label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += 'Tk ' + context.parsed.y; // Append 'Tk' to tooltip value
                            return label;
                        }
                    }
                }
            }
        }
    });
}


