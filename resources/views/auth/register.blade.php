<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ env('APP_NAME') }} | {{ $title }}</title>
		<link rel="icon" type="image/x-icon" href="{{ asset('/Assets/favicon.ico') }}">

		{{-- SEO TAGS --}}
		<meta name="title" content="{{ env('APP_NAME') }} | {{ $title }}" />
		<meta name="description" content="Monetisasi game server anda secara mudah dan cepat dengan menggunakan layanan kami." />
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<meta content='Monetisasi game server anda secara mudah dan cepat dengan menggunakan layanan kami.' name='keywords' />
		<meta name="robots" content="index, follow"/>
		<meta property="og:sitename" content="{{ env('APP_NAME') }}" />
		<meta property="og:title" content="{{ env('APP_NAME') }} | {{ $title }}" />
		<meta property="og:url" content="{{ env('APP_URL') }}" />
		<meta property="og:description" content="Monetisasi game server anda secara mudah dan cepat dengan menggunakan layanan kami.">
		<meta property="og:image" content="https://i.imgur.com/Jv9g62b.png">
		<meta property="og:type" content="website" />
		<meta property="og:locale" content="id_ID" />

		<link rel="stylesheet" href="{{ asset('/Assets/css/main/app.css') }}">
		<link rel="stylesheet" href="{{ asset('/Assets/css/pages/auth.css') }}"/>
  </head>

  <body>
    <script src="{{ asset('/Assets/js/initTheme.js') }}"></script>
    <div id="auth">
      <div class="row h-100">
        <div class="col-lg-5 col-12">
					<div id="auth-left">
						<div class="auth-logo mb-5">
							<a href="{{ route('login') }}" class="d-flex">
								<img src="{{ asset('/Assets/logo.png') }}" class="w-10 h-10 my-auto" alt="Logo"/>
								<h5 class="ms-2 my-auto">{{ env('APP_NAME') }}</h5>
							</a>
						</div>
						<h1 class="auth-title">Register.</h1>
						<p class="auth-subtitle mb-4">
							Login menggunakan akun yang telah dibuat sebelumnya.
						</p>

						@if($errors->any())
              <div class="alert alert-danger fade show" role="alert">
                <ul class="mb-0 ps-3">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                   @endforeach
                </ul>
              </div>
            @endif

            {{-- success --}}
            @if(session('success'))
              <div class="alert alert-success fade show" role="alert">
                {{ session('success') }} Tidak menerima email? <a href="{{ route('resend_verify') }}">Kirim ulang</a>.
              </div>
            @endif

						<form method="POST">
							@csrf
							<div class="d-flex align-items-center gap-2">
								<div class="form-group position-relative has-icon-left mb-3">
									<input
										type="text"
										name='firstname'
										class="form-control form-control-md"
										placeholder="Firstname"
										minlength="3"
										value="{{ old('firstname') }}"
										required
									/>
									<div class="form-control-icon">
										<i class="bi bi-person"></i>
									</div>
								</div>
								<div class="form-group position-relative has-icon-left mb-3">
									<input
										type="text"
										name='lastname'
										class="form-control form-control-md"
										placeholder="Lastname"
										minlength="3"
										required
										value="{{ old('lastname') }}"
									/>
									<div class="form-control-icon">
										<i class="bi bi-person"></i>
									</div>
								</div>
							</div>

							<div class="form-group position-relative has-icon-left mb-3">
								<input
									type="email"
									name='email'
									class="form-control form-control-md"
									placeholder="Email"
									required
									value="{{ old('email') }}"
								/>
								<div class="form-control-icon">
									<i class="bi bi-envelope"></i>
								</div>
							</div>

							<div class="form-group position-relative has-icon-left mb-3">
								<input
									type="text"
									name='phone'
									class="form-control form-control-md"
									placeholder="Phone Number"
									required
									minlength="10"
									value="{{ old('phone') }}"
								/>
								<div class="form-control-icon">
									<i class="bi bi-telephone"></i>
								</div>
							</div>

							<div class="form-group position-relative has-icon-left mb-3">
								<input
									type="password"
									name='password'
									class="form-control form-control-md"
									placeholder="Password"
									required
									minlength="8"
									value="{{ old('password') }}"
								/>
								<div class="form-control-icon">
									<i class="bi bi-shield-lock"></i>
								</div>
							</div>

							<div class="form-group position-relative has-icon-left mb-4">
								<input
									type="password"
									name='confirm_password'
									class="form-control form-control-md"
									placeholder="Confirm Password"
									required
									minlength="8"
									value="{{ old('confirm_password') }}"
								/>
								<div class="form-control-icon">
									<i class="bi bi-shield-lock"></i>
								</div>
							</div>
							
							<div class="form-check form-check-md d-flex align-items-center">
								<input
									class="form-check-input me-2"
									type="checkbox"
									value="true"
									name='terms'
									id="flexCheckDefault"
									required
								/>
								<label
									class="form-check-label mt-1 text-md"
									htmlFor="flexCheckDefault"
								>
									Saya menyetujui <a href="#">Syarat & Ketentuan</a> yang berlaku.
								</label>
							</div>
							<button type='submit' class="btn btn-primary btn-block btn-md shadow-md mt-4">
								Register
							</button>
						</form>

						<div class="text-center mt-4 text-sm fs-6">
							<p>
								Sudah memiliki akun?
								<a href="{{ route('login') }}" class="font-bold"> Masuk</a>.
							</p>
						</div>
					</div>
				</div>
				<div class="col-lg-7 d-none d-lg-block">
					<div id="auth-right">
						{{-- <img src="#" alt="Login" class="img-fluid h-100" />  --}}
					</div>
				</div>
			</div>
    </div>
		<script src="https://kit.fontawesome.com/b632dc8495.js" crossorigin="anonymous"></script>
  </body>
</html>
