@extends('layouts.app')
@section('title', 'Uusi kulu')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <create-expenses-page :infos="{{ $expenseInfos }}" :groups="{{ $groups }}" />
        </div>
    </div>
@endsection
