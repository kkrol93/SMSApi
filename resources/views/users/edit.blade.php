@extends('layouts.appCustomer')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Edytuj Użytkownika {{ $user->name }}
                    <a href="{{url('/users')}}" class="float-right btn btn-secondary  btn-return">
                        <i class="fas fa-undo"></i>Wróć
                    </a>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form method="POST" action="{{ action('UsersController@update', [$user->id]) }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">Imię</label>
                            <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="text" name="email" value="{{ $user->email }}" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Aktualizuj</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
