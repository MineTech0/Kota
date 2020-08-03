@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <x-Panel header='Tiedotteet'>
                    @foreach($data as $item)
                        <h5 style="background:#ededed;padding:20px;">&nbsp;&nbsp;
                            <b
                                class="text-primary">{{ $item->created_at->format('d/m/Y') }}</b>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <a  class="open" style="cursor:pointer; color:#37a6c4"
                                data-id='{{ $item->id }}'>{{ $item->heading }}</b></a></h5>
                    @endforeach

                </x-Panel>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <x-Panel header='Ohjeet'>
                    MOI
                </x-Panel>
            </div>
            <div class="col-md-6">
                <x-Panel header='Lomakkeet'>
                    Lomakkeet
                </x-Panel>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="NoteModal" tabindex="-1" role="dialog" aria-hidden="true">
@endsection

@section('script')
<script>
    $('.open').on('click', function (e) {
        $('#NoteModal').load('/notes/'+$(e.target).data("id")
        ,function () {
            $('#NoteModal').modal({
                show: true
            });
        });
    });
</script>
@endsection
