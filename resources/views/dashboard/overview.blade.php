@extends('dashboard.layout.app')

@section('content')
	<section class="row">
		<div class="col-12 col-lg-12">
			{{-- welcome alert name --}}
			<div class="alert alert-primary alert-dismissible fade show mt-3" role="alert">
				Selamat datang, <b>{{ ucwords($token->name) }}!</b>
        <button type="button" class="btn-close color-white" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
			<div class="row">
				<div class="col-6 col-lg-3 col-md-6">
					<div class="card">
						<div class="card-body px-4 py-4-5">
						<div class="row">
							<div
							class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start"
							>
							<div class="stats-icon purple mb-2">
								<i class="fa fa-usd" aria-hidden="true"></i>
							</div>
							</div>
							<div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
							<h6 class="text-muted font-semibold">
								Pendapatan
							</h6>
							<h6 class="font-extrabold mb-0">@currency($total_income)</h6>
							</div>
						</div>
						</div>
					</div>
				</div>
				<div class="col-6 col-lg-3 col-md-6">
					<div class="card">
						<div class="card-body px-4 py-4-5">
							<div class="row">
								<div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
									<div class="stats-icon blue mb-2">
										<i class="iconly-boldBookmark"></i>
									</div>
								</div>
								<div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
									<h6 class="text-muted font-semibold">Transaksi</h6>
									<h6 class="font-extrabold mb-0">{{ count($transactions) }}</h6>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-6 col-lg-3 col-md-6">
					<div class="card">
						<div class="card-body px-4 py-4-5">
							<div class="row">
								<div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
									<div class="stats-icon green mb-2">
										<i class="fa fa-star" aria-hidden="true"></i>
									</div>
								</div>
								<div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
									<h6 class="text-muted font-semibold">Rating</h6>
									<h6 class="font-extrabold mb-0">{{ $avg_rating }}</h6>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-6 col-lg-3 col-md-6">
					<div class="card">
						<div class="card-body px-4 py-4-5">
							<div class="row">
								<div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
									<div class="stats-icon red mb-2">
										<i class="fa fa-archive" aria-hidden="true"></i>
									</div>
								</div>
								<div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
									<h6 class="text-muted font-semibold">Produk</h6>
									<h6 class="font-extrabold mb-0">{{ count($products) }}</h6>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h4>Penjualan Toko</h4>
						</div>
						<div class="card-body">
						<div id="chart-profile-visit"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12 col-xl-12">
					<div class="card">
						<div class="card-header">
							<h4>Review Terbaru</h4>
						</div>
						<div class="card-body">
							@if($reviews->count() > 0)
								<div class="table-responsive">
									<table class="table table-hover table-lg">
									<thead>
										<tr>
										<th>Nama</th>
										<th>Komentar</th>
										<th>Rating</th>
										</tr>
									</thead>
									<tbody>
										@foreach($reviews as $review)
											<tr>
												<td class="col-3">
													<div class="d-flex align-items-center">
													<div class="avatar avatar-md">
														{{-- generate random string 1-8 --}}
														@php
															$random = rand(1,8);
														@endphp
														<img src="assets/images/faces/{{ $random }}.jpg" />
													</div>
													<p class="font-bold ms-3 mb-0">{{ ucwords($review->transaction->buyer_name) }}</p>
													</div>
												</td>
												<td class="col-auto">
													<p class="mb-0">
														{{ $review->comment }}
													</p>
												</td>
												<td class="col-auto">
													@for($i = 0; $i < $review->star; $i++)
														<i class="fa fa-star text-warning"></i>
													@endfor
												</td>
											</tr>
										@endforeach
									</tbody>
									</table>
								</div>
							@else
								<div class="text-center">
									<i class="fa fa-question fa-5x text-muted"></i>
									<h6 class="mt-3 text-muted">Belum ada review yang tersedia</h6>
									<p class="text-muted">
										Review akan muncul ketika ada pembeli yang memberikan review terhadap produk anda
									</p>
								</div>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<script src="{{ asset('/Assets/js/pages/dashboard.js') }}"></script>
@endsection
					