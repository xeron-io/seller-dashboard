<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ env('APP_NAME') }} | Forbidden</title>
    <link rel="stylesheet" href="{{ asset('Assets/css/main/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('Assets/css/pages/error.css') }}" />
  </head>

  <body>
    <div id="error">
      <div class="error-page container">
        <div class="col-md-8 col-12 offset-md-2">
          <div class="text-center">
          	<img
              class="img-error"
              src="{{ asset('Assets/images/samples/error-403.svg') }}"
              alt="Not Found"
            />
            <h1 class="error-title">Forbidden</h1>
            <p class="fs-5 text-gray-600">
              You are unauthorized to see this page.
            </p>
            <a href="/" class="btn btn-lg btn-outline-primary mt-3"
              >Go Home</a
            >
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
