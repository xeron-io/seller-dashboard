@extends('dashboard.layout.app')

@section('content')
	<section class="section">
		<div class="card">
			<div class="card-header">
				<div class="d-flex justify-content-between">
					<h4 class="card-title">Daftar Game Server</h4>
					<button type="button" class="btn btn-primary btn-sm ml-auto" data-bs-toggle="modal" data-bs-target="#createServer" fdprocessedid="gjh7mli">
						<i class="fa fa-plus"></i> Tambah Server
					</button>
				</div>
			</div>
			<div class="card-body table-responsive">
				<table class="table" id="table1">
					<thead>
						<tr>
							<th>No</th>
							<th>Nama</th>
							<th>Game</th>
							<th>Ip</th>
							<th>Port</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						@foreach($gameserver as $item)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $item->name }}</td>
								<td>{{ $item->game }}</td>
								<td>{{ $item->ip }}</td>
								<td>{{ $item->port }}</td>
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
										<button type="button" id="editBtn" class="dropdown-item" data-bs-toggle="modal" value="{{ $item->id }}" data-bs-target="#editServer">Edit</button>
										<hr style="margin: 0;padding: 0;">
										<form action="{{ route('dash.gameserver.delete', $item->id) }}">
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

	<!-- Modal Create Server -->
	<div class="modal fade text-left" id="createServer" tabindex="-1" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel33">
            Tambah Server
          </h4>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
          </button>
        </div>
        <form action="{{ route('dash.gameserver.create') }}" method="POST">
					@csrf
          <div class="modal-body">
						<label>Nama Server: </label>
            <div class="form-group">
              <input type="text" name="name" id="name" class="form-control" placeholder="Nama server" value="{{ old('name') }}" minlength="3" maxlength="255" required>
            </div>
						<label>Tipe Game: </label>
            <div class="form-group">
              <select name="game" id="game" class="form-control" required>
								<option value="fivem">FiveM</option>
							</select>
            </div>
						<div class="row">
							<div class="col-lg-8 col-12">
								<label>Ip Server: </label>
								<div class="form-group">
									<input type="text" name="ip" id="ip" class="form-control" placeholder="Ip server" value="{{ old('ip') }}" maxlength="255" required>
								</div>
							</div>

							<div class="col-lg-4 col-12">
								<label>Port Server: </label>
								<div class="form-group">
									<input type="number" name="port" id="port" class="form-control" placeholder="Port server" value="{{ old('port') }}" maxlength="255" required>
								</div>
						</div>
          </div>
					<div class="form-group">
             {{-- test connection --}}
						<button type="button" class="btn btn-sm btn-primary" id="testConnection">
							<i class="fa fa-wifi me-1" aria-hidden="true"></i>
							Test Connection
						</button>
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
      const url = "/category/";
      const categoryID = $(this).val();
      $.get(url + categoryID, function (data) {
        $('#editCategory').modal('show');
				$('#editCategory form').attr('action', url + categoryID);
				$('#editCategory form input[name="name"]').val(data.name);
				$('#editCategory form textarea[name="description"]').val(data.description);
				$('#editCategory form select[name="id_store"]').val(data.id_store).change();
      }) 
    });
	</script>
	
	<script>
		function confirm() {
			event.preventDefault();
			let form = event.target.form;
			Swal.fire({
				title: 'Apakah anda yakin?',
				text: "Semua data yang berhubungan dengan kategori ini akan dihapus, seperti produk, stok, transaksi dan lain-lain nya.",
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