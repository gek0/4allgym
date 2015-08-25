@include('adminLayout.header')

<section class="section main-content" id="main">
    <h3 class="section-header">Administracija <i class="fa fa-angle-right"></i> Web Shop <i class="fa fa-angle-right"></i> Kategorije</h3>

    <section class="section-inner">
        <section class="section form-section">
            {{ Form::open(['url' => 'admin/shop/kategorije', 'role' => 'form', 'id' => 'new-category']) }}
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        {{ Form::label('category_name', 'Ime kategorije:') }}
                        {{ Form::text('category_name', null, ['class' => 'form-input-control', 'placeholder' => 'Ime kategorije', 'id' => 'category_name', 'required']) }}
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-submit btn-padded" id="categorySubmit">Dodaj kategoriju <i class="fa fa-check"></i></button>
            </div>
            {{ Form::close() }}
        </section> <!-- end form-section -->
        <div class="space"></div>

        <h4 class="danger-notif">Brisanjem kategorije se brišu i svi proizvodi u istoj!</h4>

        <table class="table table-bordered table-striped table-hover text-center table-simple-tools" id="category-content-table" data-link-delete="{{ URL::route('admin-shop-categories-deletePost') }}" data-link-edit="{{ URL::route('admin-shop-categories-editPost') }}">
            <thead>
            <tr>
                <td>Ime kategorije</td>
                <td>Izmjena kategorije</td>
                <td>Brisanje kategorije</td>
            </tr>
            </thead>
            <tbody>
            @foreach($categories_data as $cat)
                <tr id="{{ $cat['id'] }}" role="category-content-row">
                    <td>
                        {{ $cat['category_name'] }}
                    </td>
                    <td style="width: 15%;">
                        <button class="btn btn-submit-edit btn-edit-sure"><i class="fa fa-pencil"></i></button>
                    </td>
                    <td style="width: 15%;">
                        <button class="btn btn-submit-delete btn-category-delete-sure"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="space"></div>
        <a href="{{ URL::previous() }}"><button class="btn btn-submit"><i class="fa fa-chevron-left"></i> Povratak</button></a>

    </section>  <!-- end section-inner -->

</section> <!-- end #main -->

{{-- include session notification output --}}
@include('admin.notification')

@include('adminLayout.footer')