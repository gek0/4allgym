@include('publicLayout.header')

<section class="section main-content" id="main">
    <h1 class="section-header">Galerija</h1>

    <section class="section section-inner">
        <div role="tabpanel" id="gallery-content-view">
            <!-- navigation tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#gallery-images" aria-controls="gallery-images" role="tab" data-toggle="tab"><i class="fa fa-picture-o fa-med"></i> Slike ({{ $image_data->count() }})</a></li>
                <li role="presentation"><a href="#gallery-videos" aria-controls="gallery-videos" role="tab" data-toggle="tab"><i class="fa fa-video-camera fa-med"></i> Video ({{ $video_data->count() }})</a></li>
            </ul>

            <!-- tab content -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="gallery-images">
                    <div class="space"></div>
                    <div class="row">
                        @if($image_data->count() > 0)
                            <section id="gallery_data">
                                <div class="container-fluid">
                                    <div class="row padded text-center">
                                        @foreach($image_data as $img)
                                            <div class="col-lg-3 col-sm-4 col-6 small-marg" id="container-{{ $img->id }}">
                                                <a href="{{ URL::to('/gallery_uploads/'.$img->file_name) }}" data-imagelightbox="gallery-images">
                                                    <img data-original="{{ URL::to('/gallery_uploads/'.$img->file_name) }}" alt="{{ imageAlt($img->file_name) }}" class="thumbnail img-responsive lazy" />
                                                </a>
                                            </div>
                                            <div class="clearfix visible-xs"></div>
                                        @endforeach
                                    </div>
                                </div>  <!-- end image gallery -->
                            </section>
                        @else
                            <h3 class="text-center">Trenutno nema slika u galeriji.</h3>
                        @endif
                    </div> <!-- end row -->
                </div> <!-- end gallery-images tab -->

                <div role="tabpanel" class="tab-pane fade" id="gallery-videos">
                    <div class="space"></div>
                    <div class="row">
                        @if($video_data->count() > 0)
                            <section id="gallery_data">
                                <div class="container-fluid">
                                    <div class="row padded text-center">
                                        @foreach($video_data as $vid)
                                            <div class="col-lg-6 col-sm-4 col-6 small-marg" id="container-{{ $vid->id }}">
                                                <video width="600" controls>
                                                    <source src="{{ URL::to('/gallery_uploads/'.$vid->file_name) }}" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </div>
                                            <div class="clearfix visible-xs"></div>
                                        @endforeach
                                    </div>
                                </div>  <!-- end image gallery -->
                            </section>
                        @else
                            <h3 class="text-center">Trenutno nema videa u galeriji.</h3>
                        @endif
                    </div> <!-- end row -->
                </div> <!-- end gallery-videos tab -->

            </div>
        </div> <!-- end tabpanel -->
    </section> <!-- end section -->

</section> <!-- end main-content -->

@include('publicLayout.footer')