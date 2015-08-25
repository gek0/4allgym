@include('publicLayout.header')

<section id="main">
    <h2 class="section-header"> Web Shop <i class="fa fa-angle-right"></i> Košarica</h2>

    <section class="section section-inner form-section">

        <div class="row">
            <h3>O košarici</h3>
            <p class="contact-detail">Ako imate upit za više proizvoda koje nudimo, dodajte ih u košaricu kako bi se sve zajedno poslalo u jednom upitu prodavaču. Iz košarice se može naknadno brisati.</p>
            <p class="contact-detail">Ispunite i polja sa svojim osobnim podacima kako bi mogli dobiti odgovor u što kraćem roku.</p>
            <p class="contact-detail">Proizvodi se zaprimaju i plaćaju u prostorijama 4allGym-a.</p>
        </div>

        <section id="cart-data-content">
            <h2>Proizvodi trenutno u Vašoj košarici:</h2><hr>

            @if($user_cart)
                {{ Form::open(['url' => 'shop/kosarica', 'role' => 'form', 'id' => 'cart-form']) }}

                <div role="tabpanel" id="cart-content-view">
                    <!-- navigation tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#cart-data" aria-controls="cart-data" role="tab" data-toggle="tab">Sadržaj košarice (<span id="cart-counter">{{ count($user_cart) }}</span>)</a></li>
                        <li role="presentation"><a href="#cart-user-data" aria-controls="cart-user-data" role="tab" data-toggle="tab">Osobni podaci</a></li>
                    </ul>

                    <!-- tab content -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in active" id="cart-data">
                            <div class="space"></div>
                            <div class="row text-center" id="cart-form-container" data-role-link="{{ URL::route('shop-user-cart-deletePost') }}">
                                @foreach($user_cart as $cart_item)
                                    <div id="cartform-item-container-{{ $cart_item->id }}">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                {{ Form::text('cart_index'.$cart_item->id, $cart_item->product_name, ['class' => 'form-input-control', 'id' => 'cart_index'.$cart_item->id, 'required', 'disabled']) }}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <strong>{{ $cart_item->product_price }} kn</strong>
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-submit-delete btn-padded-smaller btn-cart-item-delete" id="{{ $cart_item->id }}">Obriši <i class="fa fa-trash"></i></button>
                                        </div>
                                    </div>
                                @endforeach
                            </div> <!-- end row -->

                            <div class="space text-center">
                                <a href="{{ URL::route('shop-user-cart-flush') }}" class="btn btn-submit-delete btn-padded-smaller">Isprazni košaricu <i class="fa fa-trash"></i></a>
                            </div>
                        </div> <!-- end cart-data tab -->

                        <div role="tabpanel" class="tab-pane fade" id="cart-user-data">
                            <div class="space"></div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {{ Form::label('cart_full_name', 'Ime i prezime:') }}
                                        {{ Form::text('cart_full_name', null, ['class' => 'form-input-control', 'placeholder' => 'Ime i prezime', 'id' => 'cart_full_name', 'required']) }}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {{ Form::label('cart_email', 'E-mail adresa:') }}
                                        {{ Form::email('cart_email', null, ['class' => 'form-input-control', 'placeholder' => 'E-mail adresa', 'id' => 'cart_email', 'required']) }}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {{ Form::label('cart_message_body', 'Dodatna napomena (opcionalno):') }}
                                        {{ Form::textarea('cart_message_body', null, ['class' => 'form-input-control', 'placeholder' => 'Dodatna napomena', 'id' => 'cart_message_body']) }}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group text-center captcha">
                                        {{ Form::captcha() }}
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-submit btn-padded" id="cartSubmit">Pošalji upit <i class="fa fa-paper-plane"></i></button>
                                </div>
                            </div> <!-- end row -->
                        </div> <!-- end cart-user-data tab -->

                    </div>
                </div> <!-- end tabpanel -->
            @else
                <h4>Trenutno nemate ništa u košarici.</h4>
            @endif

        </section> <!-- end section#cart-data -->
    </section> <!-- end form-section -->
</section> <!-- end #main -->

{{-- include session notification output --}}
@include('admin.notification')

@include('publicLayout.footer')