@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <x-panel header="Varusteet">
            <div class="table-responsive">
                <table id="clist" class="display table table-striped table-bordered table-hover" cellspacing="0"
                    width="100%">
                    <thead>
                        <tr>
                            <th>Nimi</th>
                            <th>Sarjanumero</th>
                            <th>Kunto</th>
                            <th>Paikka</th>
                            <th>Määrä</th>
                            <th>Info</th>
                            <th>Kuva</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($equipment as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->serial }}</td>
                                <td>{{ $item->form }}</td>
                                <td>{{ $item->location }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->info }}</td>
                                @if ($item->picture)
                                <td><a href="storage/{{ $item->picture }}" target="_blank">Avaa kuva</a> </td>
                                    
                                @else
                                    <td></td>
                                @endif
                                <td><a href="{{route('edit.equipment',$item->id)}}">Muokkaa</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        <a href="{{route('create.equipment')}}" ><button class="btn btn-primary btn-lg mt-3">Lisää uusi</button></a>
        </x-panel>
    </div>
</div>
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
                                <td>{{ $loan->equipment->name }}</td>
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

@endsection