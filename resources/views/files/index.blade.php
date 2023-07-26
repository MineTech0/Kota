@extends('layouts.app')
@section('title', 'Tiedostot')
@section('content')
<div id="app">
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <x-panel header='Tiedostot'>
                    <file-list :files="{{ $files }}"  token="{{ $token }}" :categories="{{ $categories}}" ></file-list>
                    @can('access_management')
                    <n-button class="mt-3" tag="a" href="{{ route('files.create') }}" type="primary">Lisää tiedosto</n-button>
                    @endcan
                </x-panel>
                </div>
                <div class="col-md-6">
                    <x-panel header='Toimintasuunnitelmat'>
                        <p class="text-muted">Tulossa pian...</p>
                    </x-panel>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
