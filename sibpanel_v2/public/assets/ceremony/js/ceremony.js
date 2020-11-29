$(document).ready(function(){

// sell_count
    let ctx_sell_count = document.getElementById('chart_sell_count');
    Chart.plugins.unregister(ChartDataLabels);
    Chart.defaults.global.defaultFontFamily = 'iranSans';
    Chart.Legend.prototype.afterFit = function() {
        this.height = this.height + 30;
    };
    let labels_sell_count=['تهران','فارس','اصفهان','سایر'];
    let data_sell_count=[35.70,32.60,15.46,16.24];


    let sell_count_chart = new Chart(ctx_sell_count, {
        plugins: [ChartDataLabels],
        type: 'pie',
        data: {
            labels: labels_sell_count,
            datasets: [{
                label: 'تعداد فروش',
                data: data_sell_count,
                backgroundColor: [

                    '#4582ec',
                    '#fd7e14',
                    '#cb3278',
                    '#02b875',
                    '#d9534f',
                    '#17a2b8',
                    '#6610f2',

                    'rgb(201, 203, 207)'

                ],
                borderColor: '#e7e7e7',
                borderWidth: 2,

            }]
        },
        options: {
            legend: {
                position:'bottom',
                labels: {
                    fontStyle: 'bold',
                    fontSize: 14
                }
            },
            plugins: {
                datalabels: {
                    formatter: (value, ctx) => {
                        let sum = 0;
                        let dataArr = ctx.chart.data.datasets[0].data;
                        dataArr.map(data => {
                            sum += data;
                        });
                        let percentage = "%"+(value*100 / sum).toFixed(2);
                        return labels_sell_count[ctx.dataIndex]+" "+percentage;
                    },
                    backgroundColor: '#000000',
                    borderRadius: 4,
                    color: 'white',
                    font: {
                        weight: 'bold'
                    },
                    textAlign:'center',
                    padding: {
                        right:6,
                        left:6
                    }
                }
            },
            responsive: false
        }
    });



    // sell_amount
    let ctx_sell_amount = document.getElementById('chart_sell_amount');
    Chart.plugins.unregister(ChartDataLabels);
    Chart.defaults.global.defaultFontFamily = 'iranSans';
    Chart.Legend.prototype.afterFit = function() {
        this.height = this.height + 30;
    };
    let labels_sell_amount=['تهران','فارس','اصفهان','سایر'];
    let data_sell_amount=[34.98,29.84,21.26,13.72];


    let sell_amount_chart = new Chart(ctx_sell_amount, {
        plugins: [ChartDataLabels],
        type: 'pie',
        data: {
            labels: labels_sell_amount,
            datasets: [{
                label: 'مبلغ فروش',
                data: data_sell_amount,
                backgroundColor: [

                    '#4582ec',
                    '#fd7e14',
                    '#cb3278',
                    '#02b875',
                    '#d9534f',
                    '#17a2b8',
                    '#6610f2',

                    'rgb(201, 203, 207)'

                ],
                borderColor: '#e7e7e7',
                borderWidth: 2,

            }]
        },
        options: {
            legend: {
                position:'bottom',
                labels: {
                    fontStyle: 'bold',
                    fontSize: 14
                }
            },
            plugins: {
                datalabels: {
                    formatter: (value, ctx) => {
                        let sum = 0;
                        let dataArr = ctx.chart.data.datasets[0].data;
                        dataArr.map(data => {
                            sum += data;
                        });
                        let percentage = "%"+(value*100 / sum).toFixed(2);
                        return labels_sell_amount[ctx.dataIndex]+" %"+value;//+percentage;
                    },
                    backgroundColor: '#000000',
                    borderRadius: 4,
                    color: 'white',
                    font: {
                        weight: 'bold'
                    },
                    textAlign:'center',
                    padding: {
                        right:6,
                        left:6
                    }
                }
            },
            responsive: false
        }
    });



    // type_amount
    let ctx_type_amount = document.getElementById('chart_type_amount');
    Chart.plugins.unregister(ChartDataLabels);
    Chart.defaults.global.defaultFontFamily = 'iranSans';
    Chart.Legend.prototype.afterFit = function() {
        this.height = this.height + 30;
    };
    let labels_type_amount=['ایرانی','خارجی'];
    let data_type_amount=[62.15,37.85];


    let type_amount_chart = new Chart(ctx_type_amount, {
        plugins: [ChartDataLabels],
        type: 'pie',
        data: {
            labels: labels_type_amount,
            datasets: [{
                label: 'مبلغ فروش',
                data: data_type_amount,
                backgroundColor: [

                    '#17a2b8',
                    '#d9534f',

                    '#cb3278',
                    '#4582ec',
                    '#fd7e14',

                    '#02b875',
                    '#6610f2',

                    'rgb(201, 203, 207)'

                ],
                borderColor: '#e7e7e7',
                borderWidth: 2,

            }]
        },
        options: {
            legend: {
                position:'bottom',
                labels: {
                    fontStyle: 'bold',
                    fontSize: 14
                }
            },
            plugins: {
                datalabels: {
                    formatter: (value, ctx) => {
                        let sum = 0;
                        let dataArr = ctx.chart.data.datasets[0].data;
                        dataArr.map(data => {
                            sum += data;
                        });
                        let percentage = "%"+(value*100 / sum).toFixed(2);
                        return labels_type_amount[ctx.dataIndex]+" %"+value;//+percentage;
                    },
                    backgroundColor: '#000000',
                    borderRadius: 4,
                    color: 'white',
                    font: {
                        weight: 'bold'
                    },
                    textAlign:'center',
                    padding: {
                        right:6,
                        left:6
                    }
                }
            },
            responsive: false
        }
    });


    // type_count
    let ctx_type_count = document.getElementById('chart_type_count');
    Chart.plugins.unregister(ChartDataLabels);
    Chart.defaults.global.defaultFontFamily = 'iranSans';
    Chart.Legend.prototype.afterFit = function() {
        this.height = this.height + 30;
    };
    let labels_type_count=['ایرانی','خارجی'];
    let data_type_count=[92.65,7.35];


    let type_count_chart = new Chart(ctx_type_count, {
        plugins: [ChartDataLabels],
        type: 'pie',
        data: {
            labels: labels_type_count,
            datasets: [{
                label: 'تعداد فروش',
                data: data_type_count,
                backgroundColor: [
                    '#17a2b8',
                    '#d9534f',
                    '#cb3278',
                    '#4582ec',
                    '#fd7e14',
                    '#6610f2',

                    'rgb(201, 203, 207)'

                ],
                borderColor: '#e7e7e7',
                borderWidth: 2,

            }]
        },
        options: {
            legend: {
                position:'bottom',
                labels: {
                    fontStyle: 'bold',
                    fontSize: 14
                }
            },
            plugins: {
                datalabels: {
                    formatter: (value, ctx) => {
                        let sum = 0;
                        let dataArr = ctx.chart.data.datasets[0].data;
                        dataArr.map(data => {
                            sum += data;
                        });
                        let percentage = "%"+(value*100 / sum).toFixed(2);
                        return labels_type_count[ctx.dataIndex]+" %"+value;//+percentage;
                    },
                    backgroundColor: '#000000',
                    borderRadius: 4,
                    color: 'white',
                    font: {
                        weight: 'bold'
                    },
                    textAlign:'center',
                    padding: {
                        right:6,
                        left:6
                    }
                }
            },
            responsive: false
        }
    });



    let ctx_yearly = document.getElementById('chart_yearly');
    Chart.plugins.unregister(ChartDataLabels);
    Chart.defaults.global.defaultFontFamily = 'iranSans';
    Chart.Legend.prototype.afterFit = function() {
        this.height = this.height + 30;
    };
    let labels_yearly=['فروردین','اردیبهشت','خرداد','تیر','مرداد','شهریور','مهر','آبان','آذر','دی','بهمن','اسفند'];
    let data_yearly97=[0,0,0,0,0,0,0,0,0,6513,11305,25649];
    let data_yearly98=[140412,75717,40658,35970,56077,66475,65537,97674,41446,41355,36105,5220];
    let data_yearly99=[2,367,15527,9154,10965,19363,13158,5139,0,0,0,0];

    let yearly_chart = new Chart(ctx_yearly, {
        plugins: [ChartDataLabels],
        type: 'line',
        data: {
            labels: labels_yearly,
            datasets: [
                {
                    label: 'سال ۹۷',
                    data: data_yearly97,
                    datalabels: {
                        align: 'end',
                        anchor: 'end'
                    },
                    backgroundColor: [
                        '#4582ec22',

                    ],
                    borderColor: '#4582ec99',
                    borderWidth: 3,
                    pointBackgroundColor: '#4582ec99'
                },
                {
                    label: 'سال ۹۸',
                    data: data_yearly98,
                    datalabels: {
                        align: 'end',
                        anchor: 'end'
                    },
                    backgroundColor: [
                        '#fd7e1422',

                    ],
                    borderColor: '#fd7e14',
                    borderWidth: 3,
                    pointBackgroundColor: '#fd7e14'
                },
                {
                    label: 'سال ۹۹',
                    data: data_yearly99,
                    datalabels: {
                        align: 'end',
                        anchor: 'end'
                    },
                    backgroundColor: [
                        '#02b87522',
                    ],
                    borderColor: '#02b875',
                    borderWidth: 3,
                    pointBackgroundColor: '#02b875'
                },
            ]
        },
        options: {
            plugins: {
                datalabels: {
                    formatter: (value, ctx) => {
                        return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    },
                    backgroundColor: '#000',
                    borderRadius: 4,
                    color: 'white',
                    font: {
                        weight: 'bold',
                        // size:14
                    },
                    // formatter: Math.round,
                    textAlign:'center',
                    padding: {
                        right:6,
                        left:6
                    },
                    display: true,

                }
            },
            legend: {
                labels: {

                    fontStyle: 'bold',
                    fontSize: 14
                }
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: false,
                        fontStyle: 'bold',
                        padding:20
                    }
                }],
                xAxes: [{
                    ticks: {
                        fontStyle: 'bold',
                        fontSize: 14,
                    }
                }]
            },
            maintainAspectRatio: false,
            // responsive:false
        }
    });






    let provinces= $('#province > a > path');
    for (let i = 0; i < provinces.length; i++) {
        let el = provinces[i];
        el.style.fill="#bd2130";
    }



});





function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

async function doTheThing() {
    document.getElementById("btn_start").style.display="none";
    document.getElementById("wait").style.display="block";
    $('.progress-tooltip')[0].style.display="block";
    await sleep(1000);

    $(".dot").each(function(){
        this.style.color="#28a745"
        this.style.display="none"
    });

    let provinces= $('#province > a > path');
    for (let i = 0; i < provinces.length; i++) {
        let el = provinces[i];
        await sleep(300);
        el.style.fill="#28a745";

        $("#progress").val(i+1);
        let percent = ((i+1)*100)/31;
        $("#progress-span").text(Math.round(percent)+"%");
    }

    $(".dot").each(function(){
        this.style.display=""
    });



    await sleep(1300);

    $('#exampleModal').modal('toggle');
}




