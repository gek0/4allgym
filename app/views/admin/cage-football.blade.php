@include('adminLayout.header')

<section class="section main-content" id="main">
    <h2 class="section-header">Cage Football</h2>

    	<section class="section form-section">
		    {{ Form::open(['url' => 'admin/cage-football', 'role' => 'form', 'id' => 'cage-football', 'files' => true]) }}		    
		    <div class="form-group">
		        {{ Form::label('page_title', 'Naslov stranice:') }}
		        {{ Form::text('page_title', $cage_football_data->page_title, ['class' => 'form-input-control', 'placeholder' => 'Naslov stranice', 'id' => 'page_title', 'required']) }}
		    </div>
		    <div class="form-group">
		        {{ Form::label('page_text', 'Tekst stranice:') }}
		        {{ Form::textarea('page_text', $cage_football_data->page_text, ['class' => 'form-input-control', 'placeholder' => 'Tekst stranice', 'id' => 'codeEditor']) }}
		    </div>
		    <div class="form-group">
		        {{ Form::label('cage_football_images', 'Dodaj nove slike:') }}
		        {{ Form::file('cage_football_images[]', ['multiple' => true, 'class' => 'file', 'data-show-upload' => false, 'data-show-caption' => true, 'id' => 'cage_football_images', 'accept' => 'image/*']) }}
		   </div>
		
			{{ Form::hidden('page_uri', Route::currentRouteName()) }}

		    <div class="text-center">
		        <button type="submit" class="btn btn-submit btn-padded">Spremi izmjene <i class="fa fa-check"></i></button>
		    </div>		
		    {{ Form::close() }}
		</section> <!-- end form-section -->

        @if($cage_football_images->count() > 0)
            <section id="image_gallery" data-role-link="{{ URL::route('admin-gallery-image-delete') }}" data-role-primary="{{ URL::route('admin-gallery-image-set-primary') }}">
            <hr>
                <div class="container-fluid">
                    <div class="row padded text-center">
                        <h2>Galerija slika  <small id="image_gallery_counter">{{ $cage_football_images->count() }}</small></h2>
                        @foreach($cage_football_images as $img)
                            <div class="col-lg-3 col-sm-4 col-6 small-marg" id="img-container-{{ $img->id }}">
                                <a href="{{ URL::to('/pages_uploads/'.$img->file_name) }}" data-imagelightbox="gallery-images">
                                    <img data-original="{{ URL::to('/pages_uploads/'.$img->file_name) }}" alt="{{ imageAlt($img->file_name) }}" class="thumbnail img-responsive lazy" />
                                </a>
                                <button id="{{ $img->id }}" class="btn btn-submit-delete btn-delete-gallery-image" title="Brisanje slike {{ $img->file_name }}"><i class="fa fa-trash"></i></button>
                                
                                @if($img->is_primary == 'no')
                                	<button id="{{ $img->id }}" class="btn btn-submit-edit btn-primary-gallery-image" title="Postavi kao primarnu sliku"><i class="fa fa-circle-o"></i></button>
                                @else
                                	<button id="{{ $img->id }}" class="btn btn-submit-edit"><i class="fa fa-check-circle"></i></button>
                                @endif
                            </div>
                            <div class="clearfix visible-xs"></div>
                        @endforeach
                    </div>
                </div>  <!-- end image gallery -->
            </section>
        @endif

</section> <!-- end #main -->

{{-- include session notification output --}}
@include('admin.notification')

<script>
    $("#cage_fooball_images").fileinput({
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