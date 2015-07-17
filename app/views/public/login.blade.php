@include('publicLayout.header')

    <section class="section main-content" id="main">
        <h1 class="section-header">Prijava</h1>

        <!-- login container -->
        <div class="container" id="login-block">
            <div class="row">
                <div class="loginMainBox">
                    <div class="login-box clearfix">
                        <div class="login-logo">
                            {{ HTML::image('css/assets/images/logo_login.png', 'Logo', ['title' => '4allGym', 'class' => 'img-responsive']) }}
                        </div>
                        <hr />
                        <div class="login-form">
                            {{ Form::open(['url' => 'login', 'role' => 'form', 'id' => 'adminLogin']) }}
                            <div class="form-group-login">
                                {{ Form::label('username', 'Korisničko ime:') }}
                                {{ Form::text('username', null, ['class' => 'form-input-control', 'placeholder' => 'Korisničko ime', 'id' => 'username', 'required']) }}
                            </div>
                            <div class="form-group-login">
                                {{ Form::label('password', 'Lozinka:') }}
                                {{ Form::password('password', ['class' => 'form-input-control', 'placeholder' => 'Lozinka', 'id' => 'password', 'required']) }}
                            </div>
                            <div class="form-group-login text-center">
                                <div class="checkbox checkbox-submit">
                                    {{ Form::checkbox('rememberMe', 1, true, ['id' => 'rememberMe']) }}
                                    {{ Form::label('rememberMe', 'Zapamti me?', ['class' => 'checkbox-inline', 'id' => 'check-adjust', 'checked']) }}
                                </div>
                            </div><br>
                            <div class="text-center">
                                <button type="submit" class="btn btn-submit btn-padded" id="loginSubmit">Prijava <i class="fa fa-sign-in"></i></button>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end login container -->

    </section> <!-- end main-content -->

</div> <!-- end #inner-wrap -->
</div> <!-- end #outer-wrap -->

<footer>
    <div class="container">
        <p class="text-center">&copy; {{ date('Y') }}, 4allGym<br> Design and code by <a href="https://github.com/gek0" target="_blank">Matija</a></p>
    </div>
</footer>

<!-- scripts -->
{{ HTML::script('js/jquery.min.js', ['charset' => 'utf-8']) }}
{{ HTML::script('js/bootstrap.min.js', ['charset' => 'utf-8']) }}
<script>
    jQuery(document).ready(function() {
        $("#adminLogin").submit(function (event) {
            event.preventDefault();

            //disable button click and show loader
            $('button#loginSubmit').addClass('disabled');
            $('#adminLoginLoad').css('visibility', 'visible').fadeIn();

            //get input fields values
            var values = {};
            $.each($(this).serializeArray(), function (i, field) {
                values[field.name] = field.value;
            });
            var token = $('#adminLogin > input[name="_token"]').val();

            //user output
            var outputMsg = $('#outputMsg');
            var errorMsg = "";

            $.ajax({
                type: 'post',
                url: $(this).attr('action'),
                dataType: 'json',
                headers: {'X-CSRF-Token': token},
                data: {_token: token, formData: values},
                success: function (data) {
                    //check status of validation and query
                    if (data.status === 'success') {
                        //enable button click and hide loader
                        $('button#loginSubmit').removeClass('disabled');
                        $('#adminLoginLoad').css('visibility', 'hidden').fadeOut();

                        //redirect to intended page
                        window.location = "<?php echo $intended_url; ?>";
                    }
                    else {
                        errorMsg = '<h3>' + data.errors + '</h3>';
                        outputMsg.append(errorMsg).addClass('warningNotif').slideDown();

                        //timer
                        var numSeconds = 3;
                        function countDown(){
                            numSeconds--;
                            if(numSeconds == 0){
                                clearInterval(timer);
                            }
                            $('#notificationTimer').html(numSeconds);
                        }
                        var timer = setInterval(countDown, 1000);

                        function restoreNotification(){
                            outputMsg.fadeOut(1000, function(){
                                //enable button click and hide loader
                                $('button#loginSubmit').removeClass('disabled');
                                $('#adminLoginLoad').css('visibility', 'hidden').fadeOut();

                                setTimeout(function () {
                                    outputMsg.empty().attr('class', 'notificationOutput');
                                }, 1000);
                            });
                        }

                        //hide notification if user clicked
                        $('#notifTool').click(function(){
                            restoreNotification();
                        });

                        setTimeout(function () {
                            restoreNotification();
                        }, numSeconds * 1000);
                    }
                }
            });

            return false;
        });
    });
</script>

</body>
</html>