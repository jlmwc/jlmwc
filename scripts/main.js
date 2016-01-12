// shared.js
// -- general scope functions and modernizers
//universal var
listPage = false;
detailPage = false;
detailViewByPins = false;
var indexOf = function (needle) {
    if (typeof Array.prototype.indexOf === 'function') {
        indexOf = Array.prototype.indexOf;
    } else {
        indexOf = function (needle) {
            var i = -1,
                index = -1;
            for (i = 0; i < this.length; i++) {
                if (this[i] === needle) {
                    index = i;
                    break;
                }
            }
            return index;
        };
    }
    return indexOf.call(this, needle);
};

// _pf.js
//  PF class initialization and consolidation of objects and methods


/* initialize the PF class */
var PF = PF || {};

/* initialize the PF class objects */
PF.filter = {};
PF.forms = {};
PF.helper = {};

/* codekit imports */

// @codekit-prepend '_shared.js'
// @codekit-append '_filter.js'
// @codekit-append '_form.js'
// @codekit-append '_helper.js'

// _filter.js
// functions for displaying, hiding, or generating lists of markers


PF.filter = {

    // shows all features
    showAll: function () {
        featureLayer.setFilter(function () {
            return true;
        });
    },

    // hides all features
    showNone: function () {
        featureLayer.setFilter(function () {
            return false;
        });
    },

    // filters by features that have a particular value on a particular property
    // i.e., City: Calgary
    by: function (property, propertyValue) {
        featureLayer.setFilter(function (f) {
            return f.properties[property] === propertyValue;
        });
    },

    // shows markers that have a value within a particular list of properties
    within: function (property, propertyList) {
        featureLayer.setFilter(function (f) {
            return (f.properties[property] in propertyList);
        });
    },

    // creates a list of features that have a particular property, returns an
    // array of features
    makeList: function (featureList, property) {
        var values = [];
        for (var i = 0; i < featureList.length; i++) {
            var value = featureList[i].properties[property],
                indexTest = indexOf.call(values, value);
            if (indexTest < 0) {
                values.push(value);
            }
        }
    },

    // returns a map circle centred on the reference marker containing the stated
    // number of markers
    findNearest: function (numberMarkers, referenceMarker) {
        var markerArray = [],
            searchArea = L.circle([referenceMarker.getLatLng().lat, referenceMarker.getLatLng().lng], markerArray[numberMarkers - 1]);
        featureLayer.eachLayer(function (m) {
            markerArray.push(referenceMarker.getLatLng().distanceTo(m.getLatLng()));
        });
        return searchArea;
    }

};


// _helper.js
// helper functions


PF.helper = {

    // internal function for sorting numbers
    compareNumber: function (x, y) {
        if (Number.isNan(x) || Number.isNan(y)) {
            return false;
        } else {
            return x - y;
        }
    }

};
// app.js
// initialize mapbox and run core functions

// initialize Mapbox
L.mapbox.accessToken = 'pk.eyJ1IjoidHJhdmlzdy1yY2IiLCJhIjoiV1I2X0ZlQSJ9.HuDZt_-iESg9dg_PQvTFqA';

// initialize map then featurelayer
var map = L.mapbox.map('map', 'travisw-rcb.j03n31d8'),
    featureLayer = new L.mapbox.featureLayer();

//adding info-popUp to the markers
featureLayer.on('layeradd', function (e) {
    var marker = e.layer;
    var feature = marker.feature;
    var displayProperties = '<dl><dt>' + feature.properties.Church + '</dt>';
    if (feature.properties.areaCode !== null) {
        displayProperties += '<dd><a href="tel:1' + feature.properties.areaCode + '' + feature.properties.phone +
            '"> (' + feature.properties.areaCode +
            ') ' + feature.properties.phone.replace(/\W/g, '').replace(/(...)/, '$1-') + '</a></dd>';
    }
    if (feature.properties.Email !== null) {
        displayProperties += '<dd><a href="mailto:' + feature.properties.Email +
            '">' + feature.properties.Email + '</a></dd>';
    }
    if (feature.properties.WebsiteUrl !== null) {
        displayProperties += '<dd><a href= http://' + feature.properties.WebsiteUrl +
            ' target="_blank">' + feature.properties.WebsiteUrl + '</a></dd>';
    }
    displayProperties += '</dl> ';
    marker.bindPopup(displayProperties, {
        closeButton: false,
        minWidth: 150,
        minHieght: 400
    }).on('click', function () {
        if ($('#searchResults').children().length == 0) {
            $('a.list').removeClass('show');
            $('a.detail').removeClass('show');
        }
        if ($('nav').hasClass('detail')){$('a.detail').removeClass('show')}
        detailViewByPins = true;
        $('section#detail, section#list, section#find').removeClass('shown');
        $('section#detail').addClass('shown');
        $('nav').removeClass().addClass('detail');
        
        if($('#parishDetails').children().length > 0 ){ 
        $('#parishDetails').empty();
        $('a.detail').removeClass('show');
        }

        $('a.search').addClass('show');
        $('a.map').addClass('show');



        $.get('index.php/postfinder/parishDetails', {
            parishID: "" + feature.properties.idParish + ""
        }, function (ParishData) {
            parishName = feature.properties.Parish;
            parishHTML = '<h2>' + feature.properties.Parish + '</h2>';

            var obj = JSON.parse(ParishData);
            detailViewByPins = true;
            detailPage = false;
            var numChurches = obj.parish[0].parishinfo.length;
            
            for (var j = 0; j < obj.parish[0].parishinfo.length; j++) {
                if (numChurches > 1) {
                    parishChurch = obj.parish[0].parishinfo[j].Church;
                    churchHTML = '<h3>' + parishChurch + '</h3>';
                } else {
                    parishChurch = '';
                    churchHTML = parishChurch;
                }
                churchid = obj.parish[0].parishinfo[j].idChurch;
                
                addressHtml = addressDetails(obj, churchid);
                phoneHtml = phoneDetails(obj, churchid);
                socialHtml = socialDetails(obj, churchid);
                webHtml = webDetails(obj, churchid);
                clergyHtml = clergyDetails( obj, churchid );
                eventHtml = eventsDetails(obj, churchid);
                

             parishHTML += churchHTML + addressHtml + phoneHtml + webHtml+ clergyHtml+eventHtml;   
            }

            $('#parishDetails').append(parishHTML);


        });
    });
});

featureLayer.addTo(map);
// populate initial view
featureLayer.loadURL('index.php/home/show_churches');

function addressDetails(obj, churchid){
    var parishdetails = obj.parishdetails;
    
    for (var i = 0; i < parishdetails.length; i++) {
        if (parishdetails.length > 6 ){
            addressHtml='';
            churchAddressDetails = parishdetails[0].addressDetails;
            churchAddressDetails2 = parishdetails[6].addressDetails;
            
            if (i<6){
                if (parishdetails[i].id == churchid) {
                    if (churchAddressDetails.length !== 0) {
                        for (var l = 0; l < churchAddressDetails.length; l++) {
                            addressHtml = "<dl name='Addresses'>";
                            addressHtml += "<dt>" + churchAddressDetails[l].AddressType + " Address:</dt>";
                            if (churchAddressDetails[l].Street1 !== null || churchAddressDetails[l].Street1.length > 0) {
                                addressHtml += "<dd>" + churchAddressDetails[l].Street1 + "<br/>";
                            }
                            addressHtml += "</dd><dd>" + churchAddressDetails[l].City + ", " + churchAddressDetails[l].Abbreviation + "&ensp;" + churchAddressDetails[l].PostalCode + "</dd>";
                
                            return addressHtml += "</dl>";
            
                        }
                    }
                    else{
                        return addressHtml = '';
                    }
                }
            }
            
            if (i>6) {
                if (parishdetails[i].id == churchid) {
                    if (churchAddressDetails2.length !== 0) {
                    for (var l = 0; l < churchAddressDetails2.length; l++) {
                var addressHtml = "<dl name='Addresses'>";
                addressHtml += "<dt>" + churchAddressDetails2[l].AddressType + " Address:</dt>";
                
                if (churchAddressDetails2[l].Street1 !== null || churchAddressDetails2[l].Street1.length > 0) {


                    addressHtml += "<dd>" + churchAddressDetails2[l].Street1 + "<br/>";


                }
                addressHtml += "</dd><dd>" + churchAddressDetails2[l].City + ", " + churchAddressDetails2[l].Abbreviation + "&ensp;" + churchAddressDetails2[l].PostalCode + "</dd>";
                 return addressHtml += "</dl>";
            }
           
            

        }
        else{
        return addressHtml = '';
                }      
            }


            }
        }else{

    if (parishdetails[i].id == churchid) {

        churchAddressDetails = parishdetails[0].addressDetails;

        if (churchAddressDetails.length !== 0) {
            for (var l = 0; l < churchAddressDetails.length; l++) {
                var addressHtml = "<dl name='Addresses'>";
                addressHtml += "<dt>" + churchAddressDetails[l].AddressType + " Address:</dt>";
                
                if (churchAddressDetails[l].Street1 !== null || churchAddressDetails[l].Street1.length > 0) {


                    addressHtml += "<dd>" + churchAddressDetails[l].Street1 + "<br/>";


                }
                addressHtml += "</dd><dd>" + churchAddressDetails[l].City + ", " + churchAddressDetails[l].Abbreviation + "&ensp;" + churchAddressDetails[l].PostalCode + "</dd>";
                return addressHtml += "</dl>";
            }
            

        }
        else{
        return addressHtml = '';
                }      
            }
        }
    }
}

function phoneDetails(obj, churchid){
    
    var parishdetails = obj.parishdetails;
    
    for (var i = 0; i < parishdetails.length; i++) {
        if (parishdetails.length > 6 ){
            
        churchPhoneDetails = parishdetails[1].phoneDetails;
        churchPhoneDetails2 = parishdetails[7].phoneDetails;
            
            if (churchPhoneDetails && i < 6){
            
             if (parishdetails[i].id == churchid) {
                var phoneHtml ='';
                        if (churchPhoneDetails.length != 0){
                        for (var g = 0; g < churchPhoneDetails.length; g++) {

                            if (churchPhoneDetails[g].PhoneType == 'Phone' || churchPhoneDetails[g].PhoneType == 'Office') {
                                phoneHtml += '<dl name="Telephone">';
                                phoneHtml += "<dt>" + churchPhoneDetails[g].PhoneType + "</dt>";
                                phoneHtml += "<dd><a href='tel:1" + churchPhoneDetails[g].AreaCode + '' + churchPhoneDetails[g].Phone +
                                    "'> (" + churchPhoneDetails[g].AreaCode +
                                    ') ' + churchPhoneDetails[g].Phone.replace(/\W/g, '').replace(/(...)/, '$1-') + "</a></dd>";

                            } else {

                                phoneHtml += "<dt>" + churchPhoneDetails[g].PhoneType + "</dt>";
                                phoneHtml += "<dd>(" + churchPhoneDetails[g].AreaCode +
                                    ') ' + churchPhoneDetails[g].Phone.replace(/\W/g, '').replace(/(...)/, '$1-') + "</a></dd>";
                            }
                            
                        }
                        
                         return phoneHtml += "</dl>";
                        
                    }else{
                return phoneHtml = '';
            }
             }
            
            }
            
            if (churchPhoneDetails2 && i > 6) {
                phoneHtml ='';
                if (parishdetails[i].id == churchid) {
                    if (churchPhoneDetails2.length != 0){

                    for (var g = 0; g < churchPhoneDetails2.length; g++) {


                        if (churchPhoneDetails2[g].PhoneType == 'Phone' || churchPhoneDetails2[g].PhoneType == 'Office') {
                            phoneHtml += '<dl name="Telephone">';
                            phoneHtml += "<dt>" + churchPhoneDetails2[g].PhoneType + "</dt>";
                            phoneHtml += "<dd><a href='tel:1" + churchPhoneDetails2[g].AreaCode + '' + churchPhoneDetails2[g].Phone +
                                "'> (" + churchPhoneDetails2[g].AreaCode +
                                ') ' + churchPhoneDetails2[g].Phone.replace(/\W/g, '').replace(/(...)/, '$1-') + "</a></dd>";

                        } else {

                            phoneHtml += "<dt>" + churchPhoneDetails2[g].PhoneType + "</dt>";
                            phoneHtml += "<dd>(" + churchPhoneDetails2[g].AreaCode +
                                ') ' + churchPhoneDetails2[g].Phone.replace(/\W/g, '').replace(/(...)/, '$1-') + "</a></dd>";
                        }

                    }

                    return phoneHtml += "</dl>";

                }else{
                return phoneHtml = '';
                    }
                }


            }
        }
        else{
            churchPhoneDetails = parishdetails[1].phoneDetails;
            phoneHtml='';
            
            if (parishdetails[i].id == churchid) {
                            if (churchPhoneDetails.length != 0){
                        for (var g = 0; g < churchPhoneDetails.length; g++) {

                               

                            if (churchPhoneDetails[g].PhoneType == 'Phone' || churchPhoneDetails[g].PhoneType == 'Office') {
                                phoneHtml += '<dl name="Telephone">';
                                phoneHtml += "<dt>" + churchPhoneDetails[g].PhoneType + "</dt>";
                                phoneHtml += "<dd><a href='tel:1" + churchPhoneDetails[g].AreaCode + '' + churchPhoneDetails[g].Phone +
                                    "'> (" + churchPhoneDetails[g].AreaCode +
                                    ') ' + churchPhoneDetails[g].Phone.replace(/\W/g, '').replace(/(...)/, '$1-') + "</a></dd>";

                            } else {

                                phoneHtml += "<dt>" + churchPhoneDetails[g].PhoneType + "</dt>";
                                phoneHtml += "<dd>(" + churchPhoneDetails[g].AreaCode +
                                    ') ' + churchPhoneDetails[g].Phone.replace(/\W/g, '').replace(/(...)/, '$1-') + "</a></dd>";
                            }
                            
                        }
                        
                         return phoneHtml += "</dl>";
                            
                        }else{
                        return phoneHtml = '';
                        }
                        
                    }
            
            
            }
               
        }
}



function socialDetails(obj, churchid){
    
var parishdetails = obj.parishdetails;
    for (var i = 0; i < parishdetails.length; i++) {

        if (parishdetails[i].id == churchid) {
            
        if (Object.keys(obj.parishdetails[i]) == 'socialDetails') {
            var churchSocialDetails = obj.parishdetails[i].socialDetails;

            if (churchSocialDetails.length !== 0) {
                var socialHtml = "<dl>Social : ";

                if (churchSocialDetails[0].SocialType.length > 0) {
                    socialHtml += "<dd>" + churchSocialDetails[0].SocialType + "</dd>";
                }

                if (churchSocialDetails[0].Handle.length > 0) {

                    socialHtml += "<dd>" + churchSocialDetails[0].Handle + "</dd>";
                }
                //SocialType Handle Url
                if (churchSocialDetails[0].Url.length > 0) {

                    socialHtml += "<dd>" + churchSocialDetails[0].Url + "</dd>";
                }
                socialHtml += "</dl>";

            } else {
                socialHtml = "";

            }

        }
        
        }
    }
}

function webDetails(obj, churchid){
    
    var parishdetails = obj.parishdetails;
    
    for (var i = 0; i < parishdetails.length; i++) {
        if (parishdetails.length > 6 ){
            EmailHtml='';
            websiteHtml='';
        churchwebDetails = parishdetails[3].websiteDetails;
        churchwebDetails2 = parishdetails[9].websiteDetails;
            
            if (churchwebDetails && i < 6 ){

                if (parishdetails[i].id == churchid) {
                    if (churchwebDetails.length !== 0) {

                                if (churchwebDetails[0].Email != null || churchwebDetails[0].Email != undefined) {

                                    var EmailHtml = "<dl name ='Email'>";
                                    EmailHtml += "<dt> Email</dt>";
                                    EmailHtml += "<dd><a href='mailto:" + churchwebDetails[0].Email +
                                        "'>" + churchwebDetails[0].Email + "</a></dd>";
                                    
                                } else {
                                    EmailHtml = "";
                                }
                                    if (churchwebDetails[0].Url != null ||
                                        churchwebDetails[0].Url != undefined ||
                                        churchwebDetails[0].WebType != null ||
                                        churchwebDetails[0].WebType != undefined) {

                                        var websiteHtml = "<dl name='Web'>";
                                        websiteHtml += "<dt>" + churchwebDetails[0].WebType + "</dt>";
                                        websiteHtml += "<dd><a href= http://" + churchwebDetails[0].Url +
                                            " target='_blank'>" + churchwebDetails[0].Url + "</a></dd>";
                                        
                                    } else {
                                        websiteHtml = "";
                                    }
                                EmailHtml += "</dl>";
                                websiteHtml += "</dl>";
                                return websiteHtml + EmailHtml;

                    } else {
                        websiteHtml = "";
                        EmailHtml = "";
                        return websiteHtml + EmailHtml;
                    }
                }

            }
        
            
            if (churchwebDetails2 && i > 6 ) {

                if (parishdetails[i].id == churchid) {

                        
                    if (churchwebDetails2.length !== 0) {
                        

                        if (churchwebDetails2[0].Email != null || churchwebDetails2[0].Email != undefined) {

                            var EmailHtml = "<dl name ='Email'>";
                            EmailHtml += "<dt> Email</dt>";
                            EmailHtml += "<dd><a href='mailto:" + churchwebDetails2[0].Email +
                                "'>" + churchwebDetails2[0].Email + "</a></dd>";
                           
                        } else {
                            EmailHtml = '';
                        }
                        if (churchwebDetails2[0].Url != null ||
                            churchwebDetails2[0].Url != undefined ||
                            churchwebDetails2[0].WebType != null ||
                            churchwebDetails2[0].WebType != undefined) {

                            var websiteHtml = "<dl name='Web'>";
                            websiteHtml += "<dt>" + churchwebDetails2[0].WebType + "</dt>";
                            websiteHtml += "<dd><a href= http://" + churchwebDetails2[0].Url +
                                " target='_blank'>" + churchwebDetails2[0].Url + "</a></dd>";
                            
                        } else {
                            websiteHtml = '';
                        }
                         EmailHtml += "</dl>";
                        websiteHtml += "</dl>";
                        return websiteHtml + EmailHtml;

                    } else {
                        websiteHtml = "";
                        EmailHtml = "";
                        return websiteHtml + EmailHtml;
                    }
                }



            }        
        }else {
            var churchwebDetails = obj.parishdetails[3].websiteDetails;

    if (parishdetails[i].id == churchid) {


                    if (churchwebDetails.length !== 0) {

                        if (churchwebDetails[0].Email != null || churchwebDetails[0].Email != undefined) {

                            var EmailHtml = "<dl name ='Email'>";
                            EmailHtml += "<dt> Email</dt>";
                            EmailHtml += "<dd><a href='mailto:" + churchwebDetails[0].Email +
                                "'>" + churchwebDetails[0].Email + "</a></dd>";
                        } else {
                            EmailHtml = "";
                        }
                        if (churchwebDetails[0].Url != null ||
                            churchwebDetails[0].Url != undefined ||
                            churchwebDetails[0].WebType != null ||
                            churchwebDetails[0].WebType != undefined) {

                            var websiteHtml = "<dl name='Web'>";
                            websiteHtml += "<dt>" + churchwebDetails[0].WebType + "</dt>";
                            websiteHtml += "<dd><a href= http://" + churchwebDetails[0].Url +
                                " target='_blank'>" + churchwebDetails[0].Url + "</a></dd>";
                        } else {
                            websiteHtml = "";
                        }
                        websiteHtml += "</dl>";
                        EmailHtml += "</dl>";
                        return websiteHtml + EmailHtml;

                    } else {
                        websiteHtml = "";
                        EmailHtml = "";
                        return websiteHtml + EmailHtml;
                    }
                }

}
        
        }
    }


function clergyDetails( obj, churchid ){
    
    
     var parishdetails = obj.parishdetails;
    
    for (var i = 0; i < parishdetails.length; i++) {
        if (parishdetails.length > 6 ){
           console.log(parishdetails);
        churchClergyDetails = parishdetails[5].clergyDetails;
        churchClergyDetails2 = parishdetails[11].clergyDetails;
            
            if (churchClergyDetails){
            
             if (parishdetails[i].id == churchid) {
                    
                        var clergyHtml = '<dl class="people">';
                        for (var g = 0; g < churchClergyDetails.length; g++) {
                                
                                clergyHtml += '<dt>' + churchClergyDetails[g].ClergyPosition  + '</dt>';
                                clergyHtml += '<dd>' + churchClergyDetails[g].FirstName + ' '+ churchClergyDetails[g].LastName + '</dd>';
                                
                            }
                            
                           return  clergyHtml += '</dl>';
                }
            }
            if (churchClergyDetails2) {

                if (parishdetails[i].id == churchid) {
                     
                         var clergyHtml = '<dl class="people">';
                        for (var g = 0; g < churchClergyDetails2.length; g++) {
                               
                                clergyHtml += '<dt>' + churchClergyDetails2[g].ClergyPosition  + '</dt>';
                                clergyHtml += '<dd>' + churchClergyDetails2[g].FirstName + ' '+ churchClergyDetails2[g].LastName + '</dd>';
                                
                            }
                            
                            return clergyHtml += '</dl>';
                            
                     
                }
            }
    }else{
            churchClergyDetails = parishdetails[5].clergyDetails;
            
            if (parishdetails[i].id == churchid) {
                 
                    
                        var clergyHtml = '<dl class="people">';
                        for (var g = 0; g < churchClergyDetails.length; g++) {
                                clergyHtml += '<dt>' + churchClergyDetails[g].ClergyPosition  + '</dt>';
                                clergyHtml += '<dd>' + churchClergyDetails[g].FirstName + ' '+ churchClergyDetails[g].LastName + '</dd>';
                                
                            }
                            console.log(clergyHtml);
                            return clergyHtml += '</dl>';                     
                    }
                    }
                 }
            }


function eventsDetails( obj, churchid ){
    var parishdetails = obj.parishdetails;
    churchEventsDetails = parishdetails[4].eventDetails ;
            eventHtml = '';
    
    for (var i = 0; i < parishdetails.length; i++) {
    
        if (parishdetails[i].id == churchid && churchEventsDetails.length > 0) {
                
                eventHtml += '<div class = "events"><table>'+
                             '<th>Type</th>'+
                             '<th>Day of the Week</th>'+
                             '<th>Start</th>'+
                             '<th>Language</th>'+
                             '<th>Description</th>';
                             
            for (var g = 0; g < churchEventsDetails.length; g++) {
                
                eventHtml += '<tr>';
                eventHtml +=  '<td>' + churchEventsDetails[g].EventName+ '</td>';
                
                console.log(+Object.keys(churchEventsDetails[g].Mon));
                if(churchEventsDetails[g].Mon == 1){
                    eventHtml +=  '<td>Mon</td>';
                
                }else if(churchEventsDetails[g].Tue == 1){
                    
                eventHtml +=  '<td>Tue</td>';
                
                }else if( churchEventsDetails[g].Wed == 1){
                    
                eventHtml +=  '<td>Wed</td>';
                
                }else if(churchEventsDetails[g].Thu == 1){
                    
                    eventHtml +=  '<td>Thu</td>';
                    
                }else if(churchEventsDetails[g].Fri == 1){
                    
                    eventHtml +=  '<td>Fri</td>';
                    
                }else if(churchEventsDetails[g].Sat == 1){
                    
                    eventHtml +=  '<td>Sat</td>';
                    
                }else if(churchEventsDetails[g].Sun == 1){
                    
                    eventHtml +=  '<td>Sun</td>';
                }

                
                eventHtml +=  '<td>' + churchEventsDetails[g].StartTime+ '</td>';
                
                eventHtml +=  '<td>' + churchEventsDetails[g].Language + '</td>';
                eventHtml +=  '<td>' + churchEventsDetails[g].Notes + '</td>';
                
                
                eventHtml += '</tr>';
                
            }
            return eventHtml += '</table> </div>';
        
        
        }
        console.log(eventHtml);
        return eventHtml = '<div class="events" >No Church Events at this time. Visit our Website for more Information </div>';
    
    
    
    }
    
    
} 

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
        } catch (err) {
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

//list.children()length()- get the number of children                      
if ($(window).width() < 600) {
    var detailViewByLisitng = false;


    $('nav').removeClass().addClass('map');


    $('input#findParish').on('click', function openListOnParishSearch() {
        $('section#detail, section#list, section#find').removeClass('shown');
        $('section#list').addClass('shown');
        listPage = true;
        detailPage = false;
        detailViewByPins = false;
        $('a.search').addClass('show');
        $('a.map').addClass('show');
        $('a.detail').removeClass('show');
        $('a.list').removeClass('show');
    });

    


    $('nav a').click(function () {


        if ($(this).hasClass('search')) {
            $('nav').removeClass().addClass('find');

            $('section#detail, section#list, section#find').removeClass('shown');

            $('section#find').addClass('shown');

            if (listPage == true) {

                $('a.search').removeClass('show');
                $('a.list').addClass('show');
            }
            if (detailViewByPins == true) {
                detailPage = false;
                detailViewByPins = false;
                $('a.detail').removeClass('show');
                $('a.search').addClass('show');
                $('a.list').removeClass('show');
            } else {
                $('a.detail').removeClass('show');
            }
            return;

        } else if ($(this).hasClass('list')) {

            $('nav').removeClass().addClass('list');
            $('section#detail, section#list, section#find').removeClass('shown');
            $('section#list').addClass('shown');
            $('a.detail').removeClass('show');
            $('a.list').removeClass('show');
            detailPage = false;
            detailViewByPins = false;

            return;

        } else if ($(this).hasClass('map')) {
            $('nav').removeClass().addClass('map');

            $('section#detail, section#list, section#find')
                .removeClass('shown');
            if (listPage == true) {
                
                $('a.list').addClass('show');
                $('a.search').addClass('show');
                $('a.map').removeClass('show');
            } else {
                $('a.list').removeClass('show');
            }

            if (detailPage == true) {
                
                $('a.detail').addClass('show');
                $('a.list').addClass('show');
                $('a.search').addClass('show');
            }


            if (detailViewByPins == true) {
                
                $('a.search').addClass('show');
                $('a.detail').addClass('show');
                $('a.map').removeClass('show');
                detailViewByPins = true;
            }

            return;
        } else if ($(this).hasClass('detail')) {
            
            $('nav')
                .removeClass()
                .addClass('detail');
            $('section#detail, section#list, section#find').removeClass('shown');
            $('section#detail').addClass('shown');
            if (detailPage == true) {
                

                $('a.list').addClass('show');
                $('a.search').addClass('show');
                $('a.map').addClass('show');
                $('a.detail').removeClass('show');
                detailPage = true;
                detailViewByPins = false;
            }

            if (detailViewByPins == true) {
               
                
                $('a.search').addClass('show');
                $('a.map').addClass('show');
                $('a.detail').removeClass('show');
                detailViewByPins = true;
                detailPage = false;
            }
                    
            return;
        }

    });

} else {
    
    $('a.search').removeClass('show');
    $('a.map').removeClass('show');
    $('a.detail').removeClass('show');
    $('a.list').removeClass('show');

    $('input#findParish').on('click', function openListOnParishSearch() {
        $('section#detail, section#list, section#find').removeClass('shown');
        $('section#list').addClass('shown');
        $('nav')
            .removeClass()
            .addClass('list');
    });

    $('dl.resultlist').click(function openDetailOnListClick() {
        $('section#detail, section#list, section#find')
            .removeClass('shown');
        $('section#detail').addClass('shown');
        $('nav')
            .removeClass()
            .addClass('detail');

    });


    $('nav a').click(function () {
        if ($(this).hasClass('search')) {
            $('nav')
                .removeClass()
                .addClass('find');
            $('section#detail, section#list, section#find')
                .removeClass('shown');
            $('section#find').addClass('shown');
            return;
        } else if ($(this).hasClass('list')) {

            $('nav')
                .removeClass()
                .addClass('list');
            $('section#detail, section#list, section#find')
                .removeClass('shown');
            $('section#list').addClass('shown');
            $('nav a').removeClass('show');
            
            return;


        }

        switch ($('nav ').attr('class')) {
        case 'map':
            $('section#detail, section#list, section#find')
                .removeClass('shown');

            if ($('div#detailView').children().length > 0) {
                $('nav')
                    .removeClass()
                    .addClass('detail');
                $('a.search').css('display', 'block');
                break;
            }

            if ($('div#result').children().length > 0) {
                $('nav')
                    .removeClass()
                    .addClass('list');
                $('a.search').css('display', 'block');
                break;
            }

            $('nav')
                .removeClass('map')
                .addClass('find');
            break;

        case 'find':
            $('section#detail, section#list, section#find')
                .removeClass('shown');
            $('section#find').addClass('shown');
            $('nav')
                .removeClass()
                .addClass('find');
            $('nav a.search').css('display', 'none');
            break;

        case 'list':
            $('section#detail, section#list, section#find')
                .removeClass('shown');
            $('section#list').addClass('shown');
            $('nav')
                .removeClass()
                .addClass('list');
            break;

        case 'detail':
            $('section#detail, section#list, section#find')
                .removeClass('shown');
            $('section#detail').addClass('shown');
            $('nav')
                .removeClass()
                .addClass('detail');
            break;


        default:
            break;
        }
    });
}
/************************************************************************/
var city = function (data) {
    $.each(data, function (i, item) {
        $('#cityDropdown').append($("<option >", {
            value: item.City,
            text: item.City
        }));
    });
}

function postAjaxData(url, cb) {
    $.ajax({
        type: 'POST',
        url: url,
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: cb
    });

}



function churchDetails($clickedDl) {
    var parishID = $clickedDl.data('mapDetails').pid;

    $.get('index.php/postfinder/parishDetails', {
        parishID: "" + parishID + ""
    }, function (ParishData) {
        $('div#parishDetails').empty();
        var parishObj = JSON.parse(ParishData);
        
        parishName = parishObj.parish[0].parishinfo[0].Parish;
        parishHTML = '<h2>' + parishName + '</h2>';

        
        console.log(parishObj);
        var Church = $clickedDl.data('mapDetails').church;
//        var html = "<h3>" + Church + "</h3>";

        
//        for (var i = 0; i < obj.church_details.length; i++) {
//            switch (i) {
//            case 0:
//
//                var churchAddressDetails = obj.church_details[0].addressDetails;
//
//                for (var j = 0; j < churchAddressDetails.length; j++) {
//                    var addressHtml = "<dl name='Addresses'>";
//                    addressHtml += "<dt>" + churchAddressDetails[j].AddressType + " Address:</dt>";
//
//                    if (churchAddressDetails[j].Street1 !== null ||
//                        churchAddressDetails[j].Street1.length > 0) {
//
//                        addressHtml += "<dd>" + churchAddressDetails[j].Street1 + "<br/>";
//
//                    }
//
//                    addressHtml += "</dd><dd>" + churchAddressDetails[j].City + ", " + churchAddressDetails[j].Abbreviation +
//                        "&ensp;" + churchAddressDetails[j].PostalCode + "</dd>";
//                }
//                addressHtml += "</dl>";
//                break;
//
//            case 1:
//
//                var churchPhoneDetails = obj.church_details[1].phoneDetails;
//
//                if (churchPhoneDetails.length !== 0 &&
//                    churchPhoneDetails.AreaCode !== null) {
//
//                    var phoneHtml = "<dl name='Telephone'>";
//
//                    for (var j = 0; j < churchPhoneDetails.length; j++) {
//                        if (churchPhoneDetails[j].PhoneType === 'Phone' ||
//                            churchPhoneDetails[j].PhoneType === 'Office') {
//
//                            phoneHtml += "<dt>" + churchPhoneDetails[j].PhoneType + "</dt>";
//                            phoneHtml += "<dd><a href='tel:1" + churchPhoneDetails[j].AreaCode + '' + churchPhoneDetails[j].Phone +
//                                "'> (" + churchPhoneDetails[j].AreaCode +
//                                ') ' + churchPhoneDetails[j].Phone.replace(/\W/g, '').replace(/(...)/, '$1-') + "</a></dd>";
//                        } else {
//
//                            phoneHtml += "<dt>" + churchPhoneDetails[j].PhoneType + "</dt>";
//                            phoneHtml += "<dd>(" + churchPhoneDetails[j].AreaCode +
//                                ') ' + churchPhoneDetails[j].Phone.replace(/\W/g, '').replace(/(...)/, '$1-') + "</a></dd>";
//
//                        }
//                    }
//                    phoneHtml += "</dl>";
//                    break;
//                } else {
//                    phoneHtml = "";
//                    break;
//                }
//
//            case 2:
//
//                var churchSocialDetails = obj.church_details[2].socialDetails;
//
//                if (churchSocialDetails.length !== 0) {
//                    var socialHtml = "<dl>Social : ";
//
//                    if (churchSocialDetails[0].SocialType.length > 0) {
//                        socialHtml += "<dd>" + churchSocialDetails[0].SocialType + "</dd>";
//                    }
//
//                    if (churchSocialDetails[0].Handle.length > 0) {
//
//                        socialHtml += "<dd>" + churchSocialDetails[0].Handle + "</dd>";
//                    }
//                    //SocialType Handle Url
//                    if (churchSocialDetails[0].Url.length > 0) {
//
//                        socialHtml += "<dd>" + churchSocialDetails[0].Url + "</dd>";
//                    }
//                    socialHtml += "</dl>";
//                    break;
//                } else {
//                    socialHtml = "";
//                    break;
//                }
//            case 3:
//
//                var churchwebsiteDetails = obj.church_details[3].websiteDetails;
//
//                if (churchwebsiteDetails.length !== 0) {
//
//                    if (churchwebsiteDetails[0].Email != null || churchwebsiteDetails[0].Email != undefined) {
//
//                        var EmailHtml = "<dl name ='Email'>";
//                        EmailHtml += "<dt> Email</dt>";
//                        EmailHtml += "<dd><a href='mailto:" + churchwebsiteDetails[0].Email +
//                            "'>" + churchwebsiteDetails[0].Email + "</a></dd>";
//                    } else {
//                        EmailHtml = "";
//                    }
//                    if (churchwebsiteDetails[0].Url != null || churchwebsiteDetails[0].Url != undefined ||
//                        churchwebsiteDetails[0].WebType != null || churchwebsiteDetails[0].WebType != undefined) {
//
//                        var websiteHtml = "<dl name='Web'>";
//                        websiteHtml += "<dt>" + churchwebsiteDetails[0].WebType + "</dt>";
//                        websiteHtml += "<dd><a href= http://" + churchwebsiteDetails[0].Url +
//                            " target='_blank'>" + churchwebsiteDetails[0].Url + "</a></dd>";
//                    } else {
//                        websiteHtml = "";
//                    }
//                    websiteHtml += "</dl>";
//                    EmailHtml += "</dl>";
//                    break;
//                } else {
//                    websiteHtml = "";
//                    EmailHtml = "";
//                    break;
//                }
//
//            }
//        }
        var numChurches = parishObj.parish[0].parishinfo.length;
        for (var j = 0; j < parishObj.parish[0].parishinfo.length; j++) {
                if (numChurches > 1) {
                    parishChurch = parishObj.parish[0].parishinfo[j].Church;
                    churchHTML = '<h3>' + parishChurch + '</h3>';
                } else {
                    parishChurch = '';
                    churchHTML = parishChurch;
                }
                churchid = parishObj.parish[0].parishinfo[j].idChurch;
                addressHtml = addressDetails(parishObj, churchid);
                phoneHtml = phoneDetails(parishObj, churchid);
                socialHtml = socialDetails(parishObj, churchid);
                webHtml = webDetails(parishObj, churchid);
                clergyHtml = clergyDetails( parishObj, churchid );
                eventHtml = eventsDetails(parishObj, churchid);
                
//                var $details = details(obj, parishChurch, churchid);
             parishHTML += churchHTML + addressHtml + phoneHtml+webHtml + clergyHtml+eventHtml;   
            }
        $('div#parishDetails').append(parishHTML);
    });

}

function findpostal(url, postalcodetext) {
    $.post(url, {
        postalString: "" + postalcodetext + ""
    }, function (data) {

        var obj = JSON.parse(data);

        if (data.length > 0 || data !== "" || data !== "No results found") {
            L.mapbox.featureLayer({
                type: 'Feature',
                geometry: {
                    type: 'Point',
                    coordinates: [
                        obj.postalcode_finder[0].Longitude,
                        obj.postalcode_finder[0].Latitude
                    ]
                },
                properties: {
                    title: obj.postalcode_finder[0].PostalCode,
                    description: 'Postal Code You entered',
                    'marker-color': '#6DE8E1'
                }
            }).addTo(map);
            map.setView([
                    obj.postalcode_finder[0].Latitude,
                    obj.postalcode_finder[0].Longitude
            ]);
        } else {
            $('.postalCodeError').append('Please retype your postal code, eg: A1A 1B1 or A1A1B1')
                .css("color", "#DB4542");
        }
    });

}

function listing(json) {
    $.each(json, function (key, pack) {
        if (pack.PhoneType !== 'Fax') {
            $('#searchResults')
                .append("<dl class='resultlist'><dd>" + pack.Church +
                    "</dd><dd>" + pack.Street1 +
                    "</dd><dd>" + pack.City +
                    "</dd</dl>");

            $('.resultlist:last-child')
                .data("mapDetails", {
                    church: pack.Church,
                    cid: pack.idChurch,
                    pid:pack.idParish,
                    long: pack.Longitude,
                    lat: pack.Latitude,
                });
        }
    });

    $('#searchResults > dl').click(function () {
        detailPage = true;
        detailViewByPins = false;
        $('a.list').addClass('show');
        $('a.search').addClass('show');
        $('a.map').addClass('show');

        var $clickedDl = $(this);
        $clickedDl.addClass('selected');

        $('section#detail, section#list, section#find').removeClass('shown');
        $('section#detail').addClass('shown');


        $('#parishDetails').empty();

        churchDetails($clickedDl);

        $('.selected')
            .data("color", {
                mapcolor: '#FFDB21'
            });

        L.mapbox.featureLayer({
            type: 'Feature',
            geometry: {
                type: 'Point',
                coordinates: [
                    $clickedDl.data('mapDetails').long,
                    $clickedDl.data('mapDetails').lat
                ]
            },
            properties: {
                title: $clickedDl.data('mapDetails').church,
                'marker-color': $('.selected').data("color").mapcolor,
            }
        }).addTo(map);
        map.setView([$clickedDl.data('mapDetails').lat,
                             $clickedDl.data('mapDetails').long]);

    });

}

function findparish(url, churchname, city) {

    $.post(url, {
        churchString: "" + churchname + "",
        cityString: "" + city + ""
    }, function (parishdata) {
        
        if (parishdata === "No results found.") {
            $('div#searchResults').append("No results found.");
        } else {
            var data = JSON.parse(parishdata);
            var json = data.parish_finder;
            listing(json);
        }
    });
}

$(function () {

    postAjaxData('index.php/home/getCity', city);

    $('#postalCodeText').focus(function () {
        $('.postalCodeError').empty()
    });

    $('#postalCodeSubmit').click(function () {
        $('#searchResults').empty();
        $('#parishDetails').empty();
        $('.postalCodeError').empty();
        var postalcodetext = $('#postalCodeText').val();

        if (postalcodetext.length > 3 && postalcodetext.length <= 7) {

            findpostal("index.php/pcfinder/map", postalcodetext);
            $('section#detail, section#list, section#find')
                .removeClass('shown');
            $('nav')
                .removeClass()
                .addClass('find');
        } else {
            $('.postalCodeError').append('<p>Please retype your postal code, eg: A1A 1B1 or A1A1B1</p>')
                .css("color", "#D35652");
        }
    });

    $('#findParish').click(function (event) {
        $('#searchResults').empty();
        $('#parishDetails').empty();

        var churchname = $('#churchNameField').val();
        var city = $('#cityDropdown').val();
        churchname = churchname.trim();
        findparish("index.php/postfinder/postFinder", churchname, city);

    });

});