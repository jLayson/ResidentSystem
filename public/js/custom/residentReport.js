$(window).load(function(){
    //TOKENS FOR SUBMIT
    $.ajaxSetup({
        headers: {
           'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    })

    var submitReport = "/ajaxreportsubmit";

    //SUBMIT GUEST REGISTRATION
    $("#submitReport").click(function() {
        var report_nature = $('#report_nature').val();

        var description = $('#description').val();
        
        var location = $('#location').val();

        var postData = {
            "report_nature": report_nature,
            "description": description,
            "location": location
        };

       $.ajax({
            type: "POST",
            url: submitReport,
            data: postData,
            success: function(result){
                $('#reportSuccess').toggle();
                
                $('#report_nature').attr('value', '');
                $('#description').attr('value', '');  
                $('#location').attr('value', '');  

                window.setTimeout(function() {
                    $('#reportSuccess').toggle();
                }, 4000);


            }
       });
    });

    //GET TABLE DETAILS EVERY 5 SECS
    window.setInterval(function(){
       $.ajax({
            type: "GET",
            url: reportTable,
            success: function(result){
                $('#residentReportTable').html(result);
            }
       });
    }, 5000);
});
