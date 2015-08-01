@include('adminLayout.header')

<section class="section main-content" id="main">
    <h3 class="section-header">Administracija <i class="fa fa-angle-right"></i> Portal <i class="fa fa-angle-right"></i> Nova vijest</h3>

    <section class="section form-section">
        {{ Form::open(['url' => 'admin/portal/dodaj', 'id' => 'newNews', 'files' => true, 'role' => 'form']) }}
        <div class="form-group">
            {{ Form::label('news_title', 'Naslov vijesti:') }}
            {{ Form::text('news_title', null, ['class' => 'form-input-control', 'placeholder' => 'Naslov vijesti', 'id' => 'news_title', 'required']) }}
        </div>
        <div class="form-group">
            {{ Form::label('news_body', 'Tekst vijesti:') }}
            {{ Form::textarea('news_body', null, ['class' => 'form-input-control', 'placeholder' => 'Tekst vijesti', 'id' => 'codeEditor']) }}
        </div>
        <div class="form-group">
            {{ Form::label('news_images', 'Slike vijesti:') }}
            {{ Form::file('news_images[]', ['multiple' => true, 'class' => 'file', 'data-show-upload' => false, 'data-show-caption' => true, 'id' => 'news_images', 'accept' => 'image/*']) }}
        </div>
        <div class="form-group">
            {{ Form::label('news_tags', 'Tagovi vijesti: ("Enter" za unos taga)') }}
            {{ Form::select('tags[]', [], null, ['placeholder' => 'Tagovi vijesti', 'multiple' => 'true', 'id' => 'news_tags', 'data-role' => 'tagsinput']) }}
        </div>

        <button class="btn btn-submit" id="toogle-tags-collection">Lista postojećih tagova <i class="fa fa-chevron-down"></i></button>
        <div class="form-group text-center" id="tags-collection">
            <ul class="tags">
                @if($tag_collection->count() > 0)
                    <h4>Klik na tag za odabir:</h4>
                    <ul class="tags">
                        @foreach($tag_collection as $tag)
                            <li>{{ $tag->tag }}</li>
                        @endforeach
                    </ul>
                @else
                    <h4>Trenutno nema tagova.</h4>
                @endif
            </ul>
        </div><hr>

        <div class="text-center">
            <button type="submit" class="btn btn-submit btn-padded">Objavi vijest <i class="fa fa-check"></i></button>
        </div>
        {{ Form::close() }}
    </section> <!-- end form-section -->

</section> <!-- end #main -->

{{-- include session notification output --}}
@include('admin.notification')

<script>
    $("#news_images").fileinput({
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