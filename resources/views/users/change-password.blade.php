@extends('layouts.appCustomer')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Zmiana hasła {{ $user->name }}
                    <a href="{{url('/users')}}" class="float-right btn btn-secondary  btn-return">
                        <i class="fas fa-undo"></i>Wróć
                    </a>
                </div>
                <div class="card-body">

                    <div class="col-12">
                        <div class="table-responsive">
                            @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                            @endif
                            @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                            @endif
                            @if ($errors->has('current-password'))
                            <div class="alert alert-success">
                                {{ $errors->first('current-password') }}
                            </div>
                            @endif
                            @if ($errors->has('new-password'))
                            <div class="alert alert-success">
                                Podane hasła różnią się!
                            </div>
                            @endif

                            <form class="" method="POST"
                                action="{{ action('UsersController@updatePass',[$user->id]) }}">
                                {{ csrf_field() }}
                                <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                                    <label for="new-password" class="col-md-12 control-label">Aktualne hasło:</label>
                                    <div class="col-md-12">
                                        <input id="current-password" type="password" class="form-control"
                                            name="current-password" required>

                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
                                    <label for="new-password" class="col-md-12 control-label">Nowe hasło:</label>
                                    <div class="col-md-12">
                                        <input id="new-password" type="password" class="form-control"
                                            name="new-password" required>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="new-password-confirm" class="col-md-12 control-label">Potórz
                                        hasło:</label>
                                    <div class="col-md-12">
                                        <input id="new-password-confirm" type="password" class="form-control"
                                            name="new-password_confirmation" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    Zmień hasło
                                </button>
                        </div>
                    </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endsection
