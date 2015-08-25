@include('adminLayout.header')

<section class="section main-content" id="main">
    <h4 class="section-header">Administracija <i class="fa fa-angle-right"></i> Ponuda <i class="fa fa-angle-right"></i> Izmjena usluge <i class="fa fa-angle-right"></i> {{ $offer_data->offer_title }}</h4>

    <section class="section form-section">
        {{ Form::open(['url' => 'admin/ponuda/izmjena/'.$offer_data->slug, 'id' => 'newOffer', 'files' => true, 'role' => 'form']) }}
        <div class="form-group">
            {{ Form::label('offer_title', 'Naslov ponude:') }}
            {{ Form::text('offer_title', $offer_data->offer_title, ['class' => 'form-input-control', 'placeholder' => 'Naslov ponude', 'id' => 'news_title', 'required']) }}
        </div>
        <div class="form-group">
            {{ Form::label('offer_body', 'Tekst ponude:') }}
            {{ Form::textarea('offer_body', $offer_data->offer_body, ['class' => 'form-input-control', 'placeholder' => 'Tekst ponude', 'id' => 'codeEditor']) }}
        </div>
        <div class="form-group">
            {{ Form::label('offer_images', 'Dodaj nove slike usluge:') }}
            {{ Form::file('offer_images[]', ['multiple' => true, 'class' => 'file', 'data-show-upload' => false, 'data-show-caption' => true, 'id' => 'offer_images', 'accept' => 'image/*']) }}
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-submit btn-padded">Izmjeni uslugu <i class="fa fa-check"></i></button>
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

    jQuery(window).load(function() {
        /*
         *   BBCode editor returning blank text on refresh, FF bug
         */
        var editor = $("#codeEditor");
        var editorLength = editor.val().length;
        if(editorLength < 1){
            editor.sync();
        }
    });
</script>

@include('adminLayout.footer')