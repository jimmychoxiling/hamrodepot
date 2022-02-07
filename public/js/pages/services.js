var geocoder;
var map;
var places;
var markers = [];

$(document).ready(function () {
    $(document).on('click','.filter-btn', function(){
        getMapServices();
    });

    $("#service-price-range").slider({
        range: true,
        min: 0,
        max: maxPrice,
        values: [0, maxPrice],
        slide: function (event, ui) {
            $("#selected_price").val("$" + ui.values[0] + " - $" + ui.values[1]);
            $("#min_service_price").val(ui.values[0]);
            $("#max_service_price").val(ui.values[1]);
        }
    });

    $("#selected_price").val("$" + $("#service-price-range").slider("values", 0) +
        " - $" + $("#service-price-range").slider("values", 1));
    $("#min_service_price").val($("#service-price-range").slider("values", 0));
    $("#max_service_price").val($("#service-price-range").slider("values", 1));
});
// function getMapServices(){
//     let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
//     var infowindow =  new google.maps.InfoWindow({
//         content: ''
//     });
    
//     var formData = $('.filter_form').serialize();

//     $.ajax({
//         url: getMapServicesLink,
//         method: "POST",
//         data: {
//             _token: CSRF_TOKEN,
//             filters : formData,
//         },
//         success: function (data) {
//             var response = JSON.parse(data);
//             var responseMarkers = response.markers;
            
//             // Loop through markers and set map to null for each
//             for (var i=0; i<markers.length; i++) {
//                 markers[i].setMap(null);
//             }
//             // Reset the markers array
//             markers = [];

//             for (let index = 0; index < responseMarkers.length; index++) {
//                 tmpLatLng = new google.maps.LatLng( responseMarkers[index][1], responseMarkers[index][2]);

//                 // make and place map maker.
//                 var marker = new google.maps.Marker({
//                     map: map,
//                     position: tmpLatLng,
//                     title : responseMarkers[index][0]
//                 });

//                 $infoWindowContent = '<div class="info-box">';
//                 $infoWindowContent += '<p style="margin-bottom:10px;"><strong>Title</strong>: '+responseMarkers[index][0]+'</p>';
//                 $infoWindowContent += '<p style="margin-bottom:10px;"><strong>Address</strong>: '+responseMarkers[index][5]+'</p>';
//                 $infoWindowContent += '<p style="margin-bottom:10px;"><strong>Time</strong>: '+responseMarkers[index][4]+'</p>';
//                 $infoWindowContent += '<p style="margin-bottom:10px;"><strong>Price</strong>: '+currency+responseMarkers[index][3]+'</p>';
//                 $infoWindowContent += '<p style="margin-bottom:10px;"><strong>Seller</strong>: '+responseMarkers[index][7]+'</p>';
//                 $infoWindowContent += '<a style="padding:10px;background: #000;color: #fff;display: inline-flex;line-height: normal;" href="'+responseMarkers[index][6]+'" target="_blank">Book Service</p>';
//                 $infoWindowContent += '</div>';

//                 bindInfoWindow(marker, map, infowindow, $infoWindowContent);

//                 // not currently used but good to keep track of markers
//                 markers.push(marker);
//             }

//         },
//         error: function (data, textStatus, errorThrown) {
//             console.log(data);
//         },
//     });
// }
// function initialize() {

//     // create the geocoder
//     geocoder = new google.maps.Geocoder();
  
//   // set some default map details, initial center point, zoom and style
//   var mapOptions = {
//     center: new google.maps.LatLng(centerLat,centerLng),
//     zoom: 7,
//     scrollwheel: true,
//     mapTypeId: google.maps.MapTypeId.ROADMAP
//   };
  
//   // create the map and reference the div#map-canvas container
//   map = new google.maps.Map(document.getElementById("map_services"), mapOptions);

//   // fetch the existing places (ajax) 
//   // and put them on the map
//   getMapServices();
// }
// google.maps.event.addDomListener(window, 'load', initialize);

// // binds a map marker and infoWindow together on click
// var bindInfoWindow = function(marker, map, infowindow, html) {
//     google.maps.event.addListener(marker, 'click', function() {
//         infowindow.setContent(html);
//         infowindow.open(map, marker);
//     });
// } 