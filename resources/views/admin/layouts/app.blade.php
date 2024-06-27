<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="rtl">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Modern admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities with bitcoin dashboard.">
    <meta name="keywords" content="admin template, modern admin template, dashboard template, flat admin template, responsive admin template, web app, crypto dashboard, bitcoin dashboard">
    <meta name="author" content="PIXINVENT">
    <title>@yield('title')</title>
    <link rel="apple-touch-icon" href="">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('public/assets/images/logo.png')}}">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Quicksand:300,400,500,700"
          rel="stylesheet">
    <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css"
          rel="stylesheet">
    <!-- BEGIN VENDOR CSS-->
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @if(\Illuminate\Support\Facades\App::getLocale() == 'ar')
        <link rel="stylesheet" type="text/css" href="{{asset('public/assets/css-rtl/vendors.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('public/assets/css-rtl/app.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('public/assets/css-rtl/custom-rtl.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('public/assets/css-rtl/core/menu/menu-types/vertical-menu.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('public/assets/css-rtl/core/colors/palette-gradient.css')}}">
    @else
        <link rel="stylesheet" type="text/css" href="{{asset('public/assets/css/vendors.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('public/assets/css/app.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('public/assets/css/custom-rtl.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('public/assets/css/core/menu/menu-types/vertical-menu.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('public/assets/css/core/colors/palette-gradient.css')}}">
    @endif

    <link rel="stylesheet" type="text/css" href="{{asset('public/assets/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/assets/vendors/css/forms/toggle/bootstrap-switch.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/assets/vendors/css/forms/toggle/switchery.min.css')}}">
    @yield('styles')
</head>
<body class="vertical-layout vertical-menu 2-columns chat-application menu-expanded fixed-navbar"
      data-open="click" data-menu="vertical-menu" data-col="2-columns">

@include('admin.layouts.nav')
@include('admin.layouts.sidebar')

@yield('content')


<script src="{{asset('public/assets/vendors/js/vendors.min.js')}}" type="text/javascript"></script>
<!-- END PAGE VENDOR JS-->
<!-- BEGIN MODERN JS-->
<script src="{{asset('public/assets/js/core/app-menu.js')}}" type="text/javascript"></script>
<script src="{{asset('public/assets/js/core/app.js')}}" type="text/javascript"></script>
<script src="{{asset('public/assets/js/scripts/customizer.js')}}" type="text/javascript"></script>
<script src="{{asset('public/assets/vendors/js/forms/toggle/bootstrap-switch.min.js')}}"
        type="text/javascript"></script>
<script src="{{asset('public/assets/vendors/js/forms/toggle/bootstrap-checkbox.min.js')}}"
        type="text/javascript"></script>
<script src="{{asset('public/assets/js/scripts/forms/switch.js')}}" type="text/javascript"></script>
@yield('scripts')
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>
    const pusher = new Pusher('85aa4ca91f387f09cd0d', {
        cluster: 'ap1',
    });
    const channel = pusher.subscribe('notification.0');
    channel.bind('admin_notification', function(data) {
        var url = data.type_id == 1 ? route('admin.projects.edit',data.project_id) : (data.type_id == 2 ? route('admin.contacts.show',data.contact_id) : '#');
        var newParagraph = $(
            '<a href="' + url + '">' +
            '<div class="media">' +
            '<div class="media-left align-self-center"><i class="ft-plus-square icon-bg-circle bg-cyan"></i></div>' +
            '<div class="media-body">' +
            '<p class="notification-text font-small-3 text-muted">' + data.message + '</p>' +
            '<small> <time class="media-meta text-muted">Now</time></small>'+
            '</div>' +
            '</div>' +
            '</a>'
        );
        $('#notification-area').append(newParagraph);
        var count_notif = $('.count_notif').text();
        var calc = parseInt(count_notif) + 1 ;
        $('.count_notif').text(calc)
    });
</script>
<script>
    let success = document.getElementById('success_msg');
    setTimeout(()=>{
        success.style.display='none';
    },10000);
</script>
</body>
</html>
