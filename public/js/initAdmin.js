/**
 * main JS file for initialization in admin area
 */


jQuery(document).ready(function(){
    /**
     *  navigation
     */
    !function(n,e){var t=function(n){return n.trim?n.trim():n.replace(/^\s+|\s+$/g,"")},i=function(n,e){return-1!==(" "+n.className+" ").indexOf(" "+e+" ")},a=function(n,e){i(n,e)||(n.className=""===n.className?e:n.className+" "+e)},r=function(n,e){n.className=t((" "+n.className+" ").replace(" "+e+" "," "))},o=function(n,e){if(n)do{if(n.id===e)return!0;if(9===n.nodeType)break}while(n=n.parentNode);return!1},s=e.documentElement,d=(n.Modernizr.prefixed("transform"),n.Modernizr.prefixed("transition")),c=function(){var n={WebkitTransition:"webkitTransitionEnd",MozTransition:"transitionend",OTransition:"oTransitionEnd otransitionend",msTransition:"MSTransitionEnd",transition:"transitionend"};return n.hasOwnProperty(d)?n[d]:!1}();n.App=function(){var t=!1,l={},u=e.getElementById("inner-wrap"),v=!1,f="js-nav";return l.init=function(){if(!t){t=!0;var p=function(n){n&&n.target===u&&e.removeEventListener(c,p,!1),v=!1};l.closeNav=function(){if(v){var t=c&&d?parseFloat(n.getComputedStyle(u,"")[d+"Duration"]):0;t>0?e.addEventListener(c,p,!1):p(null)}r(s,f)},l.openNav=function(){v||(a(s,f),v=!0)},l.toggleNav=function(n){v&&i(s,f)?l.closeNav():l.openNav(),n&&n.preventDefault()},e.getElementById("nav-open-btn").addEventListener("click",l.toggleNav,!1),e.getElementById("nav-close-btn").addEventListener("click",l.toggleNav,!1),e.addEventListener("click",function(n){v&&!o(n.target,"nav")&&(n.preventDefault(),l.closeNav())},!0),a(s,"js-ready")}},l}(),n.addEventListener&&n.addEventListener("DOMContentLoaded",n.App.init,!1)}(window,window.document);


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
    *   BBcode editor
    */
    var lg = {
        lang: "hr",
        buttons: "bold,italic,underline,strike,sup,sub,|,justifyleft,justifycenter,justifyright,fontSize,quote,|,table,bullist,numlist,fontcolor,code,|,link,video,removeFormat"
    }
    $("#codeEditor").wysibb(lg);

    /**
     *   toogle tags-collection container view
     */
    $("#toogle-tags-collection").click(function(event){
        event.preventDefault();

        //update element value
        if($(this).children().attr('class') == 'fa fa-chevron-down'){
            $(this).children().attr('class', 'fa fa-chevron-up');
        }
        else if($(this).children().attr('class') == 'fa fa-chevron-up'){
            $(this).children().attr('class', 'fa fa-chevron-down');
        }

        $("#tags-collection").toggle(250);
    });

    /**
     *   add selected tag to tags input
     */
    $("#tags-collection ul li").click(function() {
        $('#news_tags').tagsinput('add', $(this).text());
        $(this).fadeOut(300, function(){ $(this).remove(); }); //remove used tag from DOM
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
                var $arrows = $('<button type="button" class="imagelightbox-arrow imagelightbox-arrow-left" title="Prethodna"></button><button type="button" class="imagelightbox-arrow imagelightbox-arrow-right" title="Sljedeća"></button>');
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