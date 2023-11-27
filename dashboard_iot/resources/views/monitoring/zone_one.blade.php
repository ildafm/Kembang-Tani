@extends('template.master')
@section('content')
    {{-- style gauge kelembaban tanah --}}
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

    {{-- style boosting chart --}}
    <style>
        .highcharts-figure-boosting,
        .highcharts-data-table table {
            min-width: auto;
            max-width: 800px;
            margin: 1em auto;
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
    </style>

    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Zone 1</h1>

            <button class="btn btn-sm btn-primary shadow-sm" id="btn_siram" onclick="clickButtonSiram()">
                <i class="fas fa-faucet fa-sm text-white-50"></i>
                Siram Tanaman
            </button>
            <button class="btn btn-sm btn-danger shadow-sm" onclick="clickButtonStopSiram()" id="btn_stop_siram" hidden>
                <i class="fas fa-stop fa-sm text-white-50"></i>
                Stop Menyiram
            </button>
        </div>

        <!-- Content Card Row -->
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
                                    @if ($lastRecord != '0' && count($lastRecord) > 0)
                                        {{ $lastRecord['sensor_value']['percent_value'] }}%
                                    @else
                                        <i>No Data</i>
                                    @endif
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-tint fa-2x"></i>
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
                                <i class="fas fa-wind fa-2x"></i>
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
                                <i class="fas fa-temperature-low fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- Content Row -->

        {{-- Chart --}}
        <div class="row">
            <!-- Gauge Chart -->
            <div class="col-xl-4 col-lg-5">
                <div class="row">
                    {{-- kelembaban tanah --}}
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Dropdown -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Kelembaban Tanah Zona 1</h6>
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
                                </figure>
                                {{-- <div class="chart-pie pt-4 pb-2"> --}}
                                {{-- <canvas id="myPieChart"></canvas> --}}
                                {{-- </div> --}}
                            </div>
                        </div>
                    </div>

                    {{-- Suhu Udara --}}
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Dropdown -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Suhu Udara Zona 1</h6>
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
                                {{-- gauge suhu --}}
                                <p>Belum ada sensor</p>
                                {{-- <figure class="highcharts-figure-suhu-udara">
                                    <div id="container-suhu-udara"></div>
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
                        @if ($datas != '0' && count($datas) > 0)
                            <figure class="highcharts-figure-boosting">
                                <div id="container-boost-chart"></div>
                            </figure>
                        @else
                            <i>No Data</i>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel History --}}
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
                @if ($datas != '0' && count($datas) > 0)
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
            </div>
        </div>

    </div>

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- global variabel --}}
    <script>
        let percent_kelembaban_value = 0;
        let interval = 1000;
        let n_boost = 5;
    </script>

    {{-- get realtime data and gauge chart --}}
    <script>
        function getRealtimeData() {
            $.ajax({
                type: 'GET',
                url: '{{ route('zone1_getrealtimedata') }}',
                success: function(data) {

                    const arr_1 = [];

                    let lastdata = data[data.length - 1];
                    let lastEpoch = lastdata.timestamp.epoch;

                    for (let i = data.length - 1; i >= 0; i--) {
                        if (data[i].timestamp.epoch >= (lastEpoch - (n_boost * 60))) {
                            let per_val = data[i].sensor_value.percent_value;
                            let epoch_time = data[i].timestamp.epoch;
                            epoch_time = epoch_time * 1000;

                            // push data epoch dan percent value ke dalam variabel array
                            arr_1.push([epoch_time, per_val]);
                        } else {
                            break;
                        }
                    }

                    // update boost
                    if (boostChartKelembabanTanah) {
                        console.log(arr_1);
                        boost_data_kelembaban_tanah = boostChartKelembabanTanah.series[0];
                        // boost_data_kelembaban_tanah.update(arr_1);
                        boost_data_kelembaban_tanah.setData(arr_1, true, true, false);
                    }

                    // update chart gauge
                    if (chartKelembabanTanah) {
                        gauge_point_kelembaban_tanah = chartKelembabanTanah.series[0].points[0];
                        gauge_point_kelembaban_tanah.update(lastdata.sensor_value.percent_value);
                    }

                    card_kelembaban_tanah_value.innerText = `${lastdata.sensor_value.percent_value}%`;
                },
                error: function(error) {
                    console.error(error);
                }
            });
        }
        // Set interval untuk melakukan polling setiap 5 detik
        setInterval(getRealtimeData, interval);
    </script>

    {{-- script for boosting chart --}}
    <script>
        function getData(n) {
            // get data berdasarka n jam yang lalu
            const lastRecordHour =
                {{ $lastRecord != '0' && count($lastRecord) > 0 ? $lastRecord['timestamp']['hour'] : -1 }}
            const arr = [];

            // konversi array menjadi json
            var datas = @json($datas);
            var lastRecord = @json($lastRecord);

            // Pastikan datas masih dalam format JSON
            // console.log(datas);

            // jika data tidak kosoong maka eksekusi
            if (lastRecordHour > -1) {

                for (let index = 0; index < datas.length; index++) {

                    if (datas[index].timestamp.epoch >= (lastRecord.timestamp.epoch - (n_boost * 60))) {
                        let per_val = datas[index].sensor_value.percent_value;
                        let epoch_time = datas[index].timestamp.epoch;
                        epoch_time = epoch_time * 1000;

                        // push data epoch dan percent value ke dalam variabel array
                        arr.push([epoch_time, per_val]);
                    } else {
                        break;
                    }
                }
            }
            // Menampilkan hasil
            console.log(arr);

            return arr;
        }

        var data = getData(n_boost);

        // console.time('line');
        const boostChartKelembabanTanah = Highcharts.chart('container-boost-chart', {

            chart: {
                zoomType: 'x',
                boost: {
                    enabled: true,
                    // useGPUTranslations: true
                }
            },

            title: {
                text: 'Riwayat kelembaban tanah dalam ' + n_boost + ' menit terakhir'
            },

            subtitle: {
                text: 'Zone 1 Live Mode'
            },

            accessibility: {
                screenReaderSection: {
                    beforeChartFormat: `
                <{headingTagName}>{chartTitle}</{headingTagName}>
                <div>{chartSubtitle}</div>
                <div>{chartLongdesc}</div>
                <div>{xAxisDescription}</div>
                <div>{yAxisDescription}</div>`
                }
            },

            tooltip: {
                valueDecimals: 2
            },

            xAxis: {
                type: 'datetime'
            },

            series: [{
                data: data,
                lineWidth: 0.5,
                name: 'Kelembaban tanah (%)'
            }]

        });
        // console.timeEnd('line');
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
                data: [
                    {{ $lastRecord != '0' && count($lastRecord) > 0 ? $lastRecord['sensor_value']['percent_value'] : 0 }}
                ],
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
            if (confirm("Aktifkan pompa penyiraman di zona 1?")) {
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
