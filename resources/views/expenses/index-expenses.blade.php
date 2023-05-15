@extends('layouts.app')
@section('content')
<div id="app">
    <index-expenses-page :expenses-by-age-group="{{$expensesByAgeGroup}}"/>
</div>
@endsection