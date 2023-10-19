@extends('dashboard.layout.app')

@section('content')
	<section class="section">
		<div class="card">
			<div class="card-header">
				<div class="d-flex justify-content-between">
					<h4 class="card-title">List Penarikan Dana</h4>
					<button type="button" class="btn btn-primary btn-sm ml-auto" data-bs-toggle="modal" data-bs-target="#createWithdraw" fdprocessedid="gjh7mli">
						<i class="fa fa-plus"></i> Request Penarikan
					</button>
				</div>
			</div>
			<div class="card-body table-responsive">
				<table class="table" id="table1">
					<thead>
						<tr>
							<th>No</th>
							<th>NO Rekening</th>
							<th>Nama Pemilik</th>
							<th>Jumlah Penarikan</th>
							<th>Pajak</th>
							<th>Total Diterima</th>
							<th>Bukti</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						@foreach($withdraw as $item)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $item->wallet_number }} ({{ $item->wallet_name }})</td>
								<td>{{ $item->wallet_owner }}</td>
								<td>@currency($item->amount)</td>
								<td>@currency($item->fee)</td>
								<td>
									@php
										$total = $item->amount - $item->fee;
									@endphp
									@currency($total)
								</td>
								<td>
									@if($item->proof)
										<a href="{{ $item->proof }}" target="_blank" class="btn btn-sm btn-primary">Lihat</a>
									@else
										-
									@endif
								</td>
								<td>
									@if($item->status == 'success')
										<span class="badge bg-success">Active</span>
									@elseif($item->status == 'pending')
										<span class="badge bg-warning">Pending</span>
									@else
										<span class="badge bg-danger">{{ $item->status }}</span>
									@endif
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</section>

	<!-- Modal Create Withdraw -->
	<div class="modal fade text-left" id="createWithdraw" tabindex="-1" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel33">
            Request Penarikan
          </h4>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
          </button>
        </div>
        <form action="{{ route('dash.withdraw.create') }}" method="POST">
					@csrf
          <div class="modal-body">
						<div class="alert alert-primary" role="alert">
							<h6>Ketentuan Penarikan Dana</h6>
							<p>1. Jumlah yang bisa dicairkan: <b>@currency($wallet->seller->balance)</b></p>
							<p>2. Minimal Jumlah Pencairan: <b>@currency(100000)</b></p>
							<p>3. Maksimal Jumlah Pencairan: <b>@currency(10000000)</b></p>
						</div>
						<label>Jumlah yang ingin dicairkan: </label>
            <div class="form-group">
              <input type="number" name="amount" id="amount" class="form-control" placeholder="Masukkan jumlah penarikan" value="{{ old('amount') }}" min="100000" max="10000000" required>
            </div>
						<label>Pajak: </label>
            <div class="form-group">
              <input type="number" name="fee" id="fee" class="form-control" placeholder="Masukkan jumlah penarikan" value="{{ $fee }}" readonly required>
            </div>
						<label>Jumlah yang diterima: </label>
            <div class="form-group">
              <input type="number" name="jumlah_diterima" id="jumlah_diterima" class="form-control" placeholder="Masukkan jumlah penarikan" value="0" readonly required>
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
		$('#amount').on('keyup', function() {
			var amount = $(this).val();
			var fee = {{ $fee }};
			var total = amount - fee;
			$('#jumlah_diterima').val(total);
		});
	</script>
	<script src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>
	<script src="{{ asset('/Assets/js/pages/datatables.js') }}"></script>
@endsection