@extends('dashboard.layout.app')

@section('content')
	<section class="section">
		<div class="row">
			<div class="col-lg-12">
				<div class="alert alert-primary">
					<h4 class="alert-heading">
						Ingin Mengupgrade Akun Anda?
					</h4>
					<p>
						Silahkan klik tombol dibawah ini untuk mengupgrade akun anda menjadi akun premium.
					</p>
					<a href="{{ route('dash.membership') }}" class="btn btn-sm btn-light mt-2 ms-2 text-primary">Upgrade</a>
      	</div>
			</div>
			<div class="col-lg-7 mt-2">
				<div class="card">
					<div class="card-header">
						<div class="d-flex justify-content-between">
							<h4 class="card-title">Edit Profil Anda</h4>
						</div>
					</div>
					<div class="card-body table-responsive">
						<form class="form" method="POST" action="{{ route('dash.profile.save.basic') }}">
							@csrf
							@method('PUT')
							<div class="row">
								<div class="col-md-6 col-12">
									<div class="form-group">
										<label>Firstname: </label>
										<input type="text" name="firstname" placeholder="Firstname" class="form-control" value="{{ $profile['firstname'] }}" minlength="4" required>
									</div>
								</div>
								<div class="col-md-6 col-12">
									<div class="form-group">
										<label>Lastname: </label>
										<div class="input-group mb-3">
											<input type="text" name="lastname" placeholder="Lastname" class="form-control" value="{{ $profile['lastname'] }}" minlength="4" required>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-12">
									<div class="form-group">
										<label>Email: </label>
										<input type="text" name="email" placeholder="Email" class="form-control" value="{{ $profile['email'] }}" minlength="4" required>
									</div>
								</div>
								<div class="col-md-6 col-12">
									<div class="form-group">
										<label>Phone Number: </label>
										<div class="input-group mb-3">
											<input type="text" name="phone" placeholder="Phone Number" class="form-control" value="{{ $profile['phone'] }}" minlength="4" required>
										</div>
									</div>
								</div>
								<div class="col-12 d-flex justify-content-end">
									<button
										type="submit"
										class="btn btn-primary me-1 mb-1"
									>
										Simpan
									</button>
									<button
										type="reset"
										class="btn btn-light-secondary me-1 mb-1"
									>
										Reset
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>

			<div class="col-lg-5 mt-2">
				<div class="card">
					<div class="card-header">
						<div class="d-flex justify-content-between">
							<h4 class="card-title">Edit Password Anda</h4>
						</div>
					</div>
					<div class="card-body table-responsive">
						<form class="form" method="POST" action="{{ route('dash.profile.save.password') }}">
							@csrf
							@method('PUT')
							<div class="row">
								<div class="col-md-12 col-12">
									<div class="form-group">
										<label>Old Password: </label>
										<input type="password" name="old_password" placeholder="Old Password" class="form-control" value="{{ old('old_password') }}" required>
									</div>
								</div>
								<div class="col-md-12 col-12">
									<div class="form-group">
										<label>New Password: </label>
										<input type="password" name="new_password" placeholder="New Password" class="form-control" value="{{ old('new_password') }}" minlength="8" required>
									</div>
								</div>
								<div class="col-md-12 col-12 mb-2">
									<div class="form-group">
										<label>Confirm New Password: </label>
										<input type="password" name="confirm_new_password" placeholder="Confirm New Password" class="form-control" value="{{ old('confirm_new_password') }}" minlength="8" required>
									</div>
								</div>
								<div class="col-12 d-flex justify-content-end">
									<button
										type="submit"
										class="btn btn-primary me-1 mb-1"
									>
										Simpan
									</button>
									<button
										type="reset"
										class="btn btn-light-secondary me-1 mb-1"
									>
										Reset
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	@if($message = Session::get('success'))
		<script>
			Toastify({
				text: '{{ $message }}',
				duration: 3000,
				close: true,
				gravity: "top",
				position: "right",
				backgroundColor: "#4fbe87",
			}).showToast()
		</script>
	@elseif($message = Session::get('errors'))
		@foreach($message->all() as $error)
			<script>
				Toastify({
					text: '{{ $error }}',
					duration: 3000,
					close: true,
					gravity: "top",
					position: "right",
					backgroundColor: "#f46a6a",
				}).showToast()
			</script>
		@endforeach
	@elseif($message = Session::get('api_errors'))
		<script>
			Toastify({
				text: '{{ $message }}',
				duration: 3000,
				close: true,
				gravity: "top",
				position: "right",
				backgroundColor: "#f46a6a",
			}).showToast()
		</script>
	@endif


	<script src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>
	<script src="{{ asset('/Assets/js/pages/datatables.js') }}"></script>
@endsection