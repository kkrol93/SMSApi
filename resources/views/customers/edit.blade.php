@extends('layouts.appCustomer')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Edytuj klienta {{$customer->name}}
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
                    <form method="POST" action="{{ action('CustomersController@update', [$customer->id]) }}">
                        @method('PATCH')
                        @csrf
                        <div class="form-group">
                            <label for="name">Nazwa klienta:</label>
                            <input type="text" class="form-control" name="name" value="{{ $customer->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Opis:</label>
                            <textarea type="text" name="description"
                                class="form-control">{{ $customer->description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="amount">Stawka SMS</label>
                            <input type="text" name="amount" value="{{ $customer->amount }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="count">Limit SMS</label>
                            <input type="number" name="count" value="{{ $customer->count }}" class="form-control">
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