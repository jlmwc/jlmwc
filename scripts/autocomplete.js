//    function lookup(inputString) {
//        if(inputString.length == 0) {
//            $('#suggestions').hide();
//
//        } else {
//            $.post("home/autocomplete", {queryString: ""+inputString+""}, function(data){
//                if(data.length > 0) {
//                    $('#suggestions').show();
//                    $('#autoSuggestionsList').html(data);
//                }
//                fillme();
//            });
//        }
//    }
//
//    function fillme() {
//            $(".completeMe li:first-child").on("click", function(){
//                var inputVar = $(this).text();
//                var myString = $.trim(inputVar.substr(inputVar.indexOf(":") + 1));
//               $('#name_of_church').val(myString);
//               $('#suggestions').hide();
//        });
//    }

    function city(){

            $.ajax({
                type:"POST",
                url:"index.php/home/getCity",
                contentType : "application/json; charset=utf-8",
                dataType:"json",
                success: function(data){

                $.each(data, function (i, item) {
                    $('#Citydropdown').append($("<option >", {
                        value: item.City,
                        text : item.City
                    }));
                    });

                },

            });



    }


$(function() {

    city();
//    $("#name_of_church" ).keyup(function() {
//    var inputString = $('#name_of_church').val();
//     lookup(inputString);


//    });


});
