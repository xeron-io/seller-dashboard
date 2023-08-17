@extends('dashboard.layout.app')

@section('content')
	<section class="row">
		<div class="col-12 col-lg-12">
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
							<h6 class="font-extrabold mb-0">Rp 112.000</h6>
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
									<h6 class="font-extrabold mb-0">10</h6>
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
									<h6 class="font-extrabold mb-0">4.5 (10 Review)</h6>
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
									<h6 class="font-extrabold mb-0">112</h6>
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
							<div class="table-responsive">
								<table class="table table-hover table-lg">
								<thead>
									<tr>
									<th>Nama</th>
									<th>Komentar</th>
									</tr>
								</thead>
								<tbody>
									<tr>
									<td class="col-3">
										<div class="d-flex align-items-center">
										<div class="avatar avatar-md">
											<img src="assets/images/faces/5.jpg" />
										</div>
										<p class="font-bold ms-3 mb-0">Si Cantik</p>
										</div>
									</td>
									<td class="col-auto">
										<p class="mb-0">
										Congratulations on your graduation!
										</p>
									</td>
									</tr>
									<tr>
									<td class="col-3">
										<div class="d-flex align-items-center">
										<div class="avatar avatar-md">
											<img src="assets/images/faces/2.jpg" />
										</div>
										<p class="font-bold ms-3 mb-0">Si Ganteng</p>
										</div>
									</td>
									<td class="col-auto">
										<p class="mb-0">
										Wow amazing design! Can you make another
										tutorial for this design?
										</p>
									</td>
									</tr>
								</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<script src="{{ asset('/Assets/js/pages/dashboard.js') }}"></script>
@endsection
					