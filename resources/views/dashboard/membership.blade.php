@extends('dashboard.layout.app')

@section('content')
	<section class="section">

		<div class="row">
      <div class="col-12 col-md-8 offset-md-2 my-5">
        <div class="pricing">
					<div class="d-flex justify-content-around">
            <div class="col-md-5 px-0">
              <div class="card">
                <div class="card-header text-center">
                  <h4 class="card-title">Free</h4>
                  <p class="text-center">
                    Fitur gratis yang bisa anda dapatkan
                  </p>
                </div>
                <h1 class="price fs-1">IDR 0</h1>
                <ul>
                  <li>
                    <i class="bi bi-check-circle"></i>Unlimited Stores
                  </li>
                  <li>
                    <i class="bi bi-check-circle"></i>Unlimited Products
                  </li>
                  <li>
                    <i class="bi bi-check-circle"></i>Unlimited Vouchers
                  </li>
                  <li>
                    <i class="bi bi-check-circle"></i>Unlimited Transactions
                  </li>
                  <li>
                    <i class="bi bi-check-circle"></i>Free SSL Certificate
                  </li>
                  <li>
                    <i class="bi bi-x-circle text-danger"></i>Custom Domain
                  </li>
                  <li>
                    <i class="bi bi-x-circle text-danger"></i>Themes Selector
                  </li>
                </ul>
                <div class="card-footer">
                  <button class="btn btn-primary btn-block" disabled>
										Selected
                  </button>
                </div>
              </div>
            </div>
						<div class="col-md-5 px-0">
              <div class="card card-highlighted shadow-lg">
                <div class="card-header text-center">
                  <h4 class="card-title">Premium</h4>
                  <p class="text-center text-white">
                   Fitur premium yang bisa anda dapatkan
                  </p>
                </div>
                <h1 class="price text-white fs-1">IDR 100K</h1>
                <ul>
                  <li>
                    <i class="bi bi-check-circle"></i>Unlimited Stores
                  </li>
                  <li>
                    <i class="bi bi-check-circle"></i>Unlimited Products
                  </li>
                  <li>
                    <i class="bi bi-check-circle"></i>Unlimited Vouchers
                  </li>
                  <li>
                    <i class="bi bi-check-circle"></i>Unlimited Transactions
                  </li>
                  <li>
                    <i class="bi bi-check-circle"></i>Free SSL Certificate
                  </li>
                  <li>
                    <i class="bi bi-check-circle"></i>Custom Domain
                  </li>
                  <li>
                    <i class="bi bi-check-circle"></i>Themes Selector
                  </li>
                </ul>
                <div class="card-footer">
                  <button class="btn btn-light btn-block">
                    Upgrade Now
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
	</section>
	
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


	<script src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>
	<script src="{{ asset('/Assets/js/pages/datatables.js') }}"></script>
@endsection