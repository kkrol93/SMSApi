@extends('layouts.appCustomer')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Dodaj konto do serwera {{$server->name}}
                    <a href="{{url('/servers/'.$server->id.'/accounts')}}"
                        class="float-right btn btn-secondary  btn-return">
                        <i class="fas fa-undo"></i>Wróć
                    </a>
                </div>
                <div class="card-body">
                    <div class="col-12">
                        <form method="post" action="{{ action('ServersController@updateAccounts', [$server->id]) }}">
                            @csrf
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Wybierz klienta</label>
                                <select class="form-control" id="customer_id" name="customer_id">
                                    <option value="">Wybierz klienta</option>
                                    @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                                <div id="accounts"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
    $('#customer_id').on('change', function() {
        var value = $(this).val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: "{{route('serversmanage.fetch', [$server->id]) }}",
            method: "POST",
            data: {
                value: value,
                _token: _token
            },
            success: function(result) {
                $('#accounts').html(result);
            }
        })
    });
</script>
@endsection
