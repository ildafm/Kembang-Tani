@extends('template.master')
@section('content')
    {{-- sytle for gauge chart --}}
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
            border: 1px solid #gree;
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
            background: green;
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
            <h1 class="h3 mb-0 text-gray-800"> <b>Dashboard of KeTan</b> </h1>

            <button class="btn btn-sm shadow-sm" style="background-color: #5dc971" id="btn_siram" onclick="clickButtonSiram()">
                <i class="fas fa-tint fa-sm text-white"></i>
                <div class="text-white d-inline">Siram Tanaman</div>
            </button>
            <button class="btn btn-sm btn-danger shadow-sm" onclick="clickButtonStopSiram()" id="btn_stop_siram" hidden>
                <i class="fas fa-stop fa-sm text-white"></i>
                Stop Menyiram
            </button>
        </div>

        {{-- gauge kelembaban tanah --}}
        <div class="card shadow mb-4 card-border-custom">
            <!-- Card Header -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                style="border-radius: 25px 25px 0px 0px">
                <h6 class="m-0 font-weight-bold" style="color: #004225">Kelembaban Tanah</h6>
            </div>

            <!-- Card Body -->
            <div class="card-body">
                <figure class="highcharts-figure">
                    <div id="container-zone_1" class="chart-container"></div>
                    <div id="container-zone_2" class="chart-container"></div>
                </figure>
            </div>
        </div>

        {{-- row prediksi cuaca --}}
        <div class="row">

            {{-- prediksi 1 --}}
            <div class="col">
                <div class="card shadow mb-4 card-border-custom">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                        style="border-radius: 25px 25px 0px 0px">
                        <h6 class="m-0 font-weight-bold" style="color: #004225">Prediksi Cuaca Selanjutnya</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        {{-- icon cuaca --}}
                        <center>
                            <div class="row">
                                <div class="col">
                                    <img id="prediksi_icon_1" src="" alt="Icon_cuaca.png"
                                        style="width: auto; height: auto" class="card-img-top">
                                </div>
                                <div class="col">
                                    <p id="prediksi_cuaca_1" class="text-dark">Cuaca</p>
                                    <p id="prediksi_waktu_1" class="text-dark">Waktu</p>
                                </div>
                            </div>
                        </center>
                    </div>
                </div>
            </div>

            {{-- prediksi 2 --}}
            <div class="col">
                <div class="card shadow mb-4 card-border-custom">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                        style="border-radius: 25px 25px 0px 0px">
                        <h6 class="m-0 font-weight-bold" style="color: #004225">Prediksi Cuaca 2</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        {{-- icon cuaca --}}
                        <center>
                            <div class="row">
                                <div class="col">
                                    <img id="prediksi_icon_2" src="" alt="Icon_cuaca.png"
                                        style="width: auto; height: auto" class="card-img-top">
                                </div>
                                <div class="col">
                                    <p id="prediksi_cuaca_2" class="text-dark">Cuaca</p>
                                    <p id="prediksi_waktu_2" class="text-dark">Waktu</p>
                                </div>
                            </div>
                        </center>
                    </div>
                </div>
            </div>

            {{-- prediksi 3 --}}
            <div class="col">
                <div class="card shadow mb-4 card-border-custom">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                        style="border-radius: 25px 25px 0px 0px">
                        <h6 class="m-0 font-weight-bold" style="color: #004225">Prediksi Cuaca 3</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        {{-- icon cuaca --}}
                        <center>
                            <div class="row">
                                <div class="col">
                                    <img id="prediksi_icon_3" src="" alt="Icon_cuaca.png"
                                        style="width: auto; height: auto" class="card-img-top">
                                </div>
                                <div class="col">
                                    <p id="prediksi_cuaca_3" class="text-dark">Cuaca</p>
                                    <p id="prediksi_waktu_3" class="text-dark">Waktu</p>
                                </div>
                            </div>
                        </center>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- global variabel --}}
    <script>
        let percent_kelembaban_zone_1_value = 0;
        let percent_kelembaban_zone_2_value = 0;
        let interval = 5000;
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

                $('#judulCuaca').html(data[0].propinsi +
                    ', ' + data[0].kota + ', ' + data[0].kecamatan + ' ' + data[0].jarak.toFixed(2) + " km");
                getCuaca(data[0].id);
            });
        }

        function getCuaca(idWilayah) {
            $.getJSON('https://ibnux.github.io/BMKG-importer/cuaca/' + idWilayah + '.json', function(data) {
                var items = [];
                var jml = data.length;

                // console.log(jml);
                let c_epoch = new Date().getTime();

                //setelah dapat jarak,  ambil 5 terdekat
                for (n = 0; n < jml; n++) {
                    let data_epoch = new Date(data[n].jamCuaca).getTime()
                    console.log("c_e ", c_epoch);
                    console.log("data_e ", data_epoch);

                    if (c_epoch < data_epoch) {
                        items.push([data[n].kodeCuaca, data[n].cuaca, data[n].jamCuaca, new Date(data[n].jamCuaca)
                            .getTime()
                        ])
                    } else if (items.length > 3) {
                        break;
                    }
                };
                // let currentTime = new Date().getTime();

                // prediksi 1
                document.getElementById("prediksi_icon_1").src = "https://ibnux.github.io/BMKG-importer/icon/" +
                    items[0][0] + ".png";
                document.getElementById("prediksi_cuaca_1").innerText = items[0][1];
                document
                    .getElementById("prediksi_waktu_1").innerText = items[0][2];

                // prediksi 2
                document.getElementById("prediksi_icon_2").src = "https://ibnux.github.io/BMKG-importer/icon/" +
                    items[1][0] + ".png";
                document.getElementById("prediksi_cuaca_2").innerText = items[1][1];
                document
                    .getElementById("prediksi_waktu_2").innerText = items[1][2];

                // prediksi 3
                document.getElementById("prediksi_icon_3").src = "https://ibnux.github.io/BMKG-importer/icon/" +
                    items[2][0] + ".png";
                document.getElementById("prediksi_cuaca_3").innerText = items[2][1];
                document
                    .getElementById("prediksi_waktu_3").innerText = items[2][2];


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

                    percent_kelembaban_zone_1_value = data_zone_1['percent_value'];
                    percent_kelembaban_zone_2_value = data_zone_2['percent_value'];

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
                color: "red",
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
            }],
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
