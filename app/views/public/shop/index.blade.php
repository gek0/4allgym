@include('publicLayout.header')

<section class="section main-content" id="main">
    <h1 class="section-header">Ponuda</h1>

    <section class="section-inner">

        <div class="row">
            <div class="col-md-3">

                <div class="well text-center">
                    <a href="{{ URL::route('shop-user-cart') }}">
                        <button class="btn btn-submit btn-padded" role="button"><i class="fa fa-shopping-cart fa-gig"></i><br>Vaša košarica</button>
                    </a>
                </div>

                <section id="tools-content" class="space">
                    <div class="well">
                        <h4 class="section-header"><i class="fa fa-cogs"></i> Dodatni alati</h4>
                        <div class="row text-center">
                            <div class="col-md-12">
                                {{ Form::open(['url' => 'shop/search', 'method' => 'GET', 'id' => 'productSearch', 'role' => 'form']) }}
                                <div class="form-group">
                                    {{ Form::text('product_name_search', $search_param, ['id' => 'product_name_search', 'class' => 'form-input-control', 'placeholder' => 'Pronađite proizvod...', 'required']) }}
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-submit">Pronađi <i class="fa fa-search"></i></button>
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </section> <!-- end #tools-content section -->

                @if($product_categories->count() > 0)
                    <ul class="list-group">
                        @foreach($product_categories as $cat)
                            <li class="list-group-item list-group-hovered">
                                <i class="fa fa-angle-right fa-med"></i> <a href="{{ URL::to('shop/'.$cat->slug) }}"> {{ $cat->category_name }}</a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <ul class="list-group">
                        <li class="list-group-item list-group-hovered">
                            <h4>Trenutno nema kategorija.</h4>
                        </li>
                    </ul>
                @endif
            </div> <!-- end categories menu -->
            <div class="col-md-9">
                <div class="shop-cover-photo">
                    <h2>4allGym Shop</h2>
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

@include('publicLayout.footer')