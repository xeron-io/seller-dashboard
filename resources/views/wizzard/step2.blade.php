<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>{{ env('APP_NAME') }} | {{ $title }}</title>
	<link rel="stylesheet" type="text/css" href="{{ asset('/Assets/css/wizzard.css') }}">
	<link rel="stylesheet" href="{{ asset('/Assets/css/main/app.css') }}">
	<link rel="stylesheet" href="{{ asset('/Assets/extensions/filepond/filepond.css') }}" />
	<link
      rel="stylesheet"
      href="{{ asset('/Assets/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.css') }}"
    />
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
                <h3 class="text-center"><strong>Setup Your Webstore</strong></h3>
                <p class="text-center">Fill all form field to go to next step</p>
                <div class="row">
                    <div class="col-md-12 mx-0">
                       	<div class="card-body">
							<ul id="progressbar" class="text-center">
                                <li class="active" id="server"><strong>Game Server</strong></li>
								<li class="active" id="webstore"><strong>Webstore</strong></li>
                                <li id="config"><strong>Configuration</strong></li> 
                                <li id="confirm"><strong>Finish</strong></li>
                            </ul>

							<form class="form" action="{{ route('dash.store.create') }}" method="POST" enctype="multipart/form-data">
								@csrf
								<input type="hidden" name="id_gameserver" value="{{ $gameserver->id }}">
								<div class="row">
									<div class="col-md-6 col-12">
										<div class="form-group">
											<label>Store Name</label>
											@if($store)
												<input type="text" id="name" class="form-control" placeholder="Store Name" name="name" value="{{ $store->name }}" readonly>
											@else
												<input type="text" id="name" class="form-control" placeholder="Store Name" name="name" value="{{ old('name') }}" required>
											@endif
										</div>
									</div>
									<div class="col-md-6 col-12">
										<label>Store Domain: </label>
										<div class="input-group">
											@if($store)
												<input type="text" name="domain" class="form-control" placeholder="Store Domain" value="{{ $store->domain }}" minlength="4" readonly>
												<span class="input-group-text" id="domain">{{ env('STORE_DOMAIN') }}</span>
											@else
												<input type="text" name="domain" class="form-control" placeholder="Store Domain" value="{{ old('domain') }}" minlength="4" required>
												<span class="input-group-text" id="domain">{{ env('STORE_DOMAIN') }}</span>
											@endif
										</div>
									</div>
								</div>
								<div class="col-md-12 col-12">
									<div class="form-group">
										<label>Store Description</label>
										@if($store)
											<textarea type="text" name="description" placeholder="Deskripsi toko" class="form-control" style="height: 100px" minlength="100" readonly>{{ $store->description }}</textarea>
										@else
											<textarea type="text" name="description" placeholder="Deskripsi toko" class="form-control" style="height: 100px" minlength="100" required>{{ old('description') }}</textarea>
										@endif
									</div>
								</div>
								<div class="col-md-12 col-12">
									<label>Store Logo: </label>
									<div class="form-group">
										@if(!$store)
											<input type="file" name="logo" class="form-control" value="{{ old('logo') }}" placeholder="Upload logo toko" accept="image/*" onchange="showPreview(event);" required>
											<p><small class="text-muted">Recommended Resolution: 512x512 | Max 2 MB</small></p>
										@endif
									</div>
								</div>
								<div class="col-lg-12">
									@if($store)
										<img src="{{ $store->logo }}" id="preview" class="img-thumbnail bg-upload" style="height: 200px;width: 200px;">
									@else
										<img src="{{ asset('/Assets/images/image-placeholder.png') }}" id="preview" class="img-thumbnail bg-upload" style="height: 200px;width: 200px;">
									@endif
								</div>
								<div class="row mt-4">
									<div class="col-12 d-flex justify-content-end">
										<a href="{{ route('dash.setup1') }}" class="btn btn-primary me-1 mb-1">
											<i class="fa fa-arrow-left me-1" aria-hidden="true"></i>
											Back
										</a>
										@if($store) 
											<a href="{{ route('dash.setup3') }}" type="submit" class="btn btn-primary me-1 mb-1">
												<i class="fa fa-arrow-right me-1" aria-hidden="true"></i>
												Next
											</a>
										@else
											<button type="submit" class="btn btn-primary me-1 mb-1">
												<i class="fa fa-arrow-right me-1" aria-hidden="true"></i>
												Next
											</button>

											<button type="reset" class="btn btn-light-secondary me-1 mb-1">
												<i class="fa fa-ban me-1" aria-hidden="true"></i>
												Reset
											</button>
										@endif
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
<script src="{{ asset('/Assets/js/app.js') }}"></script>
<script src="{{ asset('/Assets/js/bootstrap.js') }}"></script>
<script src="{{ asset('/Assets/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js') }}"></script>
<script src="{{ asset('/Assets/extensions/filepond/filepond.js') }}"></script>
<script src="{{ asset('/Assets/extensions/toastify-js/src/toastify.js') }}"></script>
<script src="{{ asset('/Assets/js/pages/filepond.js') }}"></script>
<script src="{{ asset('/Assets/extensions/jquery/jquery.min.js') }}"></script>
@if($message = Session::get('success'))
	<script>
		Toastify({
			text: 'Toko anda berhasil dibuat!',
			duration: 3000,
			close: true,
			gravity: "top",
			position: "right",
			backgroundColor: "#4dbd74",
		}).showToast()
		window.location.href = "{{ route('dash.setup3') }}";
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
<script>
	function showPreview(event){
		if(event.target.files.length > 0){
			let src = URL.createObjectURL(event.target.files[0]);
			let preview = document.getElementById("preview");
			preview.src = src;
			preview.style.display = "block";
		}
	}	
</script>
</body>
</html>