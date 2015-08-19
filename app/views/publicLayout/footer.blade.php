    </div> <!-- end #inner-wrap -->
    </div> <!-- end #outer-wrap -->

<footer>
    <div class="container">
        <p class="text-center">&copy; {{ date('Y') }}, 4allGym<br> Design and code by <a href="https://github.com/gek0" target="_blank">Matija</a></p>
        <p class="text-center">
            <a href="https://www.facebook.com/4allGym" target="_blank" class="foot-link"><i class="fa fa-facebook-square fa-gig"></i></a>&nbsp;
            <a href="{{ URL::to('rss') }}" target="_blank" class="foot-link"><i class="fa fa-rss-square fa-gig"></i></a>
        </p>
    </div>
</footer>

<a href="#0" class="cd-top"></a>
    <!-- scripts -->
    {{ HTML::script('js/bootstrap.min.js', ['charset' => 'utf-8']) }}
    {{ HTML::script('js/jquery.lazyload.min.js', ['charset' => 'utf-8']) }}
    {{ HTML::script('js/bootstrap-select.min.js', ['charset' => 'utf-8']) }}
    {{ HTML::script('js/imagelightbox.min.js', ['charset' => 'utf-8']) }}
    {{ HTML::script('js/classie.min.js', ['charset' => 'utf-8']) }}
    {{ HTML::script('https://maps.googleapis.com/maps/api/js?sensor=false', ['charset' => 'utf-8']) }}
    {{ HTML::script('js/gmaps.js', ['charset' => 'utf-8']) }}
    {{ HTML::script('js/emailAjax.js', ['charset' => 'utf-8']) }}
    {{ HTML::script('js/init.js', ['charset' => 'utf-8']) }}
</body>
</html>