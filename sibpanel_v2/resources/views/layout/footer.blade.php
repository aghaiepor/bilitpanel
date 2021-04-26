<footer class="footer">
    <div class="container-fluid">
        <nav class="float-left">
            <img src="{{asset('')}}assets/img/logo.png" style="width: 50px;filter: invert(.6);">
           {{-- <ul>
                <li>
                    <a href="https://www.creative-tim.com/">
                        Creative Tim
                    </a>
                </li>
                <li>
                    <a href="https://www.creative-tim.com/presentation">
                        About Us
                    </a>
                </li>
                <li>
                    <a href="https://www.creative-tim.com/blog">
                        Blog
                    </a>
                </li>
                <li>
                    <a href="https://www.creative-tim.com/license">
                        Licenses
                    </a>
                </li>
            </ul>--}}
        </nav>
        <div class="copyright float-right">
            &copy;
            تمامی حقوق برای شرکت آتی شهر هوشمند ایرانیان محفوظ است .
        </div>
    </div>
</footer>
@if(!getenv("APP_DEBUG"))
<script>
    $(document).ready(function () {
        console.clear();
    })
</script>
@endif
