@include('publicLayout.header')

<section class="section main-content" id="main">
    <h1 class="section-header">Tagovi vijesti</h1>

    <article class="article-container padded">
        <div class="space"></div>

        {{ Form::open(['url' => '', 'id' => 'live-search', 'role' => 'form']) }}
        <div class="row">
            <div class="col-md-5 text-center centered-col">
                <div class="form-group">
                    {{ Form::label('filter', 'Pronaðite tag:') }}
                    {{ Form::text('filter', null, ['class' => 'form-input-control', 'id' => 'filter', 'placeholder' => 'Tag...']) }}
                    <span id="filter-count"></span>
                </div>
            </div>
        </div>
        {{ Form::close() }}

        @if($tags_data->count() > 0)
            <div class="container text-center tags-collection">
                <ul class="tags">
                    @foreach($tags_data as $tag)
                        <a href="{{ URL::to('portal/tag/'.$tag->slug) }}"><li class="marginated-tags">{{ $tag->tag }}</li></a>
                    @endforeach
                </ul>
            </div>
            <div class="space"></div>
        @else
            <div class="text-center">
                Trenutno nema tagova vijesti.
            </div>
            <div class="space"></div>
        @endif

        <div class="text-center padded">
            <a href="{{ URL::to('portal') }}"><button class="btn btn-submit"><i class="fa fa-angle-left fa-med pr-10"></i> Povratak na vijesti</button></a>
        </div>

    </article> <!-- article-container end -->

</section> <!-- end main-content -->

@include('publicLayout.footer')