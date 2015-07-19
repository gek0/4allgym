/**
 * main JS file for all Ajax calls
 */

jQuery(document).ready(function(){
    /**
     * change user settings
     */
    $("#user-settings").submit(function(event){
        event.preventDefault();

        //disable button click
        $('button#profileSubmit').addClass('disabled');

        //get input fields values
        var values = {};
        $.each($(this).serializeArray(), function(i, field) {
            values[field.name] = field.value;
        });
        var token = $(this).find('input[name="_token"]').val();
        var outputMsg = $('#outputMsg');
        var errorMsg = "";
        var successMsg = "<h3>Korisničke postavke su uspješno izmjenjene.</h3>";

        function restoreNotification(){
            outputMsg.fadeOut(1000, function(){
                //enable button click and reset form
                $('button#profileSubmit').removeClass('disabled');
                //$("#user-settings").trigger('reset');

                outputMsg.find('h3').remove();
                $('#notificationTimer').empty();

                setTimeout(function () {
                    outputMsg.attr('class', 'notificationOutput');
                }, 1000);
            });
        }

        $.ajax({
            type: 'post',
            url: $(this).attr('action'),
            dataType: 'json',
            headers: { 'X-CSRF-Token' : token },
            data: { _token: token, formData: values },
            success: function(data){

                //check status of validation and query
                if(data.status === 'success'){
                    //change page data before user refresh
                    $('#nav-user-content').html(values['username']);
                    $(this).find('input[name="username"]').val(values['username']);
                    $(this).find('input[name="email"]').val(values['email']);

                    outputMsg.append(successMsg).addClass('successNotif').slideDown();

                    //timer
                    var numSeconds = 3;
                    var timer = 3;
                    function countDown(){
                        numSeconds--;
                        if(numSeconds == 0){
                            clearInterval(timer);
                        }
                        $('#notificationTimer').html(numSeconds);
                    }
                    timer = setInterval(countDown, 1000);

                    //hide notification if user clicked
                    $('#notifTool').click(function(){
                        restoreNotification();

                    });

                    setTimeout(function(){
                        restoreNotification();
                    }, numSeconds * 1000);
                }
                else{
                    $.each(data.errors, function(index, value) {
                        $.each(value, function(i){
                            errorMsg += "<h3>" + value[i] + "</h3>";
                        });
                    });
                    outputMsg.append(errorMsg).addClass('warningNotif').slideDown();

                    //timer
                    var numSeconds = 5;
                    var timer = 5;
                    function countDown(){
                        numSeconds--;
                        if(numSeconds == 0){
                            clearInterval(timer);
                        }
                        $('#notificationTimer').html(numSeconds);
                    }
                    timer = setInterval(countDown, 1000);

                    //hide notification if user clicked
                    $('#notifTool').click(function(){
                        restoreNotification();
                    });

                    setTimeout(function(){
                        restoreNotification();
                    }, numSeconds * 1000);
                }
            }
        });

        return false;
    });


    /**
     * add new user
     */
    $("#new-user").submit(function(event){
        event.preventDefault();

        //disable button click
        $('button#newProfileSubmit').addClass('disabled');

        //get input fields values
        var values = {};
        $.each($(this).serializeArray(), function(i, field) {
            values[field.name] = field.value;
        });
        var token = $(this).find('input[name="_token"]').val();
        var outputMsg = $('#outputMsg');
        var errorMsg = "";
        var successMsg = "<h3>Korisnički račun je uspješno dodan.</h3>";

        function restoreNotification(){
            outputMsg.fadeOut(1000, function(){
                //enable button click and reset form
                $('button#newProfileSubmit').removeClass('disabled');
                $("#new-user").trigger('reset');

                outputMsg.find('h3').remove();
                $('#notificationTimer').empty();

                setTimeout(function () {
                    outputMsg.attr('class', 'notificationOutput');
                }, 1000);
            });
        }

        $.ajax({
            type: 'post',
            url: $(this).attr('action'),
            dataType: 'json',
            headers: { 'X-CSRF-Token' : token },
            data: { _token: token, formData: values },
            success: function(data){

                //check status of validation and query
                if(data.status === 'success'){
                    //change page data before user refresh
                    $('#nav-user-content').html(values['username']);
                    $(this).find('input[name="username"]').val(values['username']);
                    $(this).find('input[name="email"]').val(values['email']);

                    outputMsg.append(successMsg).addClass('successNotif').slideDown();

                    //timer
                    var numSeconds = 3;
                    var timer = 3;
                    function countDown(){
                        numSeconds--;
                        if(numSeconds == 0){
                            clearInterval(timer);
                        }
                        $('#notificationTimer').html(numSeconds);
                    }
                    timer = setInterval(countDown, 1000);

                    //hide notification if user clicked
                    $('#notifTool').click(function(){
                        restoreNotification();

                    });

                    setTimeout(function(){
                        restoreNotification();
                    }, numSeconds * 1000);
                }
                else{
                    $.each(data.errors, function(index, value) {
                        $.each(value, function(i){
                            errorMsg += "<h3>" + value[i] + "</h3>";
                        });
                    });
                    outputMsg.append(errorMsg).addClass('warningNotif').slideDown();

                    //timer
                    var numSeconds = 5;
                    var timer = 5;
                    function countDown(){
                        numSeconds--;
                        if(numSeconds == 0){
                            clearInterval(timer);
                        }
                        $('#notificationTimer').html(numSeconds);
                    }
                    timer = setInterval(countDown, 1000);

                    //hide notification if user clicked
                    $('#notifTool').click(function(){
                        restoreNotification();
                    });

                    setTimeout(function(){
                        restoreNotification();
                    }, numSeconds * 1000);
                }
            }
        });

        return false;
    });

});