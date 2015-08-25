@include('adminLayout.header')

<section class="section main-content" id="main">
    <h3 class="section-header">Administracija <i class="fa fa-angle-right"></i> Ponuda <i class="fa fa-angle-right"></i> Nova usluga</h3>

    <section class="section-inner">

        <div class="well">
            <div class="row media">
                <div class="col-md-5">
                    <div class="media-left">
                        @if($offer_data->images->count() > 0)
                            {{ HTML::image('/offers_uploads/'.$offer_data->id.'/'.$offer_data->images->first()->file_name, imageAlt($offer_data->images->first()->file_name), ['class' => 'thumbnail img-responsive lazy']) }}
                        @else
                            {{ HTML::image('css/assets/images/4allgym_no_image.png', 'Slika nije dostupna', ['class' => 'thumbnail img-responsive']) }}
                        @endif
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="media-body">
                        <h1 class="media-heading">{{ $offer_data->offer_title }}</h1><br>

                        <p>{{ removeEmptyP(nl2p((new BBCParser)->parse($offer_data->offer_body))) }}</p>
                        <div class="space"></div>

                        <div class="space"></div>

                        <a href="{{ URL::route('admin-offer-edit', ['slug' => $offer_data->slug]) }}"><button class="btn btn-submit-edit">Izmjeni uslugu <i class="fa fa-pencil"></i></button></a>
                        <button class="btn btn-submit-delete" id="offerDelete">Obriši uslugu <i class="fa fa-trash"></i></button>
                    </div>
                </div>
            </div>

            @if($offer_data->images->count() > 0)
                <section id="image_gallery" data-role-link="{{ URL::route('admin-offer-gallery-image-delete') }}">
                    <hr>
                    <div class="container-fluid">
                        <div class="row padded text-center">
                            <h2>Galerija slika  <small id="image_gallery_counter">{{ $offer_data->images->count() }}</small></h2>
                            @foreach($offer_data->images as $img)
                                <div class="col-lg-3 col-sm-4 col-6 small-marg" id="img-container-{{ $img->id }}">
                                    <a href="{{ URL::to('/offers_uploads/'.$offer_data->id.'/'.$img->file_name) }}" data-imagelightbox="gallery-images">
                                        <img data-original="{{ URL::to('/offers_uploads/'.$offer_data->id.'/'.$img->file_name) }}" alt="{{ imageAlt($img->file_name) }}" class="thumbnail img-responsive lazy" />
                                    </a>
                                    <button id="{{ $img->id }}" class="btn btn-submit-delete btn-delete-gallery-image" title="Brisanje slike {{ $img->file_name }}"><i class="fa fa-trash"></i></button>
                                </div>
                                <div class="clearfix visible-xs"></div>
                            @endforeach
                        </div>
                    </div>  <!-- end image gallery -->
                </section>
            @endif

        </div>  <!-- end well -->

        <div class="space"></div>
        <a href="{{ URL::route('admin-offer') }}"><button class="btn btn-submit"><i class="fa fa-chevron-left"></i> Povratak</button></a>

    </section>  <!-- end section-inner -->

</section> <!-- end #main -->

{{-- include session notification output --}}
@include('admin.notification')

<script>
    jQuery(document).ready(function(){
        /*
         *   delete offer confirm
         */
        $("#offerDelete").click(function(){
            bootbox.confirm("Stvarno želiš obrisati ovu uslugu?", function(result) {
                if(result == true){
                    window.location = '{{ URL::route('admin-offer-delete', ['slug' => $offer_data->slug]) }}';
                }
            });
        });
    });
</script>

@include('adminLayout.footer')