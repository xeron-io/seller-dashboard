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
					<h4 class="card-title">Daftar Voucher Belum Expire</h4>
					<button type="button" class="btn btn-primary btn-sm ml-auto" data-bs-toggle="modal" data-bs-target="#createVoucher" fdprocessedid="gjh7mli">
						<i class="fa fa-plus"></i> Tambah Voucher
					</button>
				</div>
			</div>
			<div class="card-body table-responsive">
				<table class="table" id="table1">
					<thead>
						<tr>
							<th>No</th>
							<th>Toko</th>
							<th>Kode</th>
							<th>Tipe</th>
							<th>Nominal</th>
							<th>Usage</th>
							<th>Expired At</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						@foreach($voucher as $item)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $item->store->name }}</td>
								<td>
									<span class="badge bg-success">{{ $item->code }}</span>
								</td>
								<td>{{ $item->type }}</td>
								<td>{{ $item->amount }}</td>
								<td>
									@php
										$usage = $item->getUsage();
										echo $usage;
									@endphp
								</td>
								<td>{{ $item->expired_at ? date('d-m-Y H:i:s', strtotime($item->expired_at)) : '-' }}</td>
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
										<button type="button" id="editBtn" class="dropdown-item" data-bs-toggle="modal" value="{{ $item->id }}" data-bs-target="#editVoucher" fdprocessedid="gjh7mli">Edit</button>
										<hr style="margin: 0;padding: 0;">
										<form action="{{ route('dash.voucher.delete', $item->id) }}">
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
	<div class="modal fade text-left" id="createVoucher" tabindex="-1" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
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
						<label>Pilih Toko: </label>
            <div class="form-group">
              <select name="id_store" class="form-select" id="id_store">
								@foreach($store as $item)
                	<option value="{{ $item->id }}">{{ $item->name }}</option>
								@endforeach
              </select>
            </div>

						<label>Kode Voucher: </label>
						<div class="form-group">
							<div class="input-group mb-1">
								<button class="btn btn-sm btn-primary" type="button" id="generateBtn">
									Generate
								</button>
								<input type="text" class="form-control" name="code" id="code" oninput="this.value = this.value.toUpperCase()" required>
							</div>
							<p><small class="text-muted">Kode voucher digunakan sebagai identifier voucher yang akan digunakan oleh pelanggan saat proses checkout.</small></p>
						</div>

						<label>Tipe Voucher: </label>
            <div class="form-group">
              <select name="type" class="form-select mb-1" required>
                <option value="percent">Percent</option>
								<option value="fixed">Fixed</option>
              </select>
							<p><small class="text-muted">
								- Percent: Voucher akan mengurangi harga produk dengan persentase yang ditentukan<br />
								- Fixed: Voucher akan mengurangi harga produk dengan nominal yang tetap	
								Catatan: Apabila nominal transaksi kurang dari Rp 10.000, maka transaksi tidak dapat dilakukan.
							</small></p>
            </div>

						<label>Nominal Voucher: </label>
            <div class="form-group">
              <input type="number" name="nominal" id="nominal" class="form-control mb-1" placeholder="Contoh: 10 / 10000" required>
							<p><small class="text-muted">
								Contoh: <br />
								- Jika tipe voucher adalah percent dan nominal voucher adalah 10, maka harga produk akan dikurangi 10%<br />
								- Jika tipe voucher adalah fixed dan nominal voucher adalah 10000, maka harga produk akan dikurangi 10000	
							</small></p>
            </div>

						<label>Limit Voucher: </label>
            <div class="form-group">
              <input type="number" name="limit" id="limit" class="form-control mb-1" placeholder="1" required>
							<p><small class="text-muted">
								Limit voucher digunakan untuk menentukan berapa kali voucher dapat digunakan.
							</small></p>
            </div>

						<label>Tanggal Expire: </label>
            <div class="form-group">
              <input type="datetime-local" name="expired_at" id="expired_at" class="form-control mb-1" required>

							{{-- checkbox for not expire --}}
							<div class="form-check form-check-sm">
								<input class="form-check-input" type="checkbox" value="1" id="not_expired" name="not_expired">
								<label class="form-check-label" for="not_expired">
									Tidak ada batas waktu
								</label>
							</div>

							<p><small class="text-muted">Tanggal expire digunakan untuk menentukan batas waktu penggunaan voucher.</small></p>
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
	
	<!-- Modal Edit Voucher -->
	<div class="modal fade text-left" id="editVoucher" tabindex="-1" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
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
        <form action="#" method="POST">
					@csrf
					@method('PUT')
          <div class="modal-body">
						<label>Pilih Toko: </label>
            <div class="form-group">
              <select name="id_store" class="form-select" id="id_store2">
								@foreach($store as $item)
                	<option value="{{ $item->id }}">{{ $item->name }}</option>
								@endforeach
              </select>
            </div>

						<label>Kode Voucher: </label>
						<div class="form-group">
							<div class="input-group mb-1">
								<button class="btn btn-sm btn-primary" type="button" id="generateBtn">
									Generate
								</button>
								<input type="text" class="form-control" name="code" id="code" oninput="this.value = this.value.toUpperCase()" required>
							</div>
							<p><small class="text-muted">Kode voucher digunakan sebagai identifier voucher yang akan digunakan oleh pelanggan saat proses checkout.</small></p>
						</div>

						<label>Tipe Voucher: </label>
            <div class="form-group">
              <select name="type" id="type" class="form-select mb-1" required>
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
              <input type="number" name="nominal" id="nominal" class="form-control mb-1" placeholder="Contoh: 10 / 10000" required>
							<p><small class="text-muted">
								Contoh: <br />
								- Jika tipe voucher adalah percent dan nominal voucher adalah 10, maka harga produk akan dikurangi 10%<br />
								- Jika tipe voucher adalah fixed dan nominal voucher adalah 10000, maka harga produk akan dikurangi 10000	
							</small></p>
            </div>

						<label>Limit Voucher: </label>
            <div class="form-group">
              <input type="number" name="limit" id="limit" class="form-control mb-1" placeholder="1" required>
							<p><small class="text-muted">
								Limit voucher digunakan untuk menentukan berapa kali voucher dapat digunakan.
							</small></p>
            </div>

						<label>Tanggal Expire: </label>
            <div class="form-group">
              <input type="datetime-local" name="expired_at" id="expired_at2" class="form-control mb-1" required>

							{{-- checkbox for not expire --}}
							<div class="form-check form-check-sm">
								<input class="form-check-input" type="checkbox" value="1" id="not_expired2" name="not_expired">
								<label class="form-check-label" for="not_expired2">
									Tidak ada batas waktu
								</label>
							</div>

							<p><small class="text-muted">Tanggal expire digunakan untuk menentukan batas waktu penggunaan voucher.</small></p>
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
	</script>

	<script>
		$(document).on('click', '#editBtn', function(){
      const url = "/voucher/";
      const id = $(this).val();
      $.get(url + id, function (data) {
				$('#editVoucher').modal('show');
				$('#editVoucher form').attr('action', url + id);
				// id_store default selected
				$('#editVoucher #id_store2 option[value="'+data.id_store+'"]').attr('selected', 'selected');
				// type default selected
				$('#editVoucher #type option[value="'+data.type+'"]').attr('selected', 'selected');
				$('#editVoucher #code').val(data.code);
				$('#editVoucher #nominal').val(data.amount);
				$('#editVoucher #limit').val(data.limit);
				// check if expired_at not null
				if(data.expired_at != null) {
					$('#editVoucher #expired_at2').val(data.expired_at);
					$('#editVoucher #not_expired2').attr('checked', false);
					$('#editVoucher #expired_at2').attr('disabled', false);
				} else {
					$('#editVoucher #not_expired2').attr('checked', true);
					$('#editVoucher #expired_at2').attr('disabled', true);
					$('#editVoucher #expired_at2').val('');
				}
      }) 
    });
	</script>

	<script>
		$(document).on('click', '#generateBtn', function() {
			const code = Math.random().toString(36).substring(2, 5).toUpperCase() + Math.random().toString(36).substring(2, 5).toUpperCase();
			$('#code').val(code);
		});

		$(document).on('click', '#editVoucher #generateBtn', function() {
			const code = Math.random().toString(36).substring(2, 5).toUpperCase() + Math.random().toString(36).substring(2, 5).toUpperCase();
			$('#editVoucher #code').val(code);
		});
	</script>

	<script>
		// not_expired
		$(document).on('click', '#not_expired', function() {
			if($(this).is(':checked')) {
				$('#expired_at').attr('disabled', true);
			} else {
				$('#expired_at').attr('disabled', false);
			}
		});

		$(document).on('click', '#not_expired2', function() {
			if($(this).is(':checked')) {
				$('#expired_at2').attr('disabled', true);
			} else {
				$('#expired_at2').attr('disabled', false);
			}
		});
	</script>
	
	<script>
		function confirm() {
			event.preventDefault();
			let form = event.target.form;
			Swal.fire({
				title: 'Apakah anda yakin?',
				text: "Semua data yang berhubungan dengan voucher ini akan dihapus, seperti transaksi dan lain-lain nya.",
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