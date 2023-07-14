@extends('layouts.app')
@section('content')
    <div id="app">
        <index-expenses-page :current-season-expenses="{{ $currentSeasonExpenses }}"
            :previous-season-expenses="{{ $previousSeasonExpenses }}" :seasons="{{$seasons}}" />
    </div>
@endsection
