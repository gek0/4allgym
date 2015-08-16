@include('publicLayout.header')

<section class="section main-content" id="main">
    <h1 class="section-header">O nama</h1>

    <section class="section section-inner">
        <div class="img-center">
            {{ HTML::image('css/assets/images/about_us_4allgym.png', '4allGym - o nama', ['class' => 'img-responsive lazy', 'title' => '4allGym']) }}
        </div>
        <h2 class="text-center block-header">4allGym</h2>
        <h3 class="text-center block-header">Kondicijsko pripremni centar</h3>

        <article id="about-us">
            <blockquote>
                <p>"4allGym" se prostire na 650 kvadrata s ogromnim besplatnim parkingom. Radi se o idealnom mjestu za kondicijsku pripremu sportaša, što profesionalnih što rekreativnih.</p>

                <p>U "4allGymu" nudimo brojne programe, grupne i individualne treninge za sve muške i ženske dobne skupine.</p>

                <p>Osim teretane nudimo programe u cross fitu, antistres boksu, slobodnoj borbi, brazilskoj jiu jitsi, judu, pilatesu, aerobicu, plesu, insanityju i još mnoge druge...
                    Posebno smo ponosni što će u "4allGymu" svoje treninge održavati i hrvačka škola "Braća Žugaj". Nenad i Neven Žugaj su do sada osvajali medalje na svjetskim prvenstvima i nastupili na olimpijskim igrama, radi se o samoj kremi svjetske hrvačke scene.</p>

                <p>Osim braće Žugaj u "4allGym" je preslio i UFK Novi Zagreb. Jedan od najpoznatijih hrvatskih klubova u slobodnoj borbi također će održavati treninge u našem prostoru u kojem je instaliran i pravi kavez za borbu. Svi zainteresirani za amaterski i profesionalni MMA mogu pronaći ono što traže u našem Gymu.</p>

                <p>Nakon napornog treninga možete se opustiti u našem "4allBar-u", u kojem možete osim brojnih osvježavajućih pića i kave, izabrati iz bogate ponude energetskih napitaka i proteina.</p>
            </blockquote>
        </article>

    </section> <!-- end section -->
</section> <!-- end main-content -->

@include('publicLayout.footer')