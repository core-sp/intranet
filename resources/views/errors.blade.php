@if($errors->{ $bag ?? 'default' }->any())
    <div class="container">
        <div class="alert alert-danger" role="alert">
            <ul class="list-unstyled mb-0">
                @foreach($errors->{ $bag ?? 'default' }->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif