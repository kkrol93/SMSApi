@extends('layouts.appCustomer')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Zarejestruj Użytkownika
                    <a href="{{url('/users')}}" class="float-right btn btn-secondary  btn-return">
                        <i class="fas fa-undo"></i>Wróć
                    </a>
                </div>

                <div class="card-body">
                        @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    <form method="POST" action="{{ action('UsersController@store') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-12">Imię</label>

                            <div class="col-md-12">
                                <input id="name" type="text"
                                    class="form-control" name="name"
                                     required >


                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-12">E-Mail Address</label>

                            <div class="col-md-12">
                                <input id="email" type="email"
                                    class="form-control" name="email"
                                    value="{{ old('email') }}" required>
                                </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-12">Hasło</label>

                            <div class="col-md-12">
                                <input id="password" type="password"
                                    class="form-control"
                                    name="password" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-12">Potwierdź hasło</label>

                            <div class="col-md-12">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required>
                            </div>
                        </div>


                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>Zarejestruj Użytkownika
                        </button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
</div>
</div>
@endsection
