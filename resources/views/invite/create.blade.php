@extends('layouts.app')
@section('title', 'Kutsut')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-panel header='Kutsu uusia'>
                <create-invite-form></create-invite-form>
            </x-panel>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <x-panel header='Lähetetyt kutsut'>
                <invites-table :invites="{{ $invites }}"></invites-table>
        </div>
        </x-panel>
    </div>
    </div>
@endsection
