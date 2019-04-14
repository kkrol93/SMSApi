@extends('layouts.appCustomer')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Lista Serwerów Konta {{$account->service}}
                    <a href="{{url('account/'.$account->id.'/manage-servers')}}" class="float-right btn btn-primary">
                        <i class="fas fa-tools"></i>Zarządzaj
                    </a>
                    <a href="{{url('/customers/'.$customer->id.'/accounts')}}"
                        class="float-right btn btn-secondary  btn-return">
                        <i class="fas fa-undo"></i>Wróć
                    </a>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">IP</th>
                                <th scope="col">Nazwa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($account->servers as $key => $server)
                            <tr>
                                <th scope="row">{{ ++$key }}</th>
                                <td>{{ $server->ip }}</td>
                                <td>{{ $server->name }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
