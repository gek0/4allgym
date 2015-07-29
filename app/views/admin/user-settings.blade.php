@include('adminLayout.header')

<section class="section main-content" id="main">
    <h2 class="section-header">Korisničke postavke</h2>

    <div class="row">
    	<div class="col-md-6">
    		<h4 class="section-header text-center">Postavke profila</h4>

    		<section class="section form-section">
		        {{ Form::open(['url' => 'admin/korisnicke-postavke/spremi', 'role' => 'form', 'id' => 'user-settings']) }}
		        <div class="row">
		            <div class="col-md-6">
		                <div class="form-group">
		                    {{ Form::label('username', 'Korisničko ime:') }}
		                    {{ Form::text('username', $user_data->username, ['class' => 'form-input-control', 'placeholder' => 'Korisničko ime', 'id' => 'username', 'required']) }}
		                </div>
		            </div>
		            <div class="col-md-6">
		                <div class="form-group">
		                    {{ Form::label('email', 'E-mail adresa:') }}
		                    {{ Form::email('email', $user_data->email, ['class' => 'form-input-control', 'placeholder' => 'E-mail adresa', 'id' => 'email', 'required']) }}
		                </div>
		            </div>
		            <div class="col-md-6">
		                <div class="form-group">
		                    {{ Form::label('password', 'Nova lozinka:') }}
		                    {{ Form::password('password', ['class' => 'form-input-control', 'placeholder' => 'Nova lozinka', 'id' => 'password', 'autocomplete' => 'off']) }}
		                </div>
		            </div>
		            <div class="col-md-6">
		                <div class="form-group">
		                    {{ Form::label('password_again', 'Ponovite lozinku:') }}
		                    {{ Form::password('password_again', ['class' => 'form-input-control', 'placeholder' => 'Ponovite lozinku', 'id' => 'password_again', 'autocomplete' => 'off']) }}
		                </div>
		            </div>
		        </div>
		        <div class="text-center">
		            <button type="submit" class="btn btn-submit btn-padded" id="profileSubmit">Spremi postavke <i class="fa fa-check"></i></button>
		        </div>
		        {{ Form::close() }}
		    </section> <!-- end form-section -->
    	</div> <!-- end user-settings form -->

		<div class="col-md-6">
			<h4 class="section-header text-center">Novi korisnik</h4>

    		<section class="section form-section">
		        {{ Form::open(['url' => 'admin/korisnicke-postavke/dodaj', 'role' => 'form', 'id' => 'new-user']) }}
		        <div class="row">
		        	<div class="col-md-6">
			            <div class="form-group">
			                {{ Form::label('newUsername', 'Korisničko ime:') }}
			                {{ Form::text('newUsername', null, ['class' => 'form-input-control', 'placeholder' => 'Korisničko ime', 'id' => 'newUsername', 'required']) }}
			            </div>
		            </div>
		            <div class="col-md-6">
			            <div class="form-group">
			                {{ Form::label('newEmail', 'E-mail adresa:') }}
			                {{ Form::email('newEmail', null, ['class' => 'form-input-control', 'placeholder' => 'E-mail adresa', 'id' => 'newEmail', 'required']) }}
			            </div>
		            </div>
		            <div class="col-md-6">
			            <div class="form-group">
			                {{ Form::label('newPassword', 'Lozinka:') }}
			                {{ Form::password('newPassword', ['class' => 'form-input-control', 'placeholder' => 'Lozinka', 'id' => 'newPassword', 'autocomplete' => 'off', 'required']) }}
			            </div>
		            </div>
		            <div class="col-md-6">
			            <div class="form-group">
			                {{ Form::label('newPasswordAgain', 'Ponovite lozinku:') }}
			                {{ Form::password('newPasswordAgain', ['class' => 'form-input-control', 'placeholder' => 'Ponovite loziku', 'id' => 'newPasswordAgain', 'autocomplete' => 'off',  'required']) }}
			            </div>
		            </div>
		        </div>
		        <div class="text-center">
		            <button type="submit" class="btn btn-submit btn-padded" id="newProfileSubmit">Dodaj korisnika <i class="fa fa-check"></i></button>
		        </div>
		        {{ Form::close() }}
		    </section> <!-- end form-section -->
    	</div> <!-- end new-user form -->
    </div> <!-- end row -->

	<div class="space"></div>
	<div class="row">
		<div class="col-md-12 text-center">
			<h4 class="section-header text-center">Lista aktivnih korisnika</h4>

			<section class="section form-section">
				<table class="table table-bordered table-hover text-center table-simple-tools" id="user-list-table" data-link-delete="{{ URL::route('admin-user-settings-delete') }}">
					<thead>
					<tr>
						<td>Korisničko ime</td>
						<td>E-mail korisnika</td>
						<td>Zadnja izmjena</td>
						<td>Brisanje korisnika</td>
					</tr>
					</thead>
					<tbody>
					@foreach($all_users_data as $user)
						<tr id="{{ $user['id'] }}" role="user-content-row">
							<td>{{ $user['username'] }}</td>
							<td>{{ $user['email'] }}</td>
							<td>
								<time datetime="{{ date('d.m.Y. H:i', strtotime($user['updated_at'])) }}">{{ date('d.m.Y. \u H:i:s', strtotime($user['updated_at'])) }}</time>
							</td>
							<td>
								<button class="btn btn-submit-delete btn-delete-sure"><i class="fa fa-trash"></i></button>
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</section> <!-- end form-section -->
		</div> <!-- end user-list -->
	</div> <!-- end row -->

</section> <!-- end #main -->

{{-- include session notification output --}}
@include('admin.notification')

@include('adminLayout.footer')