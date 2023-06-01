@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-panel header="Uusi ryhmää">
                <div id="app">
                    <create-group-form :age-groups="{{ $ageGroups }}" :week-days="{{ $weekDays }}"
                        :users="{{ $users }}" />
                </div>
            </x-panel>
        </div>
    </div>
@endsection
