@extends('layouts.app')
@section('title', 'Uusi tiedote')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-panel header='Uusi tiedote'>
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
                <form method="post" action="/notes" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Otsikko<span style="color:red">*</span></label>
                        <div class="col-sm-4">
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Kuvaus<span style="color:red">*</span></label>
                        <div class="col-sm-10">
                            <textarea class="form-control" rows="5" name="description" value="{{ old('description') }}" required></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-8 col-sm-offset-2">
                            <button class="btn btn-primary" name="submit" type="submit">Lähetä</button>
                        </div>
                    </div>

                </form>
            </x-panel>
        </div>
    </div>

@endsection
