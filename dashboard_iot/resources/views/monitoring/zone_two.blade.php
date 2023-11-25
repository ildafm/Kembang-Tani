@extends('template.master')
@section('content')
    {{-- style gauge --}}
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
                width: 300px;
                float: none;
                margin: 0 auto;
            }
        }
    </style>

    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Zone 2</h1>

            <button class="btn btn-sm btn-primary shadow-sm" id="btn_siram" onclick="clickButtonSiram()">
                <i class="fas fa-faucet fa-sm text-white-50"></i>
                Siram Tanaman
            </button>
            <button class="btn btn-sm btn-danger shadow-sm" onclick="clickButtonStopSiram()" id="btn_stop_siram" hidden>
                <i class="fas fa-stop fa-sm text-white-50"></i>
                Stop Menyiram
            </button>
        </div>

        <!-- Content Row -->
        <div class="row">

            <!-- Kelembaban tanah Card -->
            <div class="col-xl-4 col-md-4 col-sm-4 col-xs-12 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Kelembaban Tanah</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="card_kelembaban_tanah_value">
                                    @if (count($lastRecord) > 0)
                                        {{ $lastRecord['sensor_value']['percent_value'] }}%
                                    @else
                                        <i>No Data</i>
                                    @endif
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-tint fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kelembaban udara Card -->
            <div class="col-xl-4 col-md-4 col-sm-4 col-xs-12 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Kelembaban Udara</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">X%</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-wind fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Suhu Udara Card -->
            <div class="col-xl-4 col-md-4 col-sm-4 col-xs-12 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Suhu Udara</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">X&deg; C</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-temperature-low fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- Content Row -->

        <div class="row">
            <!-- Gauge Kelembaban Tanah Chart -->
            <div class="col-xl-4 col-lg-5">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Dropdown -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Kelembaban Tanah Zona 2</h6>
                                <div class="dropdown no-arrow">
                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                                {{-- gauge Kelembaban --}}
                                <figure class="highcharts-figure">
                                    <div id="container-kelembaban-tanah" class="chart-container"></div>
                                    <p class="highcharts-description">
                                    </p>
                                </figure>
                                {{-- <div class="chart-pie pt-4 pb-2"> --}}
                                {{-- <canvas id="myPieChart"></canvas> --}}
                                {{-- </div> --}}
                            </div>
                        </div>
                    </div>

                    {{-- kelembaban Udara --}}
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Dropdown -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Kelembaban Udara Zona 2</h6>
                                <div class="dropdown no-arrow">
                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                                {{-- gauge Kelembaban --}}
                                <p>Belum ada sensor</p>
                                {{-- <figure class="highcharts-figure">
                                    <div id="container-kelembaban-udara" class="chart-container"></div>
                                    <p class="highcharts-description">
                                    </p>
                                </figure> --}}
                                {{-- <div class="chart-pie pt-4 pb-2"> --}}
                                {{-- <canvas id="myPieChart"></canvas> --}}
                                {{-- </div> --}}
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Timeline kelembaban tanah --}}
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">History kelembaban tanah</h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                        @if (count($datas) > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Time</th>
                                            <th>Kelembaban Tanah (%)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($datas as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    @php
                                                        echo date('Y-m-d H:i:s', substr($item['timestamp']['epoch'], 0, 10));
                                                    @endphp
                                                </td>
                                                <td>{{ $item['sensor_value']['percent_value'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <i>No Data</i>
                        @endif

                        {{-- <div class="chart-area">
                                        <canvas id="myAreaChart"></canvas>
                                    </div> --}}
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- global variabel --}}
    <script>
        let percent_kelembaban_value = 0;
        let interval = 10000;
    </script>

    {{-- get realtime data --}}
    <script>
        function getRealtimeData() {
            $.ajax({
                type: 'GET',
                url: '{{ route('zone2_getrealtime') }}',
                success: function(data) {
                    // Update tampilan atau lakukan sesuatu dengan data
                    percent_kelembaban_value = data['sensor_value']['percent_value'];
                    // console.error(percent_kelembaban_value);

                    // update chart gauge
                    if (chartKelembabanTanah) {
                        point = chartKelembabanTanah.series[0].points[0];
                        point.update(percent_kelembaban_value);
                    }

                    card_kelembaban_tanah_value.innerText = `${percent_kelembaban_value}%`;
                },
                error: function(error) {
                    console.error(error);
                }
            });
        }

        // Set interval untuk melakukan polling setiap 5 detik
        setInterval(getRealtimeData, interval);
    </script>

    {{-- Script for gauge chart --}}
    <script>
        const gaugeOptions = {
            chart: {
                type: 'solidgauge'
            },

            title: null,

            pane: {
                center: ['50%', '85%'],
                size: '140%',
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
                    [0.1, '#55BF3B'], // green
                    [0.5, '#DDDF0D'], // yellow
                    [0.9, '#DF5353'] // red
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

        // The Kelembaban tanah gauge
        const chartKelembabanTanah = Highcharts.chart('container-kelembaban-tanah', Highcharts.merge(gaugeOptions, {
            yAxis: {
                min: 0,
                max: 100,
                title: {
                    text: 'Kelembaban Tanah'
                }
            },

            credits: {
                enabled: false
            },

            series: [{
                name: 'Kelembaban Tanah',
                data: [{{ $lastRecord['sensor_value']['percent_value'] }}],
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
    </script>

    {{-- Script for button --}}
    <script>
        function clickButtonSiram() {
            if (confirm("Aktifkan pompa penyiraman di zona 2?")) {
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
