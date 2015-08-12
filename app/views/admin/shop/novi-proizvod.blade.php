@include('adminLayout.header')

<section class="section main-content" id="main">
    <h3 class="section-header">Administracija <i class="fa fa-angle-right"></i> Ponuda <i class="fa fa-angle-right"></i> Novi proizvod</h3>

    <section class="section-inner">

        <section class="section form-section">
            {{ Form::open(['url' => 'admin/shop/proizvod/dodaj', 'role' => 'form', 'files' => true, 'id' => 'new-product']) }}
            <div class="row text-center">
                <div class="col-md-6">
                    <div class="form-group">
                        {{ Form::label('product_name', 'Ime proizvoda:') }}
                        {{ Form::text('product_name', null, ['class' => 'form-input-control', 'placeholder' => 'Ime proizvoda', 'id' => 'product_name', 'required']) }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        {{ Form::label('product_category', 'Kategorija proizvoda:') }}<br>
                        {{ Form::select('product_category', ['Izaberi kategoriju proizvoda...' => $product_categories],
                                                  null, ['class' => 'selectpicker show-tick', 'data-style' => 'btn-submit btn-padded-smaller', 'data-live-search' => 'true', 'title' => 'Odaberi kategoriju proizvoda...', 'data-size' => '5'])
                        }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        {{ Form::label('product_active', 'Status proizvoda:') }}<br>
                        {{ Form::select('product_active', ['Izaberi status proizvoda...' => ['yes' => 'Aktivan', 'no' => 'Neaktivan']],
                                                  null, ['class' => 'selectpicker show-tick', 'data-style' => 'btn-submit btn-padded-smaller', 'title' => 'Izaberi status proizvoda...', 'data-size' => '5'])
                        }}
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="form-group">
                        {{ Form::label('product_description', 'Opis proizvoda:') }}<br>
                        {{ Form::textarea('product_description', null, ['class' => 'form-input-control', 'placeholder' => 'Opis proizvoda', 'id' => 'product_description', 'required']) }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        {{ Form::label('product_price', 'Cijena proizvoda (npr. 19.99):') }}
                        {{ Form::text('product_price', null, ['class' => 'form-input-control', 'placeholder' => 'Cijena proizvoda', 'id' => 'product_price', 'required']) }}
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        {{ Form::label('image_upload', 'Slika proizvoda:') }}
                        {{ Form::file('product_image', ['class' => 'file', 'data-show-upload' => false, 'data-show-caption' => true, 'id' => 'image_upload', 'accept' => 'image/*']) }}
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="text-center">
                            <button type="submit" class="btn btn-submit btn-padded" id="productSubmit">Dodaj proizvod <i class="fa fa-check"></i></button>
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