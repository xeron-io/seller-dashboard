<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>{{ env('APP_NAME') }} | {{ $title }}</title>
	<link rel="stylesheet" type="text/css" href="{{ asset('/Assets/css/wizzard.css') }}">
	<link rel="stylesheet" href="{{ asset('/Assets/css/main/app.css') }}">
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

							<form class="form" class="text-warning">
								<div class="row">
									<div class="col-md-6 col-12">
										<div class="form-group">
											<label>Server Name</label>
											<input type="text" id="name" class="form-control" placeholder="Server Name" name="name">
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
											<input type="text" id="ip" class="form-control" placeholder="Server IP" name="ip">
										</div>
									</div>
									<div class="col-md-6 col-12">
										<div class="form-group">
											<label>Server Port</label>
											<input type="number" id="port" class="form-control" placeholder="Server Port" name="port">
										</div>
									</div>
								</div>
								<div class="row mt-4">
									<div class="col-6 d-flex justify-content-start">
										<button class="btn btn-sm btn-warning me-1 mb-1">
											<i class="fa fa-wifi me-1" aria-hidden="true"></i>
											Test Connection
										</button>
									</div>
									<div class="col-6 d-flex justify-content-end">
										<button type="submit" class="btn btn-primary me-1 mb-1">
											Next
										</button>
										<button type="reset" class="btn btn-light-secondary me-1 mb-1">
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
<script src="https://kit.fontawesome.com/b632dc8495.js" crossorigin="anonymous"></script>
<script src="{{ asset('/Assets/js/bootstrap.js') }}"></script>
<script src="{{ asset('/Assets/extensions/jquery/jquery.min.js') }}"></script>
</body>
</html>