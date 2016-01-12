<<<<<<< HEAD
/************************************************************************/
var city = function(data)
{
    if(data != undefined){
        $.each(data, function (i, item) {
                $('#cityDropdown').append($("<option >", {
                    value: item.City,
                    text : item.City
                        }));
                });
    }
}

var postAjaxData = function(url, callback) {
    $.ajax({
        type: 'POST',
        url: url,
        contentType : "application/json; charset=utf-8",
        dataType:"json",
        success: callback
    });
    
}
postAjaxData('index.php/home/getCity', city);

function churchDetails() {
    
            var $clickedDl = $(".resultlist.selected");
            var churchID = $clickedDl.data('mapDetails').id;
    
           $.get('index.php/postfinder/parishDetails', {churchID: ""+churchID+""}, function(DetailsData){
                    console.log(DetailsData);
                     var obj = JSON.parse(DetailsData);
                var Church = $clickedDl.data('mapDetails').church;
                var html = "<dl><dd>"+Church+"</dd>";
               
               for (var i=0; i < obj.parish_details.length; i++ ){
                   switch (i){
                    case 0:
                    //TODO obj.parish_details[0].addressDetails[0]
                     var parishAddressDetails = obj.parish_details[0].addressDetails[0];
                           
                       if (parishAddressDetails.length !== 0){
                        var addressHtml = "<dl> Address: ";
                           if (parishAddressDetails.Street1.length > 0){ 
                               
                               addressHtml +="<dd>"+parishAddressDetails.Street1+"</dd>";}
                           
                           if (parishAddressDetails.City.length > 0){
                               
                                addressHtml +="<dd>"+parishAddressDetails.City+"</dd>";}
                           
                           if (parishAddressDetails.AddressType.length > 0){
                               
                                addressHtml +="<dd>"+parishAddressDetails.AddressType+"</dd>";}
                           if (parishAddressDetails.PostalCode.length > 0){
                               
                                addressHtml +="<dd>"+parishAddressDetails.PostalCode+"</dd>";}
                           if (parishAddressDetails.po.length > 0){
                               
                                addressHtml +="<dd>"+parishAddressDetails.po+"</dd>";}
                           if (parishAddressDetails.rr.length > 0){
                    
                                addressHtml +="<dd>"+parishAddressDetails.rr+"</dd>";}
                           if (parishAddressDetails.stn.length > 0){
                               
                                addressHtml +="<dd>"+parishAddressDetails.stn+"</dd>";}
                            addressHtml+= "</dl>";
                       } 
                       

                    case 1:
                           console.log(obj.parish_details[1].phoneDetails[0]);
                    //TODO obj.parish_details[1].phoneDetails[0]
                        var parishPhoneDetails = obj.parish_details[1].phoneDetails[0];
                           
                        if (parishPhoneDetails !== undefined){
                            var phoneHtml = "<dl> Phone: ";
                            
                            if (parishPhoneDetails.PhoneType.length > 0){ 
                               console.log("in case zero");
                               phoneHtml +="<dd>"+parishPhoneDetails.Street1+"</dd>";}
                           
                           if (parishPhoneDetails.Phone.length > 0){
                               console.log("in city");
                                phoneHtml +="<dd>"+parishPhoneDetails.AreaCode+" "+parishPhoneDetails.Phone+"</dd>";}
                            phoneHtml+= "</dl>";
                        }
                           else{
                           phoneHtml = "";
                           }

                    case 2:
                        //TODO obj.parish_details[2].socialDetails[0]
                            var parishSocialDetails = obj.parish_details[2].socialDetails[0];
                           
                        if (parishSocialDetails !== undefined){
                            var socialHtml = "<dl> Social: ";
                            
                            if (parishSocialDetails.SocialType.length > 0){ 
                               socialHtml +="<dd>"+parishSocialDetails.SocialType+"</dd>";}
                           
                           if (parishSocialDetails.Handle.length > 0){ 
                               
                               socialHtml +="<dd>"+parishSocialDetails.Handle+"</dd>";}
                            //SocialType Handle Url
                            if (parishSocialDetails.Url.length > 0){ 
                               
                               socialHtml +="<dd>"+parishSocialDetails.Url+"</dd>";}
                        }else{
                            socialHtml = "";
                        }    
                    case 3:
                        //TODO obj.parish_details[3].websiteDetails[0]
                        var parishwebsiteDetails = obj.parish_details[3].websiteDetails[0];
                           
                        if (parishwebsiteDetails !== undefined){
                            var websiteHtml = "<dl> website: ";
                            
                        if (parishwebsiteDetails.WebType.length > 0){ 
                            websiteHtml +="<dd>"+parishwebsiteDetails.WebType+"</dd>";}
                        if (parishwebsiteDetails.Url.length > 0){ 
                            websiteHtml +="<dd>"+parishwebsiteDetails.Url+"</dd>";}
                        
                    }else{
                    websiteHtml = "";
                    }
               }
               }
              $('div#parishDetails').append(addressHtml + "<br>"+phoneHtml+"<br>"+socialHtml+"<br>"+websiteHtml+"<br>");
            });

}


function findpostal(url, postalcodetext) {
    $.post(url, { postalString: "" + postalcodetext + "" }, function(data) {
        if (data !== "not valid"){
        var obj = JSON.parse(data);
            console.log(obj);
=======
function singleClick() {
<<<<<<< HEAD
    $('#result > dl').click(function() {
=======
<<<<<<< HEAD
        $('#result > dl').click(function() {
=======
    $('#result > dl').click(function() {
>>>>>>> master
>>>>>>> origin/jl
        var $clickedDl = $(this);
        var long = $clickedDl.data('mapDetails').long;
        var lat  = $clickedDl.data('mapDetails').lat;

        $clickedDl.addClass('selected');
<<<<<<< HEAD

=======
<<<<<<< HEAD
>>>>>>> origin/jl
        $('section#detail, section#list, section#find')
            .css('left', '100%');
        $('section#detail').css('left', '0');
        $('nav')
            .removeClass()
            .addClass('map');

<<<<<<< HEAD
=======
        $('.selected').data("color", {mapcolor : '#FFDB21'});
=======

        $('section#detail, section#list, section#find')
            .css('left', '100%');
        $('section#detail').css('left', '0');
        $('nav')
            .removeClass()
            .addClass('map');

>>>>>>> origin/jl
        $('.selected')
            .data("color", {
                mapcolor : '#FFDB21'
            });
<<<<<<< HEAD
=======
>>>>>>> master
>>>>>>> origin/jl

        L.mapbox.featureLayer({
            type: 'Feature',
            geometry: {
                type: 'Point',
                coordinates: [
                    long,
                    lat
                ]
            },
            properties: {
                title: $clickedDl.data('mapDetails').church,
                'marker-color': $('.selected').data("color").mapcolor,
            }
        }).addTo(map);
        map.setView([lat, long], 13);
<<<<<<< HEAD
    });
}

function doubleClick() {
=======
<<<<<<< HEAD

                $('.MoreInfo').click(function(){
                  $('section#detail, section#list, section#find')
                  .removeClass('shown');
                  $('section#detail').addClass('shown');
                  $('nav').removeClass().addClass('map');

                  var $clickedDl = $(".resultlist.selected");
                  var Church = $clickedDl.data('mapDetails').church;
                  var Address = $clickedDl.data('mapDetails').Address;
                  var Street2 = $clickedDl.data('mapDetails').Street2;
                  var Street1 = $clickedDl.data('mapDetails').Street1;
                  var rr = $clickedDl.data('mapDetails').rr;
                  var stn = $clickedDl.data('mapDetails').stn;
                  var City = $clickedDl.data('mapDetails').City;
                  var ProvinceName = $clickedDl.data('mapDetails').ProvinceName;
                  var PostalCode = $clickedDl.data('mapDetails').PostalCode;
                  var id = $clickedDl.data('mapDetails').id;
                  var long = $clickedDl.data('mapDetails').long;
                  var lat  = $clickedDl.data('mapDetails').lat;
                  var html = "<dl><dt>Parish</dt><dd>"+Church+
                  "</dd><dt>"+Address+
                  "</dt><dd>"+Street2+
                  "</dd><dd>"+Street1+
                  "</dd><dd>"+rr+" "+stn+
                  "</dd><dd>"+City+", "+ProvinceName+",&ensp;"+PostalCode+
                  "</dd><dt></dl>";

                  $('div#detailView').append(html);

                });
        }

}

function doubleClick() {

            $('section#detail, section#list, section#find')
            .removeClass('shown');
            $('section#detail').addClass('shown');
            $('nav').removeClass().addClass('map');

            var $clickedDl = $(".resultlist.selected");
            var Church = $clickedDl.data('mapDetails').church;
            var Address = $clickedDl.data('mapDetails').Address;
            var Street2 = $clickedDl.data('mapDetails').Street2;
            var Street1 = $clickedDl.data('mapDetails').Street1;
            var rr = $clickedDl.data('mapDetails').rr;
            var stn = $clickedDl.data('mapDetails').stn;
            var City = $clickedDl.data('mapDetails').City;
            var ProvinceName = $clickedDl.data('mapDetails').ProvinceName;
            var PostalCode = $clickedDl.data('mapDetails').PostalCode;
            var id = $clickedDl.data('mapDetails').id;
            var long = $clickedDl.data('mapDetails').long;
            var lat  = $clickedDl.data('mapDetails').lat;
            var html = "<dl><dt>Parish</dt><dd>"+Church+
            "</dd><dt>"+Address+
            "</dt><dd>"+Street2+
            "</dd><dd>"+Street1+
            "</dd><dd>"+rr+" "+stn+
            "</dd><dd>"+City+", "+ProvinceName+",&ensp;"+PostalCode+
            "</dd><dt></dl>";
            $('div#detailView').append(html);

=======
    });
}

function doubleClick() {
>>>>>>> origin/jl
    $('#result > dl').dblclick(function (){
        var $clickedDl = $(this);
        var Church = $clickedDl.data('mapDetails').church;
        var id = $clickedDl.data('mapDetails').id;
        var long = $clickedDl.data('mapDetails').long;
        var lat  = $clickedDl.data('mapDetails').lat;
        var html = "<dl class='detailView'><dd>"+Church+"</dd><dd>"+id+"</dd> <dt>"+long+"</dt><dd>"+lat+"</dd></dl>";
        $('#detailView').append(html);
    });
<<<<<<< HEAD
=======
>>>>>>> master
>>>>>>> origin/jl
}

function findpostal(url, postalcodetext) {
    $.post(url, { postalString: "" + postalcodetext + "" }, function(data) {
        var obj = JSON.parse(data);
>>>>>>> master
        if (data.length > 0) {
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
<<<<<<< HEAD
                    description: 'Postal Code You entered',
                    'marker-color': '#6DE8E1'
=======
                    description: 'This is you',
                    'marker-color': '#FFDB21'
>>>>>>> master
                }
            }).addTo(map);
            map.setView([
                obj.postalcode_finder[0].Latitude,
                obj.postalcode_finder[0].Longitude
            ]);
<<<<<<< HEAD
            }
        }else{
        $('.postalCodeError').append('Please retype your postal code, eg: A1A 1B1 or A1A1B1')
                             .css("color", "#DB4542");
        }
    });
<<<<<<< HEAD
    
=======
        }
=======
}
<<<<<<< HEAD
jQuery.fn.single_double_click = function(single_click_callback, double_click_callback, timeout) {
  return this.each(function(){
    var clicks = 0, self = this;
    jQuery(this).click(function(event){
      clicks++;
      if (clicks === 1) {
        setTimeout(function(){
          if(clicks === 1) {
            single_click_callback.call(self, event);
          } else {
            double_click_callback.call(self, event);
          }
          clicks = 0;
        }, timeout || 300);
      }
>>>>>>> origin/jl
    });
>>>>>>> master
}

function listing (json) {
    $.each(json, function(key, pack) {
<<<<<<< HEAD
        $('#searchResults')
            .append("<dl class='resultlist'><dd>"+pack.Church+"</dd><dd>"+pack.Street1+"</dd><dd>"+pack.City+"</dd</dl>");
        $('.resultlist:last-child')
            .data( "mapDetails", {
                church: pack.Church, id: pack.idChurch, long: pack.Longitude, lat: pack.Latitude,
            }
        );
    });
    
    $('#searchResults > dl').click(function(){
        var $clickedDl = $(this);
        $clickedDl.addClass('selected');
        churchDetails();
        $('section#detail, section#list, section#find')
            .removeClass('shown');
            $('section#detail').addClass('shown');
            $('nav').removeClass().addClass('map');
        $('.selected')
            .data("color", {
                mapcolor : '#FFDB21'
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
                description: $clickedDl.data('mapDetails').church,
                'marker-color': $('.selected').data("color").mapcolor,
            }
        }).addTo(map);
        map.setView([$clickedDl.data('mapDetails').lat, $clickedDl.data('mapDetails').long], 13);
    });
            
            

}
function findparish(url, churchname, city) {
   
    $.post(url, {churchString: ""+churchname+"", cityString: ""+city+"" }, function (parishdata){
        
        if (parishdata === "No results found.") {
            $('div#searchResults').append("No results found.");
=======
        $('#result')
            .append("<dl class='resultlist'><dd>"+pack.Church+"</dd><dd>"+pack.Street2+"</dd><dd>"+pack.Street1+"</dd><dd>"+pack.CityName+"</dd</dl>");
        $('.resultlist:last-child')
<<<<<<< HEAD
=======
                .data( "mapDetails", { church: pack.Church, Address : pack.Address, Street2 : pack.Street2,
                                        Street1 : pack.Street1, rr : pack.rr, stn : pack.stn, City : pack.City,
                                        ProvinceName : pack.ProvinceName, PostalCode : pack.PostalCode,
                                        id: pack.ChurchID, long: pack.Longitude, lat: pack.Latitude
                                      });
               console.log("executed");
=======

function listing (json) {
    $.each(json, function(key, pack) {
        $('#result')
            .append("<dl class='resultlist'><dd>"+pack.Church+"</dd><dd>"+pack.Street2+"</dd><dd>"+pack.Street1+"</dd><dd>"+pack.CityName+"</dd</dl>");
        $('.resultlist:last-child')
>>>>>>> origin/jl
            .data( "mapDetails", {
                church: pack.Church, id: pack.ChurchID, long: pack.Longitude, lat: pack.Latitude
            }
        );
<<<<<<< HEAD
=======
>>>>>>> master
>>>>>>> origin/jl
    });
}

function findparish(url, churchname, city) {
    $.post(url, {churchString: ""+churchname+"", cityString: ""+city+"" }, function (parishdata){
        if (parishdata === "No results found.") {
<<<<<<< HEAD
=======
<<<<<<< HEAD
            $('div#result').append("No results found.");
=======
>>>>>>> origin/jl
            $('#resultList').append("No results found.");
>>>>>>> master
        } else {
            var data = JSON.parse(parishdata);
            var json = data.parish_finder;
            listing (json);
<<<<<<< HEAD
<<<<<<< HEAD
=======
            singleClick();
=======

        $('#result > dl').single_double_click(function () {
            singleClick();
            }, function () {
                doubleClick();

              });

=======
            singleClick();
>>>>>>> origin/jl
            doubleClick();
>>>>>>> master
        }
    });
}

$(function() {
<<<<<<< HEAD
<<<<<<< HEAD
    
=======
  $("#name_of_church").focus(function(){
      $('div#result').empty();
>>>>>>> origin/jl

    $(postalCodeText).focus(function(){$('.postalCodeError').empty()});

<<<<<<< HEAD

    $('#postalCodeSubmit').click(function (){
        $('#searchResults').empty();
        $('#parishDetails').empty();
        var postalcodetext = $('#postalCodeText').val();
        if ( postalcodetext.length > 3 && postalcodetext.length <= 7 ){
            findpostal("index.php/pcfinder/map", postalcodetext);
            $('section#detail, section#list, section#find')
                .removeClass('shown');
=======
=======
=======
>>>>>>> master
>>>>>>> origin/jl
    $('#findpostal').click(function (){
        var postalcodetext = $('#postalCodeText').val();
        var $errorDiv = $('<div>error message</div>');
        if (postalcodetext.length > 0) {
            findpostal("index.php/pcfinder/map", postalcodetext);
<<<<<<< HEAD
=======
<<<<<<< HEAD
            $('section#detail, section#list, section#find')
                .removeClass('shown');
=======
>>>>>>> origin/jl
            $('section#detail, section#list, section#find').css('left', '100%');
>>>>>>> master
            $('nav')
                .removeClass()
                .addClass('find');
        } else {
<<<<<<< HEAD
            $('.postalCodeError').append('<p>Please retype your postal code, eg: A1A 1B1 or A1A1B1</p>')
                                 .css("color", "#DB4542");
        }
    });

    $('#findParish').click(function (){
        $('#searchResults').empty();
        $('#parishDetails').empty();
        var churchname = $('#churchNameField').val();
        churchname = churchname.trim();
        
        var city = $('#cityDropdown').val();
        var $errorDiv = $('<div>error message</div>');
        
        if ( churchname.length == 0 && city.length == 0 ) {
            console.log('error');
        }else {
           findparish("index.php/postfinder/postFinder", churchname, city);
           $('section#detail, section#list, section#find')
               .removeClass('shown');
           $('section#list').addClass('shown');
        }
    });
    
=======
            $errorDiv.addClass('error');
            $('.error').append($errorDiv.html());
        }
    });

    $('#findparish').click(function (){
        var churchname = $('#name_of_church').val();
<<<<<<< HEAD
=======
<<<<<<< HEAD
        console.log('churchname');
=======
>>>>>>> master
>>>>>>> origin/jl
        var city = $('#Citydropdown').val();
        var $errorDiv = $('<div>error message</div>');
        if (churchname.length === 0 && city.length === 0 ) {
            $errorDiv.addClass('error');
        } else {
<<<<<<< HEAD
            findparish("index.php/postfinder/postFinder", churchname, city);
=======
<<<<<<< HEAD
           findparish("index.php/postfinder/postFinder", churchname, city);
           $('section#detail, section#list, section#find')
               .removeClass('shown');
           $('section#list').addClass('shown');
>>>>>>> origin/jl
        }
    });

    $("#name_of_church").focus(function(){
        $('#resultList').empty();
    });

<<<<<<< HEAD
>>>>>>> master
=======
=======
            findparish("index.php/postfinder/postFinder", churchname, city);
        }
    });

    $("#name_of_church").focus(function(){
        $('#resultList').empty();
    });
>>>>>>> master

>>>>>>> origin/jl
});
