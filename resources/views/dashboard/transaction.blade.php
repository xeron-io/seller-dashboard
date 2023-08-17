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
					<h4 class="card-title">Daftar Kategori</h4>
				</div>
			</div>
			<div class="card-body table-responsive">
				<table class="table" id="table1">
					<thead>
						<tr>
							<th>No</th>
							<th>Toko</th>
							<th>Produk</th>
							<th>Nama</th>
							<th>Email</th>
							<th>No HP</th>
							<th>Jumlah</th>
							<th>Status</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						@foreach($transactions as $item)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $item['store']['store_name'] }}</td>
								<td>{{ $item['product']['product_name'] }}</td>
								<td>{{ $item['buyer_name'] }}</td>
								<td>{{ $item['buyer_email'] }}</td>
								<td>{{ $item['buyer_phone'] }}</td>
								<td>{{ $item['quantity'] }}</td>
								<td>
									<span class="badge bg-success">{{ $item['status'] }}</span>
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
										<button type="button" id="editBtn" class="dropdown-item" data-bs-toggle="modal" value="{{ $item['id_transaction'] }}" data-bs-target="#editStore" fdprocessedid="gjh7mli">Edit</button>
										<hr style="margin: 0;padding: 0;">
										<form action="{{ route('dash.transaction.cancel', $item['id_transaction']) }}">
											<button type="submit" onclick="confirm()" class="dropdown-item">Batalkan</button>
										</form>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</section>

	{{-- <!-- Modal Edit Category -->
	<div class="modal fade text-left" id="editStore" tabindex="-1" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel33">
            Edit Kategori
          </h4>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
          </button>
        </div>
        <form action="" method="POST">
					@csrf
					@method('PUT')
          <div class="modal-body">
            <label>Pilih Toko: </label>
            <div class="form-group">
              <select name="id_store" class="form-select">
								@foreach($store as $item)
                	<option value="{{ $item['id_store'] }}">{{ $item['store_name'] }}</option>
								@endforeach
              </select>
            </div>
						<label>Nama Kategori: </label>
            <div class="form-group mb-3">
              <input type="text" name="category_name" class="form-control" placeholder="Nama kategori" value="{{ old('category_name') }}" minlength="4" required>
            </div>
						<label>Deskripsi Kategori: </label>
            <div class="form-group">
              <textarea type="text" name="category_description" placeholder="Deskripsi kategori" class="form-control" style="height: 100px" value="{{ old('category_description') }}" minlength="50" required></textarea>
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
	</div> --}}
	
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
      const url = "/dashboard/category/";
      const categoryID = $(this).val();
      $.get(url + categoryID, function (data) {
        $('#editStore').modal('show');
				$('#editStore form').attr('action', url + categoryID);
				$('#editStore form input[name="category_name"]').val(data.data.category_name);
				$('#editStore form textarea[name="category_description"]').val(data.data.category_description);
				$('#editStore form select[name="id_store"]').val(data.data.id_store).change();
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