@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <h2>Päivitä</h2>
                    <x-panel header='Versio'>
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-warning" role="alert">
                                    {{ $error }}
                                </div>
                            @endforeach
                        @endif
                        @if (session()->has('message'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        <h2>Nykyinen versio: <span class="badge badge-secondary">{{ $current_version }}</span></h2>
                        @if ($new_version_available)
                            <div class="alert alert-info" role="alert">
                                Uusi versio saatavilla <b>{{ $new_version }}</b>
                            </div>
                            <form action="{{ route('update.update') }}" method="post">
                                @csrf
                                <button type="button" class="btn btn-primary">Päivitä</button>
                            </form>
                        @else
                            <p>Uusin versio käytössä</p>
                        @endif
                    </x-panel>
                </div>
            </div>
        </div>
    </div>

@endsection
