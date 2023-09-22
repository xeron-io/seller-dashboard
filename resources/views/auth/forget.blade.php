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
						<h1 class="auth-title">Forget Password</h1>
						<p class="auth-subtitle mb-4">
							Masukkan email yang telah terdaftar untuk mereset ulang password anda.
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
                {{ session('success') }}</a>.
              </div>
            @endif

						<form action="{{ route('request_forget_password') }}" method="POST">
							@csrf
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
									<i class="fa fa-envelope-o" aria-hidden="true"></i>
								</div>
							</div>
							<button type="submit" class="btn btn-primary btn-block btn-md shadow-md mt-2">
								Kirim
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
						{{-- <img className='m-auto h-100' src={ilus3}/> --}}
					</div>
				</div>
			</div>
    </div>
		<script src="https://kit.fontawesome.com/b632dc8495.js" crossorigin="anonymous"></script>
  </body>
</html>
