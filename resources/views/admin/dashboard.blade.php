@extends('admin.layouts.app')
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- eCommerce statistic -->
                @if(admin()->check_route_permission('dashboard.index') == 1)
                    <div class="row">
                        <div class="col-xl-3 col-lg-6 col-12">
                            <div class="card pull-up">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="media-body text-left">
                                                <h3 class="info">{{$freelances}}</h3>
                                                <h6>{{__('msg.freelances')}}</h6>
                                            </div>
                                            <div>
                                                <i class="icon-basket-loaded info font-large-2 float-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12">
                            <div class="card pull-up">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="media-body text-left">
                                                <h3 class="info">{{$business_owner}}</h3>
                                                <h6>{{__('msg.business_owner')}}</h6>
                                            </div>
                                            <div>
                                                <i class="icon-basket-loaded info font-large-2 float-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12">
                            <div class="card pull-up">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="media-body text-left">
                                                <h3 class="info">{{$projects}}</h3>
                                                <h6>{{__('msg.projects')}}</h6>
                                            </div>
                                            <div>
                                                <i class="icon-basket-loaded info font-large-2 float-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12">
                            <div class="card pull-up">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="media-body text-left">
                                                <h3 class="info">{{$transactions}}</h3>
                                                <h6>{{__('msg.transactions')}}</h6>
                                            </div>
                                            <div>
                                                <i class="icon-basket-loaded info font-large-2 float-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row match-height">
                        <div class="col-xl-12 col-lg-12">
                            <div class="card" style="">
                                <div class="card-content">
                                    <div class="card-body sales-growth-chart">
                                        <div id="monthly-sales" class="height-250"
                                             style="position: relative; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">

                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="chart-title mb-1 text-center">
                                        <h6>{{__('msg.total_monthly_transactions')}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <section id="chartjs-polar-charts">
                        <div class="row">
                            <!-- Polar Chart -->
                            <div class="col-md-12 col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">{{__('msg.total_monthly_profit')}}</h4>
                                        <a class="heading-elements-toggle"><i
                                                class="la la-ellipsis-v font-medium-3"></i></a>
                                        <div class="heading-elements">
                                            <ul class="list-inline mb-0">
                                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                                <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                                <li><a data-action="close"><i class="ft-x"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card-content collapse show">
                                        <div class="card-body">
                                            <canvas id="polar-chart" height="400"></canvas>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="chart-title mb-1 text-center">
                                            <h6>{{__('msg.total_monthly_profit')}}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                @else
                    @include('admin.layouts.alerts.error_perm')
                @endif

            </div>
        </div>
    </div>
@endsection
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('public/assets/assets/vendors/css/charts/chartist.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{asset('public/assets/assets/vendors/css/charts/chartist-plugin-tooltip.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{asset('public/assets/vendors/css/weather-icons/climacons.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/assets/fonts/meteocons/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/assets/vendors/css/charts/morris.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/assets/assets/css/pages/timeline.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/assets/css/pages/dashboard-ecommerce.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/assets/vendors/css/forms/selects/select2.min.css')}}">
    <style>
        .select2-container--default {
            width: 100% !important;
        }
    </style>
@endsection
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('public/assets/assets/vendors/css/charts/chartist.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{asset('public/assets/assets/vendors/css/charts/chartist-plugin-tooltip.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{asset('public/assets/vendors/css/weather-icons/climacons.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/assets/fonts/meteocons/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/assets/vendors/css/charts/morris.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/assets/assets/css/pages/timeline.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/assets/css/pages/dashboard-ecommerce.css')}}">
@endsection
@section('scripts')
    <script src="{{asset('public/assets/vendors/js/charts/chartist.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('public/assets/vendors/js/charts/chart.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('public/assets/vendors/js/charts/chartist-plugin-tooltip.min.js')}}"
            type="text/javascript"></script>
    <script src="{{asset('public/assets/vendors/js/charts/raphael-min.js')}}" type="text/javascript"></script>
    <script src="{{asset('public/assets/vendors/js/charts/morris.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('public/assets/vendors/js/timeline/horizontal-timeline.js')}}" type="text/javascript"></script>
    <!-- END PAGE VENDOR JS-->
    <script src="{{asset('public/assets/vendors/js/charts/morris.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('public/assets/js/scripts/pages/dashboard-ecommerce.js')}}" type="text/javascript"></script>
    <script src="{{asset('public/assets/js/scripts/charts/chartjs/polar-radar/polar-skip-points.js')}}"
            type="text/javascript"></script>

    <script>
        var montly_sel = [
                @foreach($montly_sel as $data)
            {
                month: '{{$data['date']}}', sales: {{$data['sum']}}
            }
            @if(! $loop->last)
            ,
            @endif
            @endforeach
        ];
        Morris.Bar({
            element: 'monthly-sales',
            data: montly_sel,
            xkey: 'month',
            ykeys: ['sales'],
            labels: ['Sales'],
            barGap: 4,
            barSizeRatio: 0.3,
            gridTextColor: '#bfbfbf',
            gridLineColor: '#E4E7ED',
            numLines: 5,
            gridtextSize: 14,
            resize: true,
            barColors: ['#FF394F'],
            hideHover: 'auto',
        });
    </script>
    <script>
        $(document).ready(function (){
            var ctx = $("#polar-chart");

            // Chart Options
            var chartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                responsiveAnimationDuration:500,
                legend: {
                    position: 'top',
                },
                title: {
                    display: false,
                    text: 'Chart.js Polar Area Chart'
                },
                scale: {
                    ticks: {
                        beginAtZero: true
                    },
                    reverse: false
                },
                animation: {
                    animateRotate: false
                }
            };

            // Chart Data
            var chartData = {
                labels: [
                    @foreach($montly_profit as $prof)
                        "{{$prof['date']}}"
                    @if(! $loop->last)
                    ,
                    @endif
                    @endforeach

                ],
                datasets: [{
                    data: [
                        @foreach($montly_profit as $prof)
                            {{$prof['sum']}}
                            @if(! $loop->last)
                        ,
                        @endif
                        @endforeach
                    ],
                    backgroundColor: [
                        '#00A5A8', '#626E82', '#FF7D4D','#FF4558', '#28D094',
                        '#74f4f8', '#d8ff33', '#98ffd1','#6dc3ff', '#28D094',
                        '#4fff00', '#ffce4f'
                    ],
                    label: 'My dataset' // for legend
                }],
            };

            var config = {
                type: 'polarArea',

                // Chart Options
                options : chartOptions,

                data : chartData
            };

            // Create the chart
            var polarChart = new Chart(ctx, config);
        })
    </script>
@endsection
