@include('publicLayout.header')

<section class="section main-content" id="main">
    <h3 class="section-header">Portal <i class="fa fa-angle-right"></i> Vijest <i class="fa fa-angle-right"></i> {{ $news_data->news_title }}</h3>

    <section class="section form-section">
        <article class="data_individual">
            <div class="page-header">
                <h1>{{ $news_data->news_title }}</h1>
            </div>
            
            <div class="row padded">
                <div class="col-md-9">
                    @if($news_data->images->count() > 0)
                        {{ HTML::image('/news_uploads/'.$news_data->id.'/'.$news_data->images->first()->file_name, imageAlt($news_data->images->first()->file_name), ['class' => 'content-header-image img-responsive lazy']) }}
                    @else
                        {{ HTML::image('css/assets/images/4allgym_no_image.png', 'Slika nije dostupna', ['class' => 'content-header-no-image img-responsive']) }}
                    @endif
                    <div class="space"></div>

                    <div class="row">
                        <div class="col-md-12">
                            <i class="fa fa-tags fa-big" title="Tagovi članka"></i> <span class="info-text">Tagovi članka</span>
                            @if($news_data->tags->count() > 0)
                                <ul class="tags">
                                    @foreach($news_data->tags as $tag)
                                        <a href="{{ URL::to('portal/tag/'.$tag->slug) }}"><li>{{ $tag->tag }}</li></a>
                                    @endforeach
                                </ul>
                            @else
                                <p>Trenutno nema tagova.</p>
                            @endif
                        </div>
                    </div>

                    <div class="space"></div>

                    {{ removeEmptyP(nl2p((new BBCParser)->parse($news_data->news_body))) }}
                </div>
                <div class="col-md-3">
                    <div class="sidebar-content">
                        <div class="sidebar-header text-center">
                            <i class="fa fa-info fa-big" title="Info"></i> <span class="info-text">Info</span>
                        </div>
                        <div class="sidebar-body">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <i class="fa fa-calendar fa-med pr-10"></i>
                                    <time datetime="{{ $news_data->getDateCreatedFormatedHTML() }}">{{ $news_data->getDateCreatedFormated() }}</time>
                                </li>
                                <li class="list-group-item">
                                    <i class="fa fa-eye fa-med pr-10"></i>
                                    {{ $news_data->num_visited }} pregleda
                                </li>
                            </ul>
                        </div>
                    </div> <!-- end info -->

                    <div class="sidebar-content">
                        <div class="sidebar-header text-center">
                            <i class="fa fa-newspaper-o fa-big" title="Probrani članci"></i> <span class="info-text">Probrani članci</span>
                        </div>
                        <div class="sidebar-body">
                            @if($random_news->count() > 0)
                                <ul class="list-group">
                                    @foreach($random_news as $r_news)
                                        <li class="list-group-item">
                                            <i class="fa fa-angle-right fa-med"></i> <a href="{{ url('portal/pregled/'.$r_news->slug) }}"> {{ Str::limit($r_news->news_title, 40) }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p>Trenutno nema drugih članaka.</p>
                            @endif
                        </div>
                    </div> <!-- end random news -->

                    <div class="sidebar-content">
                        <div class="sidebar-header text-center">
                            <i class="fa fa-arrows fa-big" title="Destinacija"></i> <span class="info-text">Destinacija</span>
                        </div>
                        <div class="sidebar-body">
                            <div class="row">
                                <div class="col-md-6 text-left">
                                    @if($previous_news == true)
                                        <div class="content-directive">
                                            <a href="{{ URL::to('portal/pregled/'.$previous_news['slug']) }}" title="{{ $previous_news['news_title'] }}"><i class="fa fa-arrow-left fa-big"></i> {{ Str::limit($previous_news['news_title'], 10) }}</a>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-6 text-right">
                                    @if($next_news == true)
                                        <div class="nextContent">
                                            <a href="{{ URL::to('portal/pregled/'.$next_news['slug']) }}" title="{{ $next_news['news_title'] }}">{{ Str::limit($next_news['news_title'], 10) }} <i class="fa fa-arrow-right fa-big"></i></a>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-12 text-center">
                                    <a href="{{ URL::to('portal') }}" title="Povratak na vijesti"><i class="fa fa-home fa-gig"></i></a>
                                </div>
                            </div> <!-- end row -->
                        </div>
                    </div> <!-- end directional info -->

                </div>
            </div>

            @if($news_data->images->count() > 0)
                <section id="image_gallery">
                    <hr>
                    <div class="container-fluid">
                        <div class="row padded text-center">
                            <h2>Galerija slika  <small id="image_gallery_counter">{{ $news_data->images->count() }}</small></h2>
                            @foreach($news_data->images as $img)
                                <div class="col-lg-3 col-sm-4 col-6 small-marg" id="img-container-{{ $img->id }}">
                                    <a href="{{ URL::to('/news_uploads/'.$news_data->id.'/'.$img->file_name) }}" data-imagelightbox="gallery-images">
                                        <img data-original="{{ URL::to('/news_uploads/'.$news_data->id.'/'.$img->file_name) }}" alt="{{ imageAlt($img->file_name) }}" class="thumbnail img-responsive lazy" />
                                    </a>
                                </div>
                                <div class="clearfix visible-xs"></div>
                            @endforeach
                        </div>
                    </div>  <!-- end image gallery -->
                </section>
            @endif

        </article> <!-- end article of news_data -->
    </section> <!-- end section -->


</section> <!-- end main-content -->

{{-- include session notification output --}}
@include('admin.notification')

@include('publicLayout.footer')