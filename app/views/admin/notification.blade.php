@if($errors->has())
    <div class="none" id="errorBag">
        @foreach($errors->all() as $error)
            <h3>{{ $error }}</h3>
        @endforeach
    </div>

    <script>
        jQuery(document).ready(function(){
            catchLaravelNotification('errorBag', 'warningNotif');
        });
    </script>
@endif
@if(Session::has('success'))
    <div class="none" id="successBag">
        <h3>{{ Session::get('success') }}</h3>
    </div>

    <script>
        jQuery(document).ready(function(){
            catchLaravelNotification('successBag', 'successNotif');
        });
    </script>
@endif