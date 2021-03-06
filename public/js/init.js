/**
 * main JS file for initialization
 */


/**
 *   social networks
 */
$("#social_aside").hide();

jQuery(document).ready(function(){
    /**
     *  navigation
     */
    !function(n,e){var t=function(n){return n.trim?n.trim():n.replace(/^\s+|\s+$/g,"")},i=function(n,e){return-1!==(" "+n.className+" ").indexOf(" "+e+" ")},a=function(n,e){i(n,e)||(n.className=""===n.className?e:n.className+" "+e)},r=function(n,e){n.className=t((" "+n.className+" ").replace(" "+e+" "," "))},o=function(n,e){if(n)do{if(n.id===e)return!0;if(9===n.nodeType)break}while(n=n.parentNode);return!1},s=e.documentElement,d=(n.Modernizr.prefixed("transform"),n.Modernizr.prefixed("transition")),c=function(){var n={WebkitTransition:"webkitTransitionEnd",MozTransition:"transitionend",OTransition:"oTransitionEnd otransitionend",msTransition:"MSTransitionEnd",transition:"transitionend"};return n.hasOwnProperty(d)?n[d]:!1}();n.App=function(){var t=!1,l={},u=e.getElementById("inner-wrap"),v=!1,f="js-nav";return l.init=function(){if(!t){t=!0;var p=function(n){n&&n.target===u&&e.removeEventListener(c,p,!1),v=!1};l.closeNav=function(){if(v){var t=c&&d?parseFloat(n.getComputedStyle(u,"")[d+"Duration"]):0;t>0?e.addEventListener(c,p,!1):p(null)}r(s,f)},l.openNav=function(){v||(a(s,f),v=!0)},l.toggleNav=function(n){v&&i(s,f)?l.closeNav():l.openNav(),n&&n.preventDefault()},e.getElementById("nav-open-btn").addEventListener("click",l.toggleNav,!1),e.getElementById("nav-close-btn").addEventListener("click",l.toggleNav,!1),e.addEventListener("click",function(n){v&&!o(n.target,"nav")&&(n.preventDefault(),l.closeNav())},!0),a(s,"js-ready")}},l}(),n.addEventListener&&n.addEventListener("DOMContentLoaded",n.App.init,!1)}(window,window.document);


    /**
     *   google maps
     */
    if($("#map").length > 0) {
        var map;
        // main directions
        map = new GMaps({
            el: '#map', lat: 45.815344, lng: 15.931346, zoom: 15, linksControl: true, zoomControl: true,
            panControl: true, scrollwheel: false, streetViewControl: true
        });

        // add address markers
        var image = 'css/assets/images/map-marker.png';
        map.addMarker({lat: 45.815344, lng: 15.931346, title: '4allGym', icon: image});
        //apply custom styles
        var styles = [{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#000000"},{"lightness":40}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#000000"},{"lightness":16}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":17},{"weight":1.2}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":21}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":16}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":19}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#fbb518"},{"lightness":17}]}];
        map.setOptions({styles: styles});
    }

    /**
     *   social networks
     */
    $(function() {
        $(window).scroll(function() {
            if ($(this).scrollTop() > 300) {
                $("#social_aside").fadeIn();
            } else {
                $("#social_aside").fadeOut();
            }
        });
    });

    /**
     *   scroll to top
     */
    var offset = 300,
        offset_opacity = 1200,
        scroll_top_duration = 700,
        $back_to_top = $('.cd-top');

        //hide or show the "back to top" link
        $(window).scroll(function(){
            ( $(this).scrollTop() > offset ) ? $back_to_top.addClass('cd-is-visible') : $back_to_top.removeClass('cd-is-visible cd-fade-out');
            if( $(this).scrollTop() > offset_opacity ) {
                $back_to_top.addClass('cd-fade-out');
            }
        });

        //smooth scroll to top
        $back_to_top.on('click', function(event){
            event.preventDefault();
            $('body,html').animate({
                    scrollTop: 0 ,
                }, scroll_top_duration
            );
        });

    /**
     *   add lazy loading to images out of screen viewport
     */
    $(function() {
        $("img.lazy").lazyload({
            effect : "fadeIn"
        });
    });

    /**
     *   live tags filtering
     */
    if($("#filter").length > 0) {
        //prevent submit action if user tried
        $("#live-search").submit(function(event){
            event.preventDefault();
        })

        //start search/filter function
        $("#filter").keyup(function () {
            $("#filter-count").text("Tražim...");

            var filter = $(this).val(), count = 0;

            $(".tags li").each(function () {
                if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                    $(this).fadeOut();
                }
                else {
                    $(this).show();
                    count++;
                }
            });

            setTimeout(function () {
                if(count > 0) {
                    $("#filter-count").text('Klknite na traženi tag za prikaz svih vijesti s istim.');
                }
                else{
                    $("#filter-count").text('Nije pronađen niti jedan tag.');
                }
            }, 1500);
        });
    }

    /**
     *   submit form if option changed in dropdown menu
     */
    if($('#sort_option').length > 0) {
        $(this).change(function () {
            $('#formSort').submit();
        });
    }

    /**
     *  Ajax cart items delete
     */
    $('.btn-cart-item-delete').click(function(event){
        event.preventDefault();

        var itemID = $(this).attr('id'); //cart item ID to delete
        var token = $('#cart-form input[name="_token"]').val();
        var outputMsg = $('#outputMsg');
        var errorMsg = "";
        var successMsg = "<h3>Košarica je osvježena.</h3>";

        var cartView = $('#cart-content-view');
        var cartItemContainer = $('#cartform-item-container-' + itemID);
        var cartCounter = parseInt($('#cart-counter').html()) - 1;
        var dataURL = $('#cart-form-container').attr('data-role-link');

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
            data: { cartData: itemID, _token : token },
            success: function(data){

                //check status of validation and query
                if(data.status === 'success'){
                    outputMsg.append(successMsg).addClass('successNotif').slideDown();

                    //hide cart item when deleted
                    cartItemContainer.fadeOut();

                    //update cart counter and hide cart if counter equals 0
                    $('#cart-counter').html(cartCounter);
                    if(cartCounter < 1){
                        cartView.fadeOut();
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
     *  send mail response to seller with user cart data
     */
    $("#cart-form").submit(function(event){
        event.preventDefault();

        var token = $('#cart-form input[name="_token"]').val();
        var outputMsg = $('#outputMsg');
        var errorMsg = "";
        var successMsg = "<h3>Vaš upit je uspješno poslan.</h3>";

        //get input fields values
        var userValues = {};
        $.each($(this).serializeArray(), function (i, field) {
            userValues[field.name] = field.value;
        });

        var cartValues = {};
        var cartDataInputs = $('#cart-data :input');
        cartDataInputs.each(function() {
            cartValues[this.name] = $(this).val();
        });

        var dataURL = $(this).attr('action');

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
            data: { cartUserData: userValues, cartItemData: cartValues, _token : token },
            success: function(data){

                //check status of validation and query
                if(data.status === 'success'){
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
                        location.reload();
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

/**
 *   catch laravel form/route notifications
 */
function catchLaravelNotification(errorHtmlSourceID, notificationType) {
    var outputMsg = $('#outputMsg');
    var errorMsg = $('#'+errorHtmlSourceID).html();
    outputMsg.append(errorMsg).addClass(notificationType).slideDown();

    //timer
    var numSeconds = 5;
    function countDown(){
        numSeconds--;
        if(numSeconds == 0){
            clearInterval(timer);
        }
        $('#notificationTimer').html(numSeconds);
    }
    var timer = setInterval(countDown, 1000);

    function restoreNotification(){
        outputMsg.fadeOut(1000, function(){
            setTimeout(function () {
                outputMsg.empty().attr('class', 'notificationOutput');
            }, 2000);
        });
    }

    //hide notification if user clicked
    $('#notifTool').click(function(){
        restoreNotification();
    });

    setTimeout(function () {
        restoreNotification();
    }, numSeconds * 1000);
}

/**
 *  image lightbox gallery
 */
(function($){
    $(document).ready(function(){
        //activity indicator
        var activityIndicatorOn = function(){
                $( '<div id="imagelightbox-loading"><div></div></div>' ).appendTo('body');
            },
            activityIndicatorOff = function(){
                $('#imagelightbox-loading').remove();
            },
        //overlay
            overlayOn = function(){
                $( '<div id="imagelightbox-overlay"></div>' ).appendTo('body');
            },
            overlayOff = function(){
                $('#imagelightbox-overlay').remove();
            },
        //close button
            closeButtonOn = function(instance){
                $( '<button type="button" id="imagelightbox-close" title="Zatvori"></button>' ).appendTo('body').on('click touchend', function(){ $(this).remove(); instance.quitImageLightbox(); return false; });
            },
            closeButtonOff = function(){
                $('#imagelightbox-close').remove();
            },
        //arrows
            arrowsOn = function(instance, selector){
                var $arrows = $('<button type="button" class="imagelightbox-arrow imagelightbox-arrow-left" title="Prethodna"></button><button type="button" class="imagelightbox-arrow imagelightbox-arrow-right" title="Sljede�a"></button>');
                $arrows.appendTo('body');

                $arrows.on('click touchend', function(e){
                    e.preventDefault();

                    var $this = $(this),
                        $target = $(selector + '[href="' + $('#imagelightbox').attr('src') + '"]'),
                        index = $target.index(selector);

                    if ($this.hasClass('imagelightbox-arrow-left')) {
                        index = index - 1;
                        if (!$(selector).eq(index).length)
                            index = $(selector).length;
                    } else {
                        index = index + 1;
                        if (!$(selector).eq(index).length)
                            index = 0;
                    }

                    instance.switchImageLightbox(index);
                    return false;
                });
            },
            arrowsOff = function(){
                $('.imagelightbox-arrow').remove();
            };

        //run gallery
        var selector = 'a[data-imagelightbox="gallery-images"]';
        var instance = $(selector).imageLightbox({
            onStart:        function() { overlayOn(); closeButtonOn(instance); arrowsOn(instance, selector); },
            onEnd:          function() { overlayOff(); closeButtonOff(); arrowsOff(); activityIndicatorOff(); },
            onLoadStart:    function() { activityIndicatorOn(); },
            onLoadEnd:      function() { activityIndicatorOff(); $('.imagelightbox-arrow').css('display', 'block'); }
        });

    });
})(this.jQuery);