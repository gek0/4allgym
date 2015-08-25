@include('adminLayout.header')

<section class="section main-content" id="main">
    <h2 class="section-header">Administracija <i class="fa fa-angle-right"></i> Ponuda</h2>

    <section class="section-inner">
        <section id="tools-content">
            <div class="well">
                <h4 class="section-header"><i class="fa fa-cogs"></i> Dodatni alati</h4>
                <div class="row text-center">
                    <div class="col-md-12">
                        <a href="{{ URL::route('admin-offer-add') }}"><button class="btn btn-submit btn-padded">Nova usluga <i class="fa fa-plus"></i></button></a>
                    </div>
                </div>
            </div>
        </section>
        <div class="space"></div>

        @if(count($offer_data->all()) > 0)
            @foreach(array_chunk($offer_data->all(), 3) as $offer)
                <div class="row padded marginated-center">
                    @foreach($offer as $item)
                        <div class="col-md-4 news-all-content">
                            <a class="content-holder" href="{{ url('admin/ponuda/pregled/'.$item->slug) }}">
                                <article id="offer-{{ $item->id }}">
                                    <div class="news-all-header space">
                                        @if($item->images->count() > 0)
                                            {{ HTML::image('/offers_uploads/'.$item->id.'/'.$item->images->first()->file_name, imageAlt($item->images->first()->file_name), ['class' => 'thumbnail img-responsive lazy']) }}
                                        @else
                                            {{ HTML::image('css/assets/images/4allgym_no_image.png', 'Slika nije dostupna', ['class' => 'thumbnail img-responsive']) }}
                                        @endif
                                    </div> <!-- end news-all-header -->

                                    <h3 class="news-all-header-title text-center">{{ $item->offer_title }}</h3>
                                </article>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endforeach

            <div class="pagination-layout pagination-centered">
                {{ $offer_data->appends(Request::except('stranica'))->links() }}
            </div> <!-- end pagination -->
        @else
            <div class="text-center">
                <h2>Trenutno nema usluga u ponudi.</h2>
            </div>
        @endif

    </section>  <!-- end section-inner -->

</section> <!-- end #main -->

{{-- include session notification output --}}
@include('admin.notification')

@include('adminLayout.footer')