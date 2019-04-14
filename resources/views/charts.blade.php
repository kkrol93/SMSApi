@extends('layouts.appCustomer')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Raport</div>
                <div class="card-body">
                    <form action="{{ action('HomeController@index') }}" method="post" class="col-12" style="margin-bottom:30px;">
                        @csrf
                        <div class="row">
                            <div class="col-12">Zestawienie smsów - parametry pytania</div>
                            <div class="form-inline col-5 ">
                                <label for="year" class="col-5">rok:</label>
                                <select name="year" style="margin:20px auto;" class="form-control col-7 form-control-sm">
                                    <option value="">Wybierz rok</option>
                                    @for ($i=0 ; $i < 5 ; $i++) <option value="{{date("Y")-$i}}" @if (date("Y")-$i==old('year', Request::get('year')))) selected="selected" @endif>{{date("Y")-$i}}</option>
                                        @endfor
                                </select>
                            </div>
                            <div class="form-inline  col-5">
                                <label for="month" class="col-5">miesiąc:</label>
                                <select name="month" style="margin:20px auto;" class="form-control col-7 form-control-sm">
                                    <option value="">Wybierz miesiąc</option>
                                    @for ( $i=1 ; $i <= 12 ; $i++) <option value="{{$i}}" @if ($i==old('month', Request::get('month')))) selected="selected" @endif>{{$i}}</option>
                                        @endfor
                                </select>
                            </div>
                            <div style="margin-bottom: 20px;" class="col-12">
                                Uwaga: Jeżeli wybrałeś konkretny miesiąc to zakres od-do będzie ignorowany.
                            </div>
                            <div class="form-inline col-5">
                                <label for="year" class="col-5">data od:</label>
                                <input type="text" autocomplete="off" name="from" id="date1" value="{{ Request::get('from') }}" class="form-control col-7 form-control-sm">
                            </div>
                            <div class="form-inline col-5">
                                <label for="year" class="col-5">data do:</label>
                                <input type="text" autocomplete="off" name="to" id="date2" value="{{ Request::get('to') }}" class="form-control col-7 form-control-sm">
                            </div>
                            <div class="form-inline col-5">
                                <label for="customer_id" class="col-5">klient:</label>
                                <select name="customer_id" style="margin:20px auto;" class="form-control col-7 form-control-sm ">
                                    <option value="">Wybierz klienta</option>
                                    @foreach ($customers as $customer_id => $customer)
                                    <option value="{{$customer_id}}" @if ($customer_id==old('customer_id', Request::get('customer_id')))) selected="selected" @endif>{{$customer}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-inline offset-2 col-5">
                                <button type="submit" class="btn btn-success col-6"><i class="fas fa-search"></i>Wybierz</button>
                            </div>
                        </div>
                    </form>
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">LP</th>
                                        <th scope="col">Klient</th>
                                        <th scope="col">Konto</th>
                                        <th scope="col">Data</th>
                                        <th scope="col">Ilość</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $i=1;
                                    @endphp

                                    @foreach ($messages as $customer_id => $customer_messages)


                                    @foreach($customer_messages as $message)

                                    <tr>
                                        <th scope="row">{{ $i++ }}</th>
                                        <td>{{$message->account->customer->name}}({{$message->account->service}})</td>
                                        <td>{{$message->account->service}}</td>
                                        <td>{{ date('m-Y', strtotime($message->date)) }}</td>
                                        <td>{{ $message->sum}}</td>
                                    </tr>

                                    @endforeach

                                    <tr class="bg-danger">
                                        <th>Klient: {{$messages[$customer_id][0]->account->customer->name}}</th>
                                        <th colspan="1"></th>
                                        <th colspan="1">Do zapłaty: {{ number_format($messages_sums[$message->account->customer_id]*$messages[$customer_id][0]->account->customer->amount,2,',','')  }} zł</th>
                                        <th colspan="1">Stawka: {{str_replace(".", ",", $messages[$customer_id][0]->account->customer->amount)}} zł</th>
                                        <th colspan="2">Suma: {{$messages_sums[$message->account->customer_id]}}/{{$messages[$customer_id][0]->account->customer->count}} </th>
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
</div>
@endsection
@section('js')
<script>
    $('#date1, #date2 ').datepicker({
        format: 'yyyy-mm-dd',
        multidateSeparator: "-"
    });
</script>
@endsection
