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
									<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe suscipit pariatur enim explicabo obcaecati veritatis cupiditate distinctio commodi! Aliquam quos esse vel illum, sint expedita id ab illo asperiores numquam earum explicabo, laboriosam impedit labore sed tenetur ipsam veritatis et nulla cupiditate pariatur, libero nisi autem optio. Voluptatem, eos dicta?</p>

									<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo nostrum aliquam inventore suscipit veritatis placeat iste maiores voluptatem aliquid recusandae.</p>
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