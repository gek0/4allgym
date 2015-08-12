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

    /**
     * delete existing user
     */
    $('.btn-delete-sure').click(function(){
        var userID = parseInt($(this).parent().parent().attr('id'));    //get ID of category to delete
        var token = $('meta[name="_token"]').attr('content');
        var dataURL = $('#user-list-table').attr('data-link-delete');
        var outputMsg = $('#outputMsg');
        var errorMsg = "";
        var successMsg = "<h3>Korisnik je uspješno obrisan.</h3>";

        function restoreNotification(){
            outputMsg.fadeOut(1000, function(){
                outputMsg.find('h3').remove();
                $('#notificationTimer').empty();

                setTimeout(function () {
                    outputMsg.attr('class', 'notificationOutput');
                }, 1000);
            });
        }

        /*
         *   delete product confirm
         */
        bootbox.confirm("Stvarno želiš obrisati ovog korisnika?", function(result) {
            if(result == true){
                $.ajax({
                    type: 'post',
                    url: dataURL,
                    dataType: 'json',
                    headers: { 'X-CSRF-Token' : token },
                    data: { userData: userID },
                    success: function(data){

                        //check status of validation and query
                        if(data.status === 'success'){
                            //hide table row when deleted from DB
                            $('#user-list-table').find('tr#' + userID).fadeOut(1000);

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
                            errorMsg = "<h3>" + data.errors + "</h3>";
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
            }
        });

        return false;
    });

    /**
     * delete image from gallery
     */
    $('.btn-delete-gallery-image').click(function(){
        var imageID = $(this).attr('id'); //image ID to delete
        var token = $('meta[name="_token"]').attr('content');
        var outputMsg = $('#outputMsg');
        var errorMsg = "";
        var successMsg = "<h3>Slika je uspješno obrisana.</h3>";

        //gallery counter
        var imageGallery = $('#image_gallery');
        var imageCount = parseInt($('#image_gallery_counter').html()) - 1;
        var dataURL = imageGallery.attr('data-role-link');

        function restoreNotification(){
            outputMsg.fadeOut(1000, function(){
                outputMsg.find('h3').remove();
                $('#notificationTimer').empty();

                setTimeout(function () {
                    outputMsg.attr('class', 'notificationOutput');
                }, 1000);
            });
        }

        $.ajax({
            type: 'post',
            url: dataURL,
            dataType: 'json',
            headers: { 'X-CSRF-Token' : token },
            data: { imageData: imageID },
            success: function(data){

                //check status of validation and query
                if(data.status === 'success'){
                    outputMsg.append(successMsg).addClass('successNotif').slideDown();
                    $('#img-container-'+imageID).fadeOut();   //hide parent div

                    //update gallery counter and hide gallery if counter equals 0
                    $('#image_gallery_counter').html(imageCount);
                    if(imageCount < 1){
                        imageGallery.fadeOut();
                    }

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
                    errorMsg = "<h3>" + data.errors + "</h3>";
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
     * set primary image from gallery
     */
    $('.btn-primary-gallery-image').click(function(){
        var imageID = $(this).attr('id'); //image ID to delete
        var imageGallery = $('#image_gallery');
        var dataURL = imageGallery.attr('data-role-primary');
        var token = $('meta[name="_token"]').attr('content');
        var outputMsg = $('#outputMsg');
        var errorMsg = "";
        var successMsg = "<h3>Slike je postavljena kao primarna.</h3>";

        function restoreNotification(){
            outputMsg.fadeOut(1000, function(){
                outputMsg.find('h3').remove();
                $('#notificationTimer').empty();

                setTimeout(function () {
                    outputMsg.attr('class', 'notificationOutput');
                }, 1000);
            });
        }

        var button = $(this);
        var buttonChild = $(this).children().first();


        $.ajax({
            type: 'post',
            url: dataURL,
            dataType: 'json',
            headers: { 'X-CSRF-Token' : token },
            data: { imageData: imageID },
            success: function(data){

                //check status of validation and query
                if(data.status === 'success'){
                    outputMsg.append(successMsg).addClass('successNotif').slideDown();

                    //change <i> button classes
                    $(".fa-check-circle").each(function() {
                        $(this).attr('class', 'fa fa-circle-o');
                    });
                    buttonChild.attr('class', 'fa fa-check-circle');

                    //change button classes to enable next request
                    $(".btn.btn-submit-edit").each(function() {
                        $(this).addClass('btn-primary-gallery-image');
                    });
                    button.attr('class', 'btn btn-submit-edit');

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
                    errorMsg = "<h3>" + data.errors + "</h3>";
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
     * delete file from gallery
     */
    $('.btn-delete-gallery-file').click(function(){
        var fileID = $(this).attr('id'); //image ID to delete
        var token = $('meta[name="_token"]').attr('content');
        var outputMsg = $('#outputMsg');
        var errorMsg = "";
        var successMsg = "<h3>Datoteka je uspješno obrisana.</h3>";

        //gallery counter
        var gallery = $('#gallery_data');
        var dataURL = gallery.attr('data-role-link');

        function restoreNotification(){
            outputMsg.fadeOut(1000, function(){
                outputMsg.find('h3').remove();
                $('#notificationTimer').empty();

                setTimeout(function () {
                    outputMsg.attr('class', 'notificationOutput');
                }, 1000);
            });
        }

        $.ajax({
            type: 'post',
            url: dataURL,
            dataType: 'json',
            headers: { 'X-CSRF-Token' : token },
            data: { fileData: fileID },
            success: function(data){

                //check status of validation and query
                if(data.status === 'success'){
                    outputMsg.append(successMsg).addClass('successNotif').slideDown();
                    $('#container-'+fileID).fadeOut();   //hide parent div

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
                    errorMsg = "<h3>" + data.errors + "</h3>";
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
     * add new product category
     */
    $("#new-category").submit(function(event){
        event.preventDefault();

        //disable button click
        $('button#categorySubmit').addClass('disabled');

        //get input fields values
        var formInputData = $(this).find('input[name="category_name"]').val();
        var token = $(this).find('input[name="_token"]').val();
        var outputMsg = $('#outputMsg');
        var errorMsg = "";
        var successMsg = "<h3>Kategorija je uspješno dodana.</h3>";

        function restoreNotification(){
            outputMsg.fadeOut(1000, function(){
                //enable button click and reset form
                $('button#categorySubmit').removeClass('disabled');
                $("#new-category").trigger('reset');

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
            data: { _token: token, formData: formInputData },
            success: function(data){

                //check status of validation and query
                if(data.status === 'success'){
                    //refresh category table
                    $("#category-content-table").find('tbody').append('<tr id="' + data.insert_id +'" role="category-content-row">' +
                                                                        '<td>' + formInputData + '</td>' +
                                                                        '<td><button class="btn btn-submit-edit btn-edit-sure"><i class="fa fa-pencil"></i></button></td>' +
                                                                        '<td><button class="btn btn-submit-delete btn-delete-sure"><i class="fa fa-trash"></i></button></td>' +
                                                                        '</tr>');

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
     *   edit product category name
     */
    $(".btn-edit-sure").click(function(){
        var categoryID = parseInt($(this).parent().parent().attr('id'));    //get ID of category to delete
        var categoryName = $('#category-content-table tr#' + categoryID + ' td:first-child').text().trim();
        var outputMsg = $('#outputMsg');
        var errorMsg = "";

        function restoreNotification(){
            outputMsg.fadeOut(1000, function(){
                outputMsg.find('h3').remove();
                $('#notificationTimer').empty();

                setTimeout(function () {
                    outputMsg.attr('class', 'notificationOutput');
                }, 1000);
            });
        }

        bootbox.prompt({
            title: "Ime kategorije:",
            value: categoryName,
            callback: function(result) {
                if(result == ''){
                    errorMsg = "<h3>Ime kategorije je obavezno.</h3>";
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
                else if(result !== null) {
                    var token = $('meta[name="_token"]').attr('content');
                    var categoryName = result;
                    var successMsg = "<h3>Ime kategorije je uspješno izmjenjeno.</h3>";
                    var dataURL = $('#category-content-table').attr('data-link-edit');

                    $.ajax({
                        type: 'post',
                        url: dataURL,
                        dataType: 'json',
                        headers: { 'X-CSRF-Token' : token },
                        data: { categoryID: categoryID, categoryName: categoryName },
                        success: function(data){

                            //check status of validation and query
                            if(data.status === 'success'){
                                outputMsg.append(successMsg).addClass('successNotif').slideDown();

                                //set new category name to DOM
                                $('#category-content-table tr#' + categoryID + ' td:first-child').text(categoryName);

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
                                errorMsg = "<h3>" + data.errors + "</h3>";
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
                }
            }
        });

        return false;
    });

    /**
     * delete product category
     */
    $('.btn-category-delete-sure').click(function(){
        var categoryID = parseInt($(this).parent().parent().attr('id'));    //get ID of category to delete
        var token = $('meta[name="_token"]').attr('content');
        var dataURL = $('#category-content-table').attr('data-link-delete');
        var outputMsg = $('#outputMsg');
        var errorMsg = "";
        var successMsg = "<h3>Kategorija je uspješno obrisana.</h3>";

        function restoreNotification(){
            outputMsg.fadeOut(1000, function(){
                outputMsg.find('h3').remove();
                $('#notificationTimer').empty();

                setTimeout(function () {
                    outputMsg.attr('class', 'notificationOutput');
                }, 1000);
            });
        }

        /*
         *   delete product confirm
         */
        bootbox.confirm("Stvarno želiš obrisati ovu kategoriju?", function(result) {
            if(result == true){
                $.ajax({
                    type: 'post',
                    url: dataURL,
                    dataType: 'json',
                    headers: { 'X-CSRF-Token' : token },
                    data: { categoryData: categoryID },
                    success: function(data){

                        //check status of validation and query
                        if(data.status === 'success'){
                            //hide table row when deleted from DB
                            $('#category-content-table').find('tr#' + categoryID).fadeOut(1000);

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
                            errorMsg = "<h3>" + data.errors + "</h3>";
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
            }
        });

        return false;
    });

});