@extends('dashboard.layout.app')
@section('content')
  <section class="section">
    <div class="row">
      <div class="col-md-8">
          <div class="card">
              <div class="card-header"><strong>Two Factor Authentication</strong></div>
              <div class="card-body">
									@if($data['seller']->twoFactorAuthentication && $data['seller']->twoFactorAuthentication->google2fa_enable)
                    <div class="alert alert-success">
                      2FA is currently <strong>enabled</strong> on your account.
                    </div>
									@endif

									@if (session('error'))
                      <div class="alert alert-danger">
                          {{ session('error') }}
                      </div>
                  @endif
                  @if (session('success'))
                      <div class="alert alert-success">
                          {{ session('success') }}
                      </div>
                  @endif

                  <p>Two factor authentication (2FA) strengthens access security by requiring two methods (also referred to as two factors) to verify your identity. Two factor authentication protects against phishing, social engineering and password brute force attacks and secures your logins from attackers exploiting weak or stolen credentials.</p>

                  @if($data['seller']->twoFactorAuthentication == null)
                      <form class="form-horizontal" method="POST" action="{{ route('generate2faSecret') }}">
                          {{ csrf_field() }}
                          <div class="form-group">
                              <button type="submit" class="btn btn-primary">
                                  Generate Secret Key to Enable 2FA
                              </button>
                          </div>
                      </form>
                  @elseif(!$data['seller']->twoFactorAuthentication->google2fa_enable)
                      <span>1. Scan this QR code with your Google Authenticator App. Alternatively, you can use the code: </span><code>{{ $data['secret'] }}</code><br/>
                      {!! $data['google2fa_url'] !!}
                      <br/><br/>
                      <span class="mt-2">2. Enter the pin from <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en">Google Authenticator app</a>:</span>
                      <form class="form-horizontal mt-1" method="POST" action="{{ route('enable2fa') }}">
                          {{ csrf_field() }}
                          <div class="form-group{{ $errors->has('verify-code') ? ' has-error' : '' }}">
                              <input id="secret" type="number" class="form-control col-md-4" name="secret" placeholder="Authenticator pin" required>
                              @if ($errors->has('verify-code'))
                                  <span class="help-block">
                                  <strong>{{ $errors->first('verify-code') }}</strong>
                                  </span>
                              @endif
                          </div>
                          <button type="submit" class="btn btn-primary">
                              Enable 2FA
                          </button>
                      </form>
                  @elseif($data['seller']->twoFactorAuthentication->google2fa_enable)
                      <p class="text-danger">If you are looking to disable Two Factor Authentication. Please confirm your password and Click Disable 2FA Button.</p>
                      <form class="form-horizontal" method="POST" action="{{ route('disable2fa') }}">
                          {{ csrf_field() }}
                          <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                              <label for="change-password" class="control-label">Current Password</label>
                              <input id="current-password" type="password" class="form-control col-md-4" name="current-password" required>
                              @if ($errors->has('current-password'))
                                <span class="help-block">
                                	<strong>{{ $errors->first('current-password') }}</strong>
                                </span>
                              @endif
                          </div>
                          <button type="submit" class="btn btn-primary">Disable 2FA</button>
                      </form>
                  @endif
              </div>
          </div>
      </div>
    </div>
  </section>
@endsection