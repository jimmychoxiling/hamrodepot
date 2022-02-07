$(document).ready(function () {

    /* Mainmenu */
    $('.mainmenu > ul').addClass('mobile-menu');
    $('.mainmenu > ul > li ul').addClass('sub-menu');
    if ($('.mobile-menu').length > 0) {
        $('.site-header .header-inner .header-right > ul').after('<button type="button" class="nav-toggle"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>');
    }
    if ($('.mobile-menu li').length > 0) {
        $('.mobile-menu li > ul').before('<span class="mobile-toggle"></span>');
    }
    $('.nav-toggle').click(function () {
        $(this).toggleClass('nav-menuopen');
        $('.mobile-menu').slideToggle(200);
        $('.mainmenu').find('.sub-menu').slideUp(250);
        $('.mainmenu').find('.mobile-toggle').removeClass('nav-subopen');
    });
    $('.mainmenu .mobile-toggle').click(function () {
        $(this).parent().siblings('.item-children').find('.mobile-toggle').removeClass('nav-subopen');
        $(this).parent().siblings('.item-children').find('.sub-menu').slideUp(250);
        $(this).next('.sub-menu').slideToggle(250);
        $(this).next('.sub-menu').children('.item-children').find('.sub-menu').slideUp(250);
        $(this).next('.sub-menu').children('.item-children').find('.mobile-toggle').removeClass('nav-subopen');
        $(this).toggleClass('nav-subopen');
        return false;
    });
    $('.site-header .mainmenu .item-children > .mobile-toggle').click(function () {
        $(this).parents(".item-children").toggleClass('active-item-children');
    });

    // SIGN UP TAB
    $('.auth_tab_btns li a').on('click', function () {
        var target = $(this).attr('data-rel');
        $('.auth_tab_btns li a').removeClass('active');
        $(this).addClass('active');
        $("#" + target).fadeIn('slow').siblings(".auth_content_inner").hide();
        return false;
    });

    $('.global_tab li a').on('click', function () {
        var target = $(this).attr('data-rel');
        $('.global_tab li a').removeClass('active');
        $(this).addClass('active');
        $("#" + target).fadeIn('slow').siblings(".global_tab_content").hide();
        return false;
    });
    // END SIGN UP TAB

    // SUB CATEGORY SLIDETOGGLE
    $('.sb_sub_category_title').first().addClass("active");
    $('.sb_sub_category_list_wrap').show();
    // $('.sb_sub_category_list_wrap').last().show();
    // $('.sb_sub_category_list_wrap').first().show();
    $(".sb_sub_category_title").click(function () {
        $(this).toggleClass("active");
        $(this).next(".sb_sub_category_list_wrap").slideToggle();
    });
    // END SUB CATEGORY SLIDETOGGLE

    // PLUS MINUS
    $('.minus').click(function (e) {
        var itemQuantity = $(this).parent().find('.output');
        var currentval = parseInt(itemQuantity.val());
        if (currentval == 1) {
            $(this).parent().parent().parent().find('.add-btn').show();
            // $(this).parent().parent().hide();
        }
        else {
            itemQuantity.val(parseInt(itemQuantity.val()) - 1);
        }
    });

    $('.plus').click(function (e) {
        var itemQuantity = $(this).parent().find('.output');
        var itemQuantityNew = parseInt(itemQuantity.val()) + 1;
        if (itemQuantityNew <= productStock) {
            itemQuantity.val(itemQuantityNew);
        } else {
            $.notifyBar({ cssClass: "error", html: 'Out Of Stock!' });

        }

    });
    // END PLUS MINUS

    $(document).on("click", '[data-target]', function () {
        var target = $(this).attr('data-target');
        if (target != null) {
            $(document).find(target).addClass("show");
        }
    });


    // ON MOBILE FILTER SIDE BAR
    jQuery('.mobile_filter_button .filter_btn').on('click', function () {
        jQuery('body').toggleClass('oy-hidden');
        jQuery(this).addClass('d-none');
        jQuery(this).parents('.mobile_filter_button').find('.filter_cancel_btn').removeClass('d-none');
        jQuery(document).find('#filter_sidebar').toggleClass('show');
    });
    jQuery('.mobile_filter_button .filter_cancel_btn').on('click', function () {
        jQuery('body').toggleClass('oy-hidden');
        jQuery(this).addClass('d-none');
        jQuery(this).parents('.mobile_filter_button').find('.filter_btn').removeClass('d-none');
        jQuery(document).find('#filter_sidebar').toggleClass('show');
    });

    $(document).on("click", '.c_popup_wrapper.show .c_popup_close', function () {
        $(this).parents(".c_popup_wrapper.show").removeClass("show");
    });
    $(document).on("click", '.c_popup_wrapper.show .c_popup_overlay', function () {
        $(this).parents(".c_popup_wrapper.show").removeClass("show");
    });

    // ORDER DETAILS TRACK ORDERS

    $('.od_product_view_status a').on('click', function () {
        $(".od_status_box_wrap").hide();
        $(this).parents(".od_list_item").find(".od_status_box_wrap").slideToggle();
    });

    $('.od_list_item .sg_purchase_close_btn').on('click', function () {
        $(this).parents(".od_status_box_wrap").slideToggle();
    });

    // ORDER DETAILS TRACK ORDERS

    // RELATED PRODUCT SLIDER
    $('.related_products .related_products_slider').slick({
        dots: false,
        infinite: true,
        slidesToShow: 5,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 1199,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 991,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 425,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                }
            },
        ]
    });
    // END RELATED PRODUCT SLIDER

    // HOME SLIDER FOR SINGLE FEATURED IMG
    $('.bannerFeaturedSliderSingle').slick({
        dots: false,
        arrows: true,
        infinite: true,
        speed: 1500,
        // fade: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
    });

    // HOME SLIDER LEFT SIDE
    $('.homeBannerMainSlider').slick({
        dots: false,
        arrows: false,
        infinite: true,
        speed: 1500,
        fade: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
    });


    // BANNER FEATURED PRODUCT SLIDER
    $('.bannerFeaturedSlider').slick({
        dots: false,
        infinite: true,
        arrows: true,
        slidesToShow: 4,
        slidesToScroll: 1,
        speed: 1500,
        autoplay: true,
        autoplaySpeed: 2000,
        responsive: [
            {
                breakpoint: 1450,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 1199,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 991,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 425,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                }
            },
        ]
    });

    // ABOUT HARDWARE SLIDER
    $('.about_hw_slider').slick({
        dots: false,
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1
    });
    // ABOUT HARDWARE SLIDER

    // FOR PRODUCT PAGE IMG SLIDER
    $('.main_single_product .product_image_slider').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.main_single_product .product_image_thumb_slider'
    });
    $('.main_single_product .product_image_thumb_slider').slick({
        slidesToShow: 6,
        slidesToScroll: 1,
        asNavFor: '.main_single_product .product_image_slider',
        dots: false,
        focusOnSelect: true,
        // centerMode: true,
        variableWidth: true
    });
    // END FOR PRODUCT PAGE IMG SLIDER

    // FOR PRODUCT PAGE RENT FORM TOGGLE
    $('.main_single_product .buy_rent a.RentCart').on('click', function () {
        $(this).toggleClass("active");
        $(this).parents(".sg_action_btn_wrap").toggleClass("active");
        $('.main_single_product .sg_purchase_rent_form').slideToggle();
    });

    $('.main_single_product .sg_purchase_close_btn').on('click', function () {
        $(this).parents(".sg_purchase_rent_form").slideToggle();
        $(document).find(".main_single_product .sg_action_btn_wrap").removeClass("active");
        $(document).find(".main_single_product .sg_action_btn_wrap .buy_rent a").removeClass("active");
    });

    $('.main_single_product .addCartRent').on('click', function () {
        $(this).parents(".sg_purchase_rent_form").slideToggle();
        $(document).find(".main_single_product .sg_action_btn_wrap").removeClass("active");
        $(document).find(".main_single_product .sg_action_btn_wrap .buy_rent a").removeClass("active");
    });
    // END FOR PRODUCT PAGE RENT FORM TOGGLE

    $('.main_single_product .sg_product_add_rating').on('click', function () {
        $(document).find(".sg_add_product_rating").slideToggle();
    });

    // CHECKOUT SELECT ADDRESS
    // $(".checkout_address_item").click(function () {
    //     $(".checkout_address_item").removeClass("active");
    //     $(this).addClass("active");
    // });
    // END CHECKOUT SELECT ADDRESS

    // // TOOGLE CLASS LIKE AND DISLIKE
    // $(".sb_favorite_icon").click(function () {
    //     $(this).toggleClass("active");
    // });
    // // TOOGLE CLASS LIKE AND DISLIKE

    // TOOGLE CLASS ADD ADDRESS
    $(".checkout_address_card .card_title__action , .main_add_adddresses .card_title__action").click(function () {
        $(".main_add_adddresses").slideToggle();
        $('#shipping_details').trigger("reset");

    });
    // TOOGLE CLASS ADD ADDRESS

    jQuery("a.fancybox").fancybox();

    // Accordion
    jQuery(document).on('click', ".accordion-item .accordion-title", function () {
        var dropDown = jQuery(this).closest('.accordion-item').find('.accordion-content');
        jQuery(this).closest('.accordion-wrapper').find('.accordion-content').not(dropDown).slideUp();

        if (jQuery(this).hasClass('active')) {
            jQuery(this).removeClass('active');
        } else {
            jQuery(this).closest('.accordion-wrapper').find('.accordion-item .accordion-title.active').removeClass('active');
            jQuery(this).addClass('active');
        }

        dropDown.stop(false, true).slideToggle();
        // j.preventDefault();
    });//.first().click();

    // END Accordion

    // USER PROFILE UPLOAD IMAGE

    if (localStorage.img) {
        // debugger;
        $('#bannerImg').attr('src', localStorage.img);
    }
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                localStorage.setItem('img', e.target.result);
                $('#bannerImg').attr('src', reader.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $(".user_file_upload_upload").change(function () {
        readURL(this);
    });

    $(".user_upload__button p").on('click', function () {
        $(".user_file_upload_upload").click();
    });

    // USER PROFILE UPLOAD IMAGE

    // RANGE SLIDER FOR PRICE FILTER
    var parent = document.querySelector("#rangeSlider");
    if (!parent) return;

    var rangeS = parent.querySelectorAll("input[type=range]"),
        numberS = parent.querySelectorAll("input[type=number]");

    rangeS.forEach(function (el) {
        el.oninput = function () {
            var slide1 = parseFloat(rangeS[0].value),
                slide2 = parseFloat(rangeS[1].value);

            if (slide1 > slide2) {
                [slide1, slide2] = [slide2, slide1];
            }

            numberS[0].value = slide1;
            numberS[1].value = slide2;
        }
    });

    numberS.forEach(function (el) {
        el.oninput = function () {
            var number1 = parseFloat(numberS[0].value),
                number2 = parseFloat(numberS[1].value);

            if (number1 > number2) {
                var tmp = number1;
                numberS[0].value = number2;
                numberS[1].value = tmp;
            }

            rangeS[0].value = number1;
            rangeS[1].value = number2;

        }
    });

    // END RANGE SLIDER FOR PRICE FILTER




    /* Menu appendto  */
    if ($(window).width() < 992) {
        $(".login-btn").appendTo($("ul.mobile-menu"));
    }

    /* Search */
    $('.search-button').click(function () {
        $('header .search-input').slideToggle();
    });



    // $('.testimonial-image-slider').slick({
    //     slidesToShow: 1,
    //     slidesToScroll: 1,
    //     arrows: false,
    //     fade: true,
    //     asNavFor: '.testimonial-content-slider'
    // });
    // $('.testimonial-content-slider').slick({
    //     slidesToShow: 1,
    //     slidesToScroll: 1,
    //     asNavFor: '.testimonial-image-slider',
    //     dots: false,
    //     arrows: true,
    //     focusOnSelect: true
    // });

    // init plugin FOR PHONE NUMBER
    var input = document.querySelector("#phone");
    window.intlTelInput(input, {
    });

});

/* Equal Height */
$(window).on('load', function () {
    equalheight('.sameheight');
    contentspacenew();

    // SLICK ARROW WRAP IN DIV
    jQuery('.feature-section .slick-next , .feature-section .slick-prev').wrapAll('<div class="SliderControls">');
});

$(window).on('resize', function () {
    equalheight('.sameheight');
    contentspacenew();
});

equalheight = function (container) {
    var currentTallest = 0, currentRowStart = 0, rowDivs = new Array(), $el, topPosition = 0;
    $(container).each(function () {
        $el = $(this);
        $($el).height('auto')
        topPostion = $el.position().top;
        if (currentRowStart != topPostion) {
            for (currentDiv = 0; currentDiv < rowDivs.length; currentDiv++) { rowDivs[currentDiv].outerHeight(currentTallest); }
            rowDivs.length = 0; // empty the array
            currentRowStart = topPostion;
            currentTallest = $el.height();
            rowDivs.push($el);
        } else {
            rowDivs.push($el);
            currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
        }
        for (currentDiv = 0; currentDiv < rowDivs.length; currentDiv++) { rowDivs[currentDiv].height(currentTallest); }
    });
}


function contentspacenew() {
    var windwidth = $(window).width();
    var containerwidth = $('.container').outerWidth();
    var contentlrspace = (windwidth - containerwidth) / 2;
    $('.left-spacepadd').css('padding-left', contentlrspace);
    $('.right-spacepadd').css('padding-right', contentlrspace);
}
