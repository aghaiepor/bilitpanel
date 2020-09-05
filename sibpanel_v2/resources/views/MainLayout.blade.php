<!DOCTYPE html>
<html lang="en">
<!-- head tags -->
@include('layout.head')

<body class="rtl">
<div class="wrapper ">
    <!-- Left sidbar here -->
    @include('layout.sidbar')

    <div class="main-panel">
        <!-- Navbar -->
{{--        @include('layout.header')--}}

            <!-- getContent -->
            @yield('content')

        <!-- Footer Place -->
        @include('layout.footer')
    </div>
</div>
<!-- All JS code here -->
@include('layout.Js')
</body>

</html>
