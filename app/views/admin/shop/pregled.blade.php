@include('adminLayout.header')

<section class="section main-content" id="main">
    <h3 class="section-header">Administracija <i class="fa fa-angle-right"></i> Ponuda <i class="fa fa-angle-right"></i> Novi proizvod</h3>

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

                        <p><strong>Kategorija:</strong> {{ $product_data->category->category_name }}</p>
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

                        <a href="{{ URL::route('admin-shop-product-edit', ['slug' => $product_data->slug]) }}"><button class="btn btn-submit-edit">Izmjeni proizvod <i class="fa fa-pencil"></i></button></a>
                        <button class="btn btn-submit-delete" id="productDelete">Obriši proizvod <i class="fa fa-trash"></i></button>
                    </div>
                </div>
            </div>
        </div>  <!-- end well -->

        <div class="space"></div>
        <a href="{{ URL::route('admin-shop') }}"><button class="btn btn-submit"><i class="fa fa-chevron-left"></i> Povratak</button></a>

    </section>  <!-- end section-inner -->

</section> <!-- end #main -->

{{-- include session notification output --}}
@include('admin.notification')

<script>
    jQuery(document).ready(function(){
        /*
         *   delete product confirm
         */
        $("#productDelete").click(function(){
            bootbox.confirm("Stvarno želiš obrisati ovaj proizvod?", function(result) {
                if(result == true){
                    window.location = '{{ URL::route('admin-shop-product-delete', ['slug' => $product_data->slug]) }}';
                }
            });
        });
    });
</script>

@include('adminLayout.footer')