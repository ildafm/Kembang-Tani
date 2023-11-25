@extends('template.master')
@section('content')
    <style>
        .highcharts-figure .chart-container {
            width: 300px;
            height: 200px;
            float: left;
        }

        .highcharts-figure,
        .highcharts-data-table table {
            width: 600px;
            margin: 0 auto;
        }

        .highcharts-data-table table {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid #ebebeb;
            margin: 10px auto;
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        .highcharts-data-table caption {
            padding: 1em 0;
            font-size: 1.2em;
            color: #555;
        }

        .highcharts-data-table th {
            font-weight: 600;
            padding: 0.5em;
        }

        .highcharts-data-table td,
        .highcharts-data-table th,
        .highcharts-data-table caption {
            padding: 0.5em;
        }

        .highcharts-data-table thead tr,
        .highcharts-data-table tr:nth-child(even) {
            background: #f8f8f8;
        }

        .highcharts-data-table tr:hover {
            background: #f1f7ff;
        }

        @media (max-width: 600px) {

            .highcharts-figure,
            .highcharts-data-table table {
                width: 100%;
            }

            .highcharts-figure .chart-container {
                width: auto;
                float: none;
                margin: 0 auto;
            }
        }
    </style>

    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>

            <button class="btn btn-sm btn-primary shadow-sm" id="btn_siram" onclick="clickButtonSiram()">
                <i class="fas fa-tint fa-sm text-white-50"></i>
                Siram Tanaman
            </button>
            <button class="btn btn-sm btn-danger shadow-sm" onclick="clickButtonStopSiram()" id="btn_stop_siram" hidden>
                <i class="fas fa-stop fa-sm text-white-50"></i>
                Stop Menyiram
            </button>
        </div>

        <!-- Content Row -->
        <div class="row">

            <!-- Kelembaban Udara (Zona 1) Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Kelembaban Udara (Zona 1)</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">X%</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-wind fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Suhu (Zona 1) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Suhu (Zona 1)</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">X&deg; C</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-temperature-low fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kelembaban Udara (Zona 2) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Kelembaban Udara (Zona 2)
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">X%</div>
                                    </div>
                                    {{-- <div class="col">
                                        <div class="progress progress-sm mr-2">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 50%"
                                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-wind fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Suhu (Zona 2) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Suhu (Zona 2)</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">X&deg; C</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-temperature-low fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- gauge kelembaban tanah --}}
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Kelembaban Tanah</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                        aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Dropdown Header:</div>
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <figure class="highcharts-figure">
                    <div id="container-zone_1" class="chart-container"></div>
                    <div id="container-zone_2" class="chart-container"></div>

                </figure>
                {{-- <canvas id="myAreaChart"></canvas> --}}
            </div>
        </div>

    </div>

    {{-- global variabel --}}
    <script>
        let percent_kelembaban_zone_1_value = 0;
        let percent_kelembaban_zone_2_value = 0;
        let interval = 5000;
    </script>

    {{-- get realtime data and gauge chart --}}
    <script>
        function getRealtimeData() {
            $.ajax({
                type: 'GET',
                url: '{{ route('dashboard_getrealtime') }}',
                success: function(data_zone) {
                    // Update tampilan atau lakukan sesuatu dengan data
                    let data_zone_1 = data_zone['lastRecordZone1'];
                    let data_zone_2 = data_zone['lastRecordZone2'];

                    percent_kelembaban_zone_1_value = data_zone_1['sensor_value']['percent_value'];
                    percent_kelembaban_zone_2_value = data_zone_2['sensor_value']['percent_value'];

                    // console.log(percent_kelembaban_zone_1_value);
                    // console.log(percent_kelembaban_zone_2_value);

                    // update chart gauge
                    if (chartZone1) {
                        point = chartZone1.series[0].points[0];
                        point.update(percent_kelembaban_zone_1_value);
                    }

                    // update chart gauge
                    if (chartZone2) {
                        point = chartZone2.series[0].points[0];
                        point.update(percent_kelembaban_zone_2_value);
                    }
                },
                error: function(error) {
                    console.error(error);
                }
            });
        }

        // Set interval untuk melakukan polling setiap 5 detik
        setInterval(getRealtimeData, interval);
    </script>


    {{-- script gauge bar --}}
    <script>
        const gaugeOptions = {
            chart: {
                type: 'solidgauge'
            },

            title: null,

            pane: {
                center: ['50%', '85%'],
                size: '100%',
                startAngle: -90,
                endAngle: 90,
                background: {
                    backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || '#EEE',
                    innerRadius: '60%',
                    outerRadius: '100%',
                    shape: 'arc'
                }
            },

            exporting: {
                enabled: false
            },

            tooltip: {
                enabled: false
            },

            // the value axis
            yAxis: {
                stops: [
                    [0.4, '#DF5353'], // RED DF5353
                    [0.6, '#DDDF0D'], // yellow DDDF0D
                    [0.7, '#55BF3B'] // GREEN 55BF3B
                ],
                lineWidth: 0,
                tickWidth: 0,
                minorTickInterval: null,
                tickAmount: 2,
                title: {
                    y: -70
                },
                labels: {
                    y: 16
                }
            },

            plotOptions: {
                solidgauge: {
                    dataLabels: {
                        y: 5,
                        borderWidth: 0,
                        useHTML: true
                    }
                }
            }
        };

        // The speed gauge
        const chartZone1 = Highcharts.chart('container-zone_1', Highcharts.merge(gaugeOptions, {
            yAxis: {
                min: 0,
                max: 100,
                title: {
                    text: 'Kelembaban Tanah Zone 1'
                }
            },

            credits: {
                enabled: false
            },

            series: [{
                name: 'Kelembaban Tanah Zone 1',
                data: [{{ $percent_value_zone_1 }}],
                dataLabels: {
                    format: '<div style="text-align:center">' +
                        '<span style="font-size:25px">{y}%</span><br/>' +
                        // '<span style="font-size:12px;opacity:0.4">km/h</span>' +
                        '</div>'
                },
                tooltip: {
                    valueSuffix: ' %'
                }
            }]

        }));

        // The Kelembaban Tanah Zone 2 gauge
        const chartZone2 = Highcharts.chart('container-zone_2', Highcharts.merge(gaugeOptions, {
            yAxis: {
                min: 0,
                max: 100,
                title: {
                    text: 'Kelembaban Tanah Zone 2'
                }
            },

            series: [{
                name: 'Kelembaban Tanah Zone 2',
                data: [{{ $percent_value_zone_2 }}],
                dataLabels: {
                    format: '<div style="text-align:center">' +
                        '<span style="font-size:25px">{y}%</span><br/>' +
                        // '<span style="font-size:12px;opacity:0.4">' +
                        // '* 1000 / min' +
                        '</span>' +
                        '</div>'
                },
                tooltip: {
                    valueSuffix: ' %'
                }
            }]

        }));
    </script>

    {{-- script click button --}}
    <script>
        function clickButtonSiram() {
            if (confirm("Aktifkan pompa penyiraman di semua zona?")) {
                btn_siram.hidden = true
                btn_stop_siram.hidden = false
            }

        }

        function clickButtonStopSiram() {
            alert("Pompa siram tanaman telah dimatikan");
            btn_siram.hidden = false
            btn_stop_siram.hidden = true
        }
    </script>
@endsection
