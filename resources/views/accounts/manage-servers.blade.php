@extends('layouts.appCustomer')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Zarządzaj serwerami konta {{ $account->service }}
                    <a href="{{ URL::previous() }}" class="float-right btn btn-secondary  btn-return">
                        <i class="fas fa-undo"></i>Wróć
                    </a>
                </div>
                <div class="card-body">
                    <form method="POST" action=" {{ action('AccountsController@updateServers', [$account->id]) }}">
                        @csrf
                        @foreach($servers as $server)
                        <div class="mb-4">
                            <label>
                                <div class="form-check">
                                    <input name="servers[]" type="checkbox" value="{{ $server->id }}"
                                        @if($account->servers->contains($server->id)) checked=checked @endif>
                                    {{ $server->name }}({{ $server->ip }})
                                </div>
                            </label>
                        </div>
                        @endforeach
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>Zapisz</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection