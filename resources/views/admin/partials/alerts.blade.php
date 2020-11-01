@if($errors->all())
    <div class="card bg-danger">
        <div class="card-header">
            <h3 class="card-title">Failure!</h3>
        </div>
        <div class="card-body">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    </div>
@endif

@if(session()->has('message'))
    <div class="card bg-primary">
        <div class="card-header">
            <h3 class="card-title">Success!</h3>
        </div>
        <div class="card-body">
            <p>{{ session()->get('message') }}</p>
        </div>
    </div>
@endif