@extends('layouts.app')
@section('title', 'Uusi ryhmä')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-panel header="Uusi ryhmää">
                    <create-group-form :age-groups="{{ $ageGroups }}" :week-days="{{ $weekDays }}"
                        :users="{{ $users }}" />
            </x-panel>
        </div>
    </div>
@endsection
