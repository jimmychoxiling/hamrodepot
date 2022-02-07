// JavaScript Document
jQuery(document).ready(function ($) {
    // file upload
    const readURL = (input) => {
        if (input.files && input.files[0]) {
            const reader = new FileReader()
            reader.onload = (e) => {
                jQuery('#preview').attr('src', e.target.result)
            }
            reader.readAsDataURL(input.files[0])
        }
    }
    jQuery('.choose').on('change', function () {
        readURL(this)
        let i
        if (jQuery(this).val().lastIndexOf('\\')) {
            i = jQuery(this).val().lastIndexOf('\\') + 1
        } else {
            i = jQuery(this).val().lastIndexOf('/') + 1
        }
        // const fileName = jQuery(this).val().slice(i)
        // $('.label').text(fileName)
    });

    $(document).on('click', '#go_to_login_btn', function (e) {
        window.location = loginUrl;
    });

    /* Add Wishlist */

    $(document).ready(function () {

        $(document).on('click', '.whishListCheck', function (e) {
            let pro_id = $(this).data('id');

            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var that = $(this);
            const data = {
                _token: CSRF_TOKEN,
                pro_id: pro_id,
            }
            whishListAddRemove(data, that);
        });
    });

});//document.ready end here

function whishListAddRemove(data, that) {
    $.ajax({
        type: "post",
        url: whishListCheck,
        data: data,
        success: function (data) {
            if (data.success == true) {
                $.notifyBar({ cssClass: "success", html: data.message });
                if (data.wishlistCheck == true) {
                    that.addClass("active");
                    if (pageName && pageName == 'product-detail') {
                        that.text('');
                        that.append('<i class="fa fa-check"></i> Added in Wishlist')
                    }
                } else {
                    if (that) {
                        that.removeClass("active");
                        if (pageName && pageName == 'product-detail') {
                            that.text('');
                            that.append('<i class="fa fa-heart"></i> Add to Wishlist');
                        }
                        if (pageName === 'wishlist') {
                            // location.href = pageName;
                            if (data.wishlistCount == 0) {
                                window.location.reload();
                            }
                            that.parent().parent().parent().parent().remove();

                        }
                    }
                }
            } else {
                if (data.not_authenticate) {
                    $("#fancyLikeError").fancybox().trigger('click');
                } else {
                    $.notifyBar({ cssClass: "error", html: data.message });
                }
            }
        }
    });
}




$(document).on('click', '.confirmRemove', function (e) {
    var that = $(this);
    let pro_id = $(this).data('id');

    swal({
        title: "Are you sure?",
        text: "You want to remove this product!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: true
    },
        function () {
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            const data = {
                _token: CSRF_TOKEN,
                pro_id: pro_id,
            }
            whishListAddRemove(data, that);
        });
});

$(document).ready(function () {
    let from_date;
    let to_date;
    let from_time;
    let to_time;
    let pro_price;
    let fromDate;
    let toDate;
    let today;

    $(document).on('change', '#from_date', function () {
        RentCount();
    });
    $(document).on('change', '#to_date', function () {
        RentCount();
    });
    $(document).on('change', '#from_time', function () {
        RentCount();
    });
    $(document).on('change', '#to_time', function () {
        RentCount();
    });
    function setDateValues() {
        from_date = $("#from_date").val();
        to_date = $("#to_date").val();
        from_time = $("#from_time").val();
        to_time = $("#to_time").val();
        pro_price = $("#pro_price").val();
        fromDate = moment(from_date);
        toDate = moment(to_date);
        today = moment(new Date()).format('YYYY-MM-DD');
        today = moment(today);
    }
    function RentCount() {
        setDateValues();
        const currentHour = new Date().getHours();
        const currentMinutes = new Date().getMinutes();
        if (to_time) {
            split_to_time = to_time.split(":");
        }
        if (from_time) {
            split_from_time = from_time.split(":");
        }
        if (fromDate && !fromDate.isSameOrAfter(today)) {
            $("#from_date").val(today.format('YYYY-MM-DD'));
        }
        if (fromDate && fromDate.isSame(today)) {
            if (from_time) {
                if (currentHour > parseInt(split_from_time[0]) || currentMinutes > parseInt(split_from_time[1])) {
                    $('#from_time').val(currentHour + ':' + currentMinutes);
                }
            }
        }
        if (toDate && !toDate.isSameOrAfter(fromDate)) {
            if (fromDate) {
                $("#to_date").val(fromDate.format('YYYY-MM-DD'));
            } else {
                $("#to_date").val(today.format('YYYY-MM-DD'));
            }
        }
        if (toDate && toDate.isSame(today)) {
            if (to_time) {
                if (currentHour > parseInt(split_to_time[0]) || currentMinutes > parseInt(split_to_time[1])) {
                    $('#to_time').val((currentHour + 1) + ':' + currentMinutes);
                }
            }
        }
        if (from_time && to_time && (toDate.isSame(today) || toDate.isSame(today))) {
            if (parseInt(split_from_time[0]) >= parseInt(split_to_time[0]) || (parseInt(split_from_time[0]) == parseInt(split_to_time[0]) && parseInt(split_from_time[1]) > parseInt(split_to_time[1]))) {
                $('#to_time').val((parseInt(split_from_time[0]) + 1) + ':' + parseInt(split_from_time[1]));
            }
        }
        if (from_time && to_time) {
            if (parseInt(split_from_time[0]) >= parseInt(split_to_time[0]) || (parseInt(split_from_time[0]) == parseInt(split_to_time[0]) && parseInt(split_from_time[1]) > parseInt(split_to_time[1]))) {
                $('#to_time').val((parseInt(split_from_time[0]) + 1) + ':' + parseInt(split_from_time[1]));
            }
        }
        setDateValues();

        if (from_date != '' && to_date != '' && from_time != '' && to_time != '') {

            let from = moment(from_date + " " + from_time);
            let to = moment(to_date + " " + to_time);

            let hours = to.diff(from, 'hours');

            var minutes = moment.utc(moment(from, "HH:mm:ss").diff(moment(to, "HH:mm:ss"))).format("mm")

            let hrs = hours + '.' + minutes;
            let total_price = pro_price * hrs;
            total_price = total_price.toFixed(2);
            $(".total_hrs").text(hrs + ' Hr');
            $(".total_price").text('$' + total_price);

            $("#total_hrs").val(hrs);
            $("#total_price").val(total_price);

            $('.addCartRent').removeClass('disabled');

        }
    }

});

/* Add Cart */

$(document).ready(function () {
    $('.output').change(function () {
        var itemQuantity = $(this).parent().find('.output');
        var currentval = parseInt(itemQuantity.val());
        if (currentval == 0) {
            itemQuantity.val(1);
        }
        if (currentval == 1) {
            $(this).parent().parent().parent().find('.add-btn').show();
        } else {

            let id = $(this).attr('data-id');
            let pro_id = $(this).attr('data-proid');
            let qty = parseInt(itemQuantity.val());

            if (qty != 0) {
                let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: cartUpdate,
                    method: "post",
                    data: { _token: CSRF_TOKEN, id: id, pro_id: pro_id, qty: qty },
                    success: function (data) {
                        if (data.success == true) {
                            $('#subtotal').text('$' + data.subTotal);
                            $('#total').text('$' + data.total);
                            $('#cartCount').text('Product Price (' + data.cartCount + ' items)');
                            $('.cart_counter').text(data.cartCount);

                        } else {
                            $.notifyBar({ cssClass: "error", html: data.message });
                            if (data.stock) {
                                itemQuantity.val(data.stock);
                            }
                        }
                    }
                });
            }
        }
    });
    $(document).on('click', '.addCart', function () {

        let pro_id = $(this).data('id');
        let qty = $('.output').val();

        if (qty == 0 || qty == undefined) {
            qty = 1;
        }

        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        let that = $(this);
        $.ajax({
            type: "post",
            url: cartAdd,
            data: {
                _token: CSRF_TOKEN,
                pro_id: pro_id,
                qty: qty,
            },
            success: function (data) {
                if (data.success == true) {
                    $.notifyBar({ cssClass: "success", html: data.message });
                    // that.addClass("disabled");
                    that.text('');
                    that.append('<i class="fa fa-shopping-cart"></i> Go to Cart');
                    that.attr("href", gotocart);
                    that.removeClass('addCart');
                    $('.cart_counter').text(data.cartCount);

                } else {
                    $.notifyBar({ cssClass: "error", html: data.message });
                }
            }
        });
    });

    $(document).on('click', '.addCartRent', function () {

        let pro_id = $(this).data('id');
        let qty = $('.output').val();
        let from_date = $("#from_date").val();
        let to_date = $("#to_date").val();
        let from_time = $("#from_time").val();
        let to_time = $("#to_time").val();
        let total_hrs = $("#total_hrs").val();
        let total_price = $("#total_price").val();

        if (qty == 0 || qty == undefined) {
            qty = 1;
        }

        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var that = $(this);
        $.ajax({
            type: "post",
            url: cartAdd,
            data: {
                _token: CSRF_TOKEN,
                pro_id: pro_id,
                qty: qty,
                from_date: from_date,
                to_date: to_date,
                from_time: from_time,
                to_time: to_time,
                total_hrs: total_hrs,
                total_price: total_price,
            },
            success: function (data) {
                if (data.success == true) {
                    $.notifyBar({ cssClass: "success", html: data.message });
                    that.addClass("disabled");
                    $('#rentCartBtn').text('');
                    $('#rentCartBtn').append('<i class="fa fa-shopping-cart"></i> Go to Cart');
                    $('#rentCartBtn').removeClass('RentCart');
                    $('#rentCartBtn').attr("href", gotocart);
                    $('.cart_counter').text(data.cartCount);
                    $('#rentCountForm').trigger("reset");
                    $(".total_hrs").text('00 Hr');
                    $(".total_price").text('$ 00.00');

                } else {
                    $.notifyBar({ cssClass: "error", html: data.message });
                }
            }
        });
    });


    $('.minusCart').click(function () {
        var itemQuantity = $(this).parent().find('.output');
        var currentval = parseInt(itemQuantity.val());
        if (currentval == 1) {
            $(this).parent().parent().parent().find('.add-btn').show();
            // $(this).parent().parent().hide();
        } else {

            let id = $(this).attr('data-id');
            let pro_id = $(this).attr('data-proid');
            let qty = parseInt(itemQuantity.val()) - 1;
            itemQuantity.val(parseInt(itemQuantity.val()) - 1);

            if (qty != 0) {
                let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: cartUpdate,
                    method: "post",
                    data: { _token: CSRF_TOKEN, id: id, pro_id: pro_id, qty: qty },
                    success: function (data) {
                        if (data.success == true) {
                            $('#subtotal').text('$' + data.subTotal);
                            $('#total').text('$' + data.total);
                            $('#cartCount').text('Product Price (' + data.cartCount + ' items)');
                            $('.cart_counter').text(data.cartCount);

                        } else {
                            $.notifyBar({ cssClass: "error", html: data.message });
                        }
                    }
                });
            }
        }
    });

    $('.plusCart').click(function () {
        var itemQuantity = $(this).parent().find('.output');

        let id = $(this).attr('data-id');
        let pro_id = $(this).attr('data-proid');
        let qty = parseInt(itemQuantity.val()) + 1;

        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: cartUpdate,
            method: "post",
            data: { _token: CSRF_TOKEN, id: id, pro_id: pro_id, qty: qty },
            success: function (data) {
                if (data.success == true) {
                    $('#subtotal').text('$' + data.subTotal);
                    $('#total').text('$' + data.total);
                    $('#cartCount').text('Product Price (' + data.cartCount + ' items)');
                    $('.cart_counter').text(data.cartCount);

                    itemQuantity.val(parseInt(itemQuantity.val()) + 1);
                } else {
                    $.notifyBar({ cssClass: "error", html: data.message });
                }
            }
        });
    });

    /* Remove Cart */

    $(document).on('click', '.remove-from-cart', function () {
        let id = $(this).data('id');
        let proid = $(this).data('proid');
        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var that = $(this);
        swal({
            title: "Are you sure?",
            text: "Remove this product from cart!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, remove it!",
            closeOnConfirm: true
        },
            function () {

                $.ajax({
                    url: cartRemove,
                    method: "DELETE",
                    data: { _token: CSRF_TOKEN, id: id, proid: proid },
                    success: function (data) {
                        if (data.success == true) {
                            $.notifyBar({ cssClass: "success", html: data.message });
                            if (data.cartCount == 0) {
                                window.location.reload();
                            }
                            that.parent().parent().parent().parent().remove();
                            $('#subtotal').text('$' + data.subTotal);
                            $('#total').text('$' + data.total);
                            $('#cartCount').text('Product Price (' + data.cartCount + ' items)');
                            $('.cart_counter').text(data.cartCount);

                        } else {
                            $.notifyBar({ cssClass: "error", html: data.message });
                        }
                    }
                });
            });
    });

    $('#shipping_details').on('submit', function (e) {
        e.preventDefault();
        if ($(this).parsley().isValid()) {

            var frm = $(this).serialize();
            shippingAddress(frm);
        }
    });
    $('#shipping_details_upd').on('submit', function (e) {
        e.preventDefault();
        if ($(this).parsley().isValid()) {

            var frm = $(this).serialize();
            shippingAddress(frm);
        }
    });

    function shippingAddress(frm) {
        $.ajax({
            type: 'POST',
            url: shippingDetailSave,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: frm,
            success: function (data) {
                if (data.success == true) {
                    $.notifyBar({ cssClass: "success", html: data.message });
                    $('#shipping-address-list').append(data.html);
                    $('#shipping_details').trigger("reset");
                    $(".main_add_adddresses").slideToggle();
                    if (data.update == '1') {
                        window.location.reload();
                    }
                } else {
                    $.notifyBar({ cssClass: "error", html: data.message });
                }
            }
        });
    }

    $(document).on('click', '.delete', function () {
        var href = $(this).data('href');
        swal({
            title: "Are you sure?",
            text: "Delete this Address!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: true
        },
            function () {
                location.href = href;
            });
    });

    $(document).on('click', '.editAddress', function (e) {
        let id = $(this).data('id');
        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "post",
            url: EditShippingAddressFetch,
            data: {
                _token: CSRF_TOKEN,
                id: id,
            },
            success: function (data) {
                $('.shipping_id').val(data.shippingAddress.id);
                $('.name').val(data.shippingAddress.name);
                $('.last_name').val(data.shippingAddress.last_name);
                let phone_number_type = data.shippingAddress.phone_number_type;

                $(".phone_number_type option[value=" + phone_number_type + "]").attr('selected', 'selected');
                $('.phone_number').val(data.shippingAddress.phone_number);
                let address_type = data.shippingAddress.address_type;

                $(".address_type option[value=" + address_type + "]").attr('selected', 'selected');
                $('.address_line1').val(data.shippingAddress.address_line1);
                $('.address_line2').val(data.shippingAddress.address_line2);
                $('.state').val(data.shippingAddress.state);
                $('.city').val(data.shippingAddress.city);
                $('.zipcode').val(data.shippingAddress.zipcode);


                let country_id = data.shippingAddress.country_id;
                let default_address = data.shippingAddress.default_address;
                $(".country_id option[value=" + country_id + "]").attr('selected', 'selected');

                if (default_address == '1') {
                    $(".default_address").attr('checked', 'checked');
                } else {
                    $(".default_address").attr('checked', false);
                }
            }
        });
    });

});

/*  Product Filter  */
$(document).ready(function () {
    let setlimit = 0;
    let isFilterClick = false;
    $(document).on('click', '.load-more', function () {
        $(this).append("<i class='fa fa-spinner fa-spin' id='load_more_spinner'></i>");
        limit = parseInt(limit);
        if (setlimit == 0) {
            setlimit = limit;
        } else {
            setlimit += limit;
        }
        let data = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            slug2: $(this).data('slug2'),
            slug3: $(this).data('slug3'),
            slug4: $(this).data('slug4'),
            brand: get_data('brand'),
            category: get_data('category'),
            rating: get_data('rating'),
            min_price: $("#min_price").val(),
            max_price: $("#max_price").val(),
            sell_type: get_data('saleType_checkbox'),
            sort_by: $("#product_sort_by").val(),
            limit: setlimit,
            cat: cat_id,
            search: search,
            brandId: brandId,
        }
        getproductListData(data, 'load-more');
        $('#load_more_spinner').remove();
    });
    function get_data(class_name) {
        let filter = [];
        $('.' + class_name + ':checked').each(function () {
            filter.push($(this).val());
        });
        return filter;
    }
    $('.brand').click(function () {
        filter_data();
    });
    $('.category').click(function () {
        filter_data();
    });
    $('.saleType_checkbox').click(function () {
        filter_data();
    });
    $('.range-input').change(function () {
        filter_data();
    });
    $('#product_sort_by').change(function () {
        filter_data();
    });
    $('.rating').click(function () {
        filter_data();
    });

    function filter_data() {
        $('.product_list_wrap').addClass('section-loader');
        let data = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            brand: get_data('brand'),
            category: get_data('category'),
            rating: get_data('rating'),
            min_price: $("#min_price").val(),
            max_price: $("#max_price").val(),
            sell_type: get_data('saleType_checkbox'),
            sort_by: $("#product_sort_by").val(),
            limit: 0,
            slug2: slug2,
            slug3: slug3,
            slug4: slug4,
            cat: cat_id,
            search: search,
            brandId: brandId,
        }

        getproductListData(data, 'filter');
    }
    function getproductListData(payload, isFor) {
        $.ajax({
            url: productFilter,
            method: "post",
            data: payload,
            success: function (data) {
                if (data.html) {
                    if (isFor == 'filter') {

                        $('#product-list').html(data.html);
                        if (data.product_count == 0 || !data.product_count) {
                            // $('#filter_sidebar').hide();
                            $('#product_list_wrap').hide();
                            $('#no_product_section').show();
                            // $('#product_sorting_section').hide();
                        }else{
                            $('#product_list_wrap').show();
                            $('#no_product_section').hide();
                        }
                        setlimit = 0;
                        isFilterClick = true;
                    } else {
                        if (data.product_count > 0) {

                            $('#product_list_wrap').show();
                            $('#no_product_section').hide();

                            $('#product-list').append(data.html);
                        }
                    }
                    if (data.product_count == 0 || data.product_count == data.all_count || setlimit > data.all_count) {
                        $('.load-more').addClass('display-none');
                    } else {
                        $('.load-more').removeClass('display-none');
                    }
                    $('.product_list_wrap').removeClass('section-loader');
                    productRatingStars();
                } else {
                    $('.product_list_wrap').removeClass('section-loader');
                    if (isFor == 'filter') {
                    // $('#filter_sidebar').hide();
                        $('#product_list_wrap').hide();
                        $('#no_product_section').show();
                    // $('#product_sorting_section').hide();
                    } else {
                        $('.load-more').addClass('display-none');

                    }

                }
            },
            error: function (data, textStatus, errorThrown) {
            },
        });
    }
    //
    // $(document).on('click', '.placeOrder', function (e) {
    //     let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    //     let shipping_address_id = $('input[name="deliver_address"]:checked').val();
    //     // console.log(shipping_address_id);
    //     if(shipping_address_id != '' && shipping_address_id != undefined){
    //         $.ajax({
    //             type: "post",
    //             url: placeOrder,
    //             data: {
    //                 _token: CSRF_TOKEN,
    //                 shipping_address_id: shipping_address_id,
    //             },
    //             success: function (data) {
    //
    //                 $.notifyBar({ cssClass: "success", html: data.message });
    //
    //             }
    //         });
    //     }else{
    //         $.notifyBar({cssClass: "error", html: 'Shipping Address is Required'});
    //     }
    //
    //
    // });

});
function productRatingStars() {
    $('.common-rating').jRating({
        bigStarsPath: bigStarsPath,
        isDisabled: true
    });
}

/* Product Rating */

$(document).ready(function () {
    initilizeRating();
    // ratingProgress();
    productRatingStars();
    $(document).on('click', '.submit-rating', function () {
        productId = $(this).data('product');
        $.ajax({
            url: addRating,
            method: "post",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                product_id: productId,
                rating: myrating,
            },
            success: function (data) {
                $('#pro_ratings').remove();
                if (data.success) {
                    $('#ratingProgress').empty();
                    ratingProgress(data.progressBar);
                    $('#avg_rating').text(data.avg_rating);
                    $('#all_rating').text(data.all_rating);
                    $(document).find(".sg_add_product_rating").slideToggle();
                    $.notifyBar({ cssClass: "success", html: data.message });
                } else {
                    $.notifyBar({ cssClass: "error", html: data.message });
                }
                $('#products_stars').append("<div class='my-rating' data-average='" + myrating + "' data-id='1' id='pro_ratings'></div>");
                initilizeRating();
            },
            error: function (data, textStatus, errorThrown) {
            },
        });
    });
    function initilizeRating() {
        $('.my-rating').jRating({
            bigStarsPath: bigStarsPath
        });
    }
    function ratingProgress(progressBars) {
        for (let index = 0; index < progressBars.length; index++) {
            const element = progressBars[index];
            const element1 = "<li class='sg_progress_item'><label for=''> " + (index + 1) + " <i class='fa fa-star' aria-hidden='true'></i></label><div class='progress'><div class='progress-bar' style='width:" + element['percentage'] + "%;'></div></div><span>" + element['all_ratings'] + " </span></li>"
            $('#ratingProgress').append(element1);
        }
    }
});

// Contact Us
$(document).ready(function () {
    $('#contact_us_update').on('submit', function (e) {
        e.preventDefault();
        if ($(this).parsley().isValid()) {
            $('#contact_us_btn').attr('disabled', true);
            $('.contact_form_wrap').addClass('section-loader');
            var frm = $(this).serialize();
            makeContact(frm);
        }
    });

    function makeContact(frm) {
        $.ajax({
            type: 'POST',
            url: contactUsUrl,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: frm,
            success: function (data) {
                if (data.success == true) {
                    $.notifyBar({ cssClass: "success", html: data.message });
                    $('#contact_us_update').trigger("reset");
                } else {
                    $.notifyBar({ cssClass: "error", html: data.message });
                }
                $('#contact_us_btn').attr('disabled', false);
                $('.contact_form_wrap').removeClass('section-loader');
            },
            error: function (data) {
                $('.contact_form_wrap').removeClass('section-loader');
            },
        });
    }
});



// Track Order
$(document).ready(function () {
    $('#track-order-form').on('submit', function (e) {
        e.preventDefault();
        if ($(this).parsley().isValid()) {
            $('.track_form_wrapper').addClass('section-loader');
            var frm = $(this).serialize();
            trackOrder(frm);
        }
    });

    function trackOrder(frm) {
        $.ajax({
            type: 'POST',
            url: trackOrderUrl,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: frm,
            success: function (data) {
                if (data.success == true) {
                    $('#traking-card').empty();
                    $.notifyBar({ cssClass: "success", html: data.message });
                    $('.track_form_wrapper').removeClass('section-loader');
                    if (data.html) {
                        $('#traking-card').append(data.html);

                        $(document).find(".track_map_wrap").show();
                    }
                } else {
                    $('#traking-card').empty();
                    $('#traking-card').append('<div class="card-header"> No Order Found </div>');
                    $.notifyBar({ cssClass: "error", html: data.message });
                    $('.track_form_wrapper').removeClass('section-loader');
                }
            },
            error: function (data) {
                $('.track_form_wrapper').removeClass('section-loader');
            },
        });
    }
});


// FAQ
$(document).ready(function () {
    if (pageName && pageName == 'faq') {
        let id = 1;
        $('.accordion-wrapper').addClass('section-loader');
        getQuestion(id);
    }
    $('.que_category').on('click', function (e) {
        $('a.que_category.active').removeClass('active');
        id = $(this).attr('id');
        $(this).addClass('active');
        getQuestion(id);
    });

    function getQuestion(id) {
        $.ajax({
            type: 'POST',
            url: faqUrl,
            data: {
                id: id,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                if (data.success == true) {
                    $('.accordion-wrapper').empty();
                    if (data.html) {
                        $('.accordion-wrapper').append(data.html);
                    } else {
                        $('.accordion-wrapper').append('<h5>No Question Found</h5>');
                    }
                    $('.accordion-wrapper').removeClass('section-loader');
                }
            },
            error: function (data) {
                $('.accordion-wrapper').removeClass('section-loader');
            },
        });
    }

    $(".txtcol").click(function () {
        if ($(this).prev().hasClass("truncate")) {
            $(this).children('a').text("Show Less");
        } else {
            $(this).children('a').text("Show More");
        }
        $(this).prev().toggleClass("truncate");

    });
});


