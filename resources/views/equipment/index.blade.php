@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <x-panel header="Varusteet">
            <equipment-table :equipment="{{ $equipment }}" :form-options="{{$formOptions}}"></equipment-table>
        </x-panel>
    </div>
</div>
@if (config('kota.show.loans'))
<div class="row">
    <div class="col-md-12">
        <x-panel header="Lainassa">
            <div class="table-responsive">
                <table id="loanTable" class="display table table-striped table-bordered table-hover" cellspacing="0"
                    width="100%">
                    <thead>
                        <tr>
                            <th>Nimi</th>
                            <th>Sarjanumero</th>
                            <th>Määrä</th>
                            <th>Lainaaja</th>
                            <th>Lainapäivä</th>
                            <th>Palautuspäivä</th>
                            <th>Mihin</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($loans as $loan)
                            <tr>
                                <td>{{ $loan->equipment->name }}
                                    @if(Carbon\Carbon::createFromFormat('d/m/Y',$loan->return_date)->lt(Carbon\Carbon::now()))
                                    <span class="badge badge-danger">Myöhässä</span>
                                    @endif
                                </td>
                                <td>{{ $loan->equipment->serial }}</td>
                                <td>{{ $loan->quantity }}</td>
                                <td>{{ $loan->user->name }}</td>
                                <td>{{ $loan->loan_date }}</td>
                                <td>{{ $loan->return_date }}</td>
                                <td>{{ $loan->state == 0 ? 'Partio tapahtumaan' : 'Omaan käyttöön'  }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-panel>
    </div>
</div>
@endif

@endsection