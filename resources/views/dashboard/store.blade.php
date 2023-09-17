@extends('dashboard.layout.app')

@section('content')
	<link	
  	rel="stylesheet"
    href="{{ asset('/Assets/extensions/toastify-js/src/toastify.css') }}"
  />
	<script src="{{ asset('/Assets/extensions/toastify-js/src/toastify.js') }}"></script>
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
							<th>Server</th>
							<th>Theme</th>
							<th>Logo</th>
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
								<td>{{ $item->gameserver->name }}</td>
								<td>{{ $item->theme->name }}</td>
								<td>
									<a href="{{ $item->logo }}" target="_blank">
										lihat
									</a>
								</td>
								<td>
									<a href="https://{{ $item->domain }}" target="_blank">
										{{ $item->domain }}
									</a>
								</td>
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
										<button type="button" id="editBtn" class="dropdown-item" data-bs-toggle="modal" value="{{ $item->id }}" data-bs-target="#editStore" fdprocessedid="gjh7mli">Edit</button>
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
								<label>Pilih Game Server:</label>
								<div class="form-group">
									<select name="id_gameserver" class="form-control" required>
										@foreach($gameserver as $item)
											<option value="{{ $item->id }}">{{ $item->name }}</option>
										@endforeach
									</select>
								</div>
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
									<input type="file" name="logo" class="form-control" value="{{ old('logo') }}" placeholder="Upload logo toko" accept="image/*" onchange="showPreview(event);" required>
									<p><small class="text-muted">Recommended Resolution: 512x512 | Max 2 MB</small></p>
								</div>
								<div class="col-lg-12">
									<img src="{{ asset('/Assets/images/image-placeholder.png') }}" id="preview" class="img-thumbnail bg-upload" style="height: 200px;width: 200px;">
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
								<label>Facebook: (opsional)</label>
								<div class="form-group">
									<input type="url" name="facebook" placeholder="Link facebook toko" class="form-control" value="{{ old('facebook') }}">
								</div>
							</div>
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

	<!-- Modal Edit Store -->
	<div class="modal modal-lg fade text-left" id="editStore" tabindex="-1" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel33">
            Edit Toko
          </h4>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
          </button>
        </div>
        <form action="" method="POST" enctype="multipart/form-data">
					@csrf
					@method('PUT')
          <div class="modal-body">
						<div class="row">
							<div class="col-lg-6 col-12">
								<label>Pilih Game Server:</label>
								<div class="form-group">
									<select name="id_gameserver" class="form-control" required>
										@foreach ($gameserver as $item)
											<option value="{{ $item->id }}">{{ $item->name }}</option>
										@endforeach
									</select>
								</div>
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
									<input type="file" name="logo" class="form-control" value="{{ old('logo') }}" placeholder="Upload logo toko" accept="image/*" onchange="showPreview2(event);">
									<p><small class="text-muted">Recommended Resolution: 512x512 | Max 2 MB</small></p>
								</div>
								<div class="col-lg-12">
									<img src="{{ asset('/Assets/images/image-placeholder.png') }}" id="preview2" class="img-thumbnail bg-upload" style="height: 200px;width: 200px;">
								</div>
							</div>

							<div class="col-lg-6 col-12">
								<label>Youtube: (opsional)</label>
								<div class="form-group">
									<input type="text" name="youtube" placeholder="Link youtube toko" class="form-control" value="{{ old('youtube') }}">
								</div>
								<label>Instagram: (opsional)</label>
								<div class="form-group">
									<input type="text" name="instagram" placeholder="Link instagram toko" class="form-control" value="{{ old('instagram') }}">
								</div>
								<label>Tiktok: (opsional)</label>
								<div class="form-group">
									<input type="text" name="tiktok" placeholder="Link tiktok toko" class="form-control" value="{{ old('tiktok') }}">
								</div>
								<label>Discord: (opsional)</label>
								<div class="form-group">
									<input type="text" name="discord" placeholder="Link discord toko" class="form-control" value="{{ old('discord') }}">
								</div>
								<label>Telepon: (opsional)</label>
								<div class="form-group">
									<input type="text" name="phone" placeholder="Nomor telepon toko" class="form-control" value="{{ old('phone') }}">
								</div>
								<label>Facebook: (opsional)</label>
								<div class="form-group">
									<input type="text" name="facebook" placeholder="Link facebook toko" class="form-control" value="{{ old('facebook') }}">
								</div>
								<label>Api Key:</label>
								<div class="input-group mb-2">
									<input type="text" class="form-control" value="{{ old('api_key') }}" name="api_key" id="api_key" readonly>

									<button class="btn btn-primary" type="button" id="copy">
										<i class="fa fa-clipboard" aria-hidden="true"></i>
									</button>
								</div>
								<label>Private Key:</label>
								<div class="input-group mb-3">
									<input type="text" class="form-control" value="{{ old('private_key') }}" name="private_key" id="private_key" readonly>

									<button class="btn btn-primary" type="button" id="copy2">
										<i class="fa fa-clipboard" aria-hidden="true"></i>
									</button>
								</div>
							</div>
						</div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
              <span class="d-sm-block">Close</span>
            </button>
            <button type="submit" class="btn btn-primary ml-1">
              <span class="d-sm-block">Edit</span>
            </button>
          </div>
        </form>
      </div>
    </div>
	</div>
	<script>
		$(document).on('click', '#editBtn', function(){
      const url = '/store/'
      const id = $(this).val();
      $.get(url + id, function (data) {
        $('#editStore').modal('show');
				$('#editStore form').attr('action', url + id);
				$('#editStore form input[name="name"]').val(data.name);
				$('#editStore form textarea[name="description"]').val(data.description);
				
				// remove xeron.io from domain
				const domain = data.domain.split('.')[0];
				$('#editStore form input[name="domain"]').val(domain);

				// game server
				$('#editStore form select[name="id_gameserver"]').val(data.id_gameserver);

				$('#editStore form input[name="youtube"]').val(data.youtube);
				$('#editStore form input[name="instagram"]').val(data.instagram);
				$('#editStore form input[name="tiktok"]').val(data.tiktok);
				$('#editStore form input[name="discord"]').val(data.discord);
				$('#editStore form input[name="phone"]').val(data.phone);
				$('#editStore form input[name="facebook"]').val(data.facebook);
				$('#editStore form img').attr('src', data.logo);
				$('#editStore form input[name="api_key"]').val(data.api_key);
				$('#editStore form input[name="private_key"]').val(data.private_key);
      }) 
    });
	</script>

	<script>
		function showPreview(event){
			if(event.target.files.length > 0){
				let src = URL.createObjectURL(event.target.files[0]);
				let preview = document.getElementById("preview");
				preview.src = src;
				preview.style.display = "block";
			}
		}

		function showPreview2(event){
			if(event.target.files.length > 0){
				let src = URL.createObjectURL(event.target.files[0]);
				let preview = document.getElementById("preview2");
				preview.src = src;
				preview.style.display = "block";
			}
		}
		
		function showPreview3(event){
			if(event.target.files.length > 0){
				let src = URL.createObjectURL(event.target.files[0]);
				let preview = document.getElementById("preview3");
				preview.src = src;
				preview.style.display = "block";
			}
		}
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
				text: "Semua data yang berhubungan dengan toko ini akan dihapus, seperti produk, stok, transaksi dan lain-lain nya.",
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
	<script>
		const copy = document.querySelector('#copy');
		copy.onclick = function() {
			// select by name
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
		const copy2 = document.querySelector('#copy2');
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
	<script src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>
	<script src="{{ asset('/Assets/js/pages/datatables.js') }}"></script>
@endsection