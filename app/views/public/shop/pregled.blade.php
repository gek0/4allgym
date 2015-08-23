@include('publicLayout.header')

<section class="section main-content" id="main">
    <h3 class="section-header">Ponuda <i class="fa fa-angle-right"></i> {{ $product_data->category->category_name }} <i class="fa fa-angle-right"></i> {{ $product_data->product_name }}</h3>

    <section class="section-inner">

        <div class="well">
            <div class="row media">
                <div class="col-md-5">
                    <div class="media-left">
                        @if($product_data->product_image != '')
                            <a href="{{ URL::to('/product_uploads/'.$product_data->id.'/'.$product_data->product_image) }}" data-imagelightbox="gallery-images">
                                <img data-original="{{ URL::to('/product_uploads/'.$product_data->id.'/'.$product_data->product_image) }}" alt="{{ imageAlt($product_data->product_image) }}" class="thumbnail img-responsive lazy" />
                            </a>
                        @else
                            {{ HTML::image('css/assets/images/4allgym_no_image.png', 'Slika nije dostupna', ['class' => 'thumbnail img-responsive']) }}
                        @endif
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="media-body">
                        <h3 class="media-heading">{{ $product_data->product_name }}</h3><br>

                        <p>{{ removeEmptyP(nl2p((new BBCParser)->parse($product_data->product_description))) }}</p>
                        <div class="space"></div>

                        <p><strong>Kategorija:</strong> <a href="{{ URL::to('shop/'.$product_data->category->slug) }}">{{ $product_data->category->category_name }}</a></p>
                        <p>
                            <strong>Status:</strong>
                            @if($product_data->product_active == 'yes')
                                <span class="info-notif">aktivan <i class="fa fa-eye"></i></span>
                            @else
                                <span class="danger-notif">neaktivan <i class="fa fa-eye-slash"></i></span>
                            @endif
                        </p>
                        <p><strong>Cijena:</strong> {{ $product_data->product_price }} kn</p>
                        <div class="space"></div>

                        <div class="text-center">
                            @if($in_cart)
                                <a href="{{ URL::route('shop-user-cart-add-product', ['id' => $product_data->id]) }}" class="btn btn-submit-edit btn-padded-smaller">Dodaj u košaricu <i class="fa fa-check"></i></a>
                            @else
                                <a href="{{ URL::route('shop-user-cart-delete-product', ['id' => $product_data->id]) }}" class="btn btn-submit-delete btn-padded-smaller">Obriši iz košarice <i class="fa fa-trash"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>  <!-- end well -->

        <div class="space"></div>
        <a href="{{ URL::to('shop') }}"><button class="btn btn-submit"><i class="fa fa-chevron-left"></i> Povratak u 4allGym shop</button></a>

    </section>  <!-- end section-inner -->

</section> <!-- end #main -->

{{-- include session notification output --}}
@include('admin.notification')

@include('publicLayout.footer')