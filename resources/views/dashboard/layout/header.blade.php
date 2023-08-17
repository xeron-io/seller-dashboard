<header class="mb-3">
	<a href="#" class="burger-btn d-block d-xl-none">
		<i class="bi bi-justify fs-3"></i>
	</a>
</header>

<div class="h-auto">
	<div class="d-flex justify-content-between">
		<div class="w-auto">
			<h3>{{ $title }}</h3>
			<p class="text-subtitle text-muted">
				{{ $subtitle }}
			</p>
		</div>
	
		<div class="w-auto">
			<button type="button" class="btn">
				<i class="bi bi-bell-fill"></i>
    			<span class="badge rounded-pill badge-notification bg-danger" style="font-size: 10px;">9</span>
			</button>

			<a href="{{ route('logout') }}" class="btn">
				<i class="fa fa-sign-out" aria-hidden="true"></i>
			</a>
		</div>
	</div>
</div>
				