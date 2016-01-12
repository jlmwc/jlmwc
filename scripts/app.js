// app.js
// initialize mapbox and run core functions

// initialize Mapbox
L.mapbox.accessToken = 'pk.eyJ1IjoidHJhdmlzdy1yY2IiLCJhIjoiV1I2X0ZlQSJ9.HuDZt_-iESg9dg_PQvTFqA';

// initialize map then featurelayer
var map = L.mapbox.map('map', 'travisw-rcb.j03n31d8'),
    featureLayer = new L.mapbox.featureLayer().addTo(map);

// populate initial view
featureLayer.loadURL('index.php/home/show_churches');

// initialize view and attempt to geolocate
$(document).ready(function () {
    if (!navigator.geolocation) {
        map.fitBounds(featureLayer.getBounds());
    } else {
        map.locate();
        $('div.loading').removeClass('hide').addClass('show');
    }

    // location found handler
    map.on('locationfound', function (e) {
        var myMarker = L.marker(new L.LatLng(e.latlng.lat, e.latlng.lng), {
            icon: L.mapbox.marker.icon({
                'marker-color': '#4098d4',
                'marker-symbol': 'star'
            })
        }).bindPopup('Here I am!').addTo(map);

        try {
            map.fitBounds(PF.filter.findNearest(3, myMarker).getBounds());
        } catch(err) {
            map.setView(myMarker.getLatLng(), 13);
        }
        $('div.loading').removeClass('show').addClass('hide');
    });

    // geolocation available but returns error
    map.on('locationerror', function () {
        map.fitBounds(featureLayer.getBounds());
        $('div.loading').removeClass('show').addClass('hide');
    });
});


// event handlers
featureLayer.on('click', function (e) {
    map.panTo(e.layer.getLatLng());
});

// navigation
<<<<<<< HEAD
<<<<<<< HEAD
$('input#findParish').on('click', function openListOnParishSearch(){
    $('section#detail, section#list, section#find').removeClass('shown');
    $('section#list').addClass('shown');
=======
$('input#findparish').on('click', function openListOnParishSearch(){
=======
$('input#findparish').on('click', function openListOnParishSearch(){
<<<<<<< HEAD
    $('section#detail, section#list, section#find').removeClass('shown');
    $('section#list').addClass('shown');
=======
>>>>>>> origin/jl
    $('section#detail, section#list, section#find').css('left', '100%');
    $('section#list').css('left', '0%');
>>>>>>> master
    $('nav')
        .removeClass()
        .addClass('map');
    $('nav a.search').css('display', 'block');
});

<<<<<<< HEAD
=======
$('dl.resultlist').click(function openDetailOnListClick(){
    $('section#detail, section#list, section#find')
        .css('left', '100%');
    $('section#detail').css('left', '0');
    $('nav')
        .removeClass()
        .addClass('map');
});


>>>>>>> master
$('nav a').click(function (){
    if ( $(this).hasClass('search') ) {
        $('nav')
            .removeClass()
            .addClass('map');
<<<<<<< HEAD
        $('section#detail, section#list, section#find')
            .removeClass('shown');
        $('section#find').addClass('shown');
=======
        $('section#detail, section#list, section#find').css('left', '100%');
        $('section#find').css('left', '0');
>>>>>>> master
        return;
    }

    switch ( $('nav').attr('class') ) {
        case 'map':
<<<<<<< HEAD
            $('section#detail, section#list, section#find')
                .removeClass('shown');
=======
            $('section#detail, section#list, section#find').css('left', '100%');
>>>>>>> master

            if ( $('div#parishDetails').children().length > 0 ) {
=======
            $('section#detail, section#list, section#find').css('left', '100%');

            if ( $('div#detailView').children().length > 0 ) {
>>>>>>> master
                $('nav')
                    .removeClass()
                    .addClass('detail');
                $('nav a.search').css('display', 'block');
                break;
            }

<<<<<<< HEAD
            if ( $('div#resultList').children().length > 0 ) {
=======
            if ( $('div#result').children().length > 0 ) {
>>>>>>> master
                $('nav')
                    .removeClass()
                    .addClass('list');
                $('nav a.search').css('display', 'block');
                break;
            }

            $('nav')
                .removeClass('map')
                .addClass('find');
            break;

        case 'find':
            $('section#detail, section#list, section#find')
<<<<<<< HEAD
                .removeClass('shown');
            $('section#find').addClass('shown');
=======
                .css('left', '100%');
            $('section#find').css('left', '0');
>>>>>>> master
            $('nav')
                .removeClass()
                .addClass('map');
            $('nav a.search').css('display', 'none');
            break;

        case 'list':
            $('section#detail, section#list, section#find')
<<<<<<< HEAD
                .removeClass('shown');
            $('section#list').addClass('shown');
=======
                .css('left', '100%');
            $('section#list').css('left', '0');
>>>>>>> master
            $('nav')
                .removeClass()
                .addClass('map');
            break;

        case 'detail':
            $('section#detail, section#list, section#find')
<<<<<<< HEAD
                .removeClass('shown');
            $('section#detail').addClass('shown');
=======
                .css('left', '100%');
            $('section#detail').css('left', '0');
>>>>>>> master
            $('nav')
                .removeClass()
                .addClass('map');
            break;

        default:
        break;
    }
});
