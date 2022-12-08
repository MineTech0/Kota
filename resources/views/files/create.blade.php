@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div id="app">
            <create-file-form :categories="{{ $categories}}"/>
        </div>
    </div>
</div>

@endsection
