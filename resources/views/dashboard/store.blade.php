@extends('dashboard.layout.app')

@section('content')
	<section class="section">
		<div class="card">
			<div class="card-header">
				<div class="d-flex justify-content-between">
					<h4 class="card-title">Daftar Toko</h4>
					<button type="button" class="btn btn-primary btn-sm ml-auto" data-bs-toggle="modal" data-bs-target="#createStore" fdprocessedid="gjh7mli">
						<i class="fa fa-plus"></i> Create Toko
					</button>
				</div>
			</div>
			<div class="card-body table-responsive">
				<table class="table" id="table1">
					<thead>
						<tr>
							<th>No</th>
							<th>Nama</th>
							<th>Theme</th>
							<th>Domain</th>
							<th>Status</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						@foreach($store as $item)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $item->name }}</td>
								<td>{{ $item->theme->name }}</td>
								<td>
									<a href="https://{{ $item->domain }}">
										{{ $item->domain }}
									</a>
								</td>
								<td>
									@if($item->status == 'active')
										<span class="badge bg-success">Active</span>
									@elseif($item->status == 'pending')
										<span class="badge bg-warning">Pending</span>
									@else
										<span class="badge bg-danger">{{ $item->status }}</span>
									@endif
								</td>
								<td>				
									<button type="button" class="btn btn-sm btn-primary dropdown-toggle me-1"
										id="dropdownMenuButton"
										data-bs-toggle="dropdown"
										aria-haspopup="true"
										aria-expanded="false"
									>
										Opsi
									</button>
									<div
										class="dropdown-menu fade"
										aria-labelledby="dropdownMenuButton"
									>
										<a class="dropdown-item" href="#">Edit</a>
										<hr style="margin: 0;padding: 0;">
										<form action="{{ route('dash.store.delete', $item->id) }}">
											<button type="submit" onclick="confirm()" class="dropdown-item">Delete</button>
										</form>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</section>

	<!-- Modal Create Store -->
	<div class="modal modal-lg fade text-left" id="createStore" tabindex="-1" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel33">
            Create Toko
          </h4>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
          </button>
        </div>
        <form action="{{ route('dash.store.create') }}" method="POST" enctype="multipart/form-data">
					@csrf
          <div class="modal-body">
						<div class="row">
							<div class="col-lg-6 col-12">
								<label>Nama Toko: </label>
								<div class="form-group">
									<input type="text" name="name" placeholder="Nama toko" class="form-control" value="{{ old('name') }}" minlength="4" required>
								</div>
								<label>Deskripsi Toko: </label>
								<div class="form-group">
									<textarea type="text" name="description" placeholder="Deskripsi toko" class="form-control" style="height: 100px" minlength="100" required>{{ old('description') }}</textarea>
								</div>
								<label>Domain: </label>
								<div class="input-group mb-2">
									<input type="text" name="domain" class="form-control" placeholder="Domain toko" value="{{ old('domain') }}" minlength="4" required>
									<span class="input-group-text" id="domain">{{ env('STORE_DOMAIN') }}</span>
								</div>
								<label>Logo Toko: </label>
								<div class="form-group">
									<input type="file" name="logo" class="form-control" value="{{ old('logo') }}" minlength="4" required>
									<p><small class="text-muted">Recommended Resolution: 512x512 | Max 2 MB</small></p>
								</div>
							</div>

							<div class="col-lg-6 col-12">
								<label>Youtube: (opsional)</label>
								<div class="form-group">
									<input type="url" name="youtube" placeholder="Link youtube toko" class="form-control" value="{{ old('youtube') }}">
								</div>
								<label>Instagram: (opsional)</label>
								<div class="form-group">
									<input type="url" name="instagram" placeholder="Link instagram toko" class="form-control" value="{{ old('instagram') }}">
								</div>
								<label>Tiktok: (opsional)</label>
								<div class="form-group">
									<input type="url" name="tiktok" placeholder="Link tiktok toko" class="form-control" value="{{ old('tiktok') }}">
								</div>
								<label>Discord: (opsional)</label>
								<div class="form-group">
									<input type="url" name="discord" placeholder="Link discord toko" class="form-control" value="{{ old('discord') }}">
								</div>
								<label>Telepon: (opsional)</label>
								<div class="form-group">
									<input type="text" name="phone" placeholder="Nomor telepon toko" class="form-control" value="{{ old('phone') }}">
								</div>
							</div>
						</div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
              <i class="bx bx-x d-block d-sm-none"></i>
              <span class="d-none d-sm-block">Close</span>
            </button>
            <button type="submit" class="btn btn-primary ml-1">
              <i class="bx bx-check d-block d-sm-none"></i>
              <span class="d-none d-sm-block">Create</span>
            </button>
          </div>
        </form>
      </div>
    </div>
	</div>
	
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
				title: 'Are you sure?',
				text: "You won't be able to revert this!",
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