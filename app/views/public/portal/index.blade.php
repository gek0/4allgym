@include('publicLayout.header')

<section class="section main-content" id="main">
    <h1 class="section-header">Portal</h1>

        @if(count($news_data->all()) > 0)
            @foreach(array_chunk($news_data->all(), 3) as $news)
                <div class="row padded marginated-center">
                    @foreach($news as $item)
                        <div class="col-md-4 news-all-content">
                            <a class="content-holder" href="{{ url('portal/pregled/'.$item->slug) }}">
                                <article id="news-{{ $item->id }}">
                                    <div class="news-all-header space">
                                        @if($item->images->count() > 0)
                                            {{ HTML::image('/news_uploads/'.$item->id.'/'.$item->images->first()->file_name, imageAlt($item->images->first()->file_name), ['class' => 'thumbnail img-responsive lazy']) }}
                                        @else
                                            {{ HTML::image('css/assets/images/4allgym_no_image.png', 'Slika nije dostupna', ['class' => 'thumbnail img-responsive']) }}
                                        @endif
                                    </div> <!-- end news-all-header -->
                                    <h3 class="news-all-header-title text-center">{{ $item->news_title }}</h3>

                                    <div class="row">
                                        <div class="col-md-12 text-center space gray">
                                            <i class="fa fa-calendar" alt="Datum objave" title="Datum objave"></i>
                                            <time datetime="{{ $item->getDateCreatedFormatedHTML() }}">{{ $item->getDateCreatedFormated() }}</time>
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