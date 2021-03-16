<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('')}}assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="{{asset('')}}assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('title')

    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <script type="text/javascript"> (function() { var css = document.createElement('link'); css.href = '{{asset("")}}assets/FontAwesome/css/all.min.css'; css.rel = 'stylesheet'; css.type = 'text/css'; document.getElementsByTagName('head')[0].appendChild(css); })(); </script>
    <!-- CSS Files -->
    <link href="{{asset('')}}assets/css/bootstrap-rtl.css" rel="stylesheet">
    <link href="{{asset('')}}assets/css/material-dashboard.css?v=2.1.2" rel="stylesheet" />
{{--    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="../assets/demo/demo.css" rel="stylesheet" />--}}
    <style>
        /* width */
        .sidebar-wrapper::-webkit-scrollbar {
            width: 10px;
        }

        /* Track */
        .sidebar-wrapper::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 5px;
        }

        /* Handle */
        .sidebar-wrapper::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 5px;
        }

        /* Handle on hover */
        .sidebar-wrapper::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
</head>
