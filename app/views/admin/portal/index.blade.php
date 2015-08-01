@include('adminLayout.header')

<section class="section main-content" id="main">
    <h2 class="section-header">Administracija <i class="fa fa-angle-right"></i> Portal</h2>

    <section class="section-inner">
        <section id="tools-content">
            <div class="well">
                <h4 class="section-header"><i class="fa fa-cogs"></i> Dodatni alati</h4>
                <div class="row text-center">
                    <div class="col-md-12">
                        <a href="{{ URL::route('admin-portal-add') }}"><button class="btn btn-submit btn-padded">Nova vijest <i class="fa fa-plus"></i></button></a>
                    </div>
                </div>
            </div>
        </section>
        <div class="space"></div>

        @if(count($news_data->all()) > 0)
            @foreach(array_chunk($news_data->all(), 3) as $news)
                <div class="row padded">
                    @foreach($news as $item)
                        <div class="col-md-4 news-all-content" id="news-{{ $item->id }}">
                            <div class="news-all-header">
                                <h3 class="news-all-header-title text-center">{{ $item->news_title }}</h3>
                                @if($item->images->count() > 0)
                                    {{ HTML::image('/news_uploads/'.$item->id.'/'.$item->images->first()->file_name, imageAlt($item->images->first()->file_name), ['class' => 'thumbnail img-responsive lazy']) }}
                                @else
                                    {{ HTML::image('css/assets/images/4allgym_no_image.png', 'Slika nije dostupna', ['class' => 'thumbnail img-responsive']) }}
                                @endif
                            </div> <!-- end news-all-header -->
                            <hr>
                            <div class="data_info">
                                <div class="row">
                                    <div class="col-md-12">
                                        <i class="fa fa-user" alt="Autor objave" title="Autor objave"></i>
                                        <span class="info-text">{{ $item->author->username }}</span>
                                    </div>
                                    <div class="col-md-12">
                                        <i class="fa fa-calendar" alt="Datum objave" title="Datum objave"></i>
                                        <time datetime="{{ $item->getDateCreatedFormatedHTML() }}">{{ $item->getDateCreatedFormated() }}</time>
                                    </div>
                                </div>
                            </div> <!-- end news info -->
                            <div class="space"></div>
                            <div class="news-all-tools text-center">
                                <a href="{{ url('admin/portal/pregled/'.$item->slug) }}"><button class="btn btn-submit">Pregledaj <i class="fa fa-chevron-right"></i></button></a>
                            </div>
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

<script>
    jQuery(document).ready(function(){
        //set news header (title and logo) height equal (biggest dimension on page)
        var maxHeightHeader = 0;
        $(".news-all-header").each(function(){
            if ($(this).height() > maxHeightHeader) { maxHeightHeader = $(this).height(); }
        });
        $(".news-all-header").height(maxHeightHeader);

        //set whole news div height equal (biggest div height dimension on page)
        var maxHeightContent = 0;
        $(".news-all-content").each(function(){
            if ($(this).height() > maxHeightContent) { maxHeightContent = $(this).height(); }
        });
        $(".news-all-content").height(maxHeightContent);
    });
</script>

@include('adminLayout.footer')