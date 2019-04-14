@extends('layouts.appCustomer')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    Wiadomości {{ $account->service }}

                    <a href="{{ url('/customers/'.$account->customer->id.'/accounts') }}" class="float-right btn btn-secondary  btn-return">
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
                                        <th scope="col">Data</th>
                                        <th scope="col">Odbiorca</th>
                                        <th scope="col">Id wiadomości</th>
                                        <th scope="col">Ilość</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($messages as $key=>$message)
                                    <tr>
                                        <th scope="row">{{ ++$key }}</th>
                                        <td>{{ $message->date }}</td>
                                        <td>{{ $message->recipient }}</td>
                                        <td>{{ $message->messages_id}}</td>
                                        <td>{{$message->quantity}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{$messages->render()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endsection
