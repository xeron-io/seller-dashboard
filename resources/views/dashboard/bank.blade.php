@extends('dashboard.layout.app')

@section('content')
	<section class="section">
		<div class="card col-md-8">
			@if($wallet)
				<div class="card-body">
					<h4>Ingin mengubah rekening bank anda?</h4>
					<p class="text-muted">
						Silahkan hubungi admin untuk mengubah rekening bank anda.
					</p>

					{{-- Create form --}}
					<form>
						<div class="row">
							<div class="col-md-12">
								<label>Nama Bank: </label>
								<div class="form-group">
									<input type="text" name="name" class="form-control mb-1" value="{{ $wallet->name }}" readonly>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<label>No Rekening Bank: </label>
								<div class="form-group">
									<input type="text" name="number" class="form-control mb-1" value="{{ $wallet->number }}" readonly>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<label>Nama Pemilik Rekening: </label>
								<div class="form-group">
									<input type="text" name="owner" class="form-control mb-1" value="{{ $wallet->owner }}" readonly>
								</div>
							</div>
						</div>
					</form>
				</div>
			@else
				<div class="card-body text-center">
					<div class="text-center">
						<i class="fa fa-question fa-5x text-muted"></i>
						<h6 class="mt-3 text-muted">
							Anda belum menambahkan rekening bank
						</h6>
						<p class="text-muted">
							Silahkan tambahkan rekening bank anda untuk memulai menarik saldo dari penjualan produk anda.
						</p>
						<a href="#" data-bs-toggle="modal" data-bs-target="#createWallet" class="btn btn-primary">
							Tambah Rekening Bank
						</a>
					</div>
				</div>
			@endif
		</div>
	</section>

	<!-- Modal Create Bank -->
	<div class="modal fade text-left" id="createWallet" tabindex="-1" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel33">
            Tambah Rekening Bank
          </h4>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
          </button>
        </div>
        <form action="{{ route('dash.bank.create') }}" method="POST">
					@csrf
          <div class="modal-body">
						<label>Nama Bank: </label>
            <div class="form-group">
              {{-- use choice.js --}}
							<select name="name" class="choices form-select" required>
								@foreach($banks as $bank)
									<option value="{{ $bank['bank_code'] }};{{ $bank['name'] }}">{{ $bank['name'] }}</option>
								@endforeach
							</select>
            </div>

						<label>No Rekening Bank: </label>
            <div class="form-group">
              <input type="text" name="number" class="form-control mb-1" required>
            </div>

						<label>Nama Pemilik Rekening: </label>
            <div class="form-group">
              <input type="text" name="owner" class="form-control mb-1" required>
							<p><small class="text-muted">
								Perhatian:
								Pastikan data yang anda masukkan sudah benar, karena data ini akan digunakan untuk penarikan saldo dari penjualan produk anda. Untuk mengubah data penarikan rekening bank, anda dapat menghubungi admin.
							</small></p>
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