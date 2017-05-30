$(window).load(function(){
    //TOKENS FOR SUBMIT
    $.ajaxSetup({
        headers: {
           'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    })

    var visitorTable = "/ajaxgetvisitors";
    var submitVisitor = "/ajaxvisitorsubmit";

    //SUBMIT GUEST REGISTRATION
    $("#submitVisitor").click(function() {
        var visitor_name = $('#visitor_name').val();

        var reason_for_visit = $('#reason_for_visit').val();
        
        var date_expected = $('#date_expected').val();

        var time_expected = $('time_expected').val();

        var postData = {
            "visitor_name": visitor_name,
            "reason_for_visit": reason_for_visit,
            "date_expected": date_expected,
            "time_expected": time_expected
        };

       $.ajax({
            type: "POST",
            url: submitVisitor,
            data: postData,
            success: function(result){
                $('#visitorSuccess').toggle();
                
                $('#visitor_name').attr('value', '');
                $('#reason_for_visit').attr('value', '');  
                $('#date_expected').attr('value', '');  
                $('#time_expected').attr('value', '');  

                window.setTimeout(function() {
                    $('#visitorSuccess').toggle();
                }, 4000);
            }
       });
    });

    //GET TABLE DETAILS EVERY 5 SECS
    window.setInterval(function(){
       $.ajax({
            type: "GET",
            url: visitorTable,
            success: function(result){
                $('#visitorTable').html(result);
            }
       });
    }, 5000);

});