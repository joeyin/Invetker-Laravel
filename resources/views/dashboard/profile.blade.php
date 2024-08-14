<x-dashboard-layout>
  @section('scripts')
    @vite(['resources/js/profile.js'])
  @endsection

  <!-- Content start -->
  <div class="d-inline-flex breadcrumb-wrapper align-items-center justify-content-between mb-4">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item active" aria-current="page">Profile</li>
      </ol>
    </nav>
  </div>
  <div class="container-fluid d-flex flex-grow-1 flex-column">
    <form class="col-12 col-md-6 col-lg-3" name="profile" method="post">
      @csrf
      <div class="alert alert-danger d-none" role="alert"></div>
      <div class="mb-3">
        <label for="email" class="form-label required">Email</label>
        <input class="form-control" id="email" type="email" name="email" value="{{ Auth::user()->email }}" disabled required>
      </div>
      <div class="mb-3">
        <label for="username" class="form-label required">Name</label>
        <input class="form-control" id="username" name="name" value="{{ Auth::user()->name }}" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password">
      </div>
      <div class="mb-3">
        <label for="confirm-password" class="form-label">Confirm Password</label>
        <input type="password" class="form-control" id="confirm-password" name="confirm-password">
        <div class="custom-invalid-feedback">Passwords do not match</div>
      </div>
      <div class="flex justify-content-end">
        <button type="submit" class="btn btn-lg btn-primary px-5 btn-warning text-light">Submit</button>
      </div>
    </form>
  </div>
  <!-- Content end -->
</x-dashboard-layout>