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
			<div class="col-lg-2">
				<button type="button" class="btn btn-primary" id="filterBtn">Tampilkan</button>
			</div>
		</div>
	</section>
	<section class="section">
		<div class="card">
			<div class="card-header">
				<div class="d-flex justify-content-between">
					<h4 class="card-title">Daftar Voucher Belum Expire</h4>
					<button type="button" class="btn btn-primary btn-sm ml-auto" data-bs-toggle="modal" data-bs-target="#createStore" fdprocessedid="gjh7mli">
						<i class="fa fa-plus"></i> Tambah Voucher
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
							<th>Kode</th>
							<th>Tipe</th>
							<th>Nominal</th>
							<th>Expire At</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						@foreach($voucher as $item)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $item['product']['product_name'] }}</td>
								<td>{{ $item['store']['store_name'] }}</td>
								<td>
									<span class="badge bg-success">{{ $item['coupon_code'] }}</span>
								</td>
								<td>{{ $item['coupon_type'] }}</td>
								<td>{{ $item['coupon_amount'] }}</td>
								<td>{{ date('d-m-Y H:i:s', strtotime($item['coupon_expired_at'])) }}</td>
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
										<button type="button" id="editBtn" class="dropdown-item" data-bs-toggle="modal" value="{{ $item['id_coupon'] }}" data-bs-target="#editStore" fdprocessedid="gjh7mli">Edit</button>
										<hr style="margin: 0;padding: 0;">
										<form action="{{ route('dash.voucher.delete', $item['id_coupon']) }}">
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
					<h4 class="card-title">Daftar Voucher Expired</h4>
				</div>
			</div>
			<div class="card-body table-responsive">
				<table class="table" id="table1">
					<thead>
						<tr>
							<th>No</th>
							<th>Produk</th>
							<th>Toko</th>
							<th>Kode</th>
							<th>Tipe</th>
							<th>Nominal</th>
							<th>Expire At</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						@foreach($voucher_expire as $item)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $item['product']['product_name'] }}</td>
								<td>{{ $item['store']['store_name'] }}</td>
								<td>
									<span class="badge bg-success">{{ $item['coupon_code'] }}</span>
								</td>
								<td>{{ $item['coupon_type'] }}</td>
								<td>{{ $item['coupon_amount'] }}</td>
								<td>{{ date('d-m-Y H:i:s', strtotime($item['coupon_expired_at'])) }}</td>
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
										<button type="button" id="editBtn" class="dropdown-item" data-bs-toggle="modal" value="{{ $item['id_coupon'] }}" data-bs-target="#editStore" fdprocessedid="gjh7mli">Edit</button>
										<hr style="margin: 0;padding: 0;">
										<form action="{{ route('dash.voucher.delete', $item['id_coupon']) }}">
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

	<!-- Modal Create Voucher -->
	<div class="modal fade text-left" id="createStore" tabindex="-1" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel33">
            Tambah Voucher
          </h4>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
          </button>
        </div>
        <form action="{{ route('dash.voucher.create') }}" method="POST">
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
						<label>Kode Voucher: </label>
						<div class="form-group">
							<div class="input-group mb-1">
								<button class="btn btn-sm btn-primary" type="button" id="generateBtn">
									Generate
								</button>
								<input type="text" class="form-control" name="coupon_code" id="voucher_code" oninput="this.value = this.value.toUpperCase()">
							</div>
							<p><small class="text-muted">Kode voucher digunakan sebagai identitas voucher yang akan digunakan oleh pelanggan saat proses checkout.</small></p>
						</div>
						<label>Tipe Voucher: </label>
            <div class="form-group">
              <select name="coupon_type" class="form-select mb-1">
                <option value="percent">Percent</option>
								<option value="fixed">Fixed</option>
              </select>
							<p><small class="text-muted">
								- Percent: Voucher akan mengurangi harga produk dengan persentase yang ditentukan<br />
								- Fixed: Voucher akan mengurangi harga produk dengan nominal yang tetap	
							</small></p>
            </div>
						<label>Nominal Voucher: </label>
            <div class="form-group">
              <input type="number" name="coupon_amount" class="form-control mb-1">
							<p><small class="text-muted">
								Contoh: <br />
								- Jika tipe voucher adalah percent dan nominal voucher adalah 10, maka harga produk akan dikurangi 10%<br />
								- Jika tipe voucher adalah fixed dan nominal voucher adalah 10000, maka harga produk akan dikurangi 10000	
							</small></p>
            </div>
						<label>Tanggal Expire: </label>
            <div class="form-group">
              <input type="datetime-local" name="coupon_expire" class="form-control mb-1">
							<p><small class="text-muted">Tanggal expire digunakan untuk menentukan batas waktu penggunaan voucher. Jika voucher tidak digunakan sebelum tanggal expire, maka voucher akan otomatis terhapus</small></p>
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

	<!-- Modal Edit Voucher -->
	<div class="modal fade text-left" id="editStore" tabindex="-1" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel33">
            Edit Voucher
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
              <select name="id_product" class="form-select" required>
								@foreach($product as $item)
                	<option value="{{ $item['id_product'] }};{{ $item['store']['id_store'] }}">{{ $item['product_name'] }} ({{ $item['store']['store_name'] }})</option>
								@endforeach
              </select>
            </div>
						<label>Kode Voucher: </label>
						<div class="form-group">
							<div class="input-group mb-1">
								<button class="btn btn-sm btn-primary" type="button" id="generateBtn">
									Generate
								</button>
								<input type="text" class="form-control" name="coupon_code" id="voucher_code" oninput="this.value = this.value.toUpperCase()" required>
							</div>
							<p><small class="text-muted">Kode voucher digunakan sebagai identitas voucher yang akan digunakan oleh pelanggan saat proses checkout.</small></p>
						</div>
						<label>Tipe Voucher: </label>
            <div class="form-group">
              <select name="coupon_type" class="form-select mb-1" required>
                <option value="percent">Percent</option>
								<option value="fixed">Fixed</option>
              </select>
							<p><small class="text-muted">
								- Percent: Voucher akan mengurangi harga produk dengan persentase yang ditentukan<br />
								- Fixed: Voucher akan mengurangi harga produk dengan nominal yang tetap	
							</small></p>
            </div>
						<label>Nominal Voucher: </label>
            <div class="form-group">
              <input type="number" name="coupon_amount" class="form-control mb-1" required>
							<p><small class="text-muted">
								Contoh: <br />
								- Jika tipe voucher adalah percent dan nominal voucher adalah 10, maka harga produk akan dikurangi 10%<br />
								- Jika tipe voucher adalah fixed dan nominal voucher adalah 10000, maka harga produk akan dikurangi 10000	
							</small></p>
            </div>
						<label>Tanggal Expire: </label>
            <div class="form-group">
              <input type="datetime-local" name="coupon_expire" class="form-control mb-1" required>
							<p><small class="text-muted">Tanggal expire digunakan untuk menentukan batas waktu penggunaan voucher. Jika voucher tidak digunakan sebelum tanggal expire, maka voucher akan otomatis terhapus</small></p>
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
		$(document).on('click', '#editBtn', function(){
      const url = "/dashboard/voucher/";
      const voucherID = $(this).val();
      $.get(url + voucherID, function (data) {
				const date = new Date(data.coupon_expired_at).toISOString().slice(0, 19).replace('T', ' ').replace('Z', '');
        $('#editStore').modal('show');
				$('#editStore form').attr('action', url + voucherID);
				$('#editStore form input[name=coupon_code]').val(data.coupon_code);
				$('#editStore form select[name=coupon_type]').val(data.coupon_type);
				$('#editStore form input[name=coupon_amount]').val(data.coupon_amount);
				$('#editStore form input[name=coupon_expire]').val(date);
      }) 
    });
	</script>

	<script>
		$(document).on('click', '#generateBtn', function() {
			const code = Math.random().toString(36).substring(2, 5).toUpperCase() + Math.random().toString(36).substring(2, 5).toUpperCase();
			$('#voucher_code').val(code);
		});

		$(document).on('click', '#editStore #generateBtn', function() {
			const code = Math.random().toString(36).substring(2, 5).toUpperCase() + Math.random().toString(36).substring(2, 5).toUpperCase();
			$('#editStore #voucher_code').val(code);
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