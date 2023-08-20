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
                <h3 class="text-center"><strong>Setup Your Game Server</strong></h3>
                <p class="text-center">Fill all form field to go to next step</p>
                <div class="row">
                    <div class="col-md-12 mx-0">
                       	<div class="card-body">
							<ul id="progressbar" class="text-center">
                                <li class="active" id="server"><strong>Game Server</strong></li>
                                <li id="config"><strong>Configuration</strong></li>
                                <li id="webstore"><strong>Webstore</strong></li>
                                <li id="confirm"><strong>Finish</strong></li>
                            </ul>

							<form class="form" action="{{ route('dash.gameserver.create') }}" method="POST">
								@csrf
								<div class="row">
									<div class="col-md-6 col-12">
										<div class="form-group">
											<label>Server Name</label>
											<input type="text" id="name" class="form-control" placeholder="Server Name" name="name" 
											@if($gameserver)
												value="{{ $gameserver->name }}"
											@endif
											>
										</div>
									</div>
									<div class="col-md-6 col-12">
										<div class="form-group">
											<label>Server Game</label>
											<select class="form-select" name="game" id="game">
												<option selected>FiveM</option>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6 col-12">
										<div class="form-group">
											<label>Server IP</label>
											<input type="text" id="ip" class="form-control" placeholder="Server IP" name="ip"
											@if($gameserver)
												value="{{ $gameserver->ip }}"
											@endif
											>
										</div>
									</div>
									<div class="col-md-6 col-12">
										<div class="form-group">
											<label>Server Port</label>
											<input type="number" id="port" class="form-control" placeholder="Server Port" name="port"
											@if($gameserver)
												value="{{ $gameserver->port }}"
											@endif
											>
										</div>
									</div>
								</div>
								<div class="row mt-4">
									<div class="col-6 d-flex justify-content-start">
										<button type="button" class="btn btn-sm btn-primary testConnection">
											<i class="fa fa-signal me-1" aria-hidden="true"></i>
											Test Connection
										</button>
										
										{{-- button loading --}}
										<button type="button" class="btn btn-sm btn-primary testConnectionLoading d-none" disabled>
											<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
											Loading...
										</button>

										{{-- show message --}}
										<div class="d-flex align-items-center ms-2 testConnectionMessageContainer">
											<span class="text-sm text-muted testConnectionMessage"></span>
										</div>
									</div>
									<div class="col-6 d-flex justify-content-end">
										@if($gameserver)
											<a href="{{ route('dash.setup2') }}" class="btn btn-primary me-1 mb-1">
												<i class="fa fa-arrow-right me-1" aria-hidden="true"></i>
												Next
											</a>
										@else
											<button type="submit" class="btn btn-primary me-1 mb-1">
												<i class="fa fa-arrow-right me-1" aria-hidden="true"></i>
												Next
											</button>
										@endif
										<button type="reset" class="btn btn-light-secondary me-1 mb-1">
											<i class="fa fa-ban me-1" aria-hidden="true"></i>
											Reset
										</button>
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
<script>
	// class testConnection
	$(document).on('click', '.testConnection', function() {
		// set loading
		$('.testConnection').addClass('d-none');
		$('.testConnectionLoading').removeClass('d-none');

		let ip = $('#ip').val();
		let port = $('#port').val();

		// check if ip and port is empty
		if(ip == '' || port == '') {
			// set message
			$('.testConnectionMessage').text('Ip dan port tidak boleh kosong.');

			// set loading
			$('.testConnection').removeClass('d-none');
			$('.testConnectionLoading').addClass('d-none');

			return;
		}
		
		// send get request to /ping/{ip}/{port}
		$.get('/ping/' + ip + '/' + port, function (data) {
			// clear data
			ip = ''
			port = ''

			// set message
			$('.testConnectionMessage').text(data.message);

			// set loading
			$('.testConnection').removeClass('d-none');
			$('.testConnectionLoading').addClass('d-none');
		})
	});
</script>

@if($message = Session::get('success'))
	<script>
		window.location.href = "{{ route('dash.setup2') }}";
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
<script src="https://kit.fontawesome.com/b632dc8495.js" crossorigin="anonymous"></script>
<script src="{{ asset('/Assets/js/bootstrap.js') }}"></script>
</body>
</html>