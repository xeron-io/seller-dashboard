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
		<meta property="og:title" content="{{ env('APP_NAME') }} | {{ $title }}n" />
		<meta property="og:url" content="{{ env('APP_URL') }}" />
		<meta property="og:description" content="Monetisasi game server anda secara mudah dan cepat dengan menggunakan layanan kami.">
		<meta property="og:image" content="{{ asset('/Assets/logo.png') }}">
		<meta property="og:type" content="website" />
		<meta property="og:locale" content="id_ID" />
		

		<link rel="stylesheet" href="{{ asset('/Assets/css/main/app.css') }}">
		<link rel="stylesheet" href="{{ asset('/Assets/css/main/app-dark.css') }}">
		<link rel="stylesheet" href="{{ asset('/Assets/css/shared/iconly.css') }}">
		<link rel="stylesheet" href="{{ asset('/Assets/css/pages/datatables.css') }}" />
		<link rel="stylesheet" href="{{ asset('/Assets/css/preloader.css') }}" />
		<link rel="stylesheet" href="{{ asset('/Assets/css/image-upload.css') }}" />
    <link
      rel="stylesheet"
      href="{{ asset('/Assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}"
    />
		<link
      rel="stylesheet"
      href="{{ asset('/Assets/extensions/toastify-js/src/toastify.css') }}"
    />
		<link
      rel="stylesheet"
      href="{{ asset('/Assets/extensions/choices.js/public/assets/styles/choices.css') }}"
    />
		<script src="{{ asset('/Assets/extensions/jquery/jquery.min.js') }}"></script>
		<script src="{{ asset('/Assets/extensions/apexcharts/apexcharts.min.js') }}"></script>
		<script src="{{ asset('/Assets/extensions/toastify-js/src/toastify.js') }}"></script>
		<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<link rel="stylesheet" href="{{ asset('/Assets/extensions/filepond/filepond.css') }}" />
    <link
      rel="stylesheet"
      href="{{ asset('/Assets/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.css') }}"
    />
		<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
		<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
  </head>

	<body>
		<script src="{{ asset('/Assets/js/initTheme.js') }}"></script>

		<div class="preloader">
			<div class="loader"></div>
		</div>

		<div id="app">
			@include('dashboard.layout.sidenav')
			<div id="main">
				@include('dashboard.layout.header')
				<div class="page-content mt-3">
					@yield('content')
				</div>
				@include('dashboard.layout.footer')
			</div>
		</div>
			
		<script src="https://kit.fontawesome.com/b632dc8495.js" crossorigin="anonymous"></script>
		<script src="{{ asset('/Assets/js/bootstrap.js') }}"></script>
		<script src="{{ asset('/Assets/js/app.js') }}"></script>
		<script src="{{ asset('/Assets/js/preloader.js') }}"></script>
		<script src="{{ asset('/Assets/extensions/choices.js/public/assets/scripts/choices.js') }}"></script>
    <script src="{{ asset('/Assets/js/pages/form-element-select.js') }}"></script>
		<script src="{{ asset('/Assets/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js') }}"></script>
		<script src="{{ asset('/Assets/extensions/filepond/filepond.min.js') }}"></script>
		<script src="{{ asset('/Assets/js/pages/filepond.js') }}"></script>
	</body>
</html>
