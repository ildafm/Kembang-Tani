@extends('template.master')
@section('content')

    {{-- style gauge kelembaban tanah --}}
    <style>
        .highcharts-figure .chart-container {
            width: 300px;
            height: 200px;
            float: unset;
        }

        .highcharts-figure,
        .highcharts-data-table table {
            width: 300px;
            margin: auto;
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
            <h1 class="h3 mb-0 text-gray-800"><b>{{ $title }}</b></h1>

            <button class="btn btn-sm shadow-sm" style="background-color: #5dc971" id="btn_siram" onclick="clickButtonSiram()">
                <i class="fas fa-tint fa-sm text-white"></i>
                <div class="text-white d-inline">Siram Tanaman</div>
            </button>
            <button class="btn btn-sm btn-danger shadow-sm" onclick="clickButtonStopSiram()" id="btn_stop_siram" hidden>
                <i class="fas fa-stop fa-sm text-white"></i>
                Stop Menyiram
            </button>
        </div>

        <!-- Content Card Row -->
        <div class="row">

            <!-- Kelembaban tanah Card -->
            <div class="col-xl-4 col-md-4 col-sm-4 col-xs-12 mb-4">
                <div class="card border-left-primary shadow h-100 py-2 card-border-custom">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Kelembaban Tanah</div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"
                                            id="card_kelembaban_tanah_value">
                                            @if ($lastRecord != '0' && count($lastRecord) > 0)
                                                {{ $lastRecord['percent_value'] }}%
                                            @else
                                                <i>No Data</i>
                                            @endif
                                        </div>
                                    </div>
                                    {{-- progress --}}
                                    <div class="col">
                                        <div class="progress progress-sm mr-2">
                                            <div class="progress-bar bg-info" role="progressbar"
                                                style="width: {{ $lastRecord['percent_value'] }}%"
                                                id="progress_bar_card_kelembaban" aria-valuenow="50" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-tint fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kondisi tanah Card -->
            <div class="col-xl-4 col-md-4 col-sm-4 col-xs-12 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Kondisi tanah</div>
                                @if ($lastRecord != '0' && count($lastRecord) > 0)
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="card_kondisi_tanah">
                                        @php
                                            if ($lastRecord['percent_value'] <= 40) {
                                                echo 'Kering';
                                            } elseif ($lastRecord['percent_value'] <= 67) {
                                                echo 'Lembab';
                                            } elseif ($lastRecord['percent_value'] > 67) {
                                                echo 'Basah';
                                            } else {
                                                echo 'Kesalahan dalam mendeteksi';
                                            }
                                        @endphp
                                    </div>
                                @else
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <i>No Data</i>
                                    </div>
                                @endif
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-glass-water fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Aksi Card -->
            <div class="col-xl-4 col-md-4 col-sm-4 col-xs-12 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Aksi</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    @if ($lastRecord != '0' && count($lastRecord) > 0)
                                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="card_aksi">
                                            @php
                                                if ($lastRecord['percent_value'] > 40) {
                                                    echo 'Tidak perlu disiram';
                                                } elseif ($lastRecord['percent_value'] >= 0) {
                                                    echo 'Perlu disiram';
                                                } else {
                                                    echo 'Kesalahan dalam mendeteksi';
                                                }
                                            @endphp
                                        </div>
                                    @else
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <i>No Data</i>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-shower fa-2x"></i>
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
                        <div class="card shadow mb-4 card-border-custom">
                            <!-- Card Header -->
                            <div class="card-header card-header-border-custom py-3 d-flex flex-row align-items-center justify-content-between"
                                style="border-radius: 25px 25px 0px 0px">
                                <h6 class="m-0 font-weight-bold" style="color: #004225">Kelembaban Tanah</h6>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                                {{-- gauge Kelembaban --}}
                                <figure class="highcharts-figure">
                                    <div id="container-kelembaban-tanah" class="chart-container"></div>
                                </figure>
                            </div>
                        </div>
                    </div>

                    {{-- Prediksi cuaca --}}
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card shadow mb-4 card-border-custom">
                            <!-- Card Header -->
                            <div class="card-header card-header-border-custom py-3 d-flex flex-row align-items-center justify-content-between"
                                style="border-radius: 25px 25px 0px 0px">
                                <h6 class="m-0 font-weight-bold" style="color: #004225">Prediksi Cuaca</h6>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                                {{-- icon cuaca --}}
                                <center>
                                    <div class="row">
                                        <div class="col">
                                            <img id="prediksi_icon" src="" alt="Icon_cuaca.png"
                                                style="width: auto; height: auto" class="card-img-top">
                                        </div>
                                        <div class="col">
                                            <p id="prediksi_cuaca">Cuaca</p>
                                            <p id="prediksi_waktu">Waktu</p>
                                        </div>
                                    </div>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- History kelembaban tanah --}}
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4 card-border-custom">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header card-header-border-custom py-3 d-flex flex-row align-items-center justify-content-between"
                        style="border-radius: 25px 25px 0px 0px">
                        <h6 class="m-0 font-weight-bold" style="color: #004225">History kelembaban tanah</h6>
                        {{-- dropdown --}}
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Atur waktunya</div>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item active" href="#" data-toggle="tab"
                                    onclick="changeTab('boost_live_mode')">Live Mode</a>

                                <a class="dropdown-item" href="#" data-toggle="tab"
                                    onclick="changeTab('boost_1_jam')"> 1 jam</a>

                                <a class="dropdown-item" href="#" data-toggle="tab"
                                    onclick="changeTab('boost_4_jam')"> 4 jam</a>

                                <a class="dropdown-item" href="#" data-toggle="tab"
                                    onclick="changeTab('boost_8_jam')">8 jam</a>

                                <a class="dropdown-item" href="#" data-toggle="tab"
                                    onclick="changeTab('boost_16_jam')"> 16 jam</a>

                                <a class="dropdown-item" href="#" data-toggle="tab"
                                    onclick="changeTab('boost_24_jam')"> 24 jam</a>
                            </div>
                        </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        @if ($datas != '0' && count($datas) > 0)
                            <div class="tab-content">
                                {{-- boost live mode --}}
                                <div class="tab-pane active" id="boost_live_mode">
                                    <figure class="highcharts-figure-boosting">
                                        <div id="container-boost-chart"></div>
                                    </figure>
                                </div>
                                {{-- boost 1 jam --}}
                                <div class="tab-pane" id="boost_1_jam">
                                    <figure class="highcharts-figure-boosting">
                                        <div id="container-boost-chart-non_live-1"></div>
                                    </figure>
                                </div>
                                {{-- boost 4 jam --}}
                                <div class="tab-pane" id="boost_4_jam">
                                    <figure class="highcharts-figure-boosting">
                                        <div id="container-boost-chart-non_live-4"></div>
                                    </figure>
                                </div>
                                {{-- boost 8 jam --}}
                                <div class="tab-pane" id="boost_8_jam">
                                    <figure class="highcharts-figure-boosting">
                                        <div id="container-boost-chart-non_live-8"></div>
                                    </figure>
                                </div>
                                {{-- boost 16 jam --}}
                                <div class="tab-pane" id="boost_16_jam">
                                    <figure class="highcharts-figure-boosting">
                                        <div id="container-boost-chart-non_live-16"></div>
                                    </figure>
                                </div>
                                {{-- boost 24 jam --}}
                                <div class="tab-pane" id="boost_24_jam">
                                    <figure class="highcharts-figure-boosting">
                                        <div id="container-boost-chart-non_live-24"></div>
                                    </figure>
                                </div>
                            </div>
                        @else
                            <i>No Data</i>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel History --}}
        <div class="card shadow mb-4 card-border-custom">
            <!-- Card Header -->
            <div class="card-header card-header-border-custom py-3 d-flex flex-row align-items-center justify-content-between"
                style="border-radius: 25px 25px 0px 0px">
                <h6 class="m-0 font-weight-bold" style="color: #004225">Tabel history kelembaban tanah</h6>

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
                                                $e = $item['epoch'];
                                                echo date('Y-m-d H:i:s', substr($e, 0, 10));
                                            @endphp
                                        </td>
                                        <td>{{ $item['percent_value'] }}</td>
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

    {{-- change tab pane script --}}
    <script>
        function changeTab(tabId) {
            // Aktifkan tab yang sesuai dengan tabId
            $('.tab-pane').removeClass('active show');
            $('.dropdown-item').removeClass('active');
            $('#' + tabId).addClass('active show');

            if (tabId == "boost_1_jam") {
                let n_boost_non_live = 1 * 60;
                var data_non_live = getData(n_boost_non_live);

                Highcharts.chart('container-boost-chart-non_live-1', {
                    chart: {
                        zoomType: 'x',
                        boost: {
                            enabled: true,
                            // useGPUTranslations: true
                        }
                    },

                    title: {
                        text: 'Riwayat kelembaban tanah dalam 1 jam terakhir'
                    },

                    subtitle: {
                        text: 'Non-live mode'
                    },

                    accessibility: {
                        screenReaderSection: {
                            beforeChartFormat: '<{headingTagName}>{chartTitle}</{headingTagName}><div>{chartSubtitle}</div><div>{chartLongdesc}</div><div>{xAxisDescription}</div><div>{yAxisDescription}</div>'
                        }
                    },

                    tooltip: {
                        valueDecimals: 2
                    },

                    xAxis: {
                        type: 'datetime'
                    },

                    series: [{
                        data: data_non_live,
                        lineWidth: 0.5,
                        name: 'Kelembaban tanah (%)'
                    }]

                });
            } else if (tabId == "boost_4_jam") {
                let n_boost_non_live = 4 * 60;
                var data_non_live = getData(n_boost_non_live);

                Highcharts.chart('container-boost-chart-non_live-4', {
                    chart: {
                        zoomType: 'x',
                        boost: {
                            enabled: true,
                            // useGPUTranslations: true
                        }
                    },

                    title: {
                        text: 'Riwayat kelembaban tanah dalam 4 jam terakhir'
                    },

                    subtitle: {
                        text: 'Non-live mode'
                    },

                    accessibility: {
                        screenReaderSection: {
                            beforeChartFormat: '<{headingTagName}>{chartTitle}</{headingTagName}><div>{chartSubtitle}</div><div>{chartLongdesc}</div><div>{xAxisDescription}</div><div>{yAxisDescription}</div>'
                        }
                    },

                    tooltip: {
                        valueDecimals: 2
                    },

                    xAxis: {
                        type: 'datetime'
                    },

                    series: [{
                        data: data_non_live,
                        lineWidth: 0.5,
                        name: 'Kelembaban tanah (%)'
                    }]

                });
            } else if (tabId == "boost_8_jam") {
                let n_boost_non_live = 8 * 60;
                var data_non_live = getData(n_boost_non_live);

                Highcharts.chart('container-boost-chart-non_live-8', {
                    chart: {
                        zoomType: 'x',
                        boost: {
                            enabled: true,
                            // useGPUTranslations: true
                        }
                    },

                    title: {
                        text: 'Riwayat kelembaban tanah dalam 8 jam terakhir'
                    },

                    subtitle: {
                        text: 'Non-live mode'
                    },

                    accessibility: {
                        screenReaderSection: {
                            beforeChartFormat: '<{headingTagName}>{chartTitle}</{headingTagName}><div>{chartSubtitle}</div><div>{chartLongdesc}</div><div>{xAxisDescription}</div><div>{yAxisDescription}</div>'
                        }
                    },

                    tooltip: {
                        valueDecimals: 2
                    },

                    xAxis: {
                        type: 'datetime'
                    },

                    series: [{
                        data: data_non_live,
                        lineWidth: 0.5,
                        name: 'Kelembaban tanah (%)'
                    }]

                });
            } else if (tabId == "boost_16_jam") {
                let n_boost_non_live = 16 * 60;
                var data_non_live = getData(n_boost_non_live);

                Highcharts.chart('container-boost-chart-non_live-16', {
                    chart: {
                        zoomType: 'x',
                        boost: {
                            enabled: true,
                            // useGPUTranslations: true
                        }
                    },

                    title: {
                        text: 'Riwayat kelembaban tanah dalam 16 jam terakhir'
                    },

                    subtitle: {
                        text: 'Non-live mode'
                    },

                    accessibility: {
                        screenReaderSection: {
                            beforeChartFormat: '<{headingTagName}>{chartTitle}</{headingTagName}><div>{chartSubtitle}</div><div>{chartLongdesc}</div><div>{xAxisDescription}</div><div>{yAxisDescription}</div>'
                        }
                    },

                    tooltip: {
                        valueDecimals: 2
                    },

                    xAxis: {
                        type: 'datetime'
                    },

                    series: [{
                        data: data_non_live,
                        lineWidth: 0.5,
                        name: 'Kelembaban tanah (%)'
                    }]

                });
            } else if (tabId == "boost_24_jam") {
                let n_boost_non_live = 24 * 60;
                var data_non_live = getData(n_boost_non_live);

                Highcharts.chart('container-boost-chart-non_live-24', {
                    chart: {
                        zoomType: 'x',
                        boost: {
                            enabled: true,
                            // useGPUTranslations: true
                        }
                    },

                    title: {
                        text: 'Riwayat kelembaban tanah dalam 24 jam terakhir'
                    },

                    subtitle: {
                        text: 'Non-live mode'
                    },

                    accessibility: {
                        screenReaderSection: {
                            beforeChartFormat: '<{headingTagName}>{chartTitle}</{headingTagName}><div>{chartSubtitle}</div><div>{chartLongdesc}</div><div>{xAxisDescription}</div><div>{yAxisDescription}</div>'
                        }
                    },

                    tooltip: {
                        valueDecimals: 2
                    },

                    xAxis: {
                        type: 'datetime'
                    },

                    series: [{
                        data: data_non_live,
                        lineWidth: 0.5,
                        name: 'Kelembaban tanah (%)'
                    }]

                });
            } else {
                return;
            }
        }
    </script>

    {{-- script prediksi cuaca --}}
    <script>
        var lat = -2.988831;
        var lon = 104.756950;

        function getWilayah() {
            $.getJSON('https://ibnux.github.io/BMKG-importer/cuaca/wilayah.json', function(data) {
                // var items = [];
                var jml = data.length;

                //hitung jarak
                for (n = 0; n < jml; n++) {
                    data[n].jarak = distance(lat, lon, data[n].lat, data[n].lon, 'K');
                }

                //urutkan berdasarkan jarak
                data.sort(urutkanJarak);

                $('#judulCuaca').html(data[0].kota);
                getCuaca(data[0].id);
            });
        }

        function getCuaca(idWilayah) {
            $.getJSON('https://ibnux.github.io/BMKG-importer/cuaca/' + idWilayah + '.json', function(data) {
                var items = [];
                var jml = 6;

                //setelah dapat jarak,  ambil 5 terdekat
                for (n = 0; n < jml; n++) {
                    items.push([data[n].kodeCuaca, data[n].cuaca, data[n].jamCuaca, new Date(data[n].jamCuaca)
                        .getTime()
                    ])
                    if (n > 4) break
                };
                let currentTime = new Date().getTime();

                let lastIndexTime;

                for (let i = 0; i < items.length; i++) {
                    lastIndexTime = items[i];

                    if (items[i][3] > currentTime) {
                        break;
                    }
                }

                let prediksi_kode_cuaca = lastIndexTime[0];
                let prediksi_cuaca = lastIndexTime[1];
                let prediksi_waktu_cuaca = lastIndexTime[2];
                let prediksi_epoch_cuaca = lastIndexTime[3];

                document.getElementById("prediksi_icon").src = "https://ibnux.github.io/BMKG-importer/icon/" +
                    prediksi_kode_cuaca + ".png";
                document.getElementById("prediksi_cuaca").innerText = prediksi_cuaca;
                document.getElementById("prediksi_waktu").innerText = prediksi_waktu_cuaca;


            });
        }

        // https://www.htmlgoodies.com/beyond/javascript/calculate-the-distance-between-two-points-in-your-web-apps.html
        function distance(lat1, lon1, lat2, lon2) {
            var radlat1 = Math.PI * lat1 / 180
            var radlat2 = Math.PI * lat2 / 180
            var theta = lon1 - lon2
            var radtheta = Math.PI * theta / 180
            var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
            dist = Math.acos(dist)
            dist = dist * 180 / Math.PI
            dist = dist * 60 * 1.1515
            return Math.round((dist * 1.609344) * 1000) / 1000;
        }

        function urutkanJarak(a, b) {
            if (a['jarak'] === b['jarak']) {
                return 0;
            } else {
                return (a['jarak'] < b['jarak']) ? -1 : 1;
            }
        }

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, onErrorGPS);
            } else {
                //ga bisa dapat GPS, pake default aja
                getWilayah();
            }
        }

        function showPosition(position) {
            lat = position.coords.latitude;
            lon = position.coords.longitude;
            getWilayah();
        }

        function onErrorGPS(error) {
            //pake default aja
            getWilayah();
        }

        getLocation();
    </script>

    {{-- global variabel --}}
    <script>
        let percent_kelembaban_value = 0;
        let interval = 5000;
        let n_boost = 10;
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
                    let lastEpoch = lastdata.epoch;
                    let kondisi_tanah;
                    let aksi;

                    // kondisi untuk chart boost
                    for (let i = data.length - 1; i >= 0; i--) {
                        if (data[i].epoch >= (lastEpoch - (n_boost * 60))) {
                            let per_val = data[i].percent_value;
                            let epoch_time = data[i].epoch;
                            epoch_time = epoch_time * 1000;

                            // push data epoch dan percent value ke dalam variabel array
                            arr_1.push([epoch_time, per_val]);
                        } else {
                            break;
                        }
                    }

                    // update boost
                    if (boostChartKelembabanTanah) {
                        boost_data_kelembaban_tanah = boostChartKelembabanTanah.series[0];
                        // boost_data_kelembaban_tanah.update(arr_1);
                        boost_data_kelembaban_tanah.setData(arr_1, true, true, false);
                    }

                    // update chart gauge
                    if (chartKelembabanTanah) {
                        gauge_point_kelembaban_tanah = chartKelembabanTanah.series[0].points[0];
                        gauge_point_kelembaban_tanah.update(lastdata.percent_value);
                    }

                    // Kondisi untuk kondisi tanah
                    if ($lastRecord['percent_value'] <= 40) {
                        kondisi_tanah = 'Kering';
                    } else if ($lastRecord['percent_value'] <= 67) {
                        kondisi_tanah = 'Lembab';
                    } else if ($lastRecord['percent_value'] > 67) {
                        kondisi_tanah = 'Basah';
                    } else {
                        kondisi_tanah = 'Kesalahan dalam mendeteksi';
                    }

                    // kondisi untuk aksi
                    if (lastdata.percent_value > 40) {
                        aksi = "Tidak perlu disiram";
                    } else if (lastdata.percent_value >= 0) {
                        aksi = "Perlu disiram";
                    } else {
                        aksi = "Kesalahan dalam mendeteksi";
                    }

                    document.getElementById("card_kelembaban_tanah_value").innerText =
                        `${lastdata.percent_value}%`;

                    document.getElementById("progress_bar_card_kelembaban").style.width =
                        `${lastdata.percent_value}%`;

                    document.getElementById("card_kondisi_tanah").innerText = `${kondisi_tanah}`;

                    document.getElementById("card_aksi").innerText = `${aksi}`;
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
        function getData(n_val) {
            // get data berdasarka n jam yang lalu
            const lastRecordHour =
                {{ $lastRecord != '0' && count($lastRecord) > 0 ? $lastRecord['epoch'] * 1000 * (60 * 60) : -1 }}
            const arr = [];

            // konversi array menjadi json
            var datas = @json($datas);
            var lastRecord = @json($lastRecord);

            // Pastikan datas masih dalam format JSON
            // console.log(datas);

            // jika data tidak kosoong maka eksekusi
            if (lastRecordHour > -1) {

                for (let index = 0; index < datas.length; index++) {

                    if (datas[index].epoch >= (lastRecord.epoch - (n_val * 60))) {
                        let per_val = datas[index].percent_value;
                        let epoch_time = datas[index].epoch;
                        epoch_time = epoch_time * 1000;

                        // push data epoch dan percent value ke dalam variabel array
                        arr.push([epoch_time, per_val]);
                    } else {
                        break;
                    }
                }
            }

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
                text: 'Live Mode'
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
                    [0.15, '#DF5353'], // RED DF5353
                    [0.20, '#DDDF0D'], // yellow DDDF0D
                    [0.45, '#55BF3B'] // GREEN 55BF3B
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
                    {{ $lastRecord != '0' && count($lastRecord) > 0 ? $lastRecord['percent_value'] : 0 }}
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
