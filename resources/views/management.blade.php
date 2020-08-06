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
                        <td>{{ $item->user != null ? $item->user->name : 'Anonyymi' }}</td>
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
            <x-panel header='Lomakkeet'/>
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
                        @foreach ($users as $index => $user)
                        <tr>
                                
                            
                            <td>{{$index +1}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>@foreach ($user->roles as $role)
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
<div class="modal fade" id="FeedbackModal" tabindex="-1" role="dialog" aria-hidden="true">
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
</script>
@endsection