$(window).load(function(){
    //TOKENS FOR SUBMIT
    $.ajaxSetup({
        headers: {
           'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    })

    var visitorTableUrl = "/ajaxsecuritynotification";
    var reportTableUrl = "/ajaxsecurityreports";
    var guestTableUrl = "/ajaxsecurityguests";
    var submitNotificationUrl = "/ajaxsecuritysubmit";

    var guestLeftUrl = "/ajaxguestleft";
    var visitorverifyUrl = "/ajaxvisitorverify"

    //SUBMIT GUEST REGISTRATION
    $("#submitForm").click(function() {
        var name_first = $('#name_first').val();
        var name_middle = $('#name_middle').val();
        var name_last = $('#name_last').val();

        var reason = $('#reason').val();
        
        var vehicle_plate = $('#vehicle_plate').val();

        var person_to_visit = $('#person_to_visit').val();

        var postData = {
            "name_first": name_first,
            "name_middle": name_middle,
            "name_last": name_last,
            "reason": reason,
            "vehicle_plate": vehicle_plate,
            "person_to_visit": person_to_visit
        };

       $.ajax({
            type: "POST",
            url: submitNotificationUrl,
            data: postData,
            success: function(result){
                $('#successnotification').toggle();
                
                $('#name_first').val('');
                $('#name_middle').val('');  
                $('#name_last').val('');  

                $('#reason').val('');  
                $('#vehicle_plate').val(''); 

                window.setTimeout(function() {
                    $('#successnotification').toggle();
                }, 8000);
            }
       });
    });

    $("#guestTable").on('click', '.btn-lft', function() {
        var received_id = $(this).val();

        var postData = {
            "user_id": received_id
        }

        $.ajax({
            type: "POST",
            data: postData,
            url: guestLeftUrl,
            success: function(result){
                $.ajax({
                    type: "GET",
                    url: guestTableUrl,
                    success: function(result){
                        $('#guestTable').html(result);
                    }
                });
            }
        });
    });

    $(".btn-ver").click(function() {
        var received_id = $(this).val();

        var postData = {
            "id": received_id
        }

        $.ajax({
            type: "POST",
            data: postData,
            url: visitorverifyUrl,
            success: function(result){
                $.ajax({
                    type: "GET",
                    url: visitorTableUrl,
                    success: function(result){
                        $('#visitorTable').html(result);
                    }
                });
            }
        });
    });

    

    //GET TABLE DETAILS EVERY 5 SECS
    window.setInterval(function(){
       $.ajax({
            type: "GET",
            url: visitorTableUrl,
            success: function(result){
                $('#visitorTable').html(result);
            }
       });
       $.ajax({
            type: "GET",
            url: reportTableUrl,
            success: function(result){
                $('#reportTable').html(result);
            }
       });
       $.ajax({
            type: "GET",
            url: guestTableUrl,
            success: function(result){
                $('#guestTable').html(result);
            }
       });
    }, 5000);

});