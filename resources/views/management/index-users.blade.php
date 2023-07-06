@extends('layouts.app')
@section('content')
    <!-- Käyttäjät rivi -->
    <div class="row">
        <div class="col-md-12">
            <x-panel header='Käyttäjät'>
                <users-table :users="{{ $users }}" :roles="{{$roles}}" ></users-table>
            </x-panel>
        </div>
    </div>
@endsection