    </div> <!-- end #inner-wrap -->
    </div> <!-- end #outer-wrap -->

<footer>
    <div class="container">
        <p class="text-center">&copy; {{ date('Y') }}, 4allGym<br> Design and code by <a href="https://github.com/gek0" target="_blank">Matija</a></p>
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