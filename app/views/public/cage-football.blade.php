@include('publicLayout.header')

<section class="section main-content" id="main">
    <h1 class="section-header">{{ $cage_football_data->page_title }}</h1>

    <section class="section section-inner">
        <div class="media">
            <div class="media-left">
                @if($cage_football_images->count() > 0 && $cage_football_primary_image)
                    <a href="{{ URL::to('/pages_uploads/'.$cage_football_primary_image->file_name) }}" data-imagelightbox="gallery-images">
                        <img data-original="{{ URL::to('/pages_uploads/'.$cage_football_primary_image->file_name) }}" alt="{{ imageAlt($cage_football_primary_image->file_name) }}" class="media-object thumbnail img-responsive lazy" />
                    </a>
                @elseif($cage_football_images->count() > 0)
                    <a href="{{ URL::to('/pages_uploads/'.$cage_football_images[0]['file_name']) }}" data-imagelightbox="gallery-images">
                        <img data-original="{{ URL::to('/pages_uploads/'.$cage_football_images[0]['file_name']) }}" alt="{{ imageAlt($cage_football_images[0]['file_name']) }}" class="media-object thumbnail img-responsive lazy" />
                    </a>
                @else
                    {{ HTML::image('css/assets/images/4allgym_no_image.png', 'Slika nije dostupna', ['class' => 'media-object thumbnail img-responsive lazy']) }}
                @endif
            </div>
            <div class="media-body">
                <h2 class="media-heading">{{ $cage_football_data->page_title }}</h2>
                {{ removeEmptyP(nl2p((new BBCParser)->parse($cage_football_data->page_text))) }}
            </div>
        </div>
    </section> <!-- end section -->

    @if($cage_football_images->count() > 0)
        <section id="image_gallery">
            <hr>
            <div class="container-fluid">
                <div class="row padded text-center">
                    <h2>Galerija slika  <small id="image_gallery_counter">{{ $cage_football_images->count() }}</small></h2>
                    @foreach($cage_football_images as $img)
                        <div class="col-lg-3 col-sm-4 col-6 small-marg" id="img-container-{{ $img->id }}">
                            <a href="{{ URL::to('/pages_uploads/'.$img->file_name) }}" data-imagelightbox="gallery-images">
                                <img data-original="{{ URL::to('/pages_uploads/'.$img->file_name) }}" alt="{{ imageAlt($img->file_name) }}" class="thumbnail img-responsive lazy" />
                            </a>
                        </div>
                        <div class="clearfix visible-xs"></div>
                    @endforeach
                </div>
            </div>  <!-- end image gallery -->
        </section>
    @endif

</section> <!-- end main-content -->

@include('publicLayout.footer')