@include('adminLayout.header')

<section class="section main-content" id="main">
    <h2 class="section-header">Administracija <i class="fa fa-angle-right"></i> Web Shop</h2>

    <section class="section-inner">
        <section id="tools-content">
            <div class="well">
                <h4 class="section-header"><i class="fa fa-cogs"></i> Dodatni alati</h4>
                <div class="row text-center">
                    <div class="col-md-12">
                        <a href="{{ URL::route('admin-shop-product-add') }}"><button class="btn btn-submit btn-padded">Novi proizvod <i class="fa fa-plus"></i></button></a>
                        <a href="{{ URL::route('admin-shop-categories') }}"><button class="btn btn-submit btn-padded">Kategorije proizvoda <i class="fa fa-list-ul"></i></button></a>
                    </div>
                    <div class="col-md-12">
                        <hr>
                        {{ Form::open(['url' => 'admin/shop/category-sort', 'method' => 'GET', 'id' => 'product-sort', 'role' => 'form']) }}
                        <div class="form-group">
                            {{ Form::label('category', 'Sortiranje po kategoriji proizvoda:') }}<br>
                            {{ Form::select('category', ['Izaberi kategoriju proizvoda...' => $product_categories],
                                              $category_id, ['class' => 'selectpicker show-tick', 'data-style' => 'btn-submit', 'title' => 'Odaberi kategoriju proizvoda...', 'data-size' => '5', 'data-live-search' => 'true'])
                            }}
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </section>
        <div class="space"></div>

        @if(count($products_data->all()) > 0)
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
                                    <h3 class="section-header">{{ $item->product_name }}</h3>
                                    <p class="text-center">
                                        <strong class="gray">Status:</strong>
                                        @if($item->product_active == 'yes')
                                            <span class="info-notif">aktivan <i class="fa fa-eye"></i></span>
                                        @else
                                            <span class="danger-notif">neaktivan <i class="fa fa-eye-slash"></i></span>
                                        @endif
                                    </p>
                                    <p class="text-center">
                                        <a href="{{ URL::route('admin-shop-product-show', ['slug' => $item->slug]) }}">
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


    </section>  <!-- end section-inner -->

</section> <!-- end #main -->

{{-- include session notification output --}}
@include('admin.notification')

<script>
    jQuery(document).ready(function(){
        /*
         *   submit form if option changed in dropdown menu
         */
        var selectCategory = $("#category");
        selectCategory.prepend("<option value='' disabled='disabled'>Odaberite kategoriju...</option>").val('');

        selectCategory.change(function(){
            $('#product-sort').submit();
        });


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