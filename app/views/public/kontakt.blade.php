@include('publicLayout.header')

<section class="section main-content" id="main">
    <h1 class="section-header">Kontakt</h1>

    <section class="section section-inner form-section">
        <div class="row">
            <div class="col-md-4 color-filled">
                <strong><i class="fa fa-map-marker fa-med"></i> Adresa:</strong><br>
                <p class="contact-detail">Ilica 288 (okretište Črnomerec, Ciglane Zagreb)</p><br>
            </div>
            <div class="col-md-4 color-filled">
                <strong><i class="fa fa-phone fa-med"></i> Telefon/Mobitel:</strong><br>
                <p class="contact-detail"><strong>Tel/Mob:</strong> 091/614-0145 Saša</p>
                <p class="contact-detail"><strong>Tel/Mob:</strong> 095/777-7095 Tomo</p>
            </div>
            <div class="col-md-4 color-filled">
                <strong><i class="fa fa-envelope fa-med"></i> E-mail:</strong><br>
                <p class="contact-detail">{{ HTML::mailto(getenv('OWNER_CONTACT_EMAIL')) }}</p><br>
            </div>
        </div>
        <div class="space"></div>

        <div class="row">
            <h3>Kontaktirajte nas</h3>
            <p class="contact-detail">Za sve upite, nejasnoće i slično, kontaktirajte nas preko kontakt forme (<strong>sva polja su obavezna</strong>) ili preko gore navedenih informacija.</p>
            <div class="space"></div>
        </div>

        {{ Form::open(['url' => 'kontakt', 'role' => 'form', 'id' => 'contact-form']) }}
        <div class="row">
            <div class="col-md-12">
                <div class="text-center" id="contact-output">
                    <div class="alert" role="alert" id="contact-output-inner">
                        <div id="contact-output-message"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::label('full_name', 'Ime i prezime:') }}
                    {{ Form::text('full_name', null, ['class' => 'form-input-control', 'placeholder' => 'Ime i prezime', 'id' => 'full_name', 'required']) }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::label('email', 'E-mail adresa:') }}
                    {{ Form::email('email', null, ['class' => 'form-input-control', 'placeholder' => 'E-mail adresa', 'id' => 'email', 'required']) }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::label('subject', 'Naslov poruke:') }}
                    {{ Form::text('subject', null, ['class' => 'form-input-control', 'placeholder' => 'Naslov poruke', 'id' => 'subject', 'required']) }}
                </div>
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('message_body', 'Poruka:') }}
            {{ Form::textarea('message_body', null, ['class' => 'form-input-control', 'placeholder' => 'Poruka', 'id' => 'message_body', 'required']) }}
        </div>
        <div class="form-group text-center captcha">
            {{ Form::captcha() }}
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-submit btn-padded" id="contactSubmit">Pošalji upit <i class="fa fa-paper-plane"></i></button>
        </div>
        {{ Form::close() }}
    </section> <!-- end form-section -->

    <section class="section section-inner">
        <div class="space"></div><hr>
    </section>

    <section id="map">
        <noscript>Morate imati omogućen JavaScript u Vašem internet pregledniku kako bi se prikazala mapa, hvala na razumijevanju.</noscript>
    </section> <!-- end map section -->

</section> <!-- end main-content -->

@include('publicLayout.footer')