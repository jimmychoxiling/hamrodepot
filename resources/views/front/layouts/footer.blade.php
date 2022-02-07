<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/jquery.fancybox.min.js') }}"></script>
<script src="{{ asset('js/slick.min.js') }}"></script>
<script src="{{ asset('js/jquery.notifyBar.js') }}"></script>
<script src="{{ asset('js/moment.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
<script src="{{ asset('assets/js/parsley.js') }}"></script>
<script>
    var cartAdd = "{{route('cart-add')}}";
    var limit = "{{env('PRODUCTS_LIMIT')}}";
    var bigStarsPath = "{{ asset('images/stars.png')}}";
    let pageName = "";
    <?php
    if($message = Session::get('success')){
    ?>
    $.notifyBar({cssClass: "success", html: "<?= $message; ?>"});
    <?php
    }
    ?>
</script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script src="{{ asset('js/public-scripts.js') }}"></script>
<script src="{{ asset('assets/js/sweetalert.js')}}"></script>
<script src="{{ asset('js/jquery.rating.js')}}"></script>
@yield('extra-js')
    </div>
</body>
</html>
