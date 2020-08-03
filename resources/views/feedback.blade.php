@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">

                <h2>Anna palautetta</h2>
                <x-panel header='Uusi palaute'>
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


                    <form action="/feedback" class="form-horizontal" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="heading">Otsikko</label><span style="color:red">*</span>
                                <input type="text" name="heading" id="heading" class="form-control form-control-lg"
                                    placeholder="Otsikko" value="{{ old('heading') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="file">Liite</label>
                                <input type="file" class="form-control-file" name="attachment" id="attachment"
                                    placeholder="" value="{{ old('file') }}">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="description">Kuvaus</label><span style="color:red">*</span>
                                <textarea class="form-control  form-control-lg" name="description" id="description"
                                    rows="5" value="{{ old('description') }}" required></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input " id="anonym" name="anonym">
                                <label class="form-check-label" for="exampleCheck1">Haluan lähettää anonyyminä</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-lg">Lähetä</button>
                        </div>

                    </form>
                </x-panel>
            </div>
        </div>
    </div>
</div>
@endsection
