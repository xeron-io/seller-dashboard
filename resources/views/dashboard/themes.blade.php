@extends('dashboard.layout.app')

@section('content')
	<section class="section">
		<div class="row">
			<div class="col-lg-3">
				<div class="form-group">
					<select name="filter_store" id="filter_store" class="form-select border-0 py-2 px-3">
						<option value="">- Pilih Toko -</option>
						@foreach($store as $item)
							<option value="{{ $item->id }}">{{ $item->name }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="col-lg-2 mb-3">
				<button type="button" class="btn btn-primary" id="filterBtn">Tampilkan</button>
			</div>
		</div>
	</section>
	<section class="section" id="noStore">
		<div class="row">
			<div class="col-lg-6">
				<div class="card">
					<div class="card-body text-center">
						<div class="text-center">
							<i class="fa fa-question fa-4x text-muted"></i>
							<h6 class="mt-3 text-muted">
								Pilih Toko Anda
							</h6>
							<p class="text-muted">
								Silahkan pilih toko anda untuk mengubah tema yang tersedia.
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	@foreach($store as $data)
		<section class="section mt-3 d-none" id="theme-section-{{ $data->id }}">
			<div class="row">
				@foreach($themes as $theme)
					<div class="col-lg-3 col-12 position-relative">
						<div class="card {{ $theme->id == $data->id_theme ? 'border border-success border-3' : '' }}">
							<div class="card-content">
								<img src="{{ $theme->thumbnail }}" class="card-img-to" style="height: 13rem;width: 100%;border-radius:10px 10px 0px 0px;" alt="singleminded">
								<div class="card-body">
									<h5 class="card-title">{{ $theme->name }}</h5>
									<p class="card-text">{{ $theme->description }}</p>

									{{-- button --}}
									@if($theme->id == $data->id_theme)
										<button class="btn btn-success disabled">Activated</button>
									@else
										<form action="{{ route('dash.themes.activate', $theme->id) }}" method="POST">
											@csrf
											<input type="hidden" name="id_store" value="">
											<button class="btn btn-success" type="submit">Active</button>
										</form>
									@endif
								</div>
							</div>

							@if($theme->id == $data->id_theme)
								<div class="position-absolute me-1 mt-1" style="top: 0;right: 0;">
									<svg
										xmlns="http://www.w3.org/2000/svg"
										xmlns:xlink="http://www.w3.org/1999/xlink"
										aria-hidden="true"
										role="img"
										width="40"
										height="40"
										preserveAspectRatio="xMidYMid meet"
										viewBox="0 0 24 24"
									>
									<path
										d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm5.293 7.293-6 6a.999.999 0 0 1-1.414 0l-3-3a.999.999 0 1 1 1.414-1.414L11 13.586l5.293-5.293a.999.999 0 1 1 1.414 1.414z"
										fill="#4fbe87"
									></path>
									</svg>
								</div>
							@endif
						</div>
					</div>
				@endforeach
			</div>
		</section>
	@endforeach
	
	<script>
		$(document).on('click', '#filterBtn', function(){
			const storeID = $('#filter_store').val();
			if(storeID != ''){
				$.ajax({
					url: '{{ route('dash.themes.filter') }}',
					type: 'POST',
					data: {
						"_token": "{{ csrf_token() }}",
						"id_store": storeID
					},
					success: function(data) {
						$('section[id^="theme-section-"]').addClass('d-none');
						$('#theme-section-'+storeID).removeClass('d-none');
						$('#theme-section-'+storeID+' input[name="id_store"]').val(storeID);
						$('#noStore').addClass('d-none'); 
					}
				});
			} else {
				$('section[id^="theme-section-"]').addClass('d-none');
				$('#noStore').removeClass('d-none');
			}
    });
	</script>

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

	<script>
		function confirm() {
			event.preventDefault();
			let form = event.target.form;
			Swal.fire({
				title: 'Apakah anda yakin?',
				text: "Anda tidak dapat mengembalikan data yang telah dihapus!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#435EBE',
				cancelButtonColor: '#DC3545',
				confirmButtonText: 'Yes, delete it!'
			}).then((result) => {
				if (result.isConfirmed) {
					form.submit();
				}
			})
		}
	</script>
	<script src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>
	<script src="{{ asset('/Assets/js/pages/datatables.js') }}"></script>
@endsection