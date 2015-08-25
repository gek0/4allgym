@include('adminLayout.header')

<section class="section main-content" id="main">
    <h2 class="section-header">Administracija</h2>

    <section class="section-inner">

        <div class="row text-center">
            <div class="col-md-3 padded">
                <a href="{{ URL::route('admin-portal') }}"><button class="btn btn-submit btn-padded"><i class="fa fa-newspaper-o"></i> Portal</button></a>
            </div>
            <div class="col-md-3 padded">
                <a href="{{ URL::route('admin-shop') }}"><button class="btn btn-submit btn-padded"><i class="fa fa-shopping-cart"></i> Web Shop</button></a>
            </div>
            <div class="col-md-3 padded">
                <a href="{{ URL::route('admin-offer') }}"><button class="btn btn-submit btn-padded"><i class="fa fa-shopping-cart"></i> Ponuda</button></a>
            </div>
            <div class="col-md-3 padded">
                <a href="{{ URL::route('admin-gallery') }}"><button class="btn btn-submit btn-padded"><i class="fa fa-picture-o"></i> Galerija</button></a>
            </div>
            <div class="col-md-4 padded">
                <a href="{{ URL::route('admin-caffe-bar') }}"><button class="btn btn-submit btn-padded"><i class="fa fa-coffee"></i> Caffe bar</button></a>
            </div>
            <div class="col-md-4 padded">
                <a href="{{ URL::route('admin-cage-football') }}"><button class="btn btn-submit btn-padded"><i class="fa fa-futbol-o"></i> Cage football</button></a>
            </div>
            <div class="col-md-4 padded">
                <a href="{{ URL::route('admin-user-settings') }}"><button class="btn btn-submit btn-padded"><i class="fa fa-user"></i> Korisničke postavke</button></a>
            </div>
        </div>

        <hr>
        <div class="text-center">
            <p>Za svaku grešku/upit/prijedlog, poslat e-mail na {{ HTML::mailto('matijaburisa@gmail.com') }}</p>
        </div>

    </section> <!-- end section-inner -->

</section> <!-- end #main -->

@include('adminLayout.footer')