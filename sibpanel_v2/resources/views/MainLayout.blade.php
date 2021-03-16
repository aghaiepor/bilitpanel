<!DOCTYPE html>
<html lang="en">
<!-- head tags -->
@include('layout.head')

<body id="body" class="rtl {{ session()->get('sidebarState') }} ">
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

    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#minimizeSidebar').on('click', function(e) {
                let mini = $("#body").hasClass("sidebar-mini") ;
                console.log("mini : " , mini);
                $.ajax({
                    type: "POST",
                    url: "{{Route("savestate")}}" ,
                    data:{
                        '_token ': '<?php echo csrf_token() ?>',
                        "Mini" : mini
                    }
                });
            });

        })
    </script>

</html>
