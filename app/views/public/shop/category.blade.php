@include('publicLayout.header')

<section class="section main-content" id="main">
    <h2 class="section-header">Ponuda <i class="fa fa-angle-right"></i> {{ $category_name }}</h2>

    <section class="section-inner">

        <div class="row">
            <div class="col-md-3">
                <section id="tools-content" class="space">
                    <div class="well">
                        <a href="{{ URL::route('shop') }}"><button class="btn btn-submit"><i class="fa fa-chevron-left"></i> Povratak na kategorije</button></a>
                        <div class="space"></div>

                        <h4 class="section-header"><i class="fa fa-cogs"></i> Dodatni alati</h4>
                        <div class="row text-center">
                            <div class="col-md-12">
                                {{ Form::open(['url' => 'shop/'.$slug.'/search', 'method' => 'GET', 'id' => 'productSearch', 'role' => 'form']) }}
                                    <div class="form-group">
                                        {{ Form::text('product_name_search', $search_param, ['id' => 'product_name_search', 'class' => 'form-input-control', 'placeholder' => 'Pronađite proizvod...']) }}
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-submit">Pronađi <i class="fa fa-search"></i></button>
                                    </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </section> <!-- end #tools-content section -->
            </div> <!-- end categories menu -->
            <div class="col-md-9">
                <div class="shop-cover-photo">
                    <h3>4allGym Shop <br> {{ $category_name }}</h3>
                </div>

                <div class="row">
                    <div class="col-md-12">

                        @if(count($products_data->all()) > 0)
                            <div class="pagination-layout pagination-centered">
                                {{ $products_data->appends(Request::except('stranica'))->links() }}
                            </div> <!-- end pagination -->

                            @foreach(array_chunk($products_data->all(), 3) as $product)
                                <div class="row padded">
                                    @foreach($product as $item)
                                        <div class="col-sm-6 col-md-4">
                                            <div class="thumbnail news-all-content">
                                                @if($item->product_image != '')
                                                    {{ HTML::image('/product_uploads/'.$item->id.'/'.$item->product_image, imageAlt($item->product_image), ['class' => 'thumbnail img-responsive lazy']) }}
                                                @else
                                                    {{ HTML::image('css/assets/images/4allgym_no_image.png', 'Slika nije dostupna', ['class' => 'thumbnail img-responsive']) }}
                                                @endif
                                                <div class="caption news-all-header">
                                                    <h4 class="section-header">{{ $item->product_name }}</h4>
                                                    <p class="text-center">
                                                        <strong class="gray">Status:</strong>
                                                        @if($item->product_active == 'yes')
                                                            <span class="info-notif">dostupan <i class="fa fa-eye"></i></span>
                                                        @else
                                                            <span class="danger-notif">nedostupan <i class="fa fa-eye-slash"></i></span>
                                                        @endif
                                                    </p>
                                                    <p class="text-center">
                                                        <strong class="gray">Cijena:</strong> <span class="primary-notif">{{ $item->product_price }} kn</span>
                                                    </p>
                                                    <p class="text-center">
                                                        <a href="{{ URL::route('shop-product-show', ['slug' => $item->slug]) }}">
                                                            <button class="btn btn-submit" role="button">Pregledaj <i class="fa fa-chevron-right"></i></button>
                                                        </a>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div> <!-- end row -->
                            @endforeach

                            <div class="pagination-layout pagination-centered">
                                {{ $products_data->appends(Request::except('stranica'))->links() }}
                            </div> <!-- end pagination -->
                        @else
                            <div class="text-center">
                                <h2>Trenutno nema proizvoda.</h2>
                            </div>
                        @endif

                    </div>  <!-- end col-md-12 -->
                </div>  <!-- end row -->

            </div> <!-- end products list -->
        </div> <!-- end row -->

    </section>  <!-- end section-inner -->

</section> <!-- end #main -->

{{-- include session notification output --}}
@include('admin.notification')

@include('publicLayout.footer')