@extends('layouts.app')
@section('title', 'Uusi tiedosto')
@section('content')
<div class="row">
    <div class="col-md-12">
            <create-file-form :categories="{{ $categories}}"/>
    </div>
</div>

@endsection
