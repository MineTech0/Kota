@extends('layouts.app')
@section('title', 'Kulut')
@section('content')
        <index-expenses-page :current-season-expenses="{{ $currentSeasonExpenses }}"
            :previous-season-expenses="{{ $previousSeasonExpenses }}" :seasons="{{$seasons}}" :can-delete="@json($canDelete)"/>
@endsection
