<x-dashboard-layout>
  @section('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
    @vite(['resources/js/about.js'])
  @endsection

  <!-- Content start -->
  <div class="d-inline-flex breadcrumb-wrapper align-items-center justify-content-between mb-4">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item active" aria-current="page">About</li>
      </ol>
    </nav>
  </div>
  <div class="container-fluid d-flex flex-grow-1 flex-column">
    <form name="about" method="post">
      @csrf
      <div class="mb-3">
        <label for="content" class="form-label required">Content</label>
        <textarea class="form-control" id="content" name="content" required>
          {!! html_entity_decode($about->content) !!}
        </textarea>
      </div>
      <div class="flex justify-content-end">
        <button type="submit" class="btn btn-lg btn-primary px-5 btn-warning text-light">Submit</button>
      </div>
    </form>
  </div>
  <!-- Content end -->
</x-dashboard-layout>