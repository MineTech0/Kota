@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <x-panel heading='Työkalut'>
                    <button type="button" class="btn btn-primary">
                        <a style="color:white;" href="uIlmoitus.php">Uusi ilmoitus</a></button>
                    <button type="button" class="btn btn-primary">
                        <a style="color:white;" href="kutsu.php">Kutsu käyttäjiä</a></button>
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
                <x-panel heading='Palaute'>
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
                        <tr>
                            @foreach ($feedback as $item)
                                
                            @endforeach
                        <td>{{ $item==null ? $item->users->name : 'Anonyymi' }}</td>
                            <td class="open" data-id="{{$item->id}}"><a style="cursor:pointer">{{$item->heading}}</a></td>
                            <td>
                                @if ($item->attachment != null)
                                <a class="btn btn-primary btn-sm" target="_blank"
                                href="/feedback/{{$item->id}}/attachment">Lataa
                                liite</a>
                                @else
                                Ei liitettä
                                @endif
                            </td>
                            <td>{{ date('d/m/Y', strtotime($item->created_at))}}</td>
                        </tr>
                    </tbody>
                </table>
                </x-panel>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">Lomakkeet</div>
                    <div class="panel-body">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Käyttäjät rivi -->
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <x-panel heading='Käyttäjät'>
                    <table id='clist' class="display table table-striped table-bordered table-hover" cellspacing="0"
                    width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nimi</th>
                            <th>Sähköposti</th>
                            <th>Rooli</th>
                            <th>Varmistettu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach ($users as $index => $user)
                                
                            @endforeach
                            <td>{{$index +1}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td><?php echo htmlentities(ucfirst($result->role));?></td>
                            <td><?php 
                                if ($result->status == 1){
                                    echo htmlentities('Kyllä');
                                }
                                else{
                                    echo 'Ei';
                                }
                                ;?></td>
                        </tr>
                        <?php $cnt=$cnt+1; }} ?>

                    </tbody>
                </table>
                </x-panel>
            </div>
        </div>
    </div>
</div>
@endsection
