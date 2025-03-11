<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    {{-- <meta http-equiv="refresh" content="20;url=dashboard" /> --}}

    <title>KeTan - {{ $title }}</title>
    {{-- logo dari halaman --}}
    <link rel="icon" href="../template/img/logo_ijo.png" type="image/icon type">

    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet"> --}}

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;400;500;600;700;900&display=swap');

        div {
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            /* Menggunakan varian Extra Light */
        }
    </style>

    <!-- Custom styles for this template-->
    <link href="{{ asset('template/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <style>
        .color {
            background-color: #004225
        }

        .colorcontent {
            background-color: #e8ebf0
        }

        .instagram-bg-ic {
            vertical-align: middle;
            background: #d6249f;
            background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%, #d6249f 60%, #285AEB 90%);
        }

        .card {
            border-radius: 25px
        }

        .card-header-border-custom {
            border-radius: 25px 25px 0px 0px
        }
    </style>

    <!-- Custom styles for this page -->
    <link href="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

    {{-- gauge chart --}}
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-more.js"></script>
    <script src="https://code.highcharts.com/modules/boost.js"></script>
    <script src="https://code.highcharts.com/modules/solid-gauge.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

</head>

<body id="page-top">
    {{-- color for gauge caption 1c444c --}}
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav color sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/dashboard">

                <div class="sidebar-brand-icon">
                    <img id="img_ic" class="img-fluid" style="height: 60px; width: auto"
                        src="../template/img/ketan_full.png" alt="">
                    {{-- <i class="fas fa-laugh-wink"></i> --}}
                </div>
                <div class="sidebar-brand-text mx-3">
                    {{-- <img id="img_txt" class="img-fluid" style="height: 20px; width: auto"
                        src="../template/img/ketan_txt.png" alt=""> --}}
                </div>
                <br>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider mt-3 my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ $active == 'dashboard' ? 'active' : '' }}">
                <a class="nav-link" href="/dashboard">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Monitoring -->
            <div class="sidebar-heading">
                MONITORING
            </div>

            {{-- Zone 1 --}}
            <li class="nav-item {{ $active == 'zone_1' ? 'active' : '' }}">
                <a class="nav-link" href="/monitoring/zone-one">
                    <i class="fas fa-fw fa-desktop"></i>
                    <span>Zone 1</span></a>
            </li>

            {{-- Zone 2 --}}
            <li class="nav-item {{ $active == 'zone_2' ? 'active' : '' }}">
                <a class="nav-link" href="/monitoring/zone-two">
                    <i class="fas fa-fw fa-desktop"></i>
                    <span>Zone 2</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle" onclick="changeImgIcWin()"></button>
            </div>


        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content" class="colorcontent">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars" style="color: #5dc971"></i>
                    </button>

                    <!-- Topbar time -->
                    <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100">
                        <div id="currentTime" style="color:black">

                        </div>
                    </div>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Profile -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="img-fluid" src="../template/img/2pd_crew_full.png"
                                    style="height: 100px; width: auto" alt="2pd_crew_full.img">
                            </a>

                            <!-- Dropdown - profiles -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="">
                                <h6 class="dropdown-header" style="background-color: #004225; border: 0px">
                                    Profiles Center
                                </h6>

                                <div class="d-flex align-items-center mt-2 mb-2 ml-2 mr-2">
                                    {{-- email --}}
                                    <div class="ml-2 mr-2">
                                        <a class="btn" href="#" title="email to: 2PD Crew">
                                            <div class="icon-circle bg-info">
                                                <i class="fas fa-envelope fa-xl text-white"></i>
                                            </div>
                                        </a>
                                    </div>

                                    {{-- linkin --}}
                                    <div class="ml-2 mr-2">
                                        <a href="#" class="btn btn-sm" title="2PD Crew Linkedin Profile">
                                            <div class="icon-circle bg-primary">
                                                <i class="fab fa-linkedin fa-xl text-white"></i>
                                            </div>
                                        </a>
                                    </div>

                                    {{-- ig --}}
                                    <div class="ml-2 mr-2">
                                        <a href="#" class="btn btn-sm" title="Open Instagram 2PD Crew">
                                            <div class="icon-circle instagram-bg-ic">
                                                <i class="fab fa-instagram fa-xl text-white"></i>
                                            </div>
                                        </a>
                                    </div>

                                    {{-- wa --}}
                                    <div class="ml-2 mr-2">
                                        <a href="#" class="btn btn-sm" title="Call 2PD Crew via Whatsapp">
                                            <div class="icon-circle bg-success">
                                                <i class="fab fa-whatsapp fa-xl text-white"></i>
                                            </div>
                                        </a>
                                    </div>
                                </div>

                                <a class="dropdown-item text-center small text-gray-500" href="#">Open
                                    Profile</a>
                            </div>
                        </li>
                        <!-- Nav Item - User Information -->


                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                @yield('content')
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Kembang Tani 2023 by 2PD Crew | Universitas Multi Data Palembang</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    {{-- script for img_ic src change --}}
    <script>
        // script for img_ic src change with toggled
        function changeImgIcWin() {
            if (document.getElementById("page-top").className == "") {
                document.getElementById("img_ic").src = "../template/img/ketan_full.png"
            } else {
                document.getElementById("img_ic").src = "../template/img/ketan_ic.png"
            }
        }

        function changeImgIcSm() {
            if (document.getElementById("page-top").className == "") {
                document.getElementById("img_ic").src = "../template/img/ketan_ic.png"
            } else {
                document.getElementById("img_ic").src = "../template/img/ketan_ic.png"
            }
        }
    </script>
    <script>
        //script for img_ic src change with window width
        if (window.screen.width < 700) {
            document.getElementById("img_ic").src = "../template/img/ketan_ic.png"
        } else {
            setInterval(changeImgIcWin, 250);
        }
    </script>



    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('template/vendor/jquery/jquery.min.js') }}"></script>

    <script src="{{ asset('template/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('template/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('template/js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('template/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('template/js/demo/datatables-demo.js') }}"></script>

    {{-- get date and time --}}
    <script>
        getTime()

        function getTime() {
            n = new Date()
            year = n.getFullYear()
            date = n.getDate()
            hour = n.getHours();
            minute = n.getMinutes();
            second = n.getSeconds();

            months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober',
                'November', 'Desember'
            ]
            month = months[n.getMonth()]

            weekday = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', "Jum'at", 'Sabtu']
            day = weekday[n.getDay()]

            if (date < 10) {
                date = "0" + date
            }

            if (hour < 10) {
                hour = "0" + hour
            }

            if (minute < 10) {
                minute = "0" + minute
            }

            if (second < 10) {
                second = "0" + second
            }

            document.getElementById('currentTime').innerHTML =
                `${day}, ${date} ${month} ${year} - ${hour}:${minute}:${second}`
            setTimeout(getTime, 1000);
        }
    </script>

</body>


</html>
