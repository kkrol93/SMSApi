@extends('layouts.appCustomer')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    Lista serwerów:
                    <a href="{{url('servers\create')}}" class="float-right btn btn-primary">
                        <i class="fas fa-plus"></i>Dodaj serwer
                    </a>
                </div>
                <div class="card-body">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">IP</th>
                                        <th scope="col">Nazwa</th>
                                        <th scope="col">Konta</th>
                                        <th scope="col">Edytuj</th>
                                        <th scope="col">Usuń</th>
                                    </tr>
                                </thead>
                                    <tbody>

                                        @foreach ($servers as $key => $server)
                                            <tr>
                                            <th scope="row">{{++$key}}</th>
                                                <td>{{ $server->ip }}</td>
                                                <td>{{ $server->name }}</td>
                                                <td>
                                                    <a href="/servers/{{ $server->id }}/accounts"  class="btn btn-primary btn-sm">
                                                        <i class="fas fa-users"></i> Konta <span class="badge badge-light">{{$server->accounts->count()}}</span>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="/servers/{{ $server->id }}/edit"  class="btn btn-warning btn-sm">
                                                        <i class="fas fa-pencil-alt"></i>Edytuj
                                                    </a>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#customerDelete{{$key}}">
                                                            <i class="fas fa-minus-circle"></i>Usuń
                                                    </button>
                                                    <!-- Modal -->
                                                <div class="modal fade" id="customerDelete{{$key}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Uwaga!</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                Czy na pewno chcesz usunąć serwer {{$server->name}}?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-undo-alt"></i>Wróć</button>
                                                                    <form action="{{ route('servers.destroy', ['server' => $server]) }}" method="post">
                                                                            @csrf
                                                                            <button type="submit" class="btn btn-danger">
                                                                                <i class="fas fa-minus-circle"></i>Usuń
                                                                            </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{$servers->render()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
