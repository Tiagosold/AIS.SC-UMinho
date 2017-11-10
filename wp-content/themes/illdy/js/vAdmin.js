/**
 * Created by tiago on 31/03/2017.
 */

// IIFE - Immediately Invoked Function Expression
(function(yourcode) {

    // The global jQuery object is passed as a parameter
    yourcode(window.jQuery, window, document);

}(function($, window, document) {

        // The $ is now locally scoped
        $(function() {

            // The DOM is ready!

        });

        // The rest of your code goes here!

    }
));


$(document).ready(function(){
        $("#add-type-button").on('click', function (){
        $('#type-event-modal input[name="type-event-index"]').val('');
        hideValidation($('#desigmsg'));
        $('#type-event-modal select[name="type-event-desig"]').css('display', 'inline');
        $('#edit-type-event').css('display', 'inline-block');
        $('#create-type-event').css('display', 'inline-block');
        $('#save-type-event').css('display', 'none');
        $('#type-event-color').css('display', 'none');
        $('#delete-type-event').css('display', 'none');
        $('#type-event-modal input[name=type-event-desig-in]').css('display', 'none');
        $('#event-modal').modal('hide');
       $('#type-event-modal').modal();
    });

    $('#show-event-modal').on('click', function(){
        $('#type-event-modal').modal('hide');
        $('#event-modal').modal('show');
    });
});


function updateLayout(){
    $.ajax({
        type: "POST",
        url: "/wp-content/themes/illdy/bd/",
        dataType: 'json',
        data: {
            object: 'admin',
            function: 'getSiteInfo'
        },
        statusCode: {
            200: function (response) {
                $("#users-count").text(response[0].users);
                $("#event-count").text(response[0].events);
                $("#partners-count").text(response[0].partners);
            }, 500: function (response) {
                alert(response.msg);
            }
        }
    });
}




