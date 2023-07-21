@extends('layouts.app')
@section('title', 'Info')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-Panel header='Tiedotteet'>
                @foreach ($data as $item)
                    <h5 style="background:#ededed;padding:20px; ">&nbsp;&nbsp;
                        <div style="display: inline-block">
                            <b class="text-primary">{{ $item->created_at->format('d/m/Y') }}</b>
                        </div>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <div style="display: inline-flex; max-width:30%;">
                            <a class="open" style="cursor:pointer; color:#37a6c4"
                                data-id='{{ $item->id }}'>{{ $item->heading }}</b></a>

                        </div>
                    </h5>
                @endforeach
            </x-Panel>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <x-Panel header='Ohjeet'>
                <p class="text-muted">Vielä tyhjää</p>
            </x-Panel>
        </div>
        @if (config('kota.show.kitchen_booking'))
            <div class="col-md-6">
                <x-Panel header='Keittiön varauslista'>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session()->has('message'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            {{ session()->get('message') }}
                        </div>
                    @endif
                    <x-kitchen-booking-form />
                </x-Panel>
            </div>
        @endif
    </div>

    <div class="modal fade" id="NoteModal" tabindex="-1" role="dialog" aria-hidden="true">
    @endsection

    @section('script')
        <script>
            $('.open').on('click', function(e) {
                $('#NoteModal').load('/notes/' + $(e.target).data("id"), function() {
                    $('#NoteModal').modal({
                        show: true
                    });
                });
            });
        </script>
    @endsection
