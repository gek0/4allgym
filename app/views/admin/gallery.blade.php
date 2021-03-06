@include('adminLayout.header')

<section class="section main-content" id="main">
    <h2 class="section-header">Administracija <i class="fa fa-angle-right"></i> Galerija</h2>

    <section class="section form-section">
        {{ Form::open(['url' => 'admin/galerija/dodaj', 'id' => 'galleryUpload', 'files' => true, 'role' => 'form']) }}
        <div class="form-group">
            {{ Form::label('gallery_file', 'Datoteke galerije - (mp4 video i slike):') }}
            {{ Form::file('gallery_files[]', ['multiple' => true, 'class' => 'file', 'id' => 'gallery_file', 'accept' => '*', 'required']) }}
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-submit btn-padded">Dodaj u galeriju <i class="fa fa-check"></i></button>
        </div>
        {{ Form::close() }}

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
                            <section id="gallery_data" data-role-link="{{ URL::route('admin-gallery-delete') }}">
                                <div class="container-fluid">
                                    <div class="row padded text-center">
                                        @foreach($image_data as $img)
                                            <div class="col-lg-3 col-sm-4 col-6 small-marg" id="container-{{ $img->id }}">
                                                <a href="{{ URL::to('/gallery_uploads/'.$img->file_name) }}" data-imagelightbox="gallery-images">
                                                    <img data-original="{{ URL::to('/gallery_uploads/'.$img->file_name) }}" alt="{{ imageAlt($img->file_name) }}" class="thumbnail img-responsive lazy" />
                                                </a>
                                                <button id="{{ $img->id }}" class="btn btn-submit-delete btn-delete-gallery-file" title="Brisanje slike {{ $img->file_name }}"><i class="fa fa-trash"></i></button>
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
                            <section id="gallery_data" data-role-link="{{ URL::route('admin-gallery-delete') }}">
                                <div class="container-fluid">
                                    <div class="row padded text-center">
                                        @foreach($video_data as $vid)
                                            <div class="col-lg-3 col-sm-4 col-6 small-marg" id="container-{{ $vid->id }}">
                                                <video width="300" controls>
                                                    <source src="{{ URL::to('/gallery_uploads/'.$vid->file_name) }}" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                                <button id="{{ $vid->id }}" class="btn btn-submit-delete btn-delete-gallery-file" title="Brisanje videa {{ $vid->file_name }}"><i class="fa fa-trash"></i></button>
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
    </section> <!-- end form-section -->

</section> <!-- end #main -->

{{-- include session notification output --}}
@include('admin.notification')

@include('adminLayout.footer')