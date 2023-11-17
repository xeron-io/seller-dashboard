@extends('dashboard.layout.app')

@section('content')
	<section class="section">
		<div class="row">
			<div class="col-lg-3">
				<div class="form-group">
					<select name="filter_store" id="filter_store" class="form-select border-0 py-2 px-3">
						<option value="">- Semua Toko -</option>
						@foreach($store as $item)
							<option value="{{ $item->name }}">{{ $item->name }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="col-lg-2 mb-3">
				<button type="button" class="btn btn-primary" id="filterBtn">Tampilkan</button>
			</div>
		</div>
	</section>
	<section class="section">
		<div class="card">
			<div class="card-header">
				<div class="d-flex justify-content-between">
					<h4 class="card-title">Daftar Produk</h4>
					<button type="button" class="btn btn-primary btn-sm ml-auto" data-bs-toggle="modal" data-bs-target="#createProduct" fdprocessedid="gjh7mli">
						<i class="fa fa-plus"></i> Tambah Produk
					</button>
				</div>
			</div>
			<div class="card-body table-responsive">
				<table class="table" id="table1">
					<thead>
						<tr>
							<th>No</th>
							<th>Nama</th>
							<th>Harga</th>
							<th>Deskripsi</th>
							<th>Kategori</th>
							<th>Toko</th>
							<th>Gambar</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						@foreach($product as $item)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $item->name }}</td>
								<td>@currency($item->price)</td>
								<td>{{ Str::limit(strip_tags($item->description), 50) }}</td>
								<td>{{ $item->category->name }}</td>
								<td>{{ $item->store->name }}</td>
								<td>
									<a href="{{ $item->image }}" target="_blank">
										click here
									</a>
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
										<button type="button" id="editBtn" class="dropdown-item" data-bs-toggle="modal" value="{{ $item->id }}" data-bs-target="#editProduct" fdprocessedid="gjh7mli">Edit</button>
										<hr style="margin: 0;padding: 0;">
										<form action="{{ route('dash.product.delete', $item->id) }}">
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

	<!-- Modal Create Product -->
	<div class="modal modal-lg fade text-left" id="createProduct" tabindex="-1" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel33">
            Tambah Produk
          </h4>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
          </button>
        </div>
        <form action="{{ route('dash.product.create') }}" method="POST" enctype="multipart/form-data">
					@csrf
          <div class="modal-body">
            <label>Pilih Kategory: </label>
            <div class="form-group">
              <select name="id_category" class="form-select">
								@foreach($category as $item)
                	<option value="{{ $item->id }}">{{ $item->name }} ({{ $item->store->name }})</option>
								@endforeach
              </select>
            </div>
						<label>Nama Produk: </label>
            <div class="form-group">
              <input type="text" name="name" class="form-control" placeholder="Nama produk" value="{{ old('name') }}" minlength="4" required>
            </div>
						<label>Deskripsi Produk: </label>
            <div class="form-group">
							<div id="editor" style="height: 100px;">{{ strip_tags(old('description')) }}</div>
							<input type="hidden" name="description" id="description" value="{{ old('description') }}">
            </div>
						<label>Harga Produk: </label>
            <div class="form-group">
              <input type="number" name="price" class="form-control" placeholder="Insert product price without dot (.)" value="{{ old('price') }}" min="10000" required>
            </div>
						<label>Ingame Command: </label>
            <div class="input-group">
              <span class="input-group-text" id="basic-addon1">When the product is purchased:</span>
              <input type="text" name="ingame_command" class="form-control" placeholder="Insert ingame command without slash (/)." value="{{ old('ingame_command') }}">
            </div>
						<ul>
							<li><small class="text-muted">FiveM: Gunakan variabel <b>{id}</b> untuk mendapatkan user ingame id</small></li>
							<li><small class="text-muted">Minecraft: Gunakan variabel <b>{username}</b> untuk mendapatkan username</small></li>
						</ul>
						<label>Minimum Empty Slot: (For Minecraft Only)</label>
						<div class="form-group">
							<input type="number" name="min_slot" class="form-control" placeholder="Insert mininum slot players has to empty" value="0" required>
							<p><small class="text-muted">Minimum empty slot adalah berapa banyak minimal slot kosong pada player saat akan redeem transaksi</small></p>
						</div>
						<label>Gambar Produk: </label>
						<div class="form-group">
              <input type="file" name="image" class="form-control" placeholder="Upload gambar produk" value="{{ old('image') }}" accept="image/*" onchange="showPreview(event);" required>
            </div>
						<div class="col-lg-6 mb-3">
							<img src="{{ asset('/Assets/images/image-placeholder.png') }}" id="preview" class="img-thumbnail bg-upload" style="height: 200px;width: 200px;">
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

	<!-- Modal Edit Product -->
	<div class="modal modal-lg fade text-left" id="editProduct" tabindex="-1" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel33">
            Edit Produk
          </h4>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
          </button>
        </div>
        <form action="" method="POST" enctype="multipart/form-data">
					@csrf
					@method('PUT')
          <div class="modal-body">
            <label>Pilih Kategory: </label>
            <div class="form-group">
              <select name="id_category" class="form-select">
								@foreach($category as $item)
                	<option value="{{ $item->id }}">{{ $item->name }} ({{ $item->store->name }})</option>
								@endforeach
              </select>
            </div>
						<label>Nama Produk: </label>
            <div class="form-group">
              <input type="text" name="name" class="form-control" placeholder="Nama produk" value="{{ old('name') }}" minlength="4" required>
            </div>
						<label>Deskripsi Produk: </label>
            <div class="form-group">
							<div id="editor2" style="height: 100px;"></div>
							<input type="hidden" name="description2" id="description">
            </div>
						<label>Harga Produk: </label>
            <div class="form-group">
              <input type="number" name="price" class="form-control" placeholder="Insert product price without dot (.)" value="{{ old('price') }}" min="10000" required>
            </div>
						<label>Ingame Command: </label>
            <div class="input-group">
              <span class="input-group-text" id="basic-addon1">When the product is purchased:</span>
              <input type="text" name="ingame_command" class="form-control" placeholder="Insert ingame command without slash (/)." value="{{ old('ingame_command') }}">
            </div>
						<ul>
							<li><small class="text-muted">FiveM: Gunakan variabel <b>{id}</b> untuk mendapatkan user ingame id</small></li>
							<li><small class="text-muted">Minecraft: Gunakan variabel <b>{username}</b> untuk mendapatkan username</small></li>
						</ul>
						<label>Minimum Empty Slot: (For Minecraft Only)</label>
						<div class="form-group">
							<input type="number" name="min_slot" class="form-control" placeholder="Insert mininum slot players has to empty" value="0" required>
							<p><small class="text-muted">Minimum empty slot adalah berapa banyak minimal slot kosong pada player saat akan redeem transaksi</small></p>
						</div>
						<label>Gambar Produk: </label>
						<div class="form-group">
              <input type="file" name="image" class="form-control" placeholder="Upload gambar produk" value="{{ old('image') }}" accept="image/*" onchange="showPreview2(event);">
            </div>
						<div class="col-lg-6 mb-3">
							<img src="{{ asset('/Assets/images/image-placeholder.png') }}" id="preview2" class="img-thumbnail bg-upload" style="height: 200px;width: 200px;">
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
		$(document).on('click', '#filterBtn', function(){
			const storeName = $('#filter_store').val();
			$('#table1').DataTable().search(storeName).draw();
    });

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
	</script>

	<script>
		var quill = new Quill('#editor', {
			theme: 'snow'
		});

		quill.on('text-change', function(delta, oldDelta, source) {
			document.querySelector("input[name='description']").value = quill.root.innerHTML;
		});
	</script>

	<script>
		var quill2 = new Quill('#editor2', {
			theme: 'snow'
		});

		quill2.on('text-change', function(delta, oldDelta, source) {
			document.querySelector("input[name='description2']").value = quill2.root.innerHTML;
		});
	</script>

	<script>
		$(document).on('click', '#editBtn', function(){
      const url = "/product/";
      const id = $(this).val();
      $.get(url + id, function (data) {
        $('#editProduct').modal('show');
				$('#editProduct form').attr('action', url + id);
				$('#editProduct form input[name="name"]').val(data.name);
				$('#editProduct form input[name="price"]').val(data.price);
				$('#editProduct form input[name="ingame_command"]').val(data.ingame_command);
				$('#editProduct form input[name="min_slot"]').val(data.min_slot);
				$('#editProduct form img').attr('src', data.image);
				$('#editProduct form input[name="description2"]').val(data.description);
				$('#editProduct form select[name="id_category"]').val(data.id_category);
				quill2.root.innerHTML = data.description;
			})
    });
	</script>
	
	<script>
		function confirm() {
			event.preventDefault();
			let form = event.target.form;
			Swal.fire({
				title: 'Apakah anda yakin?',
				text: "Semua data yang berhubungan dengan produk ini akan dihapus, seperti stok, transaksi dan lain-lain nya.",
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