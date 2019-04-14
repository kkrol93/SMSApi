@extends('layouts.appCustomer')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Dodaj konto
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
                    <form method="POST" action="{{ action('AccountsController@store', [$customer->id]) }}">
                        @csrf
                        <div class="form-group">
                            <label for="service">Serwis</label>
                            <input type="text" class="form-control" name="service" placeholder="serwis" required>
                        </div>
                        <div class="form-group">
                            <label for="signature">Podpis</label>
                            <input type="text" name="signature" placeholder="podpis" class="form-control" required>
                        </div>
                        <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                        <button type="submit" class="btn btn-primary">Dodaj konto</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
