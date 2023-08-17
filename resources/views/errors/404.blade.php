<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ env('APP_NAME') }} | Not Found</title>
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
              src="{{ asset('Assets/images/samples/error-404.svg') }}"
              alt="Not Found"
            />
            <h1 class="error-title">NOT FOUND</h1>
            <p class="fs-5 text-gray-600">
              The page you are looking not found.
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
