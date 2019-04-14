@extends('layouts.appCustomer')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Dodaj kilenta
                    <a href="{{ url('/customers') }}" class="float-right btn btn-secondary  btn-return">
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
                    <form method="POST" action="{{ action('CustomersController@store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nazwa Klienta</label>
                            <input type="text" class="form-control" name="name" placeholder="Nazwa" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Opis</label>
                            <textarea type="text" name="description" placeholder="Opis" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="amount">Stawka SMS</label>
                            <input type="text" name="amount" placeholder="Stawka SMS" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="count">Limit SMS</label>
                            <input type="number" name="count" placeholder="Limit SMS" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Dodaj Klienta</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection