@include('adminLayout.header')

<section class="section main-content" id="main">
    <h3 class="section-header">Administracija <i class="fa fa-angle-right"></i> Ponuda <i class="fa fa-angle-right"></i> Nova usluga</h3>

    <section class="section form-section">
        {{ Form::open(['url' => 'admin/ponuda/dodaj', 'id' => 'newOffer', 'files' => true, 'role' => 'form']) }}
        <div class="form-group">
            {{ Form::label('offer_title', 'Naslov ponude:') }}
            {{ Form::text('offer_title', null, ['class' => 'form-input-control', 'placeholder' => 'Naslov ponude', 'id' => 'news_title', 'required']) }}
        </div>
        <div class="form-group">
            {{ Form::label('offer_body', 'Tekst ponude:') }}
            {{ Form::textarea('offer_body', null, ['class' => 'form-input-control', 'placeholder' => 'Tekst ponude', 'id' => 'codeEditor']) }}
        </div>
        <div class="form-group">
            {{ Form::label('offer_images', 'Slike ponude:') }}
            {{ Form::file('offer_images[]', ['multiple' => true, 'class' => 'file', 'data-show-upload' => false, 'data-show-caption' => true, 'id' => 'offer_images', 'accept' => 'image/*']) }}
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-submit btn-padded">Dodaj uslugu <i class="fa fa-check"></i></button>
        </div>
        {{ Form::close() }}
    </section> <!-- end form-section -->

</section> <!-- end #main -->

{{-- include session notification output --}}
@include('admin.notification')

<script>
    $("#offer_images").fileinput({
        showUpload: false,
        layoutTemplates: {
            main1: "{preview}\n" +
            "<div class=\'input-group {class}\'>\n" + "   " +
                "<div class=\'input-group-btn\'>\n" +
                    "{browse}\n" + "" +
                    "{remove}\n" +
                "</div>\n" +
                "{caption}\n" +
            "</div>"
        }
    });
</script>

@include('adminLayout.footer')