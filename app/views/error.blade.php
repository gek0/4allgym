@include('publicLayout.header')

<section class="section main-content"  id="main">
    <h1 class="section-header">Greška</h1>

    <section class="section section-inner">
        <div class="text-center space">
            <h1>{{{ $exception }}}</h1>

            <div class="space"></div>
            <a href="{{ URL::route('home') }}"><button class="btn btn-submit btn-padded-smaller">Povratak na početnu</button></a>
        </div>
    </section> <!-- end section-inner -->

</section> <!-- end #main -->

@include('publicLayout.footer')