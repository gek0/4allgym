@include('publicLayout.header')

<section class="section main-content" id="main">
    <h3 class="section-header">Portal <i class="fa fa-angle-right"></i> Tag <i class="fa fa-angle-right"></i> {{ $tag_data->tag }}</h3>

    <div class="text-center">
        <h3>Pretraga po tagu:<br> <strong>{{ $tag_data->tag }}</strong></h3>

        <div class="space"></div>
        <a href="{{ url('tagovi') }}"><button class="btn btn-submit"><i class="fa fa-tags fa-med pr-10"></i> Lista svih tagova</button></a>
    </div>

    @if(count($news_data->all()) > 0)
        @foreach(array_chunk($news_data->all(), 3) as $news)
            <div class="row padded marginated-center">
                @foreach($news as $item)
                    <div class="col-md-4 news-all-content">
                        <a class="content-holder" href="{{ url('portal/pregled/'.$item->slug) }}">
                            <article id="news-{{ $item->id }}">
                                <div class="news-all-header space">
                                    @if($item->newsImage)
                                        {{ HTML::image('/news_uploads/'.$item->id.'/'.$item->newsImage, imageAlt($item->newsImage), ['class' => 'thumbnail img-responsive lazy']) }}
                                    @else
                                        {{ HTML::image('css/assets/images/4allgym_no_image.png', 'Slika nije dostupna', ['class' => 'thumbnail img-responsive']) }}
                                    @endif
                                </div> <!-- end news-all-header -->
                                <h3 class="news-all-header-title text-center">{{ $item->news_title }}</h3>

                                <div class="row">
                                    <div class="col-md-12 text-center space gray">
                                        <i class="fa fa-calendar" alt="Datum objave" title="Datum objave"></i>
                                        <time datetime="{{ date('Y-m-d', strtotime($item->created_at)) }}">{{ date('d.m.Y. \u H:i\h', strtotime($item->created_at)) }}</time>
                                    </div>
                                </div>
                            </article>
                        </a>
                    </div>
                @endforeach
            </div>
        @endforeach

        <div class="pagination-layout pagination-centered">
            {{ $news_data->appends(Request::except('stranica'))->links() }}
        </div> <!-- end pagination -->
    @else
        <div class="text-center">
            <h2>Trenutno nema vijesti.</h2>
        </div>
    @endif

</section>  <!-- end section-inner -->

</section> <!-- end #main -->

{{-- include session notification output --}}
@include('admin.notification')

@include('publicLayout.footer')