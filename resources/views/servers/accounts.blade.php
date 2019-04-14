@extends('layouts.appCustomer')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    Konta, które używają serwera {{ $server->name }}
                    <a href="{{action('ServersController@manageAccounts', [$server->id])}}"
                        class="float-right btn btn-primary">
                        <i class="fas fa-tools"></i>Zarządzaj
                    </a>
                    <a href="{{url('/servers')}}" class="float-right btn btn-secondary  btn-return">
                        <i class="fas fa-undo"></i>Wróć
                    </a>

                </div>
                <div class="card-body">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Serwis</th>
                                        <th scope="col">Podpis</th>
                                        <th scope="col">Klient</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($accounts as $key => $account)
                                    <tr>
                                        <th scope="row">{{ ++$key }}</th>
                                        <td>{{ $account->service }}</td>
                                        <td>{{ $account->signature }}</td>
                                        <td>{{ $account->customer->name }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
