<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>{{ env('APP_NAME') }} | {{ $title }}</title>
	<link rel="stylesheet" type="text/css" href="{{ asset('/Assets/css/wizzard.css') }}">
	<link rel="stylesheet" href="{{ asset('/Assets/css/main/app.css') }}">
	<script src="{{ asset('/Assets/extensions/jquery/jquery.min.js') }}"></script>
	<link
      rel="stylesheet"
      href="{{ asset('/Assets/extensions/toastify-js/src/toastify.css') }}"
    />
	<script src="{{ asset('/Assets/extensions/toastify-js/src/toastify.js') }}"></script>
</head>
<body>
<div class="container-fluid" id="grad1">
    <div class="row justify-content-center mt-0">
        <div class="col-11 col-sm-9 col-md-7 col-lg-6 p-0 mt-3 mb-2">
            <div class="card px-0 pb-0 mt-5 mb-3 py-5">
                <h3 class="text-center"><strong>Configure Your Game Server</strong></h3>
                <p class="text-center">Fill all form field to go to next step</p>
                <div class="row">
                    <div class="col-md-12 mx-0">
                       	<div class="card-body">
							<ul id="progressbar" class="text-center">
                                <li class="active" id="server"><strong>Game Server</strong></li>
								<li class="active" id="webstore"><strong>Webstore</strong></li>
                                <li class="active" id="config"><strong>Configuration</strong></li> 
                                <li id="confirm"><strong>Finish</strong></li>
                            </ul>

							<form class="form" class="text-warning">
								<div class="col-md-12 col-12">
									<label>API Key</label>
									<div class="input-group mb-2">
										<input type="text" class="form-control" value="{{ $store->api_key }}" id="api_key" readonly>

										<button class="btn btn-primary" type="button" id="copy">
											<i class="fa fa-clipboard" aria-hidden="true"></i>
										</button>
									</div>
								</div>

								<div class="col-md-12 col-12">
									<label>Private Key</label>
									<div class="input-group mb-3">
										<input type="text" class="form-control" value="{{ $store->private_key }}" id="private_key" readonly>

										<button class="btn btn-primary" type="button" id="copy2">
											<i class="fa fa-clipboard" aria-hidden="true"></i>
										</button>
									</div>
								</div>
								<div class="row">
									{{-- Tutorial --}}
									<h5 class="mb-2">Cara Mengintegrasikan Webstore dengan Game Server</h5>
									<h6 class="mb-1">● Instalasi Plugin</h6>
									<p class="mb-0">Silahkan download plugin dari link berikut:</p>
									<ul class="ms-4 mb-1">
										<li>FiveM: <a href="https://github.com/xeron-io/fivem-plugin/releases">https://github.com/xeron-io/fivem-plugin/releases</a></li>
										<li>Minecraft: <a href="https://github.com/xeron-io/minecraft-plugin/releases">https://github.com/xeron-io/minecraft-plugin/releases</a></li>
									</ul>
									<h6 class="mb-0 mt-1">Minecraft:</h6>
									<p class="mb-0">Untuk game Minecraft, silahkan ikuti langkah-langkah berikut:</p>
									<p class="mb-0">1. Download plugin dari link yang telah disediakan dan masukkan ke dalam folder <strong>plugins</strong> server anda</p>
									<p class="mb-0">2. Restart server anda dan buka config dari <strong>plugin xeron</strong>.</p>
									<p class="mb-0">3. Isikan  <strong>Api Key & Private Key</strong> sesuai yang terdapat diatas halaman ini.</p>
									<p class="mb-0">4. Restart kembali server anda, agar perubahan dapat  <strong>tersimpan</strong></p>
									<p class="mb-0">5.  <strong>Selesai,</strong> toko anda siap digunakan</p>
									<h6 class="mb-0 mt-2">FiveM:</h6>
									<p class="mb-0">Untuk game FiveM, silahkan ikuti langkah-langkah berikut:</p>
									<p class="mb-0">1. Download plugin dari link yang telah disediakan</p>
									<p class="mb-0">2. Extract file tersebut dan copy ke folder resources pada server FiveM anda.</p>
									<p class="mb-2">3. Rename folder tersebut menjadi <strong>xeron</strong>.</p>
									<h6 class="mb-1">● Konfigurasi Rcon</h6>
									<p class="mb-2">3. Buka file <strong>server.cfg</strong> yang terletak pada root direktori server anda dan tambahkan baris baru berikut: <strong>rcon_password "passwordAnda"</strong>. Ubah password sesuai dengan yang anda inginkan.</p>
									<h6 class="mb-1">● Konfigurasi Config</h6>
									<p class="mb-0">4. Ubah nama file <strong>config.json.example</strong> menjadi <strong>config.json</strong> yang berada pada folder <strong>conf</strong>.</p>
									<p class="mb-0">5. Kemudian buka file tersebut dan isikan <strong>apiKey</strong> & <strong>privateKey</strong> sesuai dengan data yang terdapat diatas halaman ini.</p>
									<p class="mb-0">6. Isikan juga <strong>rconPassword</strong> sesuai dengan password yang anda buat pada langkah ke-3.</p>
									<p class="mb-0">7. Tambahkan baris <strong>ensure xeron</strong> pada file <strong>server.cfg</strong> yang terletak pada root direktori server anda.</p>
									<p class="mb-0">8. Restart server anda.</p>
								</div>
								<div class="row mt-4">
									<div class="col-12 d-flex justify-content-end">
										<a href="{{ route('dash.setup2') }}" class="btn btn-primary me-1 mb-1">
											<i class="fa fa-arrow-left me-1" aria-hidden="true"></i>
											Back
										</a>
										<a href="{{ route('dash.setup4') }}" type="submit" class="btn btn-primary me-1 mb-1">
											<i class="fa fa-arrow-right me-1" aria-hidden="true"></i>
											Next
										</a>
									</div>
								</div>
							</form>
					   	</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://kit.fontawesome.com/b632dc8495.js" crossorigin="anonymous"></script>
<script src="{{ asset('/Assets/js/bootstrap.js') }}"></script>
<script>
	copy.onclick = function() {
		var input = document.querySelector('#api_key');
		input.select();
		document.execCommand('copy');
		input.setSelectionRange(0, 0);

		// show toast
		Toastify({
			text: 'API Key copied to clipboard',
			duration: 3000,
			close: true,
			gravity: "top",
			position: "right",
			backgroundColor: "#4fbe87",
		}).showToast()
	}
</script>
<script>
	copy2.onclick = function() {
		var input = document.querySelector('#private_key');
		input.select();
		document.execCommand('copy');
		input.setSelectionRange(0, 0);

		// show toast
		Toastify({
			text: 'Private Key copied to clipboard',
			duration: 3000,
			close: true,
			gravity: "top",
			position: "right",
			backgroundColor: "#4fbe87",
		}).showToast()
	}
</script>
</body>
</html>