@extends('layouts.app')
@section('title', 'Omat ryhmät')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <group-expenses-page season="{{ $season }}" :groups="{{ $groups }}"
                :club-money="{{ $clubMoney }}"></group-expenses-page>
        </div>
    </div>
@endsection
