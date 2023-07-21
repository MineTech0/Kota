@extends('layouts.app')
@section('title', 'Muokkaa varustetta')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <x-panel header='Muokkaa varustetta'>
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if(session()->has('message'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            {{ session()->get('message') }}
                        </div>
                    @endif


                    <form action="{{ route('update.equipment',$equipment->id) }}" class="form-horizontal"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="heading">Nimi</label><span style="color:red">*</span>
                                <input type="text" name="name" id="name" class="form-control form-control-lg"
                                    placeholder="" value="{{ $equipment->name }}" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="description">Sarjanumero</label><span style="color:red">*</span>
                                <input type="text" name="serial" id="serial" class="form-control form-control-lg"
                                    placeholder="esim. #AV01" value="{{ $equipment->serial }}" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="description">Paino</label>
                                <input type="text" name="weight" id="weight" class="form-control form-control-lg"
                                    value="{{ $equipment->weight }}">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="description">Kunto</label><span style="color:red">*</span>
                                <select class="form-control form-control-lg" name="form" id="form"
                                    value="{{ $equipment->form }}">
                                    <option>Hyvä</option>
                                    <option>Rikki</option>
                                    <option>Huono</option>
                                    <option>Kulunut</option>
                                    <option>Uusi</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="description">Paikka</label><span style="color:red">*</span>
                                <input type="text" name="location" id="location" class="form-control form-control-lg"
                                    placeholder="esim. Pappila/A1" value="{{ $equipment->location }}" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="description">Määrä</label><span style="color:red">*</span>
                                <input type="number" name="quantity" id="quantity" class="form-control form-control-lg"
                                    value="{{ $equipment->quantity }}" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="description">Tiedot</label><span style="color:red">*</span>
                                <textarea class="form-control  form-control-lg" name="info" id="info"
                                    rows="5">{{ $equipment->info }}</textarea>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="file">Kuva</label>
                                <input type="file" class="form-control-file" name="picture" id="picture" placeholder="" accept="image/*" onchange="document.getElementById('preview').src = window.URL.createObjectURL(this.files[0])">
                            </div>
                        </div>
                        <div class="form-group row">
                            @if($equipment->picture)

                                <img  id="preview" src="{{url("storage/$equipment->picture") }}"
                                    class="img-thumbnail rounded d-block" width="200">
                            @else
                                <p>Ei kuvaa</p>
                            @endif
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-lg">Muokkaa</button>
                        </div>

                    </form>
                </x-panel>
            </div>
        </div>
    </div>
</div>
@endsection
