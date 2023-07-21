@extends('layouts.app')
@section('title', 'Ryhmät')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-panel header="Ryhmät">
                @can('access_management')
                    <n-button type="primary" tag="a" href="{{ route('create.group') }}" class="mb-3">Lisää Ryhmä</n-button>
                @endcan
                <groups-table :groups="{{ $groups }}"></groups-table>

            </x-panel>
        </div>
    </div>
@endsection
