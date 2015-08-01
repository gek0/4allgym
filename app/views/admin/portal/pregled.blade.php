@include('adminLayout.header')

<section class="section main-content" id="main">
    <h4 class="section-header">Administracija <i class="fa fa-angle-right"></i> Portal <i class="fa fa-angle-right"></i> Vijest <i class="fa fa-angle-right"></i> {{ $news_data->news_title }}</h4>

    <section class="section form-section">
        <article class="data_individual">
            <div class="page-header">
                <h1>{{ $news_data->news_title }}</h1>
            </div>
            <div class="data_info">
                <div class="row">
                    <div class="col-md-4">
                        <span class="fa fa-user fa-med" title="Autor objave"></span>
                        <span class="info-text">{{ $news_data->author->username }}</span>
                    </div>
                    <div class="col-md-4">
                        <span class="fa fa-calendar fa-med" title="Datum objave"></span>
                    <span class="info-text">
                        <time datetime="{{ $news_data->getDateCreatedFormatedHTML() }}">{{ $news_data->getDateCreatedFormated() }}</time>
                    </span>
                    </div>
                    <div class="col-md-4">
                        <span class="fa fa-eye fa-med" title="Broj pregleda"></span>
                        <span class="info-text">{{ $news_data->num_visited }} pregleda</span>
                    </div>
                </div>
            </div>
            <div class="row padded">
                <div class="col-md-9">
                    {{ removeEmptyP(nl2p((new BBCParser)->parse($news_data->news_body))) }}
                </div>
                <div class="col-md-3">
                    <div class="sidebar-content">
                        <div class="sidebar-header">
                            <span class="fa fa-tags fa-big" title="Tagovi"></span> <span class="info-text">Tagovi članka</span>
                        </div>
                        <div class="sidebar-body">
                            @if($news_data->tags->count() > 0)
                                <ul class="tags">
                                    @foreach($news_data->tags as $tag)
                                        <li>{{ $tag->tag }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p>Trenutno nema tagova.</p>
                            @endif
                        </div>
                    </div>
                    <div class="sidebar-content">
                        <div class="sidebar-header">
                            <span class="fa fa-cogs fa-big" title="Alati"></span> <span class="info-text">Admin alati</span>
                        </div>
                        <div class="sidebar-body">
                            <a href="{{ URL::to('admin/portal/izmjena/'.$news_data->slug) }}" id="newsEdit"><button class="btn btn-submit-edit"><span class="fa fa-pencil"></span> Uredi članak</button></a>
                            <button class="btn btn-submit-delete" id="newsDelete"><span class="fa fa-trash"></span> Obriši članak</button>
                        </div>
                    </div>
                </div>
            </div>

            @if($news_data->images->count() > 0)
                <section id="image_gallery" data-role-link="{{ URL::route('admin-portal-gallery-image-delete') }}">
                    <hr>
                    <div class="container-fluid">
                        <div class="row padded text-center">
                            <h2>Galerija slika  <small id="image_gallery_counter">{{ $news_data->images->count() }}</small></h2>
                            @foreach($news_data->images as $img)
                                <div class="col-lg-3 col-sm-4 col-6 small-marg" id="img-container-{{ $img->id }}">
                                    <a href="{{ URL::to('/news_uploads/'.$news_data->id.'/'.$img->file_name) }}" data-imagelightbox="gallery-images">
                                        <img data-original="{{ URL::to('/news_uploads/'.$news_data->id.'/'.$img->file_name) }}" alt="{{ imageAlt($img->file_name) }}" class="thumbnail img-responsive lazy" />
                                    </a>
                                    <button id="{{ $img->id }}" class="btn btn-submit-delete btn-delete-gallery-image" title="Brisanje slike {{ $img->file_name }}"><i class="fa fa-trash"></i></button>
                                </div>
                                <div class="clearfix visible-xs"></div>
                            @endforeach
                        </div>
                    </div>  <!-- end image gallery -->
                </section>
            @endif

        </article> <!-- end article of news_data -->
    </section> <!-- end section -->

</section> <!-- end #main -->

{{-- include session notification output --}}
@include('admin.notification')

<script>
    jQuery(document).ready(function(){
        /*
         *   delete news confirm
         */
        $("#newsDelete").click(function(){
            bootbox.confirm("Stvarno želiš obrisati ovu vijest?", function(result) {
                if(result == true){
                    window.location = '{{ URL::to('admin/portal/brisanje/'.$news_data->slug) }}';
                }
            });
        });
    });
</script>

@include('adminLayout.footer')