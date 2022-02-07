$(document).ready(function(){
    $(".select2").select2({
        closeOnSelect : false,
        allowClear: true,
    });
    
    // $(document).on('focus','.auto-complete-address', function(){
    //     var _this = $(this);
    //     var autocomplete = new google.maps.places.Autocomplete(_this[0], {
    //         componentRestrictions: { country: [] },
    //         fields: ["address_components", "geometry"],
    //         // types: ["address"],
    //     });
    //     // autocomplete.addListener("place_changed", fillInAddress);

    //     google.maps.event.addListener(autocomplete, 'place_changed', function() {
    //         var place = autocomplete.getPlace();
    //         _this.parents('.single-address-row').find(".lat").val(place.geometry.location.lat())
    //         _this.parents('.single-address-row').find(".lng").val(place.geometry.location.lng())
            
    //         var addresses = place.address_components;

    //         for (var j = 0; j < addresses.length; j++) {
    //             var componentType = addresses[j].types[0];
    //             switch (componentType) {
    //                 case "postal_code":
    //                     _this.parents('.single-address-row').find(".zipcode").val(addresses[j].long_name);
    //                     break;
    //                 case "locality":
    //                     _this.parents('.single-address-row').find(".city").val(addresses[j].long_name);
    //                     break;
    //                 case "administrative_area_level_1":
    //                     _this.parents('.single-address-row').find(".state").val(addresses[j].long_name);
    //                     break;
    //                 case "country":
    //                     _this.parents('.single-address-row').find(".country").val(addresses[j].long_name);
    //                     break;
    //             }
    //         }

    //         $('.service-form').valid();
    //     });
    // })


    $(document).on('click', '.addMoreAddress', function() {
        var html = $("#services-addresses .single-address-row").first().clone();
        $(html).find('.more-address-btn').html('<a href="javascript:void(0);" class="removeAddress"><i class="fas fa-minus btn btn-danger"></i></a>')
        $(html).find("input, textarea, select").val("").addClass('new-field');
        $(html).find(".error").remove();

        var totalRowCount = $('#services-addresses').find('.single-address-row').length;
        totalRowCount = totalRowCount+1;
        $(html).find('input[name^="address"]').attr('name', 'address['+totalRowCount+']');
        $(html).find('input[name^="country"]').attr('name', 'country['+totalRowCount+']');
        $(html).find('input[name^="state"]').attr('name', 'state['+totalRowCount+']');
        $(html).find('input[name^="city"]').attr('name', 'city['+totalRowCount+']');
        $(html).find('input[name^="zipcode"]').attr('name', 'zipcode['+totalRowCount+']');            
        $(html).find('input[name^="lat"]').attr('name', 'lat['+totalRowCount+']');            
        $(html).find('input[name^="lng"]').attr('name', 'lng['+totalRowCount+']');            
        $(html).find('input[name^="price"]').attr('name', 'price['+totalRowCount+']');            
        
        $(this).parent().parent().parent().parent().append(html);

        validateExtraFields(true);
    });


    $.validator.addMethod("noSpace", function (value, element) {
        return value.indexOf(" ") < 0 && value != "";
    });
    $.validator.addMethod("alpha", function(value, element) {
        return this.optional(element) || value == value.match(/^[a-zA-ZÄäÜüÖö\u0600-\u06FF][\sa-zA-ZÄäÜüÖö\u0600-\u06FF]*/);
    });
    $.validator.addMethod("alphaNumeric", function (value, element) {
        return this.optional(element) || value.match(/^[a-zA-ZÄäÜüÖö0-9\u0600-\u06FF][\sa-zA-ZÄäÜüÖö0-9\u0600-\u06FF]*/);
    });
    $.validator.addMethod("noDigits", function (value, element) {
        return this.optional(element) || value != value.match(/^[0-9]*/);
    }, "Only Numbers Not Allowed");

    $.validator.addMethod("greaterThanZero", function(value, el, param) {
        value = $.trim(value);
        if (value == "") return true;
        else if (value < 0) return false;
        return true;
    });
    jQuery.validator.addMethod("lesserThan", function(value, element, params) {
        if($(params).val() != '' && value != ''){
            return isNaN(value) && isNaN(params) || (Number(value) < Number($(params).val()));
        }
        return true;
    });

    // $(document).on('change', '#service_category_id', function(){
    //     $('.service-form').valid();
    // });

    $(document).on('click', '.removeAddress', function() {
        $(this).parent().parent().parent().fadeOut(500, function(){ 
            $(this).remove();
        });
    });
    
    $(".service-form").validate({
        ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
        errorElement: 'span',
        errorClass: 'error',
        successClass: 'validation-valid-label',
        highlight: function (element, errorClass) {
            $(element).removeClass(errorClass);
        },
        unhighlight: function (element, errorClass) {
            $(element).removeClass(errorClass);
        },
        // Different components require proper error label placement
        errorPlacement: function (error, element) {
            if (element.hasClass("select2")) {
                error.appendTo(element.parent());
            } else if (element.parents('div').hasClass('time-check')) {
                error.appendTo( element.parent().parent().parent());
            } else {
                error.insertAfter(element);
            }
        },
        validClass: "validation-valid-label",
        success: function (label) {
            label.remove();
        },
        rules: {
            name: {
                required: true,
                noDigits:true,
                minlength: 2,
                maxlength: 100,
            },
            description: {
                required: true,
                minlength: 10,
                maxlength: 1000,
            },
            service_category_id: {
                required: true,
            },
            "time[]": {
                required: true,
                minlength: 1
            },
        },
        debug:true,
        messages: {
            name: {
                required: "Please enter name",
                alpha: "The name may only contain Letters and Spaces",
                minlength: jQuery.validator.format("Please enter max {0} characters."),
                maxlength: jQuery.validator.format("Maximum {0} characters are allowed."),
            },
            description: {
                required: "Please enter service details",
                minlength: jQuery.validator.format("Please enter max {0} characters."),
                maxlength: jQuery.validator.format("Maximum {0} characters are allowed."),
            },
            service_category_id: {
                required: "Please select atleast one category"
            },
            "time[]": {
                required: "Please select atleast one time",
                minlength: "Please select atleast one time",
            },
        },
        submitHandler: function (form) {
            validateExtraFields();
            $(form).find('button[type="submit"]').attr('disabled', 'disabled');
            form.submit();
        }
    });

    validateExtraFields();
});

function PreviewImage(no) {
    var oFReader = new FileReader();
    oFReader.readAsDataURL(document.getElementById("uploadImage" + no).files[0]);
    oFReader.onload = function(oFREvent) {
        document.getElementById("uploadPreview" + no).src = oFREvent.target.result;
    };
}

function validateExtraFields(is_click = false){
    $('.single-address-row [name^=address]').each(function() {
        $(this).rules('add', {
            required: true,
            messages: {
                required: "please enter address",
            }
        });
    });
    $('.single-address-row [name^=country]').each(function() {
        $(this).rules('add', {
            required: true,
            messages: {
                required: "please enter country",
            }
        });
    });
    $('.single-address-row [name^=state]').each(function() {
        $(this).rules('add', {
            required: true,
            messages: {
                required: "please enter state",
            }
        });
    });
    $('.single-address-row [name^=city]').each(function() {
        $(this).rules('add', {
            required: true,
            messages: {
                required: "please enter city",
            }
        });
    });
    $('.single-address-row [name^=zipcode]').each(function() {
        $(this).rules('add', {
            required: true,
            number : true,
            messages: {
                required: "please enter zipcode",
            }
        });
    });
    $('.single-address-row [name^=lat]').each(function() {
        $(this).rules('add', {
            required: true,
            messages: {
                required: "please enter lat",
            }
        });
    });
    $('.single-address-row [name^=lng]').each(function() {
        $(this).rules('add', {
            required: true,
            messages: {
                required: "please enter lng",
            }
        });
    });
    $('.single-address-row [name^=price]').each(function() {
        $(this).rules('add', {
            required: true,
            greaterThanZero: true,
            messages: {
                required: "please enter price",
                greaterThanZero: "price value must be greater then 0",
            }
        });
    });

    if(is_click == true){
        $('.service-form').valid();
    }
}