@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-panel header="Muokkaa ryhmää">
                <edit-group-form :group="{{ $group }}" :age-groups="{{ $ageGroups }}" :week-days="{{ $weekDays }}"
                    :users="{{ $users }}" />
            </x-panel>
        </div>
    </div>
@endsection
