@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <x-panel header='Työkalut'>
                    <button type="button" class="btn btn-primary">
                        <a style="color:white;" href="{{route('notes.create')}}">Uusi ilmoitus</a></button>
                    <button type="button" class="btn btn-primary">
                        <a style="color:white;" href="{{route('create.invite')}}">Kutsu käyttäjiä</a></button>
                </x-panel>
            </div>
        </div>
    </div>
</div>
<!-- Palaute ja lomakkeet rivi -->
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <x-panel header='Palaute'>
                    <div class="table-responsive">
                    <table class="display table table-striped table-bordered table-hover" cellspacing="0"
                    width="100%">
                    <thead>
                        <tr>
                            <th>Nimi</th>
                            <th>Otsikko</th>
                            <th>Liite</th>
                            <th>Aika</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($feedback as $item)
                        <tr>
                        <td>{{ $item->loan != null ? $item->loan->name : 'Anonyymi' }}</td>
                            <td><a class="open"  data-id="{{$item->id}}" style="cursor:pointer;color:#37a6c4"">{{$item->heading}}</a></td>
                            <td>
                                @if ($item->attachment != null)
                                <a class="btn btn-primary btn-sm" target="_blank"
                                href="/feedback/{{$item->id}}/attachment">Lataa liite</a>
                                @else
                                Ei liitettä
                                @endif
                            </td>
                            <td>{{ date('d/m/Y', strtotime($item->created_at))}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                    </div>
                </x-panel>
            </div>
            <div class="col-md-6">
            <x-panel header='Hyväksyttävät lainat'>
                <div class="table-responsive">
                    <table id='loanTable' class="display table table-striped table-bordered table-hover" cellspacing="0"
                    width="100%">
                    <thead>
                        <tr>
                            <th>Lainaaja</th>
                            <th>Varuste</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($loans as  $loan)
                        <tr>
                            <td>{{$loan->user->name}}</td>
                            <td>{{$loan->equipment->name}}</td>
                            <td><button data-id='{{ $loan->id }}' class="btn btn-primary btn-sm loanBtn">Tiedot</button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </x-panel>
            </div>
        </div>
    </div>
</div>
<!-- Käyttäjät rivi -->
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <x-panel header='Käyttäjät'>
                    <div class="table-responsive">
                    <table id='clist' class="display table table-striped table-bordered table-hover" cellspacing="0"
                    width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nimi</th>
                            <th>Sähköposti</th>
                            <th>Rooli</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $index => $loan)
                        <tr>
                                
                            
                            <td>{{$index +1}}</td>
                            <td>{{$loan->name}}</td>
                            <td>{{$loan->email}}</td>
                            <td>@foreach ($loan->roles as $role)
                                {{ucfirst($role->name)}}<br>
                            @endforeach</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
                </x-panel>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="loanModal" aria-hidden="true"></div>
<div class="modal fade" id="FeedbackModal" aria-hidden="true"></div>
@endsection
@section('script')
<script>
    $('.open').on('click', function (e) {
        $('#FeedbackModal').load('/feedback/'+$(e.target).data("id")
        ,function () {
            $('#FeedbackModal').modal({
                show: true
            });
        });
    });
    $('.loanBtn').on('click', function (e) {
            $('#loanModal').load('/loan/accept/' + $(e.target).data("id"), function () {
                $('#loanModal').modal({
                    show: true
                });
            });
        });
        $(document).on('click', '.acceptBtn', function (e) {
                    let id = $(this).data('id');
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                        $.ajax({
                            url: '/loan/' + id,
                            type: 'PATCH',
                            dataType: 'json',
                            data: {
                                state: $(this).data('state')
                            },
                            success: function (result) {
                                $('.returnInfo').html('Lähetetty');
                                $('.returnInfo').addClass('alert-success');
                                $('.returnInfo').show();
                                setTimeout(function () {
                                    location.reload();
                                }, 2000);
                            },
                            error: function (xhr, Status, error) {
                                $('.returnInfo').html(Status);
                                $('.returnInfo').addClass('alert-danger');
                                $('.returnInfo').show();
                            }
                        });
                    });
</script>
@endsection