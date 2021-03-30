@if($errors->all())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <h4 class="alert-heading">{{ __('partials.failure') }}!</h4>
        <hr>
        @foreach($errors->all() as $error)
            <p class="mb-0">{{ $error }}</p>
        @endforeach
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if(session()->has('message'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <h4 class="alert-heading">{{ __('partials.success') }}!</h4>
        <hr>
        <p class="mb-0">{{ session()->get('message') }}</p>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
