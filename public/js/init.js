/**
 * main JS file for initialization
 */


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