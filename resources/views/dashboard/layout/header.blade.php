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
			<button class="btn btn-sm border-0 dropdown-toggle me-1 show" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
				<div class="avatar bg-warning">
          <span class="avatar-content">{{ $token->initial }}</span>
          <span class="avatar-status bg-success"></span>
        </div>
			</button>

			{{-- dropdown content --}}
			<div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate3d(0px, 40px, 0px);" data-popper-placement="bottom-start">
				
				<div class="dropdown-item">
					{{-- text capitalize --}}
					<span class="font-bold">{{ ucwords($token->name) }}</span><br>
					<span class="text-sm">{{strtolower($token->email) }}</span><br>
					@if ($token->membership == 'Free')
						<span class="badge bg-success mt-1">Free</span>
					@elseif ($token->membership == 'Premium')
						<span class="badge bg-warning mt-1">Premium</span>
					@endif
				</div>

				<hr class="my-2">
				<a class="dropdown-item text-md" href="{{ route('dash.profile') }}">
					<i class="fa fa-user me-1" aria-hidden="true"></i>
					Profile
				</a>

				<a class="dropdown-item text-md" href="{{ route('dash.membership') }}">
					<i class="fa fa-arrow-up me-1" aria-hidden="true"></i>
					Upgrade
				</a>

				<a class="dropdown-item text-md" href="{{ route('dash.2fa') }}">
					<i class="bi bi-shield-lock me-1"></i>
					2FA
				</a>

				<a class="dropdown-item text-md" href="{{ route('logout') }}">
					<i class="fa fa-sign-out me-1" aria-hidden="true"></i>
					Logout
				</a>

      </div>
		</div>
	</div>
</div>
				