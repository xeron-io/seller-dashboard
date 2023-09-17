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
					<h4 class="card-title">Daftar Transaksi</h4>
				</div>
			</div>
			<div class="card-body table-responsive">
				<table class="table" id="table1">
					<thead>
						<tr>
							<th>No</th>
							<th>Toko</th>
							<th>Produk</th>
							<th>Jumlah</th>
							<th>Nama Pembeli</th>
							<th>Pendapatan Kotor</th>
							<th>Pajak</th>
							<th>Pendapatan Bersih</th>
							<th>Status</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						@foreach($transactions as $item)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $item->store->name }}</td>
								<td>{{ Str::limit($item->product->name, 30, '...') }}</td>
								<td>{{ $item->quantity }}</td>
								<td>{{ $item->buyer_name }}</td>
								<td>Rp {{ number_format($item->amount) }}</td>
								<td>Rp {{ number_format($item->pajak) }}</td>
								<td>Rp {{ number_format($item->amount_bersih) }}</td>
								<td>
									@if($item->status == 'PAID')
										<span class="badge bg-success">Paid</span>
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
										<button type="button" id="editBtn" class="dropdown-item" data-bs-toggle="modal" value="{{ $item->id }}" data-bs-target="#detail" fdprocessedid="gjh7mli">Detail</button>
										@if(strtolower($item->status) == 'paid')
											<hr style="margin: 0;padding: 0;">
											<form action="{{ route('dash.transaction.refund', $item->id) }}" method="POST">
												@csrf
												<button type="submit" onclick="confirm()" class="dropdown-item">Refund</button>
											</form>

											<form action="{{ route('dash.transaction.resend', $item->id) }}" method="POST">
												@csrf
												<button type="submit" onclick="confirm()" class="dropdown-item">Resend</button>
											</form>
										@elseif(strtolower($item->status) == 'unpaid')
											<hr style="margin: 0;padding: 0;">
											<form action="{{ route('dash.transaction.cancel', $item->id) }}" method="POST">
												@csrf
												<button type="submit" onclick="confirm()" class="dropdown-item">Batalkan</button>
											</form>
										@endif
									</div>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</section>

	<!-- Modal Edit Category -->
	<div class="modal fade text-left" id="detail" tabindex="-1" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel33">
            Detail Transaksi
          </h4>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
          </button>
        </div>
        <form>
					@csrf
          <div class="modal-body">
						<label>Reference: </label>
						<div class="form-group mb-3">
							<input type="text" name="reference" id="reference" class="form-control" value="" readonly>
						</div>
						<label>Merchant Ref: </label>
						<div class="form-group">
							<input type="text" name="merchant_ref" id="merchant_ref" class="form-control" value="" readonly>
						</div>
						<label>Store: </label>
            <div class="form-group mb-3">
              <input type="text" name="store" id="store" class="form-control" value="" readonly>
            </div>
						<label>Product: </label>
            <div class="form-group">
              <input type="text" name="product" id="product" class="form-control" value="" readonly>
            </div>
						<label>Buyer Name: </label>
            <div class="form-group">
              <input type="text" name="buyer_name" id="buyer_name" class="form-control" value="" readonly>
            </div>
						<label>Buyer Email: </label>
            <div class="form-group">
              <input type="text" name="buyer_email" id="buyer_email" class="form-control" value="" readonly>
            </div>
						<label>Buyer Phone: </label>
						<div class="form-group">
							<input type="text" name="buyer_phone" id="buyer_phone" class="form-control" value="" readonly>
						</div>
						<label>Quantity: </label>
						<div class="form-group">
							<input type="text" name="quantity" id="quantity" class="form-control" value="" readonly>
						</div>
						<label>Pendapatan Kotor: </label>
						<div class="form-group">
							<input type="text" name="amount" id="amount" class="form-control" value="" readonly>
						</div>
						<label>Pajak: </label>
						<div class="form-group">
							<input type="text" name="pajak" id="pajak" class="form-control" value="" readonly>
						</div>
						<label>Pendapatan Bersih: </label>
						<div class="form-group">
							<input type="text" name="amount_bersih" id="amount_bersih" class="form-control" value="" readonly>
						</div>
						<label>Payment Method: </label>
						<div class="form-group">
							<input type="text" name="payment_method" id="payment_method" class="form-control" value="" readonly>
						</div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
              <span class="d-sm-block">Close</span>
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
      const url = "/transaction/";
      const id = $(this).val();
      $.get(url + id, function (data) {
        $('#detail').modal('show');
				$('#reference').val(data.reference);
				$('#merchant_ref').val(data.merchant_ref);
				$('#store').val(data.store.name);
				$('#product').val(data.product.name);
				$('#buyer_name').val(data.buyer_name);
				$('#buyer_email').val(data.buyer_email);
				$('#buyer_phone').val(data.buyer_phone);
				$('#quantity').val(data.quantity);
				$('#amount').val(data.amount);
				$('#pajak').val(data.pajak);
				$('#amount_bersih').val(data.amount_bersih);
				$('#payment_method').val(data.payment_method);
      }) 
    });
	</script>
	
	<script>
		function confirm() {
			event.preventDefault();
			let form = event.target.form;
			Swal.fire({
				title: 'Apakah anda yakin?',
				text: "Anda tidak akan dapat membatalkan ini!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#435EBE',
				cancelButtonColor: '#DC3545',
				confirmButtonText: 'Yes!'
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