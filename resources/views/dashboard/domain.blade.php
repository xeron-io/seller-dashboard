@extends('dashboard.layout.app')

@section('content')
	<section class="section">
		<div class="card">
			<div class="card-header">
				<div class="d-flex justify-content-between">
					<h4 class="card-title">List Custom Domain Yang Terdaftar</h4>
					<button type="button" class="btn btn-primary btn-sm ml-auto" data-bs-toggle="modal" data-bs-target="#createDomain" fdprocessedid="gjh7mli">
						<i class="fa fa-plus"></i> Tambah Domain
					</button>
				</div>
			</div>
			<div class="card-body table-responsive">
				<table class="table" id="table1">
					<thead>
						<tr>
							<th>No</th>
							<th>Toko</th>
							<th>Default Domain</th>
							<th>Custom Domain</th>
							<th>Status</th>
							<th>Opsi</th>
						</tr>
					</thead>
					<tbody>
						@foreach($domain as $item)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $item->name }}</td>
								<td><a href="https://{{ $item->domain }}" target="_blank">{{ $item->domain }}</a></td>
								<td><a href="https://{{ $item->custom_domain }}" target="_blank">{{ $item->custom_domain }}</a></td>
								<td>
									@if($item->status == 'active')
										<span class="badge bg-success">Active</span>
									@elseif($item->status == 'pending')
										<span class="badge bg-warning">Pending</span>
									@else
										<span class="badge bg-danger">{{ ucwords($item->status) }}</span>
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
										<a class="dropdown-item" href="https://{{ $item->custom_domain }}" target="_blank">Lihat</a>
										<hr style="margin: 0;padding: 0;">
										<form action="{{ route('dash.domain.delete', $item->id) }}" method="POST">
											@csrf
											@method('DELETE')
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

	<!-- Modal Create Domain -->
	<div class="modal fade text-left" id="createDomain" tabindex="-1" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel33">
            Tambah Custom Domain
          </h4>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
          </button>
        </div>
        <form action="{{ route('dash.domain.create') }}" method="POST">
					@csrf
          <div class="modal-body">
						{{-- Tutorial Add Custom Domain --}}
						<div class="alert alert-primary" role="alert">
							<h6>Tutorial Add Custom Domain</h6>
							<p>1. Masukkan domain yang ingin anda tambahkan, tanpa http/https (example.com)</p>
							<p>2. Tambahkan CNAME record pada domain anda dengan value <b>dns.xeron.io</b></p>
							<p>3. Tunggu hingga status domain menjadi active</p>
						</div>
						{{-- End Tutorial Add Custom Domain --}}

						<label>Pilih Toko: </label>
            <div class="form-group">
              <select name="id_store" class="form-select">
								@foreach($store as $item)
                	<option value="{{ $item->id }}">{{ $item->name }}</option>
								@endforeach
              </select>
            </div>
						<label>Domain: </label>
            <div class="form-group">
              <input type="text" name="domain" id="domain" class="form-control" placeholder="Insert domain without http/https (example.com)" value="{{ old('domain') }}" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
              <span class="d-sm-block">Close</span>
            </button>
            <button type="submit" class="btn btn-primary ml-1">
              <span class="d-sm-block">Tambah</span>
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