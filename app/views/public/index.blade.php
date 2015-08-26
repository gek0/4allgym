@include('publicLayout.header')

<section class="section main-content" id="main">
    <h1 class="section-header">Početna</h1>

    <section class="section section-inner">

        <div class="row img-center">
            <div class="col-md-4">
                {{ HTML::image('css/assets/images/offer/homepage_offer_1.png', '4allGym - Ponuda', ['class' => 'img-responsive lazy ani-offer', 'title' => '4allGym - Ponuda']) }}
            </div>
            <div class="col-md-4">
                {{ HTML::image('css/assets/images/offer/homepage_offer_2.png', '4allGym - Ponuda', ['class' => 'img-responsive lazy ani-offer', 'title' => '4allGym - Ponuda']) }}
            </div>
            <div class="col-md-4">
                {{ HTML::image('css/assets/images/offer/homepage_offer_3.png', '4allGym - Ponuda', ['class' => 'img-responsive lazy ani-offer', 'title' => '4allGym - Ponuda']) }}
            </div>

            <div class="col-md-6">
                {{ HTML::image('css/assets/images/offer/homepage_offer_4.png', '4allGym - Ponuda', ['class' => 'img-responsive lazy ani-offer', 'title' => '4allGym - Ponuda']) }}
            </div>
            <div class="col-md-6">
                {{ HTML::image('css/assets/images/offer/homepage_offer_5.png', '4allGym - Ponuda', ['class' => 'img-responsive lazy ani-offer', 'title' => '4allGym - Ponuda']) }}
            </div>
        </div> <!-- end row -->

        <h2 class="text-center block-header">4allGym</h2>
        <h3 class="text-center block-header">Kondicijsko pripremni centar</h3>

        <article id="homepage">
            <blockquote>
                <p>Kondicijsko-pripremni centar "4allGym" novi je fitness centar u Zagrebu, smješten na idealnoj lokaciji između centra i zapadnog dijela grada, na Črnomercu.</p>

                <p>Unutar "4allGyma" treninge će održavati i hrvačka škola braće Žugaj, radi se o svjetskim medaljašima i hrvačima top klase, ali i UFK Novi Zagreb.</p>

                <p>Tako da osim teretane nudimo i treninge u hrvanju, slobodnoj borbi, judu, jiu jitsi, a za naše ženske članove i u pilatesu, aerobiku, antistres boksu.</p>

                <p>Na ulazu u dvoranu koja se rasprostire na 650 kvadratnih metara smješten je i naš "4allBar" u kojem se možete okrijepiti nakon treninga. Za sve članove je osiguran beslplatan parking.</p>
            </blockquote>

            <div class="text-center">
                <a href="{{ URL::to('o-nama') }}">
                    <button class="btn btn-submit"><i class="fa fa-info fa-med"></i> Više o nama</button>
                </a>
            </div>
        </article>

    </section> <!-- end section -->

</section> <!-- end main-content -->

{{-- include session notification output --}}
@include('admin.notification')

@include('publicLayout.footer')