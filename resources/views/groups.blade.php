@extends('layouts.app')
@section('content')

<div class="row">
    <div class="col-md-12">
        <x-panel header="Ryhmät">
            <div class="table-responsive">
                <table id="clist" class="display table table-striped table-bordered table-hover" cellspacing="0"
                    width="100%">
                    <thead>
                        <tr>
                            <th>Nimi</th>
                            <th>Johtajat</th>
                            <th>Kokouspäivä</th>
                            <th>Aika</th>
                            <th>Kokoontuu</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($groups as $group)
                            <tr>
                                <td>{{ $group->name }}</td>
                                <td>{!! str_replace(',', '<br />', $group->leaders) !!}
                                </td>
                                <td>{{ $group->day }}</td>
                                <td>{{ date('H:i',strtotime($group->time)) }}</td>
                                <td>{{ $group->repeat }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-panel>
    </div>
</div>

@endsection
