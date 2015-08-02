@include('publicLayout.header')

<section class="section main-content" id="main">
    <h1 class="section-header">{{ $caffe_bar_data->page_title }}</h1>

    <section class="section section-inner">
        <div class="media">
            <div class="media-left">
                @if($caffe_bar_images->count() > 0 && $caffe_bar_primary_image)
                    <a href="{{ URL::to('/pages_uploads/'.$caffe_bar_primary_image->file_name) }}" data-imagelightbox="gallery-images">
                        <img data-original="{{ URL::to('/pages_uploads/'.$caffe_bar_primary_image->file_name) }}" alt="{{ imageAlt($caffe_bar_primary_image->file_name) }}" class="media-object thumbnail img-responsive lazy" />
                    </a>
                @elseif($caffe_bar_images->count() > 0)
                    <a href="{{ URL::to('/pages_uploads/'.$caffe_bar_images[0]['file_name']) }}" data-imagelightbox="gallery-images">
                        <img data-original="{{ URL::to('/pages_uploads/'.$caffe_bar_images[0]['file_name']) }}" alt="{{ imageAlt($caffe_bar_images[0]['file_name']) }}" class="media-object thumbnail img-responsive lazy" />
                    </a>
                @else
                    {{ HTML::image('css/assets/images/4allgym_no_image.png', 'Slika nije dostupna', ['class' => 'media-object thumbnail img-responsive lazy']) }}
                @endif
            </div>
            <div class="media-body">
                <h2 class="media-heading">{{ $caffe_bar_data->page_title }}</h2>
                {{ removeEmptyP(nl2p((new BBCParser)->parse($caffe_bar_data->page_text))) }}
            </div>
        </div>
    </section> <!-- end section -->

    @if($caffe_bar_images->count() > 0)
        <section id="image_gallery">
            <hr>
            <div class="container-fluid">
                <div class="row padded text-center">
                    <h2>Galerija slika  <small id="image_gallery_counter">{{ $caffe_bar_images->count() }}</small></h2>
                    @foreach($caffe_bar_images as $img)
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