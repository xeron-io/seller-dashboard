@extends('dashboard.layout.app')

@section('content')
	<section class="section">
		<div class="row">
			<div class="col-lg-3">
				<div class="form-group">
					<select name="filter_store" id="filter_store" class="form-select border-0 py-2 px-3">
						<option value="">- Semua Toko -</option>
						@foreach($store as $item)
							<option value="{{ $item['store_name'] }}">{{ $item['store_name'] }}</option>
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
					<button type="button" class="btn btn-primary btn-sm ml-auto" data-bs-toggle="modal" data-bs-target="#createStore" fdprocessedid="gjh7mli">
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
							<th>Deskripsi</th>
							<th>Kategori</th>
							<th>Toko</th>
							<th>Stok</th>
							<th>Gambar</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						@foreach($product as $item)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $item['product_name'] }}</td>
								<td>{{ Str::substr($item['product_description'], 0, 50) . '...' }}</td>
								<td>{{ $item['category']['category_name'] }}</td>
								<td>{{ $item['store']['store_name'] }}</td>
								<td>
									<span class="badge bg-success">0</span>
								</td>
								<td>
									<a href="{{ $item['product_image'] }}" target="_blank">
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
										<button type="button" id="editBtn" class="dropdown-item" data-bs-toggle="modal" value="{{ $item['id_product'] }}" data-bs-target="#editProduct" fdprocessedid="gjh7mli">Edit</button>
										<hr style="margin: 0;padding: 0;">
										<form action="{{ route('dash.product.delete', $item['id_product']) }}">
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

	<!-- Modal Create Category -->
	<div class="modal fade text-left" id="createStore" tabindex="-1" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
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
						<label>Upload Gambar: </label>
						<div class="form-group">
              <input type="file" name="product_image" class="form-control" placeholder="Upload gambar produk" value="{{ old('product_image') }}" accept="image/*" onchange="showPreview(event);" required>
            </div>
						<div class="col-lg-6 mb-3">
							<img src="{{ asset('/Assets/images/image-placeholder.png') }}" id="preview" class="img-thumbnail bg-upload">
						</div>
            <label>Pilih Kategory: </label>
            <div class="form-group">
              <select name="id_category" class="form-select">
								@foreach($category as $item)
                	<option value="{{ $item['id_category'] }};{{ $item['store']['id_store'] }}">{{ $item['category_name'] }} ({{ $item['store']['store_name'] }})</option>
								@endforeach
              </select>
            </div>
						<label>Nama Produk: </label>
            <div class="form-group">
              <input type="text" name="product_name" class="form-control" placeholder="Nama produk" value="{{ old('product_name') }}" minlength="4" required>
            </div>
						<label>Deskripsi Produk: </label>
            <div class="form-group">
              <textarea type="text" name="product_description" placeholder="Deskripsi produk" class="form-control" style="height: 100px" value="{{ old('product_description') }}" minlength="100" required></textarea>
            </div>
						<label>Harga Produk: </label>
            <div class="form-group">
              <input type="number" name="product_price" class="form-control" placeholder="Harga produk" value="{{ old('product_price') }}" min="5000" required>
            </div>
						<label>Min Quantity: </label>
            <div class="form-group">
              <input type="number" name="min_quantity" class="form-control" placeholder="Minimal Kuantitas" value="1" min="1" required>
							<p><small class="text-muted">Minimal kuantitas adalah jumlah minimal produk yang dapat dibeli dalam satu kali transaksi</small></p>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
              <i class="bx bx-x d-block d-sm-none"></i>
              <span class="d-none d-sm-block">Close</span>
            </button>
            <button type="submit" class="btn btn-primary ml-1">
              <i class="bx bx-check d-block d-sm-none"></i>
              <span class="d-none d-sm-block">Tambah</span>
            </button>
          </div>
        </form>
      </div>
    </div>
	</div>

	<!-- Modal Edit Category -->
	<div class="modal fade text-left" id="editProduct" tabindex="-1" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
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
						<label>Upload Gambar: </label>
						<div class="form-group">
              <input type="file" name="product_image" class="form-control" placeholder="Upload gambar produk" value="{{ old('product_image') }}" accept="image/*" onchange="showPreview2(event);">
            </div>
						<div class="col-lg-6 mb-3">
							<img src="{{ asset('/Assets/images/image-placeholder.png') }}" id="preview2" class="img-thumbnail bg-upload">
						</div>
            <label>Pilih Kategory: </label>
            <div class="form-group">
              <select name="id_category" class="form-select">
								@foreach($category as $item)
                	<option value="{{ $item['id_category'] }};{{ $item['store']['id_store'] }}">{{ $item['category_name'] }} ({{ $item['store']['store_name'] }})</option>
								@endforeach
              </select>
            </div>
						<label>Nama Produk: </label>
            <div class="form-group">
              <input type="text" name="product_name" class="form-control" placeholder="Nama produk" value="{{ old('product_name') }}" minlength="4" required>
            </div>
						<label>Deskripsi Produk: </label>
            <div class="form-group">
              <textarea type="text" name="product_description" placeholder="Deskripsi produk" class="form-control" style="height: 100px" value="{{ old('product_description') }}" minlength="100" required></textarea>
            </div>
						<label>Harga Produk: </label>
            <div class="form-group">
              <input type="number" name="product_price" class="form-control" placeholder="Harga produk" value="{{ old('product_price') }}" min="5000" required>
            </div>
						<label>Min Quantity: </label>
            <div class="form-group">
              <input type="number" name="min_quantity" class="form-control" placeholder="Minimal Kuantitas" value="1" min="1" required>
							<p><small class="text-muted">Minimal kuantitas adalah jumlah minimal produk yang dapat dibeli dalam satu kali transaksi</small></p>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
              <i class="bx bx-x d-block d-sm-none"></i>
              <span class="d-none d-sm-block">Close</span>
            </button>
            <button type="submit" class="btn btn-primary ml-1">
              <i class="bx bx-check d-block d-sm-none"></i>
              <span class="d-none d-sm-block">Edit</span>
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
		$(document).on('click', '#editBtn', function(){
      const url = "/product/";
      const productID = $(this).val();
      $.get(url + productID, function (data) {
        $('#editProduct').modal('show');
				$('#editProduct form').attr('action', url + productID);
				$('#editProduct form input[name="product_name"]').val(data.product_name);
				$('#editProduct form input[name="product_price"]').val(data.product_price);
				$('#editProduct form textarea[name="product_description"]').val(data.product_description);
				$('#editProduct form input[name="min_quantity"]').val(data.min_quantity);
				$('#editProduct form input[name="id_category"]').val(data.id_category + ';' + data.id_store);
				$('#editProduct form img').attr('src', data.product_image);
      }) 
    });
	</script>
	
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