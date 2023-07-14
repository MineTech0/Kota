@extends('layouts.app')
@section('content')

<div class="row">
    <div class="col-md-12">
        <x-panel header="{{ucfirst($season)}} ryhmien kulut">
            <user-group-table :groups="{{ $groups }}"/>
        </x-panel>
    </div>
</div>
@endsection
