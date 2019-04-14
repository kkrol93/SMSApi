@extends('layouts.appCustomer')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Edytuj konto {{ $account->service }}
                    <a href="{{url('/customers/'.$customer->id.'/accounts')}}"
                        class="float-right btn btn-secondary  btn-return">
                        <i class="fas fa-undo"></i>Wróć
                    </a>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error}}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form method="POST"
                        action="{{ route('account.edit', ['customer' => $customer, 'account' => $account]) }}">
                        @csrf
                        <div class="form-group">
                            <label for="service">Serwis:</label>
                            <input type="text" class="form-control" name="service" value="{{ $account->service }}">
                        </div>
                        <div class="form-group">
                            <label for="signature">Podpis</label>
                            <input type="text" name="signature" value="{{ $account->signature }}" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Aktualizuj</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
