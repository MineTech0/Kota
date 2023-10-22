@extends('layouts.app')
@section('title', 'Budjetti')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-panel header="Kerhoraha">
                <club-money-form :club-moneys="{{ $clubMoneys }}"></club-money-form>
            </x-panel>
        </div>
    </div>
@endsection
