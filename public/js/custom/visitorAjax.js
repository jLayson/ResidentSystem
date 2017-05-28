$(document).ready(function(){
    $.ajaxSetup({
        headers: {
           'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    })


    var php_url = "/ajaxgetvisitors";

    $('#dateStart').datepicker({
        autoclose: true
    });
    $('#dateEnd').datepicker({
        autoclose: true
    });

    $("#searchButton").click(function() {
        var startDate = $('#dateStart').val();
        var endDate = $('#dateEnd').val();

        var searchParam = $('#searchParam').val();
        
        var postData = {
            "dateStart": startDate,
            "dateEnd": endDate,
            "searchParam": searchParam
        };

       $.ajax({
            type: "POST",
            url: php_url,
            data: postData,
            success: function(result){
                alert(result);
                $('#visitorTable').html(result);
            }
       });
    });
});