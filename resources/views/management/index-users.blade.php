@extends('layouts.app')
@section('title', 'Käyttäjät')
@section('content')
    <!-- Käyttäjät rivi -->
    <div class="row">
        <div class="col-md-12">
            <x-panel header='Käyttäjät'>
                <users-table :users="{{ $users }}" :roles="{{ $roles }}"></users-table>
            </x-panel>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <x-panel header='Roolit'>
                <roles-permissions-table :roles="{{ $roles }}" :permissions="{{ $permissions }}">
                </roles-permissions-table>

            </x-panel>
        </div>
    </div>
@endsection