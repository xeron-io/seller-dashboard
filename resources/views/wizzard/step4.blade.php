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
                <h3 class="text-center"><strong>Congratulations!</strong></h3>
                <p class="text-center">
					You have successfully completed the setup of your store.
				</p>
                <div class="row">
                    <div class="col-md-12 mx-0">
                       	<div class="card-body">
							<ul id="progressbar" class="text-center">
                                <li class="active" id="server"><strong>Game Server</strong></li>
								<li class="active" id="webstore"><strong>Webstore</strong></li>
                                <li class="active" id="config"><strong>Configuration</strong></li> 
                                <li class="active" id="confirm"><strong>Finish</strong></li>
                            </ul>
					   	</div>
                    </div>
                </div>

				<div class="row mb-5">
					<div class="col-lg-6 m-auto text-center">
						<i class="fa fa-check-circle text-success text-center fs-1" aria-hidden="true"></i>
						<p class="text-center mt-3">
							Your webstore is now ready to use. You can now login to your dashboard and start adding products.
						</p>
						<a href="{{ route('dash.overview') }}" class="btn btn-primary">Go to dashboard</a>
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
</body>
</html>