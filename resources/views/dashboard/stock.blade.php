@extends('dashboard.layout.app')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

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
			<div class="col-lg-2">
				<button type="button" class="btn btn-primary" id="filterBtn">Tampilkan</button>
			</div>
		</div>
	</section>
	<section class="section">
		<div class="card">
			<div class="card-header">
				<div class="d-flex justify-content-between">
					<h4 class="card-title">Daftar Stok Belum Expired</h4>
					<button type="button" class="btn btn-primary btn-sm ml-auto" data-bs-toggle="modal" data-bs-target="#createStore" fdprocessedid="gjh7mli">
						<i class="fa fa-plus"></i> Tambah Stok
					</button>
				</div>
			</div>
			<div class="card-body table-responsive">
				<table class="table" id="table1">
					<thead>
						<tr>
							<th>No</th>
							<th>Produk</th>
							<th>Toko</th>
							<th>Content</th>
							<th>Expire At</th>
							<th>isUnlimited</th>
							<th>Status</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						@foreach($stock as $item)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $item['product']['product_name'] }}</td>
								<td>{{ $item['store']['store_name'] }}</td>
								<td>{{ Str::substr(strip_tags($item['stock_content']), 0, 30) . '...' }}</td>
								<td>
									{{ date('d-m-Y H:i:s', strtotime($item['stock_expired_at'])) }}
								</td>
								<td>
									<span class="badge bg-warning">{{ $item['isUnlimited'] == 1 ? 'True' : 'False'}}</span>
								</td>
								<td>
									<span class="badge bg-success">{{ $item['store']['status'] }}</span>
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
										<button type="button" id="editBtn" class="dropdown-item" data-bs-toggle="modal" value="{{ $item['id_stock'] }}" data-bs-target="#editStore" fdprocessedid="gjh7mli">Edit</button>
										<hr style="margin: 0;padding: 0;">
										<form action="{{ route('dash.stock.delete', $item['id_stock']) }}">
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

	<section class="section">
		<div class="card">
			<div class="card-header">
				<div class="d-flex justify-content-between">
					<h4 class="card-title">Daftar Stok Expired</h4>
				</div>
			</div>
			<div class="card-body table-responsive">
				<table class="table" id="table1">
					<thead>
						<tr>
							<th>No</th>
							<th>Produk</th>
							<th>Toko</th>
							<th>Content</th>
							<th>Expire At</th>
							<th>isUnlimited</th>
							<th>Status</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						@foreach($stock_expire as $item)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $item['product']['product_name'] }}</td>
								<td>{{ $item['store']['store_name'] }}</td>
								<td>{{ Str::substr(strip_tags($item['stock_content']), 0, 30) . '...' }}</td>
								<td>
									{{ date('d-m-Y H:i:s', strtotime($item['stock_expired_at'])) }}
								</td>
								<td>
									<span class="badge bg-warning">{{ $item['isUnlimited'] == 1 ? 'True' : 'False'}}</span>
								</td>
								<td>
									<span class="badge bg-success">{{ $item['store']['status'] }}</span>
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
										<button type="button" id="editBtn" class="dropdown-item" data-bs-toggle="modal" value="{{ $item['id_stock'] }}" data-bs-target="#editStore" fdprocessedid="gjh7mli">Edit</button>
										<hr style="margin: 0;padding: 0;">
										<form action="{{ route('dash.stock.delete', $item['id_stock']) }}">
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

	<!-- Modal Create Stock -->
	<div class="modal fade text-left" id="createStore" tabindex="-1" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel33">
            Tambah Stok
          </h4>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
          </button>
        </div>
        <form action="{{ route('dash.stock.create') }}" method="POST">
					@csrf
          <div class="modal-body">
            <label>Pilih Produk: </label>
            <div class="form-group">
              <select name="id_product" class="form-select">
								@foreach($product as $item)
                	<option value="{{ $item['id_product'] }};{{ $item['store']['id_store'] }}">{{ $item['product_name'] }} ({{ $item['store']['store_name'] }})</option>
								@endforeach
              </select>
            </div>
						<label>Unlimited: </label>
            <div class="form-group">
              <select name="unlimited" class="form-select">
								<option value="false">False</option>
                <option value="true">True</option>
              </select>
							<p><small class="text-muted">Jika pilihan true, maka stok dapat digunakan berulang kali</small></p>
            </div>
						<label>Tanggal Expire: </label>
            <div class="form-group">
              <input type="datetime-local" name="stock_expire" class="form-control">
							<p><small class="text-muted">Tanggal expire digunakan untuk menentukan batas waktu penggunaan stok. Jika stok tidak digunakan sebelum tanggal expire, maka stok akan otomatis terhapus</small></p>
            </div>
						<label>Content: </label>
						<div class="form-group">
							<div id="editor"></div>
							<input type="hidden" name="stock_content" id="stock_content">
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

	<!-- Modal Edit Stock -->
	<div class="modal fade text-left" id="editStore" tabindex="-1" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel33">
            Tambah Stok
          </h4>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
          </button>
        </div>
        <form action="" method="POST">
					@csrf
					@method('PUT')
          <div class="modal-body">
            <label>Pilih Produk: </label>
            <div class="form-group">
              <select name="id_product" class="form-select">
								@foreach($product as $item)
                	<option value="{{ $item['id_product'] }};{{ $item['store']['id_store'] }}">{{ $item['product_name'] }} ({{ $item['store']['store_name'] }})</option>
								@endforeach
              </select>
            </div>
						<label>Unlimited: </label>
            <div class="form-group">
              <select name="unlimited" class="form-select">
								<option value="false">False</option>
                <option value="true">True</option>
              </select>
							<p><small class="text-muted">Jika pilihan true, maka stok dapat digunakan berulang kali</small></p>
            </div>
						<label>Tanggal Expire: </label>
            <div class="form-group">
              <input type="datetime-local" name="stock_expire" class="form-control">
							<p><small class="text-muted">Tanggal expire digunakan untuk menentukan batas waktu penggunaan stok. Jika stok tidak digunakan sebelum tanggal expire, maka stok akan otomatis terhapus</small></p>
            </div>
						<label>Content: </label>
						<div class="form-group">
							<div id="editor2"></div>
							<input type="hidden" name="stock_content" id="stock_content">
						</div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
              <i class="bx bx-x d-block d-sm-none"></i>
              <span class="d-none d-sm-block">Close</span>
            </button>
            <button type="submit" class="btn btn-primary ml-1">
              <i class="bx bx-check d-block d-sm-none"></i>
              <span class="d-none d-sm-block">Update</span>
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
	</script>

	<script>
		const quill = new Quill('#editor', {
			theme: 'snow'
		});

		quill.on('text-change', function(delta, oldDelta, source) {
			$('#stock_content').val(quill.root.innerHTML);
		});

		const quill2 = new Quill('#editor2', {
			theme: 'snow'
		});

		quill2.on('text-change', function(delta, oldDelta, source) {
			$('#stock_content').val(quill2.root.innerHTML);
		});
	</script>

	<script>
		$(document).on('click', '#editBtn', function(){
      const url = "/dashboard/stock/";
      const stockID = $(this).val();
      $.get(url + stockID, function (data) {
				const date = new Date(data.stock_expired_at).toISOString().slice(0, 19).replace('T', ' ').replace('Z', '');
        $('#editStore').modal('show');
				$('#editStore form').attr('action', url + stockID);
				$('#editStore form select[name=id_product]').val(data.id_product + ';' + data.id_store);
				$('#editStore form input[name=stock_expire]').val(date);
				data.isUnlimited == 1 ? $('#editStore form select[name=unlimited]').val('true') : $('#editStore form select[name=unlimited]').val('false');
				quill2.root.innerHTML = data.stock_content;
				$('#editStore form input[name=stock_content').val(data.stock_content);
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
	<script src="{{ asset('/Assets/extensions/quill/quill.min.js') }}"></script>
@endsection