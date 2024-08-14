<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ config('app.name') }}</title>
  @vite(['resources/css/app.css', 'resources/css/home.css'])
</head>

<body>
  <x-user-modal/>
  <header>
    <nav class="navbar navbar-expand-sm navbar-toggleable-sm navbar-light bg-warning">
      <div class="container">
        <a href={{ route('home') }} title="{{ config('app.name') }}">
          <div class="brand"></div>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target=".navbar-collapse"
          aria-controls="user-modal" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse justify-content-end gap-sm-3">
          <ul class="navbar-nav gap-sm-3">
            <li class="nav-item">
              <a title="Home" class="nav-link text-dark active" href={{ route('home') }}>Home</a>
            </li>
            <li class="nav-item">
              <a title="About" class="nav-link text-dark" href={{ route('about') }}>About</a>
            </li>
          </ul>
          <button id="signinup" class="btn btn-outline-dark rounded-0 px-3">SIGN IN/UP</button>
        </div>
      </div>
    </nav>
  </header>
  <div class="container">
    {{ $slot }}
  </div>
  <footer class="footer bg-warning">
    <div class="container">
      <div class="d-flex flex-row flex-wrap justify-content-md-between gap-5 gap-md-3">
        <div class="col-12 col-md-4">
          <div class="brand"></div>
          <div class="slogan text-secondary">
            INVETKER offers easy stock tracking, clear charts, daily rankings, and a beginner-friendly interface.
          </div>
        </div>
        <div class="col-auto text-light fs-6">
          <div class="title fw-bold">Get Started</div>
          <ul class="list-unstyled">
            <li class="mt-2"><a title="Home" href={{ route('home') }}>Home</a></li>
            <li class="mt-2"><a title="About" href={{ route('about') }}>About</a></li>
          </ul>
        </div>
        <div class="col-auto text-light fs-6">
          <div class="title fw-bold">Resources</div>
          <ul class="list-unstyled">
            <li class="mt-2"><a title="Contact" href="#">Contact</a></li>
            <li class="mt-2"><a title="Privacy Policy" href="#">Privacy Policy</a></li>
          </ul>
        </div>
      </div>
      <div class="text-light my-4">
        <hr>
      </div>
      <div class="text-light text-center">
        &copy; {{ date('Y') }} INVETKER, All right reserved.
      </div>
    </div>
  </footer>
  @vite(['resources/js/app.js', 'resources/js/home.js'])
</body>

</html>