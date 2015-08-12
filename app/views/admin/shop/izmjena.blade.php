@include('adminLayout.header')

<section class="section main-content" id="main">
    <h4 class="section-header">Administracija <i class="fa fa-angle-right"></i> Proizvodi <i class="fa fa-angle-right"></i> Izmjena proizvoda <i class="fa fa-angle-right"></i> {{ $product_data->product_name }}</h4>

    <section class="section-inner">
        <section class="section form-section">
            {{ Form::open(['url' => 'admin/shop/proizvod/izmjena', 'role' => 'form', 'files' => true, 'id' => 'edit-product']) }}
            <div class="row text-center">
                <div class="col-md-6">
                    <div class="form-group">
                        {{ Form::label('product_name', 'Ime proizvoda:') }}
                        {{ Form::text('product_name', $product_data->product_name, ['class' => 'form-input-control', 'placeholder' => 'Ime proizvoda', 'id' => 'product_name', 'required']) }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        {{ Form::label('product_category', 'Kategorija proizvoda:') }}<br>
                        {{ Form::select('product_category', ['Izaberi kategoriju proizvoda...' => $product_categories],
                                                  $product_data->category_id, ['class' => 'selectpicker show-tick', 'data-style' => 'btn-submit btn-padded-smaller', 'data-live-search' => 'true', 'title' => 'Odaberi kategoriju proizvoda...', 'data-size' => '5'])
                        }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        {{ Form::label('product_active', 'Status proizvoda:') }}<br>
                        {{ Form::select('product_active', ['Izaberi status proizvoda...' => ['yes' => 'Aktivan', 'no' => 'Sakriven']],
                                                  $product_data->product_active, ['class' => 'selectpicker show-tick', 'data-style' => 'btn-submit btn-padded-smaller', 'title' => 'Izaberi status proizvoda...', 'data-size' => '5'])
                        }}
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="form-group">
                        {{ Form::label('product_description', 'Opis proizvoda:') }}<br>
                        {{ Form::textarea('product_description', $product_data->product_description, ['class' => 'form-input-control', 'placeholder' => 'Opis proizvoda', 'id' => 'product_description', 'required']) }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        {{ Form::label('product_price', 'Cijena proizvoda:') }}
                        {{ Form::text('product_price', $product_data->product_price, ['class' => 'form-input-control', 'placeholder' => 'Cijena proizvoda', 'id' => 'product_price', 'required']) }}
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        {{ Form::label('image_upload', 'Slika proizvoda (ako dodate novu sliku, stara se briše):') }}
                        {{ Form::file('product_image', ['class' => 'file', 'data-show-upload' => false, 'data-show-caption' => true, 'id' => 'image_upload', 'accept' => 'image/*']) }}
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="text-center">
                            {{ Form::hidden('slug', $product_data->slug) }}
                            <button type="submit" class="btn btn-submit btn-padded" id="productSubmit">Izmjeni proizvod <i class="fa fa-check"></i></button>
                        </div>
                    </div>
                </div>
            </div> <!-- end row -->
            {{ Form::close() }}
        </section>

        <div class="space"></div>
        <a href="{{ URL::previous() }}"><button class="btn btn-submit"><i class="fa fa-chevron-left"></i> Povratak</button></a>

    </section>  <!-- end section-inner -->

</section> <!-- end #main -->

{{-- include session notification output --}}
@include('admin.notification')

@include('adminLayout.footer')
